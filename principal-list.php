<?php
$pageTitle = 'Top Principal List';
require __DIR__ . '/includes/content_store.php';
$principalList = wbi_get_principal_list();
$entryCount = count($principalList);
$featuredEntry = $principalList[0] ?? null;
$otherEntries = array_slice($principalList, 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?> - William Bean Institute</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main>
    <section class="hero p-0 m-0" data-animate>
      <div class="hero-slide">
        <img src="assets/images/banner.png" alt="Top principal list banner" class="hero-slide-image">
        <div class="hero-content container">
          <h1>Top Principal List</h1>
          <p>Honoring students who demonstrate excellence in academics, leadership, and character.</p>
          <div class="hero-buttons">
            <a href="#principal-list" class="btn primary">View Honorees</a>
            <a href="academics.php" class="btn light">Explore Academics</a>
          </div>
        </div>
      </div>
    </section>

    <section class="stats-section py-5 text-center text-light" data-animate>
      <div class="container">
        <h2 class="text-white">Recognition Overview</h2>
        <div class="row g-3 mt-3 justify-content-center">
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars((string) $entryCount); ?></h3><p>Total Honorees</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars(date('Y')); ?></h3><p>Current Session</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3>WBI</h3><p>Excellence Culture</p></div></div>
        </div>
      </div>
    </section>

    <section class="py-5" id="principal-list" data-animate>
      <div class="container">
        <div class="section-heading">
          <span class="section-kicker">Student Honors</span>
          <h1>Top Principal List</h1>
          <p>Celebrating outstanding students recognized for academic excellence, discipline, and leadership.</p>
        </div>

        <?php if ($featuredEntry): ?>
          <div class="proprietor-wrap mb-4 text-start">
            <div class="row g-4 align-items-center">
              <div class="col-lg-5">
                <?php if (!empty($featuredEntry['image_path'])): ?>
                  <img src="<?php echo htmlspecialchars($featuredEntry['image_path']); ?>" alt="<?php echo htmlspecialchars($featuredEntry['title'] ?? 'Featured Honoree'); ?>" class="img-fluid rounded w-100" style="max-height: 320px; object-fit: cover;">
                <?php else: ?>
                  <div class="admin-card h-100 d-flex align-items-center justify-content-center">
                    <div class="text-center text-muted">
                      <i class="bi bi-award" style="font-size: 2rem;"></i>
                      <p class="mb-0 mt-2">Featured Honoree</p>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-lg-7">
                <span class="section-kicker">Featured Recognition</span>
                <h2 class="section-title h3"><?php echo htmlspecialchars($featuredEntry['title'] ?? ''); ?></h2>
                <p class="mb-2"><strong><?php echo htmlspecialchars($featuredEntry['summary'] ?? ''); ?></strong></p>
                <p class="mb-2"><?php echo nl2br(htmlspecialchars($featuredEntry['content'] ?? '')); ?></p>
                <small class="text-muted">Updated: <?php echo htmlspecialchars(date('M d, Y', strtotime((string) ($featuredEntry['created_at'] ?? 'now')))); ?></small>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="news-cards">
          <?php foreach (($featuredEntry ? $otherEntries : $principalList) as $entry): ?>
            <article class="card value-card-item fade-left text-start">
              <?php if (!empty($entry['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($entry['image_path']); ?>" alt="<?php echo htmlspecialchars($entry['title']); ?>" class="img-fluid rounded mb-3" style="width: 100%; max-height: 260px; object-fit: cover;">
              <?php endif; ?>
              <h3><?php echo htmlspecialchars($entry['title']); ?></h3>
              <p><strong><?php echo htmlspecialchars($entry['summary']); ?></strong></p>
              <p class="mb-2"><?php echo nl2br(htmlspecialchars($entry['content'])); ?></p>
              <small class="text-muted">Updated: <?php echo date('M d, Y', strtotime($entry['created_at'])); ?></small>
            </article>
          <?php endforeach; ?>

          <?php if (empty($principalList)): ?>
            <div class="proprietor-wrap text-center">
              <h3 class="mb-2">No Principal List Entries Yet</h3>
              <p class="mb-0">Top student recognitions posted by admin will be displayed here.</p>
            </div>
          <?php endif; ?>
        </div>

        <div class="admissions-cta p-4 p-md-5 mt-5" data-animate>
          <div class="row g-3 align-items-center">
            <div class="col-lg-8">
              <span class="section-kicker">Keep Growing</span>
              <h2 class="text-white mb-2">Every Student Can Reach This List</h2>
              <p class="mb-0 text-white-50">Through consistent discipline, leadership, and strong academic effort, students are prepared for distinction.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
              <a href="academics.php" class="btn btn-school">View Academic Programs</a>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
