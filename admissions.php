<?php
# Includes configuration constants
require_once __DIR__ . '/config.php';

# Sets the page title for the browser tab
$pageTitle = 'Admissions - IT Department Portal';

# Includes the global header template
require_once __DIR__ . '/includes/header.php';
?>

<!-- Admissions requirements section -->
<div class="card">
    <h2>Undergraduate Admission Requirements</h2>
    <p>UCC's published requirements for Jamaican applicants to undergraduate programmes include:</p>
    <ul>
        <li>Five GCE or CSEC subjects, including English Language and Mathematics, at grades A, B or C (GCE) or 1, 2 or 3 (CSEC). CSEC grade 3 results must be from 1998 onward.</li>
        <li>Applicants with four CSEC subjects may apply while completing outstanding subjects or UCC replacement courses in Core Mathematics, English for Academic Purposes and Fundamentals of Accounting.</li>
        <li>Mature-entry applicants must be at least 25 years old and have at least five years of work experience. UCC requests academic qualifications, a résumé, a job letter and three professional references.</li>
    </ul>
    <p>
        Requirements may vary by programme. Review UCC's current
        <a href="https://ucc.edu.jm/programmes/undergraduate/requirements" target="_blank" rel="noopener noreferrer">undergraduate admission requirements</a>
        for full details.
    </p>
    <p><a class="btn" href="https://ucc.edu.jm/apply/undergraduate" target="_blank" rel="noopener noreferrer">Apply to UCC</a></p>
</div>

<?php
# Includes the global footer template
require_once __DIR__ . '/includes/footer.php';
?>
