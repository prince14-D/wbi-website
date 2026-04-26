<?php
$pageTitle = 'News';
require __DIR__ . '/includes/content_store.php';
$newsItems = wbi_get_news();
$newsCount = count($newsItems);
$featuredNews = $newsItems[0] ?? null;
$otherNews = array_slice($newsItems, 1);
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
<body class="news-page">
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main class="w-100 m-0">
    <section class="hero p-0 m-0" data-animate>
      <div class="hero-slide">
        <img src="assets/images/banner.png" alt="WBI news banner" class="hero-slide-image">
        <div class="hero-content container">
          <h1>WBI News &amp; Announcements</h1>
          <p>Stay informed with official school announcements, event updates, and academic highlights.</p>
          <div class="hero-buttons">
            <a href="#latest-news" class="btn primary">View Latest News</a>
            <a href="contact.php" class="btn light">Contact School Office</a>
          </div>
        </div>
      </div>
    </section>

    <section class="stats-section py-5 text-center text-light" data-animate>
      <div class="container">
        <h2 class="text-white">News Overview</h2>
        <div class="row g-3 mt-3 justify-content-center">
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars((string) $newsCount); ?></h3><p>Total Updates</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars(date('Y')); ?></h3><p>Current Session</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3>WBI</h3><p>Official Bulletin</p></div></div>
        </div>
      </div>
    </section>

    <section class="py-5" id="latest-news" data-animate>
      <div class="container">
        <div class="section-heading">
          <span class="section-kicker">School Updates</span>
          <h1>Latest News</h1>
          <p>Official announcements and updates from World Wide Missions School (WBI).</p>
        </div>

        <?php if ($featuredNews): ?>
          <div class="proprietor-wrap mb-4 text-start">
            <div class="row g-4 align-items-center">
              <div class="col-lg-5">
                <?php if (!empty($featuredNews['image_path'])): ?>
                  <img src="<?php echo htmlspecialchars($featuredNews['image_path']); ?>" alt="<?php echo htmlspecialchars($featuredNews['title'] ?? 'Featured News'); ?>" class="img-fluid rounded w-100" style="max-height: 320px; object-fit: cover;">
                <?php else: ?>
                  <div class="admin-card h-100 d-flex align-items-center justify-content-center">
                    <div class="text-center text-muted">
                      <i class="bi bi-newspaper" style="font-size: 2rem;"></i>
                      <p class="mb-0 mt-2">Featured News</p>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-lg-7">
                <span class="section-kicker">Featured Update</span>
                <h2 class="section-title h3"><?php echo htmlspecialchars($featuredNews['title'] ?? ''); ?></h2>
                <p class="mb-2"><strong><?php echo htmlspecialchars($featuredNews['summary'] ?? ''); ?></strong></p>
                <p class="mb-2"><?php echo nl2br(htmlspecialchars($featuredNews['content'] ?? '')); ?></p>
                <small class="text-muted">Posted: <?php echo htmlspecialchars(date('M d, Y', strtotime((string) ($featuredNews['created_at'] ?? 'now')))); ?></small>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="news-cards">
          <?php foreach (($featuredNews ? $otherNews : $newsItems) as $item): ?>
            <article class="card value-card-item fade-left text-start">
              <?php if (!empty($item['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="img-fluid rounded mb-3" style="width: 100%; max-height: 260px; object-fit: cover;">
              <?php endif; ?>
              <h3><?php echo htmlspecialchars($item['title']); ?></h3>
              <p><strong><?php echo htmlspecialchars($item['summary']); ?></strong></p>
              <p class="mb-2"><?php echo nl2br(htmlspecialchars($item['content'])); ?></p>
              <small class="text-muted">Posted: <?php echo date('M d, Y', strtotime($item['created_at'])); ?></small>
            </article>
          <?php endforeach; ?>

          <?php if (empty($newsItems)): ?>
            <div class="proprietor-wrap text-center">
              <h3 class="mb-2">No News Yet</h3>
              <p class="mb-0">School announcements posted by the admin will appear here.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
