<?php
require __DIR__ . '/includes/admin_auth.php';
require __DIR__ . '/includes/content_store.php';
require __DIR__ . '/includes/upload_helpers.php';

wbi_admin_require_auth();

$notice = '';
$error = '';

$editType = $_GET['edit_type'] ?? '';
$editId = $_GET['edit_id'] ?? '';
$editItem = null;

if ($editType === 'news' && $editId !== '') {
  $editItem = wbi_find_news($editId);
} elseif ($editType === 'job' && $editId !== '') {
  $editItem = wbi_find_job($editId);
} elseif ($editType === 'blog' && $editId !== '') {
  $editItem = wbi_find_blog($editId);
} elseif ($editType === 'principal_list' && $editId !== '') {
  $editItem = wbi_find_principal_list($editId);
} elseif ($editType === 'activity' && $editId !== '') {
  $editItem = wbi_find_activity($editId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? 'create';
  $type = $_POST['type'] ?? '';
  if ($action === 'review_admission') {
    $admissionId = trim((string) ($_POST['admission_id'] ?? ''));
    $reviewStatus = trim((string) ($_POST['review_status'] ?? 'Pending'));
    $reviewNote = trim((string) ($_POST['review_note'] ?? ''));

    if ($admissionId === '') {
      $error = 'Invalid admission record.';
    } elseif (wbi_update_admission_review($admissionId, $reviewStatus, $reviewNote)) {
      $notice = 'Admission review updated successfully.';
    } else {
      $error = 'Unable to update admission review.';
    }
  }

  $id = $_POST['id'] ?? '';
  $title = trim($_POST['title'] ?? '');
  $summary = trim($_POST['summary'] ?? '');
  $content = trim($_POST['content'] ?? '');
  $deadline = trim($_POST['deadline'] ?? '');

  if ($action === 'review_admission') {
    // Admission review is handled above.
  } elseif ($action === 'delete') {
    if ($type === 'news') {
      $item = wbi_find_news($id);
      if ($item && wbi_delete_news($id)) {
        wbi_remove_uploaded_post_image($item['image_path'] ?? '');
        $notice = 'News deleted successfully.';
      } else {
        $error = 'Unable to delete the selected item.';
      }
    } elseif ($type === 'job') {
      $item = wbi_find_job($id);
      if ($item && wbi_delete_job($id)) {
        wbi_remove_uploaded_post_image($item['image_path'] ?? '');
        $notice = 'Job vacancy deleted successfully.';
      } else {
        $error = 'Unable to delete the selected item.';
      }
    } elseif ($type === 'blog') {
      $item = wbi_find_blog($id);
      if ($item && wbi_delete_blog($id)) {
        wbi_remove_uploaded_post_image($item['image_path'] ?? '');
        $notice = 'Blog post deleted successfully.';
      } else {
        $error = 'Unable to delete the selected item.';
      }
    } elseif ($type === 'principal_list') {
      $item = wbi_find_principal_list($id);
      if ($item && wbi_delete_principal_list($id)) {
        wbi_remove_uploaded_post_image($item['image_path'] ?? '');
        $notice = 'Principal list entry deleted successfully.';
      } else {
        $error = 'Unable to delete the selected item.';
      }
    } elseif ($type === 'activity') {
      $item = wbi_find_activity($id);
      if ($item && wbi_delete_activity($id)) {
        wbi_remove_uploaded_post_image($item['image_path'] ?? '');
        $notice = 'Student activity deleted successfully.';
      } else {
        $error = 'Unable to delete the selected item.';
      }
    } else {
      $error = 'Unable to delete the selected item.';
    }

    $editType = '';
    $editId = '';
    $editItem = null;
  } elseif ($title === '' || $summary === '' || $content === '') {
    $error = 'Please complete title, summary, and content.';
  } else {
    $existingImage = '';
    if ($action === 'update' && $id !== '') {
      if ($type === 'news') {
        $existingImage = (string) ((wbi_find_news($id)['image_path'] ?? ''));
      } elseif ($type === 'job') {
        $existingImage = (string) ((wbi_find_job($id)['image_path'] ?? ''));
      } elseif ($type === 'blog') {
        $existingImage = (string) ((wbi_find_blog($id)['image_path'] ?? ''));
      } elseif ($type === 'principal_list') {
        $existingImage = (string) ((wbi_find_principal_list($id)['image_path'] ?? ''));
      } elseif ($type === 'activity') {
        $existingImage = (string) ((wbi_find_activity($id)['image_path'] ?? ''));
      }
    }

    $upload = wbi_handle_post_image_upload('post_image', $existingImage);
    if ($upload['error'] !== '') {
      $error = $upload['error'];
    } elseif ($action === 'update') {
      if ($type === 'news' && wbi_update_news($id, $title, $summary, $content, $upload['path'])) {
        $notice = 'News updated successfully.';
      } elseif ($type === 'job' && wbi_update_job($id, $title, $summary, $content, $deadline, $upload['path'])) {
        $notice = 'Job vacancy updated successfully.';
      } elseif ($type === 'blog' && wbi_update_blog($id, $title, $summary, $content, $upload['path'])) {
        $notice = 'Blog post updated successfully.';
      } elseif ($type === 'principal_list' && wbi_update_principal_list($id, $title, $summary, $content, $upload['path'])) {
        $notice = 'Principal list entry updated successfully.';
      } elseif ($type === 'activity' && wbi_update_activity($id, $title, $summary, $content, $upload['path'])) {
        $notice = 'Student activity updated successfully.';
      } else {
        $error = 'Unable to update the selected item.';
      }

      $editType = '';
      $editId = '';
      $editItem = null;
    } elseif ($type === 'news') {
      wbi_add_news($title, $summary, $content, $upload['path']);
      $notice = 'News posted successfully.';
    } elseif ($type === 'job') {
      wbi_add_job($title, $summary, $content, $deadline, $upload['path']);
      $notice = 'Job vacancy posted successfully.';
    } elseif ($type === 'blog') {
      wbi_add_blog($title, $summary, $content, $upload['path']);
      $notice = 'Blog post published successfully.';
    } elseif ($type === 'principal_list') {
      wbi_add_principal_list($title, $summary, $content, $upload['path']);
      $notice = 'Principal list entry posted successfully.';
    } elseif ($type === 'activity') {
      wbi_add_activity($title, $summary, $content, $upload['path']);
      $notice = 'Student activity posted successfully.';
    } else {
      $error = 'Invalid post type.';
    }
  }
}

$allNews = wbi_get_news();
$allJobs = wbi_get_jobs();
$allBlogs = wbi_get_blogs();
$allPrincipalList = wbi_get_principal_list();
$allActivities = wbi_get_activities();
$allAdmissions = wbi_get_admissions();

$latestNews = array_slice($allNews, 0, 3);
$latestJobs = array_slice($allJobs, 0, 3);
$latestBlogs = array_slice($allBlogs, 0, 3);
$latestPrincipalList = array_slice($allPrincipalList, 0, 3);
$latestActivities = array_slice($allActivities, 0, 3);
$latestAdmissions = array_slice($allAdmissions, 0, 8);

$publishedCount = count($allNews) + count($allJobs) + count($allBlogs) + count($allPrincipalList) + count($allActivities);
$pendingAdmissions = count(array_filter($allAdmissions, function ($item) {
  return (($item['status'] ?? 'Pending') === 'Pending');
}));
$approvedAdmissions = count(array_filter($allAdmissions, function ($item) {
  return (($item['status'] ?? '') === 'Approved');
}));
$declinedAdmissions = count(array_filter($allAdmissions, function ($item) {
  return (($item['status'] ?? '') === 'Declined');
}));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - WBI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
  <?php include __DIR__ . '/includes/header.php'; ?>

  <main class="admin-dashboard container py-4 py-lg-5" data-animate>
    <section class="admin-hero mb-4">
      <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3">
        <div>
          <span class="admin-eyebrow">Administration Console</span>
          <h1 class="admin-hero-title">Dashboard Overview</h1>
          <p class="admin-hero-text">Manage school content, monitor admissions, and keep the website up to date from one streamlined workspace.</p>
        </div>
        <div class="admin-hero-actions">
          <a class="btn btn-light" href="index.php">View Website</a>
          <a class="btn btn-outline-light" href="admin-logout.php">Logout</a>
        </div>
      </div>

      <div class="admin-metric-grid">
        <div class="admin-metric-card">
          <div class="metric-icon"><i class="bi bi-ui-checks-grid"></i></div>
          <div class="metric-value"><?php echo htmlspecialchars((string) $publishedCount); ?></div>
          <p class="metric-label">Published Content</p>
        </div>
        <div class="admin-metric-card">
          <div class="metric-icon"><i class="bi bi-person-lines-fill"></i></div>
          <div class="metric-value"><?php echo htmlspecialchars((string) count($allAdmissions)); ?></div>
          <p class="metric-label">Total Admissions</p>
        </div>
        <div class="admin-metric-card">
          <div class="metric-icon"><i class="bi bi-hourglass-split"></i></div>
          <div class="metric-value"><?php echo htmlspecialchars((string) $pendingAdmissions); ?></div>
          <p class="metric-label">Pending Reviews</p>
        </div>
        <div class="admin-metric-card">
          <div class="metric-icon"><i class="bi bi-check2-circle"></i></div>
          <div class="metric-value"><?php echo htmlspecialchars((string) $approvedAdmissions); ?></div>
          <p class="metric-label">Approved</p>
        </div>
        <div class="admin-metric-card">
          <div class="metric-icon"><i class="bi bi-x-circle"></i></div>
          <div class="metric-value"><?php echo htmlspecialchars((string) $declinedAdmissions); ?></div>
          <p class="metric-label">Declined</p>
        </div>
      </div>
    </section>

    <div class="admin-shell row g-4 align-items-start">
      <aside class="col-lg-3 admin-sidebar-col">
        <div class="admin-sidebar admin-panel p-3 sticky-top">
          <div class="admin-sidebar-brand mb-3">
            <div class="admin-sidebar-mark">WBI</div>
            <div>
              <div class="admin-sidebar-title">Admin Navigation</div>
              <div class="admin-sidebar-subtitle">Quick access</div>
            </div>
          </div>

          <nav class="nav flex-column admin-nav nav-pills admin-tabs gap-1">
            <a class="nav-link active" href="admin-dashboard.php">Overview</a>
            <a class="nav-link" href="admin-posts.php">Posts</a>
            <a class="nav-link" href="admin-admissions.php">Admissions</a>
            <a class="nav-link" href="admin-transcripts.php">Transcripts</a>
          </nav>

          <hr class="my-3">

          <div class="d-grid gap-2">
            <a class="btn btn-school btn-sm" href="admissions.php">Admissions Page</a>
            <a class="btn btn-outline-secondary btn-sm" href="index.php">View Website</a>
            <a class="btn btn-outline-danger btn-sm" href="admin-logout.php">Logout</a>
          </div>
        </div>
      </aside>

      <div class="col-lg-9">

    <?php if ($notice !== ''): ?>
      <div class="alert alert-success"><?php echo htmlspecialchars($notice); ?></div>
    <?php endif; ?>
    <?php if ($error !== ''): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <section class="row g-4 mb-4" id="admin-overview">
      <div class="col-lg-5" id="post-update">
        <div class="admin-panel p-4">
          <div class="admin-panel-header">
            <div>
              <h2 class="admin-panel-title">Post Update</h2>
              <p class="admin-panel-subtitle">Publish school news, blog posts, activities, jobs, and principal list entries.</p>
            </div>
          </div>
          <form method="post" enctype="multipart/form-data" class="row g-3 text-start">
            <input type="hidden" name="action" value="<?php echo $editItem ? 'update' : 'create'; ?>">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($editItem['id'] ?? ''); ?>">
            <div class="col-12">
              <label class="form-label">Type</label>
              <select class="form-select" name="type" required>
                <option value="news" <?php echo (($editType ?: 'news') === 'news') ? 'selected' : ''; ?>>School News</option>
                <option value="job" <?php echo (($editType ?: '') === 'job') ? 'selected' : ''; ?>>Job Vacancy</option>
                <option value="blog" <?php echo (($editType ?: '') === 'blog') ? 'selected' : ''; ?>>Blog Post</option>
                <option value="principal_list" <?php echo (($editType ?: '') === 'principal_list') ? 'selected' : ''; ?>>Top Principal List</option>
                <option value="activity" <?php echo (($editType ?: '') === 'activity') ? 'selected' : ''; ?>>Student Activity</option>
              </select>
            </div>
            <div class="col-12">
              <label class="form-label">Title</label>
              <input class="form-control" name="title" value="<?php echo htmlspecialchars($editItem['title'] ?? ''); ?>" required>
            </div>
            <div class="col-12">
              <label class="form-label">Summary</label>
              <input class="form-control" name="summary" value="<?php echo htmlspecialchars($editItem['summary'] ?? ''); ?>" required>
            </div>
            <div class="col-12">
              <label class="form-label">Full Content</label>
              <textarea class="form-control" name="content" rows="6" required><?php echo htmlspecialchars($editItem['content'] ?? ''); ?></textarea>
            </div>
            <div class="col-12">
              <label class="form-label">Application Deadline (for jobs only)</label>
              <input class="form-control" name="deadline" value="<?php echo htmlspecialchars($editItem['deadline'] ?? ''); ?>" placeholder="e.g. 30 Sep 2026">
            </div>
            <div class="col-12">
              <label class="form-label">Photo (JPG, PNG, WEBP up to 3MB)</label>
              <input class="form-control" type="file" name="post_image" accept="image/jpeg,image/png,image/webp">
              <?php if (!empty($editItem['image_path'])): ?>
                <small class="d-block mt-2 text-muted">Current image:</small>
                <img src="<?php echo htmlspecialchars($editItem['image_path']); ?>" alt="Current post image" class="img-fluid rounded-3 mt-2" style="max-width: 180px;">
              <?php endif; ?>
            </div>
            <div class="col-12 d-flex flex-wrap gap-2">
              <button class="btn btn-school" type="submit"><?php echo $editItem ? 'Update' : 'Publish'; ?></button>
              <?php if ($editItem): ?>
                <a class="btn btn-outline-secondary" href="admin-dashboard.php">Cancel Edit</a>
              <?php endif; ?>
            </div>
          </form>
        </div>
      </div>

      <div class="col-lg-7">
        <div class="admin-panel admin-panel-soft p-4 h-100" id="content-studio">
          <div class="admin-panel-header">
            <div>
              <h2 class="admin-panel-title">Content Studio</h2>
              <p class="admin-panel-subtitle">Latest items with quick edit and delete actions.</p>
            </div>
          </div>

          <div class="row g-4">
            <div class="col-md-6">
              <div class="admin-stream-card">
                <div class="stream-head">
                  <div>
                    <h3 class="h6 mb-1">School News</h3>
                    <p class="admin-panel-subtitle mb-0">Recent updates</p>
                  </div>
                  <span class="stream-count"><?php echo htmlspecialchars((string) count($allNews)); ?></span>
                </div>
                <div class="admin-entry-list">
                  <?php foreach ($latestNews as $item): ?>
                    <div class="admin-entry">
                      <p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p>
                      <p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p>
                      <div class="mt-2 d-flex flex-wrap gap-2">
                        <a class="btn btn-sm btn-outline-primary" href="admin-dashboard.php?edit_type=news&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a>
                        <form method="post" class="d-inline">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="type" value="news">
                          <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                          <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                      </div>
                    </div>
                  <?php endforeach; ?>
                  <?php if (empty($latestNews)): ?>
                    <div class="admin-entry text-muted">No news posted yet.</div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="admin-stream-card">
                <div class="stream-head">
                  <div>
                    <h3 class="h6 mb-1">Job Vacancies</h3>
                    <p class="admin-panel-subtitle mb-0">Open positions</p>
                  </div>
                  <span class="stream-count"><?php echo htmlspecialchars((string) count($allJobs)); ?></span>
                </div>
                <div class="admin-entry-list">
                  <?php foreach ($latestJobs as $item): ?>
                    <div class="admin-entry">
                      <p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p>
                      <p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p>
                      <div class="mt-2 d-flex flex-wrap gap-2">
                        <a class="btn btn-sm btn-outline-primary" href="admin-dashboard.php?edit_type=job&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a>
                        <form method="post" class="d-inline">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="type" value="job">
                          <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                          <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                      </div>
                    </div>
                  <?php endforeach; ?>
                  <?php if (empty($latestJobs)): ?>
                    <div class="admin-entry text-muted">No job vacancies posted yet.</div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="admin-stream-card">
                <div class="stream-head">
                  <div>
                    <h3 class="h6 mb-1">Blog Posts</h3>
                    <p class="admin-panel-subtitle mb-0">School stories</p>
                  </div>
                  <span class="stream-count"><?php echo htmlspecialchars((string) count($allBlogs)); ?></span>
                </div>
                <div class="admin-entry-list">
                  <?php foreach ($latestBlogs as $item): ?>
                    <div class="admin-entry">
                      <p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p>
                      <p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p>
                      <div class="mt-2 d-flex flex-wrap gap-2">
                        <a class="btn btn-sm btn-outline-primary" href="admin-dashboard.php?edit_type=blog&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a>
                        <form method="post" class="d-inline">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="type" value="blog">
                          <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                          <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                      </div>
                    </div>
                  <?php endforeach; ?>
                  <?php if (empty($latestBlogs)): ?>
                    <div class="admin-entry text-muted">No blog posts yet.</div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="admin-stream-card">
                <div class="stream-head">
                  <div>
                    <h3 class="h6 mb-1">Principal List</h3>
                    <p class="admin-panel-subtitle mb-0">Recognitions</p>
                  </div>
                  <span class="stream-count"><?php echo htmlspecialchars((string) count($allPrincipalList)); ?></span>
                </div>
                <div class="admin-entry-list">
                  <?php foreach ($latestPrincipalList as $item): ?>
                    <div class="admin-entry">
                      <p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p>
                      <p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p>
                      <div class="mt-2 d-flex flex-wrap gap-2">
                        <a class="btn btn-sm btn-outline-primary" href="admin-dashboard.php?edit_type=principal_list&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a>
                        <form method="post" class="d-inline">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="type" value="principal_list">
                          <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                          <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                      </div>
                    </div>
                  <?php endforeach; ?>
                  <?php if (empty($latestPrincipalList)): ?>
                    <div class="admin-entry text-muted">No principal list entries yet.</div>
                  <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <div class="admin-stream-card">
                <div class="stream-head">
                  <div>
                    <h3 class="h6 mb-1">Student Activities</h3>
                    <p class="admin-panel-subtitle mb-0">Events, clubs, and campus life</p>
                  </div>
                  <span class="stream-count"><?php echo htmlspecialchars((string) count($allActivities)); ?></span>
                </div>
                <div class="admin-entry-list">
                  <?php foreach ($latestActivities as $item): ?>
                    <div class="admin-entry">
                      <p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p>
                      <p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p>
                      <div class="mt-2 d-flex flex-wrap gap-2">
                        <a class="btn btn-sm btn-outline-primary" href="admin-dashboard.php?edit_type=activity&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a>
                        <form method="post" class="d-inline">
                          <input type="hidden" name="action" value="delete">
                          <input type="hidden" name="type" value="activity">
                          <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                          <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
                        </form>
                      </div>
                    </div>
                  <?php endforeach; ?>
                  <?php if (empty($latestActivities)): ?>
                    <div class="admin-entry text-muted">No student activities yet.</div>
                  <?php endif; ?>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="row g-4" id="admissions-desk">
      <div class="col-lg-4">
        <div class="admin-panel admin-panel-soft p-4 h-100">
          <div class="admin-panel-header">
            <div>
              <h2 class="admin-panel-title">Admissions Desk</h2>
              <p class="admin-panel-subtitle">Review registrations, update status, and add notes.</p>
            </div>
          </div>
          <div class="mb-3">
            <div class="d-flex justify-content-between mb-2"><span>Pending</span><strong><?php echo htmlspecialchars((string) $pendingAdmissions); ?></strong></div>
            <div class="d-flex justify-content-between mb-2"><span>Approved</span><strong><?php echo htmlspecialchars((string) $approvedAdmissions); ?></strong></div>
            <div class="d-flex justify-content-between"><span>Declined</span><strong><?php echo htmlspecialchars((string) $declinedAdmissions); ?></strong></div>
          </div>
          <div class="d-grid gap-2">
            <a class="btn btn-school" href="admissions.php">Open Admissions Page</a>
            <a class="btn btn-outline-secondary" href="admission-result.php">Result Slip Preview</a>
          </div>
        </div>
      </div>

      <div class="col-lg-8">
        <div class="admission-queue">
          <?php foreach ($latestAdmissions as $admission): ?>
            <?php
              $status = (string) ($admission['status'] ?? 'Pending');
              $statusClass = 'pending';
              if ($status === 'Approved') {
                $statusClass = 'approved';
              } elseif ($status === 'Declined') {
                $statusClass = 'declined';
              }
            ?>
            <div class="admission-item">
              <div class="d-flex flex-column flex-md-row gap-3 align-items-md-start">
                <?php if (!empty($admission['student_photo'])): ?>
                  <img class="admission-photo" src="<?php echo htmlspecialchars($admission['student_photo']); ?>" alt="Student photo">
                <?php else: ?>
                  <div class="admission-photo d-flex align-items-center justify-content-center text-muted">No Photo</div>
                <?php endif; ?>

                <div class="flex-grow-1">
                  <div class="d-flex flex-column flex-lg-row justify-content-between gap-2 align-items-start">
                    <div>
                      <h3 class="h5 mb-1"><?php echo htmlspecialchars($admission['student_name'] ?? ''); ?></h3>
                      <div class="text-muted small"><?php echo htmlspecialchars($admission['application_number'] ?? ''); ?></div>
                    </div>
                    <span class="admission-badge <?php echo $statusClass; ?>"><?php echo htmlspecialchars($status); ?></span>
                  </div>

                  <div class="row g-2 mt-2 small">
                    <div class="col-md-6"><strong>Type:</strong> <?php echo htmlspecialchars(ucfirst((string) ($admission['student_type'] ?? ''))); ?></div>
                    <div class="col-md-6"><strong>Grade:</strong> <?php echo htmlspecialchars($admission['grade_applying'] ?? ''); ?></div>
                    <div class="col-md-6"><strong>Parent:</strong> <?php echo htmlspecialchars($admission['parent_name'] ?? ''); ?></div>
                    <div class="col-md-6"><strong>Phone:</strong> <?php echo htmlspecialchars($admission['parent_phone'] ?? ''); ?></div>
                    <div class="col-12 text-muted"><strong>Submitted:</strong> <?php echo htmlspecialchars(date('M d, Y h:i A', strtotime((string) ($admission['created_at'] ?? 'now')))); ?></div>
                  </div>

                  <div class="d-flex flex-wrap gap-2 mt-3">
                    <a class="btn btn-sm btn-outline-primary" target="_blank" href="admission-result.php?id=<?php echo urlencode($admission['id'] ?? ''); ?>">Open Slip</a>
                  </div>

                  <form method="post" class="mt-3 row g-2 align-items-end">
                    <input type="hidden" name="action" value="review_admission">
                    <input type="hidden" name="admission_id" value="<?php echo htmlspecialchars($admission['id'] ?? ''); ?>">
                    <div class="col-md-4">
                      <label class="form-label small mb-1">Status</label>
                      <select class="form-select form-select-sm" name="review_status">
                        <option value="Pending" <?php echo (($admission['status'] ?? '') === 'Pending') ? 'selected' : ''; ?>>Pending</option>
                        <option value="Approved" <?php echo (($admission['status'] ?? '') === 'Approved') ? 'selected' : ''; ?>>Approved</option>
                        <option value="Declined" <?php echo (($admission['status'] ?? '') === 'Declined') ? 'selected' : ''; ?>>Declined</option>
                      </select>
                    </div>
                    <div class="col-md-5">
                      <label class="form-label small mb-1">Admin Note</label>
                      <input class="form-control form-control-sm" name="review_note" value="<?php echo htmlspecialchars($admission['admin_note'] ?? ''); ?>" placeholder="Optional note">
                    </div>
                    <div class="col-md-3 d-grid">
                      <button class="btn btn-sm btn-school" type="submit">Save Review</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          <?php endforeach; ?>

          <?php if (empty($latestAdmissions)): ?>
            <div class="admission-item text-muted">No admission records yet.</div>
          <?php endif; ?>
        </div>
      </div>
    </section>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
