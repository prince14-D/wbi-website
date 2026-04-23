<?php
$pageTitle = 'Blog';
require __DIR__ . '/includes/content_store.php';
$blogPosts = wbi_get_blogs();
$blogCount = count($blogPosts);
$featuredPost = $blogPosts[0] ?? null;
$otherPosts = array_slice($blogPosts, 1);
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
        <img src="assets/images/banner2.png" alt="WBI blog banner" class="hero-slide-image">
        <div class="hero-content container">
          <h1>WBI School Blog</h1>
          <p>Stories, reflections, and practical insights from our school community.</p>
          <div class="hero-buttons">
            <a href="#blog-posts" class="btn primary">Read Blog Posts</a>
            <a href="news.php" class="btn light">View News</a>
          </div>
        </div>
      </div>
    </section>

    <section class="stats-section py-5 text-center text-light" data-animate>
      <div class="container">
        <h2 class="text-white">Blog Snapshot</h2>
        <div class="row g-3 mt-3 justify-content-center">
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars((string) $blogCount); ?></h3><p>Total Posts</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars(date('Y')); ?></h3><p>Current Session</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3>WBI</h3><p>Community Insights</p></div></div>
        </div>
      </div>
    </section>

    <section class="py-5" id="blog-posts" data-animate>
      <div class="container">
        <div class="section-heading">
          <span class="section-kicker">WBI Stories</span>
          <h1>School Blog</h1>
          <p>Insights, student stories, school life updates, and educational reflections from our community.</p>
        </div>

        <?php if ($featuredPost): ?>
          <div class="proprietor-wrap mb-4 text-start">
            <div class="row g-4 align-items-center">
              <div class="col-lg-5">
                <?php if (!empty($featuredPost['image_path'])): ?>
                  <img src="<?php echo htmlspecialchars($featuredPost['image_path']); ?>" alt="<?php echo htmlspecialchars($featuredPost['title'] ?? 'Featured Blog'); ?>" class="img-fluid rounded w-100" style="max-height: 320px; object-fit: cover;">
                <?php else: ?>
                  <div class="admin-card h-100 d-flex align-items-center justify-content-center">
                    <div class="text-center text-muted">
                      <i class="bi bi-journal-text" style="font-size: 2rem;"></i>
                      <p class="mb-0 mt-2">Featured Blog</p>
                    </div>
                  </div>
                <?php endif; ?>
              </div>
              <div class="col-lg-7">
                <span class="section-kicker">Featured Story</span>
                <h2 class="section-title h3"><?php echo htmlspecialchars($featuredPost['title'] ?? ''); ?></h2>
                <p class="mb-2"><strong><?php echo htmlspecialchars($featuredPost['summary'] ?? ''); ?></strong></p>
                <p class="mb-2"><?php echo nl2br(htmlspecialchars($featuredPost['content'] ?? '')); ?></p>
                <small class="text-muted">Published: <?php echo htmlspecialchars(date('M d, Y', strtotime((string) ($featuredPost['created_at'] ?? 'now')))); ?></small>
              </div>
            </div>
          </div>
        <?php endif; ?>

        <div class="news-cards">
          <?php foreach (($featuredPost ? $otherPosts : $blogPosts) as $post): ?>
            <article class="card value-card-item fade-left text-start">
              <?php if (!empty($post['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($post['image_path']); ?>" alt="<?php echo htmlspecialchars($post['title']); ?>" class="img-fluid rounded mb-3" style="width: 100%; max-height: 260px; object-fit: cover;">
              <?php endif; ?>
              <h3><?php echo htmlspecialchars($post['title']); ?></h3>
              <p><strong><?php echo htmlspecialchars($post['summary']); ?></strong></p>
              <p class="mb-2"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
              <small class="text-muted">Published: <?php echo date('M d, Y', strtotime($post['created_at'])); ?></small>
            </article>
          <?php endforeach; ?>

          <?php if (empty($blogPosts)): ?>
            <div class="proprietor-wrap text-center">
              <h3 class="mb-2">No Blog Posts Yet</h3>
              <p class="mb-0">Blog updates from WBI will appear here once published by the admin.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
