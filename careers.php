<?php
$pageTitle = 'Careers';
require __DIR__ . '/includes/content_store.php';
$jobs = wbi_get_jobs();
$jobCount = count($jobs);
$featuredJob = $jobs[0] ?? null;
$otherJobs = array_slice($jobs, 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> - WBI Website</title>
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
    <section class="hero p-0 m-0" data-animate>
      <div class="hero-slide">
        <img src="assets/images/banner3.png" alt="WBI careers banner" class="hero-slide-image">
        <div class="hero-content container">
          <h1>Work With WBI</h1>
          <p>Join our mission-driven team and help shape a safe, caring, and excellent learning environment.</p>
          <div class="hero-buttons">
            <a href="#job-openings" class="btn primary">View Open Positions</a>
            <a href="contact.php" class="btn light">Contact HR Office</a>
          </div>
        </div>
      </div>
    </section>

    <section class="stats-section py-5 text-center text-light" data-animate>
      <div class="container">
        <h2 class="text-white">Careers Overview</h2>
        <div class="row g-3 mt-3 justify-content-center">
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars((string) $jobCount); ?></h3><p>Open Vacancies</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars(date('Y')); ?></h3><p>Current Recruitment Cycle</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3>WBI</h3><p>Professional Growth Culture</p></div></div>
        </div>
      </div>
    </section>

    <section class="py-5" id="job-openings" data-animate>
      <div class="container">
        <div class="section-heading">
          <span class="section-kicker">Join Our Team</span>
          <h1>Current Job Vacancies</h1>
          <p>Explore available roles at World Wide Missions School and become part of our student-centered academic community.</p>
        </div>

        <?php if ($featuredJob): ?>
          <div class="proprietor-wrap mb-4 text-start">
            <div class="row g-4 align-items-center">
              <div class="col-lg-5">
                <?php if (!empty($featuredJob['image_path'])): ?>
                  <img src="<?php echo htmlspecialchars($featuredJob['image_path']); ?>" alt="<?php echo htmlspecialchars($featuredJob['title'] ?? 'Featured Vacancy'); ?>" class="img-fluid rounded w-100" style="max-height: 320px; object-fit: cover;">
                <?php else: ?>
                  <div class="admin-card h-100 d-flex align-items-center justify-content-center">
                    <div class="text-center text-muted">
                      <i class="bi bi-briefcase" style="font-size: 2rem;"></i>
                      <p class="mb-0 mt-2">Featured Vacancy</p>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-lg-7">
                <span class="section-kicker">Priority Hiring</span>
                <h2 class="section-title h3"><?php echo htmlspecialchars($featuredJob['title'] ?? ''); ?></h2>
                <p class="mb-2"><strong><?php echo htmlspecialchars($featuredJob['summary'] ?? ''); ?></strong></p>
                <p class="mb-2"><?php echo nl2br(htmlspecialchars($featuredJob['content'] ?? '')); ?></p>
                <?php if (!empty($featuredJob['deadline'])): ?>
                  <p class="mb-2"><small class="text-muted">Application Deadline: <?php echo htmlspecialchars($featuredJob['deadline']); ?></small></p>
                <?php endif; ?>
                <small class="text-muted">Posted: <?php echo htmlspecialchars(date('M d, Y', strtotime((string) ($featuredJob['created_at'] ?? 'now')))); ?></small>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="news-cards">
          <?php foreach (($featuredJob ? $otherJobs : $jobs) as $job): ?>
            <article class="card text-start value-card-item fade-left">
              <?php if (!empty($job['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($job['image_path']); ?>" alt="<?php echo htmlspecialchars($job['title']); ?>" class="img-fluid rounded mb-3" style="width: 100%; max-height: 260px; object-fit: cover;">
              <?php endif; ?>
              <h3><?php echo htmlspecialchars($job['title']); ?></h3>
              <p><strong><?php echo htmlspecialchars($job['summary']); ?></strong></p>
              <p class="mb-2"><?php echo nl2br(htmlspecialchars($job['content'])); ?></p>
              <?php if (!empty($job['deadline'])): ?>
                <p class="mb-2"><small class="text-muted">Deadline: <?php echo htmlspecialchars($job['deadline']); ?></small></p>
              <?php endif; ?>
              <small class="text-muted">Posted: <?php echo date('M d, Y', strtotime($job['created_at'])); ?></small>
            </article>
          <?php endforeach; ?>

          <?php if (empty($jobs)): ?>
            <div class="proprietor-wrap text-center">
              <h3 class="mb-2">No Openings Posted Yet</h3>
              <p class="mb-0">Please check back soon for new employment opportunities at WBI.</p>
            </div>
          <?php endif; ?>
        </div>

        <div class="admissions-cta p-4 p-md-5 mt-5" data-animate>
          <div class="row g-3 align-items-center">
            <div class="col-lg-8">
              <span class="section-kicker">Application Support</span>
              <h2 class="text-white mb-2">Need Help With Your Application?</h2>
              <p class="mb-0 text-white-50">Contact our office for guidance on required documents, role expectations, and submission timelines.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
              <a href="contact.php" class="btn btn-school">Contact School Office</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
