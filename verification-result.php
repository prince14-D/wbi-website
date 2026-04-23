<?php
$pageTitle = 'Verified Transcript';
require __DIR__ . '/includes/content_store.php';

$record = null;
$id = trim((string) ($_GET['id'] ?? ''));

if ($id !== '') {
    $record = wbi_find_transcript_by_id($id);
}

$verificationUrl = '';
$qrCodeUrl = '';
if ($record) {
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = (string) ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $path = rtrim(str_replace('\\', '/', dirname((string) ($_SERVER['SCRIPT_NAME'] ?? ''))), '/');
    $basePath = $path === '' ? '' : $path;
    $verificationUrl = $scheme . '://' . $host . $basePath . '/verification-result.php?id=' . urlencode((string) ($record['id'] ?? ''));
    $qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=170x170&margin=10&data=' . rawurlencode($verificationUrl);
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
        .transcript-shell {
            position: relative;
            max-width: 940px;
            margin: 1.5rem auto;
            background: #fff;
            border: 1px solid #e8c8d0;
            border-radius: 16px;
            box-shadow: 0 14px 28px rgba(77, 20, 41, 0.14);
            overflow: hidden;
        }

        .transcript-shell::before {
            content: "WBI VERIFIED";
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%) rotate(-24deg);
            font-size: clamp(2.6rem, 8vw, 5rem);
            font-weight: 900;
            color: rgba(107, 30, 58, 0.06);
            letter-spacing: 0.2rem;
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
        }

        .transcript-head,
        .transcript-body {
            position: relative;
            z-index: 1;
        }

        .transcript-head {
            background: linear-gradient(120deg, #6b1e3a, #4d1429);
            color: #fff;
            padding: 1rem 1.2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
        }

        .transcript-brand {
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .transcript-brand img {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.75);
            background: #fff;
        }

        .transcript-body {
            padding: 1.2rem;
        }

        .student-photo {
            width: 160px;
            height: 195px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #e8c8d0;
            background: #f8f9fa;
        }

        .status-chip {
            display: inline-block;
            border-radius: 999px;
            padding: 0.24rem 0.8rem;
            font-size: 0.82rem;
            font-weight: 700;
            background: #d1e7dd;
            color: #0f5132;
        }

        .transcript-foot {
            border-top: 1px dashed #d8b8c0;
            margin-top: 0.8rem;
            padding-top: 0.8rem;
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .print-actions {
            text-align: right;
            margin-top: 1rem;
        }

        .qr-wrap {
            border: 1px solid #e8c8d0;
            border-radius: 10px;
            padding: 0.6rem;
            display: inline-block;
            background: #fff;
        }

        .qr-wrap img {
            width: 140px;
            height: 140px;
            display: block;
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

            .transcript-shell {
                box-shadow: none;
                border: 1px solid #8c8c8c;
                margin: 0;
                border-radius: 0;
            }
        }
    </style>
</head>
<body>
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="container py-4">
        <?php if (!$record): ?>
            <div class="card p-4 text-center">
                <h1 class="h4">Transcript Record Not Found</h1>
                <p class="mb-3">The provided student transcript information could not be verified.</p>
                <a href="verification.php" class="btn btn-school">Back to Verification</a>
            </div>
        <?php else: ?>
            <div class="transcript-shell">
                <div class="transcript-head">
                    <div class="transcript-brand">
                        <img src="assets/images/logo.png" alt="WBI logo">
                        <div>
                            <h1 class="h5 mb-1">World Wide Missions School (WBI)</h1>
                            <p class="mb-0 small">Duport Road, Monrovia, Liberia | Official Transcript Verification</p>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="small">Transcript ID</div>
                        <strong><?php echo htmlspecialchars((string) ($record['transcript_id'] ?? '')); ?></strong>
                    </div>
                </div>

                <div class="transcript-body">
                    <div class="row g-3">
                        <div class="col-md-9">
                            <table class="table table-sm table-bordered align-middle mb-0">
                                <tbody>
                                    <tr><th style="width: 32%;">Name</th><td><?php echo htmlspecialchars((string) ($record['name'] ?? '')); ?></td></tr>
                                    <tr><th>Grade</th><td><?php echo htmlspecialchars((string) ($record['grade'] ?? '')); ?></td></tr>
                                    <tr><th>Date of Birth</th><td><?php echo htmlspecialchars((string) ($record['date_of_birth'] ?? '')); ?></td></tr>
                                    <tr><th>Parent Contact</th><td><?php echo htmlspecialchars((string) ($record['parent_contact'] ?? '')); ?></td></tr>
                                    <tr><th>Gender</th><td><?php echo htmlspecialchars((string) ($record['gender'] ?? '')); ?></td></tr>
                                    <tr><th>Address</th><td><?php echo htmlspecialchars((string) ($record['address'] ?? '')); ?></td></tr>
                                    <tr><th>Status</th><td><span class="status-chip"><?php echo htmlspecialchars((string) ($record['status'] ?? 'Verified')); ?></span></td></tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-3 text-center">
                            <?php if (!empty($record['photo'])): ?>
                                <img class="student-photo" src="<?php echo htmlspecialchars((string) $record['photo']); ?>" alt="Student photo">
                            <?php else: ?>
                                <div class="student-photo d-flex align-items-center justify-content-center text-muted">No Photo</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="transcript-foot">
                        <div>
                            <strong>Verification Date:</strong>
                            <?php echo htmlspecialchars(date('M d, Y h:i A')); ?>
                        </div>
                        <div class="text-end">
                            <strong>Verified By:</strong> WBI Registrar Office
                            <?php if ($qrCodeUrl !== ''): ?>
                                <div class="mt-2">
                                    <div class="small text-muted mb-1">Scan to verify this exact report</div>
                                    <a class="qr-wrap" href="<?php echo htmlspecialchars($verificationUrl); ?>" target="_blank" rel="noopener noreferrer">
                                        <img src="<?php echo htmlspecialchars($qrCodeUrl); ?>" alt="Verification QR code">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="print-actions">
                        <button type="button" class="btn btn-school" onclick="window.print()">Download/Print PDF</button>
                        <a href="verification.php" class="btn btn-outline-secondary">Back to Verification</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
