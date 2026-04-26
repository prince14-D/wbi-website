<?php
$pageTitle = 'Resources';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> - William Bean Institute</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" type="image/png" sizes="32x32" href="assets/images/WBI-logo.png">
  <link rel="icon" type="image/png" sizes="16x16" href="assets/images/WBI-logo.png">
  <link rel="shortcut icon" href="assets/images/WBI-logo.png">
  <link rel="manifest" href="manifest.json">
  <meta name="theme-color" content="#1E4FA3">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="WBI">
  <link rel="apple-touch-icon" href="assets/images/WBI-logo.png">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main>
    <section class="about-preview">
      <div class="container">
        <h1>Resources and Services</h1>
        <p>Use the dropdown below to go directly to News, Blog, Job Vacancy, Top Principal List, or the Verification System.</p>

        <div class="hub-chooser">
          <label for="resource-select"><strong>Select a destination:</strong></label>
          <select id="resource-select" class="hub-select" onchange="if(this.value){window.location.href=this.value;}">
            <option value="">Choose an option</option>
            <option value="news.php">News</option>
            <option value="blog.php">Blog</option>
            <option value="careers.php">Job Vacancy</option>
            <option value="principal-list.php">Top Principal List</option>
            <option value="verification.php">Verification System</option>
          </select>
        </div>
      </div>
    </section>

    <section class="values section-soft">
      <div class="container">
        <h2>Quick Access</h2>
        <div class="value-cards">
          <article class="card">
            <h3>News</h3>
            <p>Read school updates, announcements, and important events.</p>
            <a href="news.php" class="btn secondary">Open News</a>
          </article>
          <article class="card">
            <h3>Job Vacancy</h3>
            <p>See open positions and opportunities available at WBI.</p>
            <a href="careers.php" class="btn secondary">Open Careers</a>
          </article>
          <article class="card">
            <h3>Blog</h3>
            <p>Read stories, updates, and reflections from school life at WBI.</p>
            <a href="blog.php" class="btn secondary">Open Blog</a>
          </article>
          <article class="card">
            <h3>Top Principal List</h3>
            <p>Celebrate top students recognized for excellence and discipline.</p>
            <a href="principal-list.php" class="btn secondary">Open Principal List</a>
          </article>
          <article class="card">
            <h3>Verification System</h3>
            <p>Verify academic records and document authenticity.</p>
            <a href="verification.php" class="btn secondary">Open Verification</a>
          </article>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
