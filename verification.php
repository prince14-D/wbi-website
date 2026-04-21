<?php
$pageTitle = 'Verification System';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> - William Bean Institute</title>
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

  <main>
    <section class="about-preview">
      <div class="container">
        <h1>Verification System</h1>
        <p>Use this page to verify student records, transcripts, and official documents.</p>
      </div>
    </section>

    <section class="values section-soft">
      <div class="container">
        <div class="value-cards">
          <article class="card">
            <h3>Record Verification</h3>
            <p>Submit a verification request for academic records.</p>
          </article>
          <article class="card">
            <h3>Certificate Check</h3>
            <p>Confirm authenticity of certificates issued by WBI.</p>
          </article>
          <article class="card">
            <h3>Support</h3>
            <p>Contact the registrar if you need help with verification processing.</p>
          </article>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
