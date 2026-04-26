<?php
$pageTitle = 'Admissions';
require __DIR__ . '/includes/content_store.php';
require __DIR__ . '/includes/upload_helpers.php';

$notice = '';
$error = '';
$lookupError = '';
$createdAdmission = null;

$formData = [
    'student_type' => 'new',
    'student_name' => '',
    'date_of_birth' => '',
    'gender' => '',
    'grade_applying' => '',
    'previous_school' => '',
    'last_class_completed' => '',
    'parent_name' => '',
    'parent_phone' => '',
    'parent_email' => '',
    'address' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $formAction = $_POST['form_action'] ?? '';

    if ($formAction === 'register') {
        foreach ($formData as $key => $value) {
            $formData[$key] = trim((string) ($_POST[$key] ?? ''));
        }

        if (!in_array($formData['student_type'], ['new', 'returning'], true)) {
            $formData['student_type'] = 'new';
        }

        $requiredFields = [
            'student_name' => 'Student name',
            'date_of_birth' => 'Date of birth',
            'gender' => 'Gender',
            'grade_applying' => 'Grade applying for',
            'parent_name' => 'Parent/Guardian name',
            'parent_phone' => 'Parent/Guardian phone',
            'address' => 'Address',
        ];

        foreach ($requiredFields as $field => $label) {
            if ($formData[$field] === '') {
                $error = $label . ' is required.';
                break;
            }
        }

        if ($error === '') {
            $photoUpload = wbi_handle_admission_photo_upload('student_photo');
            if ($photoUpload['error'] !== '') {
                $error = $photoUpload['error'];
            } else {
                $createdAdmission = wbi_add_admission([
                    'student_type' => $formData['student_type'],
                    'student_name' => $formData['student_name'],
                    'date_of_birth' => $formData['date_of_birth'],
                    'gender' => $formData['gender'],
                    'grade_applying' => $formData['grade_applying'],
                    'previous_school' => $formData['previous_school'],
                    'last_class_completed' => $formData['last_class_completed'],
                    'parent_name' => $formData['parent_name'],
                    'parent_phone' => $formData['parent_phone'],
                    'parent_email' => $formData['parent_email'],
                    'address' => $formData['address'],
                    'student_photo' => $photoUpload['path'],
                ]);

                $notice = 'Registration submitted successfully.';
                foreach ($formData as $key => $value) {
                    $formData[$key] = '';
                }
                $formData['student_type'] = 'new';
            }
        }
    }

    if ($formAction === 'lookup') {
        $applicationNumber = trim((string) ($_POST['application_number'] ?? ''));
        if ($applicationNumber === '') {
            $lookupError = 'Please enter your application number.';
        } else {
            $record = wbi_find_admission_by_application_number($applicationNumber);
            if ($record) {
                header('Location: admission-result.php?id=' . urlencode($record['id']));
                exit;
            }
            $lookupError = 'No admission record was found for that application number.';
        }
    }
}
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
<body class="admissions-page">
    <?php include __DIR__ . '/includes/header.php'; ?>

    <main class="w-100 m-0">
        <section class="hero p-0 m-0" data-animate>
            <div class="hero-slide">
                <img src="assets/images/banner2.png" alt="WBI admissions banner" class="hero-slide-image">
                <div class="hero-content container">
                    <h1>Admissions at World Wide Missions School</h1>
                    <p>Register new or returning students online and track your admission result quickly.</p>
                    <div class="hero-buttons">
                        <a href="#admission-form" class="btn primary">Start Registration</a>
                        <a href="assets/uploads/information-sheet.pdf" class="btn light" download>Download Information Sheet</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5" id="admission-form" data-animate>
            <div class="container">
                <div class="row g-4 align-items-start">
                    <div class="col-lg-8">
                        <div class="card p-4 text-start">
                            <h2 class="section-title h3 mb-2">Student Registration Form</h2>
                            <p class="text-muted mb-4">Complete this form for both new and returning students.</p>

                            <?php if ($notice !== ''): ?>
                                <div class="alert alert-success"><?php echo htmlspecialchars($notice); ?></div>
                            <?php endif; ?>
                            <?php if ($error !== ''): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>

                            <?php if ($createdAdmission): ?>
                                <div class="alert alert-info">
                                    <strong>Application Number:</strong> <?php echo htmlspecialchars($createdAdmission['application_number']); ?><br>
                                    Keep this number safe. You can view and print your admission result slip any time.
                                    <div class="mt-2">
                                        <a class="btn btn-school btn-sm" href="admission-result.php?id=<?php echo urlencode($createdAdmission['id']); ?>">View / Download Result Slip</a>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <form method="post" enctype="multipart/form-data" class="row g-3">
                                <input type="hidden" name="form_action" value="register">

                                <div class="col-md-6">
                                    <label class="form-label">Student Type</label>
                                    <select class="form-select" name="student_type" required>
                                        <option value="new" <?php echo ($formData['student_type'] === 'new') ? 'selected' : ''; ?>>New Student</option>
                                        <option value="returning" <?php echo ($formData['student_type'] === 'returning') ? 'selected' : ''; ?>>Returning Student</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Student Full Name</label>
                                    <input type="text" class="form-control" name="student_name" value="<?php echo htmlspecialchars($formData['student_name']); ?>" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" class="form-control" name="date_of_birth" value="<?php echo htmlspecialchars($formData['date_of_birth']); ?>" required>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Gender</label>
                                    <select class="form-select" name="gender" required>
                                        <option value="" <?php echo ($formData['gender'] === '') ? 'selected' : ''; ?>>Select</option>
                                        <option value="Male" <?php echo ($formData['gender'] === 'Male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="Female" <?php echo ($formData['gender'] === 'Female') ? 'selected' : ''; ?>>Female</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Grade Applying For</label>
                                    <input type="text" class="form-control" name="grade_applying" value="<?php echo htmlspecialchars($formData['grade_applying']); ?>" placeholder="e.g. Grade 8" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Previous School</label>
                                    <input type="text" class="form-control" name="previous_school" value="<?php echo htmlspecialchars($formData['previous_school']); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Last Class Completed</label>
                                    <input type="text" class="form-control" name="last_class_completed" value="<?php echo htmlspecialchars($formData['last_class_completed']); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Parent/Guardian Name</label>
                                    <input type="text" class="form-control" name="parent_name" value="<?php echo htmlspecialchars($formData['parent_name']); ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Parent/Guardian Phone</label>
                                    <input type="text" class="form-control" name="parent_phone" value="<?php echo htmlspecialchars($formData['parent_phone']); ?>" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Parent/Guardian Email (optional)</label>
                                    <input type="email" class="form-control" name="parent_email" value="<?php echo htmlspecialchars($formData['parent_email']); ?>">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Student Photo (JPG, PNG, WEBP up to 3MB)</label>
                                    <input type="file" class="form-control" name="student_photo" accept="image/jpeg,image/png,image/webp" required>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Home Address</label>
                                    <textarea class="form-control" name="address" rows="3" required><?php echo htmlspecialchars($formData['address']); ?></textarea>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-school" type="submit">Submit Registration</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card p-4 text-start mb-3">
                            <h3 class="h5 mb-2">Check Admission Result</h3>
                            <p class="text-muted small mb-3">Enter your application number to view and download your result slip.</p>

                            <?php if ($lookupError !== ''): ?>
                                <div class="alert alert-warning py-2"><?php echo htmlspecialchars($lookupError); ?></div>
                            <?php endif; ?>

                            <form method="post" class="d-grid gap-2">
                                <input type="hidden" name="form_action" value="lookup">
                                <input type="text" class="form-control" name="application_number" placeholder="WBI-ADM-XXXXXXXX" required>
                                <button class="btn btn-outline-secondary" type="submit">View Result Slip</button>
                            </form>
                        </div>

                        <div class="card p-4 text-start">
                            <h3 class="h6 mb-2">Need Help?</h3>
                            <p class="mb-2">Call Admissions Office: 0777580532 or 0886543547</p>
                            <a href="contact.php" class="btn btn-outline-secondary btn-sm">Contact Admissions</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
