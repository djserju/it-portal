<?php
require_once __DIR__ . '/../includes/auth_check.php';
require_once __DIR__ . '/../config.php';

$pdo = db();
$error = '';
$success = '';
$name = '';
$position = '';
$phone = '';
$email = '';

// Delete a staff member after confirmation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete'])) {
    $id = isset($_POST['id']) && is_numeric($_POST['id']) ? (int) $_POST['id'] : 0;
    $stmt = $pdo->prepare('SELECT * FROM staff WHERE id = :id');
    $stmt->execute(['id' => $id]);
    $person = $stmt->fetch();

    if ($person) {
        if (isset($_POST['confirm']) && $_POST['confirm'] === 'yes') {
            $stmt = $pdo->prepare('DELETE FROM staff WHERE id = :id');
            $stmt->execute(['id' => $id]);

            if ($person['photo']) {
                $photo = basename($person['photo']);
                $path = __DIR__ . '/../uploads/' . $photo;
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $success = 'Staff member deleted.';
        } else {
            $confirmPerson = $person;
        }
    } else {
        $error = 'Staff member not found.';
    }
}

// Add a staff member
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name = isset($_POST['name']) && is_string($_POST['name']) ? trim($_POST['name']) : '';
    $position = isset($_POST['position']) && is_string($_POST['position']) ? trim($_POST['position']) : '';
    $phone = isset($_POST['phone']) && is_string($_POST['phone']) ? trim($_POST['phone']) : '';
    $email = isset($_POST['email']) && is_string($_POST['email']) ? trim($_POST['email']) : '';

    if ($name === '' || $position === '' || $phone === '' || $email === '') {
        $error = 'Please fill in every field.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        $photoName = '';

        // Check that a file was uploaded
        if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
            $error = 'Please choose a valid JPG or PNG photo.';
        } elseif ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
            $error = 'The photo must be 2 MB or smaller.';
        } elseif (!is_uploaded_file($_FILES['photo']['tmp_name'])) {
            $error = 'The photo upload could not be verified.';
        } else {
            // Check the real file type
            $info = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($info, $_FILES['photo']['tmp_name']);
            finfo_close($info);

            if ($mime === 'image/jpeg') {
                $extension = 'jpg';
            } elseif ($mime === 'image/png') {
                $extension = 'png';
            } else {
                $extension = '';
            }

            if ($extension === '') {
                $error = 'Only JPG and PNG photos are accepted.';
            } else {
                $photoName = 'staff_' . time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;
                $target = __DIR__ . '/../uploads/' . $photoName;

                if (!move_uploaded_file($_FILES['photo']['tmp_name'], $target)) {
                    $error = 'The photo could not be saved.';
                }
            }
        }

        // Save the database record only after the photo succeeds
        if ($error === '') {
            $sql = 'INSERT INTO staff (name, position, phone, email, photo)
                    VALUES (:name, :position, :phone, :email, :photo)';
            $stmt = $pdo->prepare($sql);

            try {
                $stmt->execute([
                    'name' => $name,
                    'position' => $position,
                    'phone' => $phone,
                    'email' => $email,
                    'photo' => $photoName
                ]);
                $success = 'Staff member added.';
                $name = '';
                $position = '';
                $phone = '';
                $email = '';
            } catch (PDOException $e) {
                if ($photoName !== '') {
                    unlink(__DIR__ . '/../uploads/' . $photoName);
                }
                $error = 'The staff member could not be saved.';
            }
        }
    }
}

$staff = $pdo->query('SELECT * FROM staff ORDER BY id ASC')->fetchAll();

$pageTitle = 'Manage Staff';
$basePath = '../';
require_once __DIR__ . '/../includes/header.php';
?>

<div class="card">
    <h2>Add Staff Member</h2>
    <?php if ($error): ?><p class="alert alert-error"><?= h($error) ?></p><?php endif; ?>
    <?php if ($success): ?><p class="alert alert-success"><?= h($success) ?></p><?php endif; ?>

    <form method="post" action="staff.php" enctype="multipart/form-data">
        <input type="hidden" name="add" value="1">
        <div class="form-group">
            <label>Name</label>
            <input class="form-control" type="text" name="name" value="<?= h($name) ?>" required>
        </div>
        <div class="form-group">
            <label>Position</label>
            <input class="form-control" type="text" name="position" value="<?= h($position) ?>" required>
        </div>
        <div class="form-group">
            <label>Phone</label>
            <input class="form-control" type="text" name="phone" value="<?= h($phone) ?>" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input class="form-control" type="email" name="email" value="<?= h($email) ?>" required>
        </div>
        <div class="form-group">
            <label>Photo (JPG or PNG, maximum 2 MB)</label>
            <input class="form-control" type="file" name="photo" accept=".jpg,.jpeg,.png,image/jpeg,image/png" required>
        </div>
        <button class="btn" type="submit">Add Staff Member</button>
    </form>
</div>

<?php if (isset($confirmPerson)): ?>
    <div class="card">
        <h3>Confirm Delete</h3>
        <p>Delete <?= h($confirmPerson['name']) ?>?</p>
        <form method="post" action="staff.php">
            <input type="hidden" name="delete" value="1">
            <input type="hidden" name="confirm" value="yes">
            <input type="hidden" name="id" value="<?= (int) $confirmPerson['id'] ?>">
            <button class="btn btn-danger" type="submit">Yes, Delete</button>
            <a class="btn" href="staff.php">Cancel</a>
        </form>
    </div>
<?php endif; ?>

<div class="card">
    <h2>Staff Members</h2>
    <table>
        <tr><th>Photo</th><th>Name</th><th>Position</th><th>Phone</th><th>Email</th><th>Action</th></tr>
        <?php foreach ($staff as $person): ?>
            <?php
            $photo = $person['photo'] ? basename($person['photo']) : '';
            $hasPhoto = $photo !== '' && file_exists(__DIR__ . '/../uploads/' . $photo);
            ?>
            <tr>
                <td><?= $hasPhoto ? '<img class="staff-photo" src="../uploads/' . h($photo) . '" alt="' . h($person['name']) . '">' : 'No photo' ?></td>
                <td><?= h($person['name']) ?></td>
                <td><?= h($person['position']) ?></td>
                <td><?= h($person['phone']) ?></td>
                <td><?= h($person['email']) ?></td>
                <td>
                    <form method="post" action="staff.php">
                        <input type="hidden" name="delete" value="1">
                        <input type="hidden" name="id" value="<?= (int) $person['id'] ?>">
                        <button class="btn btn-danger" type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
