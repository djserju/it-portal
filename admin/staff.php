<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../classes/database.php';
require_once __DIR__ . '/../classes/staff.php';

$pdo = (new Database())->getConnection();
$staffModel = new Staff($pdo);
$errors = [];
$success = '';
$form = ['name' => '', 'position' => '', 'phone' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'delete') {
        $deleteId = filter_var($_POST['id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        $confirmed = isset($_POST['confirm']) && $_POST['confirm'] === '1';

        if ($deleteId !== false) {
            $memberToDelete = $staffModel->find((int) $deleteId);
            if ($memberToDelete === null) {
                $errors[] = 'The staff member could not be found.';
            } elseif (!$confirmed) {
                $errors[] = 'Please confirm staff deletion.';
                $deleteConfirmation = $memberToDelete;
            } elseif ($staffModel->delete((int) $deleteId)) {
                $photoName = basename((string) ($memberToDelete['photo'] ?? ''));
                if ($photoName !== '' && is_file(__DIR__ . '/../uploads/' . $photoName)) {
                    unlink(__DIR__ . '/../uploads/' . $photoName);
                }
                $success = 'Staff member deleted successfully.';
            } else {
                $errors[] = 'The staff member could not be deleted.';
            }
        } else {
            $errors[] = 'Invalid staff member selected.';
        }
    } else {
        $form = [
            'name' => is_string($_POST['name'] ?? null) ? trim($_POST['name']) : '',
            'position' => is_string($_POST['position'] ?? null) ? trim($_POST['position']) : '',
            'phone' => is_string($_POST['phone'] ?? null) ? trim($_POST['phone']) : '',
            'email' => is_string($_POST['email'] ?? null) ? trim($_POST['email']) : '',
        ];

        foreach (['name' => 'Name', 'position' => 'Position', 'phone' => 'Phone'] as $field => $label) {
            if ($form[$field] === '') {
                $errors[] = $label . ' is required.';
            }
        }
        if ($form['email'] === '' || !filter_var($form['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'A valid email address is required.';
        }

        $photoName = null;
        $upload = $_FILES['photo'] ?? null;
        if (!is_array($upload)) {
            $errors[] = 'A JPG or PNG photo is required.';
        } else {
            if (!isset($upload['error']) || $upload['error'] !== UPLOAD_ERR_OK) {
                $errors[] = 'The photo upload failed. Please try again.';
            } elseif (!isset($upload['size']) || $upload['size'] > 2 * 1024 * 1024) {
                $errors[] = 'The photo must be no larger than 2 MB.';
            } elseif (!isset($upload['tmp_name']) || !is_uploaded_file($upload['tmp_name'])) {
                $errors[] = 'The photo upload is invalid.';
            } else {
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $mimeType = $finfo->file($upload['tmp_name']);
                $allowed = ['image/jpeg' => 'jpg', 'image/png' => 'png'];
                if (!isset($allowed[$mimeType])) {
                    $errors[] = 'Only JPG and PNG photos are accepted.';
                } else {
                    $extension = $allowed[$mimeType];
                    $photoName = 'staff_' . bin2hex(random_bytes(16)) . '.' . $extension;
                }
            }
        }

        if (empty($errors) && $photoName !== null) {
            $uploadDir = __DIR__ . '/../uploads';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            if (move_uploaded_file($upload['tmp_name'], $uploadDir . '/' . $photoName)) {
                $form['photo'] = $photoName;
                try {
                    if ($staffModel->create($form)) {
                        $success = 'Staff member added successfully.';
                        $form = ['name' => '', 'position' => '', 'phone' => '', 'email' => ''];
                    } else {
                        unlink($uploadDir . '/' . $photoName);
                        $errors[] = 'The staff member could not be saved.';
                    }
                } catch (PDOException $e) {
                    unlink($uploadDir . '/' . $photoName);
                    $errors[] = 'The staff member could not be saved. The email may already be in use.';
                }
            } else {
                $errors[] = 'The photo could not be saved.';
            }
        }
    }
}

$staff = $staffModel->all();
$pageTitle = 'Manage Staff - Admin';
$basePath = '../';
require_once __DIR__ . '/../includes/header.php';
?>

<section class="card">
    <h2>Add Staff Member</h2>
    <?php if ($success !== ''): ?><p class="alert alert-success"><?= e($success) ?></p><?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">
            <?php foreach ($errors as $error): ?><p><?= e($error) ?></p><?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="post" action="staff.php" enctype="multipart/form-data">
        <div class="form-group"><label for="name">Name</label><input class="form-control" type="text" id="name" name="name" required value="<?= e($form['name']) ?>"></div>
        <div class="form-group"><label for="position">Position</label><input class="form-control" type="text" id="position" name="position" required value="<?= e($form['position']) ?>"></div>
        <div class="form-group"><label for="phone">Phone</label><input class="form-control" type="text" id="phone" name="phone" required value="<?= e($form['phone']) ?>"></div>
        <div class="form-group"><label for="email">Email</label><input class="form-control" type="email" id="email" name="email" required value="<?= e($form['email']) ?>"></div>
        <div class="form-group"><label for="photo">Photo (JPG or PNG, up to 2 MB)</label><input class="form-control" type="file" id="photo" name="photo" accept=".jpg,.jpeg,.png,image/jpeg,image/png" required></div>
        <button class="btn" type="submit">Add Staff Member</button>
    </form>
</section>

<?php if (isset($deleteConfirmation)): ?>
    <section class="card">
        <h2>Confirm Staff Deletion</h2>
        <p>Delete <strong><?= e($deleteConfirmation['name']) ?></strong>?</p>
        <form method="post" action="staff.php">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= (int) $deleteConfirmation['id'] ?>">
            <input type="hidden" name="confirm" value="1">
            <button class="btn btn-danger" type="submit">Yes, Delete Staff Member</button>
            <a class="btn" href="staff.php">Cancel</a>
        </form>
    </section>
<?php endif; ?>

<section class="card">
    <h2>Staff Members</h2>
    <?php if (empty($staff)): ?>
        <p>No staff profiles available.</p>
    <?php else: ?>
        <table>
            <thead><tr><th>Photo</th><th>Name</th><th>Position</th><th>Phone</th><th>Email</th><th>Action</th></tr></thead>
            <tbody>
            <?php foreach ($staff as $member): ?>
                <?php
                $photoName = basename((string) ($member['photo'] ?? ''));
                $photoPath = __DIR__ . '/../uploads/' . $photoName;
                ?>
                <tr>
                    <td><?= $photoName !== '' && is_file($photoPath) ? '<img class="staff-photo" src="../uploads/' . e($photoName) . '" alt="">' : 'No photo' ?></td>
                    <td><?= e($member['name']) ?></td>
                    <td><?= e($member['position']) ?></td>
                    <td><?= e($member['phone']) ?></td>
                    <td><?= e($member['email']) ?></td>
                    <td>
                        <form method="post" action="staff.php">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int) $member['id'] ?>">
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
