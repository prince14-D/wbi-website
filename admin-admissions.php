<?php
require __DIR__ . '/includes/admin_auth.php';
require __DIR__ . '/includes/content_store.php';
require __DIR__ . '/includes/upload_helpers.php';

wbi_admin_require_auth();

$notice = '';
$error = '';
$statusFilter = strtolower(trim((string) ($_GET['status'] ?? 'all')));
$validFilters = ['all', 'new', 'returning'];
if (!in_array($statusFilter, $validFilters, true)) {
    $statusFilter = 'all';
}

$allAdmissions = wbi_get_admissions();

if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    $exportAdmissions = array_values(array_filter($allAdmissions, function ($admission) use ($statusFilter) {
        if ($statusFilter === 'all') {
            return true;
        }
        return strtolower((string) ($admission['student_type'] ?? '')) === $statusFilter;
    }));

    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="wbi-admissions-' . $statusFilter . '-' . date('Y-m-d') . '.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Application Number', 'Student Name', 'Student Type', 'Date of Birth', 'Gender', 'Grade Applying', 'Previous School', 'Last Class Completed', 'Parent Name', 'Parent Phone', 'Parent Email', 'Address', 'Status', 'Admin Note', 'Submitted At']);

    foreach ($exportAdmissions as $admission) {
        fputcsv($output, [
            $admission['application_number'] ?? '',
            $admission['student_name'] ?? '',
            ucfirst((string) ($admission['student_type'] ?? '')),
            $admission['date_of_birth'] ?? '',
            $admission['gender'] ?? '',
            $admission['grade_applying'] ?? '',
            $admission['previous_school'] ?? '',
            $admission['last_class_completed'] ?? '',
            $admission['parent_name'] ?? '',
            $admission['parent_phone'] ?? '',
            $admission['parent_email'] ?? '',
            $admission['address'] ?? '',
            $admission['status'] ?? 'Pending',
            $admission['admin_note'] ?? '',
            $admission['created_at'] ?? '',
        ]);
    }

    fclose($output);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

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
    } elseif ($action === 'delete_admission') {
        $admissionId = trim((string) ($_POST['admission_id'] ?? ''));
        if ($admissionId === '') {
            $error = 'Invalid admission record.';
        } elseif (wbi_delete_admission($admissionId)) {
            $notice = 'Admission deleted successfully.';
        } else {
            $error = 'Unable to delete the selected admission.';
        }
    }
}

$filteredAdmissions = array_values(array_filter($allAdmissions, function ($admission) use ($statusFilter) {
    if ($statusFilter === 'all') {
        return true;
    }
    return strtolower((string) ($admission['student_type'] ?? '')) === $statusFilter;
}));

$allCount = count($allAdmissions);
$newCount = count(array_filter($allAdmissions, function ($admission) {
    return strtolower((string) ($admission['student_type'] ?? '')) === 'new';
}));
$returningCount = count(array_filter($allAdmissions, function ($admission) {
    return strtolower((string) ($admission['student_type'] ?? '')) === 'returning';
}));
$pendingCount = count(array_filter($allAdmissions, function ($admission) {
    return (($admission['status'] ?? 'Pending') === 'Pending');
}));
$approvedCount = count(array_filter($allAdmissions, function ($admission) {
    return (($admission['status'] ?? '') === 'Approved');
}));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admissions Admin - WBI</title>
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
                    <span class="admin-eyebrow">Admissions Console</span>
                    <h1 class="admin-hero-title">Admission Records</h1>
                    <p class="admin-hero-text">Filter new and returning students, export CSV files, review submissions, and manage records from one place.</p>
                </div>
                <div class="admin-hero-actions">
                    <a class="btn btn-light" href="admin-dashboard.php">Dashboard</a>
                    <a class="btn btn-outline-light" href="admin-posts.php">Posts</a>
                    <a class="btn btn-outline-light" href="admin-transcripts.php">Transcripts</a>
                    <a class="btn btn-outline-light" href="admin-logout.php">Logout</a>
                </div>
            </div>

            <div class="admin-metric-grid">
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-people-fill"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $allCount); ?></div><p class="metric-label">Total</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-person-plus-fill"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $newCount); ?></div><p class="metric-label">New Students</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-arrow-repeat"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $returningCount); ?></div><p class="metric-label">Returning</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-hourglass-split"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $pendingCount); ?></div><p class="metric-label">Pending</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-check2-circle"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $approvedCount); ?></div><p class="metric-label">Approved</p></div>
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
                            <div class="admin-sidebar-title">Admissions Nav</div>
                            <div class="admin-sidebar-subtitle">Export and filter</div>
                        </div>
                    </div>

                    <nav class="nav flex-column admin-nav nav-pills admin-tabs gap-1">
                        <a class="nav-link <?php echo $statusFilter === 'all' ? 'active' : ''; ?>" href="admin-admissions.php?status=all">All Admissions</a>
                        <a class="nav-link <?php echo $statusFilter === 'new' ? 'active' : ''; ?>" href="admin-admissions.php?status=new">New Students</a>
                        <a class="nav-link <?php echo $statusFilter === 'returning' ? 'active' : ''; ?>" href="admin-admissions.php?status=returning">Returning Students</a>
                    </nav>

                    <hr class="my-3">

                    <div class="d-grid gap-2">
                        <a class="btn btn-school btn-sm" href="admin-admissions.php?status=<?php echo urlencode($statusFilter); ?>&export=csv">Export CSV</a>
                        <a class="btn btn-outline-secondary btn-sm" href="admissions.php">Public Admissions</a>
                        <a class="btn btn-outline-secondary btn-sm" href="admin-dashboard.php">Dashboard</a>
                    </div>
                </div>
            </aside>

            <div class="col-lg-9">
                <div class="admin-panel p-4">
                    <div class="admin-panel-header">
                        <div>
                            <h2 class="admin-panel-title">Filtered Records</h2>
                            <p class="admin-panel-subtitle">Showing <?php echo htmlspecialchars(ucfirst($statusFilter)); ?> admissions.</p>
                        </div>
                    </div>

                    <div class="admission-queue">
                        <?php foreach ($filteredAdmissions as $admission): ?>
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
                                            <form method="post" class="d-inline">
                                                <input type="hidden" name="action" value="delete_admission">
                                                <input type="hidden" name="admission_id" value="<?php echo htmlspecialchars($admission['id'] ?? ''); ?>">
                                                <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this admission record?');">Delete Admission</button>
                                            </form>
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

                        <?php if (empty($filteredAdmissions)): ?>
                            <div class="admission-item text-muted">No admission records found for this filter.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
