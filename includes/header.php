<?php
require_once __DIR__ . '/contact_info.php';
?>
<?php if (basename($_SERVER['PHP_SELF']) === 'index.php'): ?>
<div id="splash-screen" aria-hidden="true">
  <img src="assets/images/WBI-logo.png" alt="WBI Logo">
  <h3>WBI - The Tigars Kingdom</h3>
</div>
<?php endif; ?>

<header class="site-header">
  <?php include __DIR__ . '/navbar.php'; ?>
</header>
