<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config.php';

$pdo = db();
$error = '';
$success = '';
$editId = 0;
$code = '';
$name = '';
$credits = '3';
$prerequisites = '';
$description = '';

// Add or update a course
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $editId = isset($_POST['id']) && is_numeric($_POST['id']) ? (int) $_POST['id'] : 0;
    $code = isset($_POST['code']) && is_string($_POST['code']) ? strtoupper(trim($_POST['code'])) : '';
    $name = isset($_POST['name']) && is_string($_POST['name']) ? trim($_POST['name']) : '';
    $credits = isset($_POST['credits']) && is_string($_POST['credits']) ? trim($_POST['credits']) : '';
    $prerequisites = isset($_POST['prerequisites']) && is_string($_POST['prerequisites']) ? trim($_POST['prerequisites']) : '';
    $description = isset($_POST['description']) && is_string($_POST['description']) ? trim($_POST['description']) : '';

    if (!preg_match('/^[A-Z]{3}[0-9]{3}$/', $code)) {
        $error = 'Course code must be three uppercase letters followed by three digits.';
    } elseif ($name === '' || $description === '') {
        $error = 'Name and description are required.';
    } elseif (!preg_match('/^[1-4]$/', $credits)) {
        $error = 'Credits must be a whole number from 1 to 4.';
    } else {
        // Check for duplicate course codes
        if ($editId > 0) {
            $check = $pdo->prepare('SELECT id FROM courses WHERE code = :code AND id != :id');
            $check->execute(['code' => $code, 'id' => $editId]);
        } else {
            $check = $pdo->prepare('SELECT id FROM courses WHERE code = :code');
            $check->execute(['code' => $code]);
        }

        if ($check->fetch()) {
            $error = 'That course code is already used.';
        } else {
            if ($editId > 0) {
                $sql = 'UPDATE courses SET code=:code, name=:name, credits=:credits,
                        prerequisites=:prerequisites, description=:description WHERE id=:id';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'code' => $code,
                    'name' => $name,
                    'credits' => (int) $credits,
                    'prerequisites' => $prerequisites === '' ? null : $prerequisites,
                    'description' => $description,
                    'id' => $editId
                ]);
                $success = 'Course updated.';
            } else {
                $sql = 'INSERT INTO courses (code, name, credits, prerequisites, description)
                        VALUES (:code, :name, :credits, :prerequisites, :description)';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    'code' => $code,
                    'name' => $name,
                    'credits' => (int) $credits,
                    'prerequisites' => $prerequisites === '' ? null : $prerequisites,
                    'description' => $description
                ]);
                $success = 'Course added.';
            }

            $code = '';
            $name = '';
            $credits = '3';
            $prerequisites = '';
            $description = '';
            $editId = 0;
        }
    }
}

// First delete step asks for confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $deleteId = isset($_POST['id']) && is_numeric($_POST['id']) ? (int) $_POST['id'] : 0;
    $stmt = $pdo->prepare('SELECT * FROM courses WHERE id = :id');
    $stmt->execute(['id' => $deleteId]);
    $courseToDelete = $stmt->fetch();

    if ($courseToDelete) {
        if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
            $stmt = $pdo->prepare('DELETE FROM courses WHERE id = :id');
            $stmt->execute(['id' => $deleteId]);
            $success = 'Course deleted.';
        } else {
            $confirmCourse = $courseToDelete;
        }
    } else {
        $error = 'Course not found.';
    }
}

// Load a course into the form when Edit is clicked
if (isset($_GET['edit'])) {
    $editId = (int) $_GET['edit'];
    $stmt = $pdo->prepare('SELECT * FROM courses WHERE id = :id');
    $stmt->execute(['id' => $editId]);
    $course = $stmt->fetch();

    if ($course) {
        $code = $course['code'];
        $name = $course['name'];
        $credits = $course['credits'];
        $prerequisites = $course['prerequisites'];
        $description = $course['description'];
    }
}

$courses = $pdo->query('SELECT * FROM courses ORDER BY code ASC')->fetchAll();

$pageTitle = 'Manage Courses';
$basePath = '../';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="card">
    <h2><?= $editId ? 'Edit Course' : 'Add Course' ?></h2>
    <?php if ($error): ?><p class="alert alert-error"><?= h($error) ?></p><?php endif; ?>
    <?php if ($success): ?><p class="alert alert-success"><?= h($success) ?></p><?php endif; ?>

    <form method="post" action="courses.php">
        <input type="hidden" name="save" value="1">
        <?php if ($editId): ?><input type="hidden" name="id" value="<?= (int) $editId ?>"><?php endif; ?>

        <div class="form-group">
            <label>Course Code</label>
            <input class="form-control" type="text" name="code" maxlength="6" pattern="[A-Z]{3}[0-9]{3}" value="<?= h($code) ?>" required>
        </div>
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" name="name" value="<?= h($name) ?>" required>
        </div>
        <div class="form-group">
            <label>Credits</label>
            <input class="form-control" type="number" name="credits" min="1" max="4" step="1" value="<?= h($credits) ?>" required>
        </div>
        <div class="form-group">
            <label>Prerequisites (optional)</label>
            <input class="form-control" type="text" name="prerequisites" value="<?= h($prerequisites) ?>">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" required><?= h($description) ?></textarea>
        </div>
        <button class="btn" type="submit"><?= $editId ? 'Update Course' : 'Add Course' ?></button>
    </form>
</div>

<?php if (isset($confirmCourse)): ?>
    <div class="card">
        <h3>Confirm Delete</h3>
        <p>Delete <?= h($confirmCourse['code']) ?> - <?= h($confirmCourse['name']) ?>?</p>
        <form method="post" action="courses.php">
            <input type="hidden" name="delete" value="1">
            <input type="hidden" name="confirm" value="yes">
            <input type="hidden" name="id" value="<?= (int) $confirmCourse['id'] ?>">
            <button class="btn btn-danger" type="submit">Yes, Delete</button>
            <a class="btn" href="courses.php">Cancel</a>
        </form>
    </div>
<?php endif; ?>

<div class="card">
    <h2>Courses</h2>
    <table>
        <tr><th>Code</th><th>Name</th><th>Credits</th><th>Prerequisites</th><th>Actions</th></tr>
        <?php foreach ($courses as $course): ?>
            <tr>
                <td><?= h($course['code']) ?></td>
                <td><?= h($course['name']) ?></td>
                <td><?= h($course['credits']) ?></td>
                <td><?= h($course['prerequisites'] ? $course['prerequisites'] : 'None') ?></td>
                <td>
                    <a href="courses.php?edit=<?= (int) $course['id'] ?>">Edit</a>
                    <form method="post" action="courses.php" style="display:inline;">
                        <input type="hidden" name="delete" value="1">
                        <input type="hidden" name="id" value="<?= (int) $course['id'] ?>">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
