<?php
$pageTitle = 'Careers';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> - WBI Website</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/logo.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/logo.png">
  <link rel="shortcut icon" href="assets/images/logo.png">
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#1E4FA3">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="WBI">
  <link rel="apple-touch-icon" href="assets/images/logo.png">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main class="container">
    <h1>Current Job Vacancies</h1>
    <p>Welcome to our careers page. Open positions will be listed here.</p>

    <section class="card">
      <h2>No openings posted yet</h2>
      <p>Please check back soon for job opportunities.</p>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
