<?php
# Includes configuration and database connection
require_once __DIR__ . '/config.php';

# Sets the page title for the browser tab
$pageTitle = 'Home &bull; IT Department Portal';

# Includes the global header template
require_once __DIR__ . '/includes/header.php';
?>

<!-- Home page hero section -->
<div class="card" style="margin-bottom: 24px;">
    <h2>Welcome to the Department of Information Technology</h2>
    <p style="margin: 10px 0 20px 0; color: #6b7280;">
        Serving students and faculty of the University of the Commonwealth Caribbean.
    </p>
    <div>
        <a href="courses.php" class="btn">Browse Courses</a>
        <a href="admissions.php" class="btn" style="background-color: #6b7280; margin-left: 8px;">Admissions</a>
    </div>
</div>

<!-- Navigation cards grid -->
<div class="grid-3">
    <!-- Staff directory card -->
    <div class="card">
        <h3>Staff Directory</h3>
        <p>Find faculty profiles, departmental roles and contact information.</p>
        <a href="staff.php" class="btn">View Faculty &rarr;</a>
    </div>

    <!-- Course catalog card -->
    <div class="card">
        <h3>Course Catalog</h3>
        <p>Explore information technology courses, credit requirements and descriptions.</p>
        <a href="courses.php" class="btn">View Courses &rarr;</a>
    </div>

    <!-- Admissions card -->
    <div class="card">
        <h3>Admissions</h3>
        <p>Review undergraduate entry requirements and apply to UCC.</p>
        <a href="admissions.php" class="btn">View Requirements &rarr;</a>
    </div>

    <!-- Contact HOD card -->
    <div class="card">
        <h3>Contact HOD</h3>
        <p>Send inquiries, administrative questions or appointment requests to the Head of Department.</p>
        <a href="contact.php" class="btn">Send Message &rarr;</a>
    </div>
</div>

<?php
# Includes the global footer template
require_once __DIR__ . '/includes/footer.php';
?>