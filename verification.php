<?php
$pageTitle = 'Verification System';
require __DIR__ . '/includes/content_store.php';

$error = '';
$verifyInput = [
  'transcript_id' => '',
  'student_name' => '',
  'date_of_birth' => '',
  'grade' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = trim((string) ($_POST['action'] ?? 'verify'));

  if ($action === 'verify') {
    $verifyInput['transcript_id'] = trim((string) ($_POST['transcript_id'] ?? ''));
    $verifyInput['student_name'] = trim((string) ($_POST['student_name'] ?? ''));
    $verifyInput['date_of_birth'] = trim((string) ($_POST['date_of_birth'] ?? ''));
    $verifyInput['grade'] = trim((string) ($_POST['grade'] ?? ''));

    if (
      $verifyInput['transcript_id'] === '' &&
      $verifyInput['student_name'] === '' &&
      $verifyInput['date_of_birth'] === ''
    ) {
      $error = 'Enter at least Transcript ID, Student Name, or Date of Birth to verify.';
    } else {
      $record = wbi_verify_transcript_record(
        $verifyInput['transcript_id'],
        $verifyInput['student_name'],
        $verifyInput['date_of_birth'],
        $verifyInput['grade']
      );

      if ($record) {
        header('Location: verification-result.php?id=' . urlencode((string) ($record['id'] ?? '')));
        exit;
      }

      $error = 'No verified transcript found with the provided information.';
    }
  }

}

$transcripts = wbi_get_transcripts();
$totalTranscripts = count($transcripts);
$lastUpdated = $totalTranscripts > 0 ? ($transcripts[0]['updated_at'] ?? $transcripts[0]['created_at'] ?? '') : '';
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
    <section class="hero p-0 m-0" data-animate>
      <div class="hero-slide">
        <img src="assets/images/banner1.png" alt="Transcript verification banner" class="hero-slide-image">
        <div class="hero-content container">
          <h1>Transcript Verification Portal</h1>
          <p>Students and external institutions can verify official student transcript records securely.</p>
          <div class="hero-buttons">
            <a href="#verify-form" class="btn primary">Verify Transcript</a>
            <a href="admin-login.php" class="btn light">Admin Login</a>
          </div>
        </div>
      </div>
    </section>

    <section class="stats-section py-5 text-center text-light" data-animate>
      <div class="container">
        <h2 class="text-white">Verification Overview</h2>
        <div class="row g-3 mt-3 justify-content-center">
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars((string) $totalTranscripts); ?></h3><p>Transcript Records</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3><?php echo htmlspecialchars(date('Y')); ?></h3><p>Current Session</p></div></div>
          <div class="col-md-4"><div class="stat-card"><h3>WBI</h3><p>Secure Verification</p></div></div>
        </div>
      </div>
    </section>

    <section class="py-5" id="verify-form" data-animate>
      <div class="container">
        <div class="section-heading">
          <span class="section-kicker">Verify Transcript</span>
          <h1>Student Transcript Verification</h1>
          <p>Enter transcript details exactly as they appear in school records to retrieve a verified transcript report.</p>
        </div>

        <?php if ($error !== ''): ?>
          <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="row g-4 align-items-start">
          <div class="col-lg-7">
            <div class="admin-panel p-4 text-start">
              <h2 class="h4 mb-3">Verification Form</h2>
              <form method="post" class="row g-3">
                <input type="hidden" name="action" value="verify">
                <div class="col-12">
                  <label class="form-label">Transcript ID</label>
                  <input class="form-control" name="transcript_id" value="<?php echo htmlspecialchars($verifyInput['transcript_id']); ?>" placeholder="e.g. WBI-TR-7A91BC3D">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Student Name</label>
                  <input class="form-control" name="student_name" value="<?php echo htmlspecialchars($verifyInput['student_name']); ?>" placeholder="Student full name">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Date of Birth</label>
                  <input type="date" class="form-control" name="date_of_birth" value="<?php echo htmlspecialchars($verifyInput['date_of_birth']); ?>">
                </div>
                <div class="col-md-6">
                  <label class="form-label">Grade</label>
                  <input class="form-control" name="grade" value="<?php echo htmlspecialchars($verifyInput['grade']); ?>" placeholder="e.g. Grade 9">
                </div>
                <div class="col-12 d-flex flex-wrap gap-2">
                  <button type="submit" class="btn btn-school">Verify &amp; Generate Transcript PDF</button>
                  <a href="verification.php" class="btn btn-outline-secondary">Reset</a>
                </div>
              </form>
            </div>
          </div>

          <div class="col-lg-5">
            <div class="proprietor-wrap text-start h-100">
              <h3 class="h5">Information Displayed</h3>
              <p class="mb-2">The verified transcript report includes:</p>
              <ul class="mb-3">
                <li>Name</li>
                <li>Grade</li>
                <li>Date of Birth</li>
                <li>Parent Contact</li>
                <li>Photo</li>
                <li>Gender</li>
                <li>Address</li>
                <li>Status</li>
              </ul>
              <p class="small text-muted mb-0">
                <?php if ($lastUpdated !== ''): ?>
                  Last updated: <?php echo htmlspecialchars(date('M d, Y h:i A', strtotime((string) $lastUpdated))); ?>
                <?php else: ?>
                  No transcript records imported yet.
                <?php endif; ?>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
