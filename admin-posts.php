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
    $id = $_POST['id'] ?? '';
    $title = trim($_POST['title'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    $content = trim($_POST['content'] ?? '');
    $deadline = trim($_POST['deadline'] ?? '');

    if ($action === 'delete') {
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

$latestNews = array_slice($allNews, 0, 3);
$latestJobs = array_slice($allJobs, 0, 3);
$latestBlogs = array_slice($allBlogs, 0, 3);
$latestPrincipalList = array_slice($allPrincipalList, 0, 3);
$latestActivities = array_slice($allActivities, 0, 3);

$publishedCount = count($allNews) + count($allJobs) + count($allBlogs) + count($allPrincipalList) + count($allActivities);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Posts Admin - WBI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="admin-dashboard container py-4 py-lg-5" data-animate>
        <section class="admin-hero mb-4">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start gap-3">
                <div>
                    <span class="admin-eyebrow">Content Console</span>
                    <h1 class="admin-hero-title">Posts Management</h1>
                    <p class="admin-hero-text">Create, edit, and delete school content from a focused content workspace.</p>
                </div>
                <div class="admin-hero-actions">
                    <a class="btn btn-light" href="admin-dashboard.php">Dashboard</a>
                    <a class="btn btn-outline-light" href="admin-admissions.php">Admissions</a>
                    <a class="btn btn-outline-light" href="admin-transcripts.php">Transcripts</a>
                    <a class="btn btn-outline-light" href="admin-logout.php">Logout</a>
                </div>
            </div>

            <div class="admin-metric-grid">
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-newspaper"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $publishedCount); ?></div><p class="metric-label">Published Items</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-megaphone-fill"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) count($allNews)); ?></div><p class="metric-label">News</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-briefcase-fill"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) count($allJobs)); ?></div><p class="metric-label">Jobs</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-journal-text"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) count($allBlogs)); ?></div><p class="metric-label">Blogs</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-people-fill"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) count($allActivities)); ?></div><p class="metric-label">Activities</p></div>
            </div>
        </section>

        <?php if ($notice !== ''): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($notice); ?></div>
        <?php endif; ?>
        <?php if ($error !== ''): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <section class="row g-4 align-items-start">
            <aside class="col-lg-3 admin-sidebar-col">
                <div class="admin-sidebar admin-panel p-3 sticky-top">
                    <div class="admin-sidebar-brand mb-3">
                        <div class="admin-sidebar-mark">WBI</div>
                        <div>
                            <div class="admin-sidebar-title">Posts Nav</div>
                            <div class="admin-sidebar-subtitle">Manage content</div>
                        </div>
                    </div>

                    <nav class="nav flex-column admin-nav nav-pills admin-tabs gap-1">
                        <a class="nav-link" href="admin-dashboard.php">Dashboard</a>
                        <a class="nav-link active" href="admin-posts.php">Posts</a>
                        <a class="nav-link" href="admin-admissions.php">Admissions</a>
                        <a class="nav-link" href="admin-transcripts.php">Transcripts</a>
                    </nav>

                    <hr class="my-3">

                    <div class="d-grid gap-2">
                        <a class="btn btn-school btn-sm" href="index.php">View Website</a>
                        <a class="btn btn-outline-danger btn-sm" href="admin-logout.php">Logout</a>
                    </div>
                </div>
            </aside>

            <div class="col-lg-9">
                <div class="row g-4 mb-4">
                    <div class="col-lg-5" id="post-update">
                        <div class="admin-panel p-4 h-100">
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
                                <div class="col-12"><label class="form-label">Title</label><input class="form-control" name="title" value="<?php echo htmlspecialchars($editItem['title'] ?? ''); ?>" required></div>
                                <div class="col-12"><label class="form-label">Summary</label><input class="form-control" name="summary" value="<?php echo htmlspecialchars($editItem['summary'] ?? ''); ?>" required></div>
                                <div class="col-12"><label class="form-label">Full Content</label><textarea class="form-control" name="content" rows="6" required><?php echo htmlspecialchars($editItem['content'] ?? ''); ?></textarea></div>
                                <div class="col-12"><label class="form-label">Application Deadline (for jobs only)</label><input class="form-control" name="deadline" value="<?php echo htmlspecialchars($editItem['deadline'] ?? ''); ?>" placeholder="e.g. 30 Sep 2026"></div>
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
                                    <?php if ($editItem): ?><a class="btn btn-outline-secondary" href="admin-posts.php">Cancel Edit</a><?php endif; ?>
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
                                <div class="col-md-6"><div class="admin-stream-card"><div class="stream-head"><div><h3 class="h6 mb-1">School News</h3><p class="admin-panel-subtitle mb-0">Recent updates</p></div><span class="stream-count"><?php echo htmlspecialchars((string) count($allNews)); ?></span></div><div class="admin-entry-list"><?php foreach ($latestNews as $item): ?><div class="admin-entry"><p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p><p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p><div class="mt-2 d-flex flex-wrap gap-2"><a class="btn btn-sm btn-outline-primary" href="admin-posts.php?edit_type=news&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a><form method="post" class="d-inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="type" value="news"><input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>"><button class="btn btn-sm btn-outline-danger" type="submit">Delete</button></form></div></div><?php endforeach; ?><?php if (empty($latestNews)): ?><div class="admin-entry text-muted">No news posted yet.</div><?php endif; ?></div></div></div>
                                <div class="col-md-6"><div class="admin-stream-card"><div class="stream-head"><div><h3 class="h6 mb-1">Job Vacancies</h3><p class="admin-panel-subtitle mb-0">Open positions</p></div><span class="stream-count"><?php echo htmlspecialchars((string) count($allJobs)); ?></span></div><div class="admin-entry-list"><?php foreach ($latestJobs as $item): ?><div class="admin-entry"><p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p><p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p><div class="mt-2 d-flex flex-wrap gap-2"><a class="btn btn-sm btn-outline-primary" href="admin-posts.php?edit_type=job&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a><form method="post" class="d-inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="type" value="job"><input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>"><button class="btn btn-sm btn-outline-danger" type="submit">Delete</button></form></div></div><?php endforeach; ?><?php if (empty($latestJobs)): ?><div class="admin-entry text-muted">No job vacancies posted yet.</div><?php endif; ?></div></div></div>
                                <div class="col-md-6"><div class="admin-stream-card"><div class="stream-head"><div><h3 class="h6 mb-1">Blog Posts</h3><p class="admin-panel-subtitle mb-0">School stories</p></div><span class="stream-count"><?php echo htmlspecialchars((string) count($allBlogs)); ?></span></div><div class="admin-entry-list"><?php foreach ($latestBlogs as $item): ?><div class="admin-entry"><p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p><p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p><div class="mt-2 d-flex flex-wrap gap-2"><a class="btn btn-sm btn-outline-primary" href="admin-posts.php?edit_type=blog&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a><form method="post" class="d-inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="type" value="blog"><input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>"><button class="btn btn-sm btn-outline-danger" type="submit">Delete</button></form></div></div><?php endforeach; ?><?php if (empty($latestBlogs)): ?><div class="admin-entry text-muted">No blog posts yet.</div><?php endif; ?></div></div></div>
                                <div class="col-md-6"><div class="admin-stream-card"><div class="stream-head"><div><h3 class="h6 mb-1">Principal List</h3><p class="admin-panel-subtitle mb-0">Recognitions</p></div><span class="stream-count"><?php echo htmlspecialchars((string) count($allPrincipalList)); ?></span></div><div class="admin-entry-list"><?php foreach ($latestPrincipalList as $item): ?><div class="admin-entry"><p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p><p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p><div class="mt-2 d-flex flex-wrap gap-2"><a class="btn btn-sm btn-outline-primary" href="admin-posts.php?edit_type=principal_list&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a><form method="post" class="d-inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="type" value="principal_list"><input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>"><button class="btn btn-sm btn-outline-danger" type="submit">Delete</button></form></div></div><?php endforeach; ?><?php if (empty($latestPrincipalList)): ?><div class="admin-entry text-muted">No principal list entries yet.</div><?php endif; ?></div></div></div>
                                <div class="col-12"><div class="admin-stream-card"><div class="stream-head"><div><h3 class="h6 mb-1">Student Activities</h3><p class="admin-panel-subtitle mb-0">Events, clubs, and campus life</p></div><span class="stream-count"><?php echo htmlspecialchars((string) count($allActivities)); ?></span></div><div class="admin-entry-list"><?php foreach ($latestActivities as $item): ?><div class="admin-entry"><p class="entry-title"><?php echo htmlspecialchars($item['title']); ?></p><p class="entry-summary"><?php echo htmlspecialchars($item['summary']); ?></p><div class="mt-2 d-flex flex-wrap gap-2"><a class="btn btn-sm btn-outline-primary" href="admin-posts.php?edit_type=activity&amp;edit_id=<?php echo urlencode($item['id']); ?>">Edit</a><form method="post" class="d-inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="type" value="activity"><input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>"><button class="btn btn-sm btn-outline-danger" type="submit">Delete</button></form></div></div><?php endforeach; ?><?php if (empty($latestActivities)): ?><div class="admin-entry text-muted">No student activities yet.</div><?php endif; ?></div></div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
