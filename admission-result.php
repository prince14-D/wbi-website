<?php
$pageTitle = 'Admission Result Slip';
require __DIR__ . '/includes/content_store.php';

$admission = null;
$id = trim((string) ($_GET['id'] ?? ''));
$app = trim((string) ($_GET['app'] ?? ''));

if ($id !== '') {
    $admission = wbi_find_admission($id);
}

if (!$admission && $app !== '') {
    $admission = wbi_find_admission_by_application_number($app);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - William Bean Institute</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .result-shell {
            max-width: 900px;
            margin: 1.5rem auto;
            background: #fff;
            border: 1px solid #efd0d7;
            border-radius: 14px;
            box-shadow: 0 12px 24px rgba(77, 20, 41, 0.12);
            overflow: hidden;
        }

        .result-head {
            background: linear-gradient(120deg, #6b1e3a, #4d1429);
            color: #fff;
            padding: 1rem 1.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .result-brand {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .result-brand img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.75);
            background: #fff;
        }

        .result-body {
            padding: 1.1rem;
        }

        .student-photo {
            width: 150px;
            height: 180px;
            border-radius: 8px;
            object-fit: cover;
            border: 1px solid #efd0d7;
        }

        .status-chip {
            display: inline-block;
            border-radius: 999px;
            padding: 0.2rem 0.75rem;
            font-size: 0.82rem;
            font-weight: 700;
        }

        .status-pending { background: #ffe6a8; color: #5c4707; }
        .status-approved { background: #c7f1d5; color: #0f5132; }
        .status-declined { background: #f8d7da; color: #842029; }

        .print-actions {
            text-align: right;
            margin-top: 1rem;
        }

        @media print {
            body {
                background: #fff;
            }

            .site-header,
            .site-footer,
            .print-actions {
                display: none !important;
            }

            .result-shell {
                box-shadow: none;
                border: 1px solid #999;
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container py-4">
        <?php if (!$admission): ?>
            <div class="card p-4 text-center">
                <h1 class="h4">Admission Record Not Found</h1>
                <p class="mb-3">Please confirm your application number and try again.</p>
                <a href="admissions.php" class="btn btn-school">Back to Admissions</a>
            </div>
        <?php else: ?>
            <?php
                $statusClass = 'status-pending';
                if (($admission['status'] ?? '') === 'Approved') {
                    $statusClass = 'status-approved';
                }
                if (($admission['status'] ?? '') === 'Declined') {
                    $statusClass = 'status-declined';
                }
            ?>
            <div class="result-shell">
                <div class="result-head">
                    <div class="result-brand">
                        <img src="assets/images/WBI-logo.png" alt="WBI logo">
                        <div>
                            <h1 class="h5 mb-1">World Wide Missions School (WBI)</h1>
                            <p class="mb-0 small">Duport Road, Monrovia, Liberia | Admission Result Slip</p>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="small">Application Number</div>
                        <strong><?php echo htmlspecialchars($admission['application_number'] ?? ''); ?></strong>
                    </div>
                </div>

                <div class="result-body">
                    <div class="row g-3">
                        <div class="col-md-9">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <tbody>
                                    <tr><th style="width: 32%;">Student Name</th><td><?php echo htmlspecialchars($admission['student_name'] ?? ''); ?></td></tr>
                                    <tr><th>Student Type</th><td><?php echo htmlspecialchars(ucfirst((string) ($admission['student_type'] ?? ''))); ?></td></tr>
                                    <tr><th>Date of Birth</th><td><?php echo htmlspecialchars($admission['date_of_birth'] ?? ''); ?></td></tr>
                                    <tr><th>Gender</th><td><?php echo htmlspecialchars($admission['gender'] ?? ''); ?></td></tr>
                                    <tr><th>Grade Applying</th><td><?php echo htmlspecialchars($admission['grade_applying'] ?? ''); ?></td></tr>
                                    <tr><th>Parent/Guardian</th><td><?php echo htmlspecialchars($admission['parent_name'] ?? ''); ?></td></tr>
                                    <tr><th>Parent Phone</th><td><?php echo htmlspecialchars($admission['parent_phone'] ?? ''); ?></td></tr>
                                    <tr><th>Parent Email</th><td><?php echo htmlspecialchars($admission['parent_email'] ?? ''); ?></td></tr>
                                    <tr><th>Address</th><td><?php echo htmlspecialchars($admission['address'] ?? ''); ?></td></tr>
                                    <tr><th>Status</th><td><span class="status-chip <?php echo $statusClass; ?>"><?php echo htmlspecialchars($admission['status'] ?? 'Pending'); ?></span></td></tr>
                                    <tr><th>Admin Note</th><td><?php echo htmlspecialchars($admission['admin_note'] ?? ''); ?></td></tr>
                                    <tr><th>Submitted At</th><td><?php echo htmlspecialchars(date('M d, Y h:i A', strtotime((string) ($admission['created_at'] ?? 'now')))); ?></td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3 text-center">
                            <?php if (!empty($admission['student_photo'])): ?>
                                <img class="student-photo" src="<?php echo htmlspecialchars($admission['student_photo']); ?>" alt="Student photo">
                            <?php else: ?>
                                <div class="student-photo d-flex align-items-center justify-content-center text-muted">No Photo</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="print-actions">
                        <button type="button" class="btn btn-school" onclick="window.print()">Download/Print PDF</button>
                        <a href="admissions.php" class="btn btn-outline-secondary">Back to Admissions</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
