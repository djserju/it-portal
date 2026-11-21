<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/course.php';

$pdo = (new Database())->getConnection();
$courseModel = new Course($pdo);
$errors = [];
$success = '';
$form = [
    'code' => '',
    'name' => '',
    'credits' => '3',
    'prerequisites' => '',
    'description' => '',
];
$editingId = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $deleteId = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $confirmed = isset($_POST['confirm']) && $_POST['confirm'] === '1';

        if ($deleteId !== false) {
            $courseToDelete = $courseModel->find((int) $deleteId);
            if ($courseToDelete === null) {
                $errors[] = 'The course could not be found.';
            } elseif (!$confirmed) {
                $errors[] = 'Please confirm course deletion.';
                $deleteConfirmation = $courseToDelete;
            } elseif ($courseModel->delete((int) $deleteId)) {
                $success = 'Course deleted successfully.';
            } else {
                $errors[] = 'The course could not be deleted.';
            }
        } else {
            $errors[] = 'Invalid course selected.';
        }
    } else {
        $editingId = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $editingId = $editingId !== false ? (int) $editingId : null;
        $form = [
            'code' => is_string($_POST['code'] ?? null) ? strtoupper(trim($_POST['code'])) : '',
            'name' => is_string($_POST['name'] ?? null) ? trim($_POST['name']) : '',
            'credits' => is_string($_POST['credits'] ?? null) ? trim($_POST['credits']) : '',
            'prerequisites' => is_string($_POST['prerequisites'] ?? null) ? trim($_POST['prerequisites']) : '',
            'description' => is_string($_POST['description'] ?? null) ? trim($_POST['description']) : '',
        ];

        if (!preg_match('/^[A-Z]{3}[0-9]{3}$/', $form['code'])) {
            $errors[] = 'Course code must be three uppercase letters followed by three digits.';
        }
        if ($form['name'] === '') {
            $errors[] = 'Course name is required.';
        }
        if ($form['description'] === '') {
            $errors[] = 'Course description is required.';
        }
        if (!preg_match('/^[1-4]$/', $form['credits'])) {
            $errors[] = 'Credits must be a whole number from 1 to 4.';
        }
        if ($courseModel->codeExists($form['code'], $editingId)) {
            $errors[] = 'That course code is already in use.';
        }

        if (empty($errors)) {
            $saved = $editingId === null
                ? $courseModel->create($form)
                : $courseModel->update($editingId, $form);

            if ($saved) {
                $success = $editingId === null ? 'Course added successfully.' : 'Course updated successfully.';
                $form = ['code' => '', 'name' => '', 'credits' => '3', 'prerequisites' => '', 'description' => ''];
                $editingId = null;
            } else {
                $errors[] = 'The course could not be saved.';
            }
        }
    }
}

if ($editingId === null && isset($_GET['edit'])) {
    $requestedId = filter_var($_GET['edit'], FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($requestedId !== false) {
        $existing = $courseModel->find((int) $requestedId);
        if ($existing !== null) {
            $editingId = (int) $existing['id'];
            $form = [
                'code' => $existing['code'],
                'name' => $existing['name'],
                'credits' => (string) $existing['credits'],
                'prerequisites' => $existing['prerequisites'] ?? '',
                'description' => $existing['description'] ?? '',
            ];
        }
    }
}

$courses = $courseModel->all();
$pageTitle = 'Manage Courses - Admin';
$basePath = '../';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="card">
    <h2><?= $editingId === null ? 'Add Course' : 'Edit Course' ?></h2>
    <?php if ($success !== ''): ?><p class="alert alert-success"><?= e($success) ?></p><?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?><p><?= e($error) ?></p><?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="courses.php">
        <?php if ($editingId !== null): ?>
            <input type="hidden" name="id" value="<?= (int) $editingId ?>">
        <?php endif; ?>
        <div class="form-group">
            <label for="code">Course Code</label>
            <input class="form-control" type="text" id="code" name="code" pattern="[A-Z]{3}[0-9]{3}" maxlength="6" required value="<?= e($form['code']) ?>">
        </div>
        <div class="form-group">
            <label for="name">Course Name</label>
            <input class="form-control" type="text" id="name" name="name" required value="<?= e($form['name']) ?>">
        </div>
        <div class="form-group">
            <label for="credits">Credits</label>
            <input class="form-control" type="number" id="credits" name="credits" min="1" max="4" step="1" required value="<?= e($form['credits']) ?>">
        </div>
        <div class="form-group">
            <label for="prerequisites">Prerequisites (optional)</label>
            <input class="form-control" type="text" id="prerequisites" name="prerequisites" value="<?= e($form['prerequisites']) ?>">
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required><?= e($form['description']) ?></textarea>
        </div>
        <button class="btn" type="submit"><?= $editingId === null ? 'Add Course' : 'Update Course' ?></button>
        <?php if ($editingId !== null): ?><a class="btn" href="courses.php">Cancel</a><?php endif; ?>
    </form>
</section>

<?php if (isset($deleteConfirmation)): ?>
    <section class="card">
        <h2>Confirm Course Deletion</h2>
        <p>Delete <strong><?= e($deleteConfirmation['code'] . ' - ' . $deleteConfirmation['name']) ?></strong>?</p>
        <form method="post" action="courses.php">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int) $deleteConfirmation['id'] ?>">
            <input type="hidden" name="confirm" value="1">
            <button class="btn btn-danger" type="submit">Yes, Delete Course</button>
            <a class="btn" href="courses.php">Cancel</a>
        </form>
    </section>
<?php endif; ?>

<section class="card">
    <h2>Courses</h2>
    <?php if (empty($courses)): ?>
        <p>No courses available.</p>
    <?php else: ?>
        <table>
            <thead><tr><th>Code</th><th>Name</th><th>Credits</th><th>Prerequisites</th><th>Actions</th></tr></thead>
            <tbody>
            <?php foreach ($courses as $course): ?>
                <tr>
                    <td><?= e($course['code']) ?></td>
                    <td><?= e($course['name']) ?></td>
                    <td><?= e((string) $course['credits']) ?></td>
                    <td><?= e($course['prerequisites'] ?: 'None') ?></td>
                    <td>
                        <a href="courses.php?edit=<?= (int) $course['id'] ?>">Edit</a>
                        <form method="post" action="courses.php" style="display:inline;">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $course['id'] ?>">
                            <button class="btn btn-danger" type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
