<?php
require __DIR__ . '/includes/admin_auth.php';
require __DIR__ . '/includes/content_store.php';
require __DIR__ . '/includes/upload_helpers.php';

wbi_admin_require_auth();

function wbi_csv_header_key($value)
{
    $key = strtolower(trim((string) $value));
    return preg_replace('/[^a-z0-9]/', '', $key);
}

function wbi_csv_first_non_empty($row, $keys)
{
    foreach ($keys as $key) {
        $value = trim((string) ($row[$key] ?? ''));
        if ($value !== '') {
            return $value;
        }
    }

    return '';
}

function wbi_excel_date_to_string($raw)
{
    $value = trim((string) $raw);
    if ($value === '') {
        return '';
    }

    if (is_numeric($value)) {
        $days = (int) $value;
        if ($days > 25569) {
            $unix = ($days - 25569) * 86400;
            return gmdate('Y-m-d', $unix);
        }
    }

    $time = strtotime($value);
    if ($time === false) {
        return $value;
    }

    return date('Y-m-d', $time);
}

$notice = '';
$error = '';
$search = trim((string) ($_GET['q'] ?? ''));
$editId = trim((string) ($_GET['edit_id'] ?? ''));
$editItem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = trim((string) ($_POST['action'] ?? ''));

    if ($action === 'create_transcript') {
        $photoInputPath = trim((string) ($_POST['photo'] ?? ''));
        $photoUpload = wbi_handle_transcript_photo_upload('student_photo');

        $payload = [
            'transcript_id' => trim((string) ($_POST['transcript_id'] ?? '')),
            'name' => trim((string) ($_POST['name'] ?? '')),
            'grade' => trim((string) ($_POST['grade'] ?? '')),
            'date_of_birth' => trim((string) ($_POST['date_of_birth'] ?? '')),
            'parent_contact' => trim((string) ($_POST['parent_contact'] ?? '')),
            'photo' => $photoUpload['path'] !== '' ? $photoUpload['path'] : $photoInputPath,
            'gender' => trim((string) ($_POST['gender'] ?? '')),
            'address' => trim((string) ($_POST['address'] ?? '')),
            'status' => trim((string) ($_POST['status'] ?? 'Active')),
        ];

        if ($photoUpload['error'] !== '') {
            $error = $photoUpload['error'];
        } elseif ($payload['transcript_id'] === '' || $payload['name'] === '') {
            $error = 'Transcript ID and student name are required.';
        } else {
            $result = wbi_upsert_transcript($payload);
            if (($result['created'] ?? false) === true) {
                $notice = 'Transcript record created successfully.';
            } elseif (($result['updated'] ?? false) === true) {
                $notice = 'Transcript ID already existed, record updated successfully.';
            } else {
                $error = 'Unable to create transcript record.';
            }
        }
    }

    if ($action === 'import_csv') {
        $file = $_FILES['transcript_sheet'] ?? null;
        $importMode = trim((string) ($_POST['import_mode'] ?? 'replace'));
        if (!in_array($importMode, ['replace', 'incremental'], true)) {
            $importMode = 'replace';
        }

        if (!is_array($file) || ($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            $error = 'Please upload a CSV file.';
        } elseif (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            $error = 'CSV upload failed. Please try again.';
        } else {
            $tmpPath = (string) ($file['tmp_name'] ?? '');
            $originalName = (string) ($file['name'] ?? '');
            $extension = strtolower((string) pathinfo($originalName, PATHINFO_EXTENSION));

            if (!is_uploaded_file($tmpPath) || $extension !== 'csv') {
                $error = 'Only CSV files are supported.';
            } else {
                $handle = fopen($tmpPath, 'r');
                if ($handle === false) {
                    $error = 'Unable to read uploaded CSV file.';
                } else {
                    $headerRow = fgetcsv($handle);
                    if (!is_array($headerRow) || empty($headerRow)) {
                        fclose($handle);
                        $error = 'The CSV file is empty or invalid.';
                    } else {
                        $headerMap = [];
                        foreach ($headerRow as $index => $headerValue) {
                            $headerMap[$index] = wbi_csv_header_key($headerValue);
                        }

                        $records = [];
                        while (($rowValues = fgetcsv($handle)) !== false) {
                            $row = [];
                            foreach ($headerMap as $index => $key) {
                                $row[$key] = (string) ($rowValues[$index] ?? '');
                            }

                            $name = wbi_csv_first_non_empty($row, ['name', 'studentname', 'fullname']);
                            $grade = wbi_csv_first_non_empty($row, ['grade', 'class', 'gradelevel']);
                            $dobRaw = wbi_csv_first_non_empty($row, ['dateofbirth', 'dob', 'birthdate']);
                            $parentContact = wbi_csv_first_non_empty($row, ['parentcontact', 'parentphone', 'guardiancontact', 'parent']);
                            $photo = wbi_csv_first_non_empty($row, ['photo', 'photopath', 'studentphoto', 'image']);
                            $gender = wbi_csv_first_non_empty($row, ['gender', 'sex']);
                            $address = wbi_csv_first_non_empty($row, ['address', 'residentialaddress', 'location']);
                            $status = wbi_csv_first_non_empty($row, ['status', 'studentstatus']);
                            $transcriptId = wbi_csv_first_non_empty($row, ['transcriptid', 'transcriptno', 'transcriptnumber', 'id']);

                            if ($name === '' && $grade === '' && $dobRaw === '' && $parentContact === '') {
                                continue;
                            }

                            if ($transcriptId === '') {
                                $transcriptId = 'WBI-TR-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
                            }

                            $records[] = [
                                'transcript_id' => $transcriptId,
                                'name' => $name,
                                'grade' => $grade,
                                'date_of_birth' => wbi_excel_date_to_string($dobRaw),
                                'parent_contact' => $parentContact,
                                'photo' => trim($photo),
                                'gender' => $gender,
                                'address' => $address,
                                'status' => $status !== '' ? $status : 'Active',
                            ];
                        }

                        fclose($handle);

                        if (empty($records)) {
                            $error = 'No valid transcript records were found in the CSV file.';
                        } else {
                            if ($importMode === 'replace') {
                                $replaceRows = [];
                                foreach ($records as $recordPayload) {
                                    $replaceRows[] = [
                                        'id' => uniqid('tr_', true),
                                        'transcript_id' => (string) $recordPayload['transcript_id'],
                                        'name' => (string) $recordPayload['name'],
                                        'grade' => (string) $recordPayload['grade'],
                                        'date_of_birth' => (string) $recordPayload['date_of_birth'],
                                        'parent_contact' => (string) $recordPayload['parent_contact'],
                                        'photo' => (string) $recordPayload['photo'],
                                        'gender' => (string) $recordPayload['gender'],
                                        'address' => (string) $recordPayload['address'],
                                        'status' => (string) $recordPayload['status'],
                                        'created_at' => date('c'),
                                        'updated_at' => date('c'),
                                    ];
                                }

                                wbi_replace_transcripts($replaceRows);
                                $notice = 'CSV imported in Replace mode. Total records: ' . count($replaceRows) . '.';
                            } else {
                                $createdCount = 0;
                                $updatedCount = 0;

                                foreach ($records as $recordPayload) {
                                    $result = wbi_upsert_transcript($recordPayload);
                                    if (($result['created'] ?? false) === true) {
                                        $createdCount++;
                                    }
                                    if (($result['updated'] ?? false) === true) {
                                        $updatedCount++;
                                    }
                                }

                                $notice = 'CSV imported in Incremental mode. Added: ' . $createdCount . ', Updated: ' . $updatedCount . '.';
                            }
                        }
                    }
                }
            }
        }
    }

    if ($action === 'delete_transcript') {
        $id = trim((string) ($_POST['id'] ?? ''));
        if ($id === '') {
            $error = 'Invalid transcript record.';
        } elseif (wbi_delete_transcript($id)) {
            $notice = 'Transcript record deleted successfully.';
            if ($editId === $id) {
                $editId = '';
                $editItem = null;
            }
        } else {
            $error = 'Unable to delete transcript record.';
        }
    }

    if ($action === 'update_transcript') {
        $id = trim((string) ($_POST['id'] ?? ''));
        $existingRecord = wbi_find_transcript_by_id($id);
        $existingPhoto = trim((string) ($existingRecord['photo'] ?? ''));
        $photoInputPath = trim((string) ($_POST['photo'] ?? ''));
        $photoUpload = wbi_handle_transcript_photo_upload('student_photo', $existingPhoto);

        $payload = [
            'transcript_id' => trim((string) ($_POST['transcript_id'] ?? '')),
            'name' => trim((string) ($_POST['name'] ?? '')),
            'grade' => trim((string) ($_POST['grade'] ?? '')),
            'date_of_birth' => trim((string) ($_POST['date_of_birth'] ?? '')),
            'parent_contact' => trim((string) ($_POST['parent_contact'] ?? '')),
            'photo' => $photoUpload['path'] !== '' ? $photoUpload['path'] : ($photoInputPath !== '' ? $photoInputPath : $existingPhoto),
            'gender' => trim((string) ($_POST['gender'] ?? '')),
            'address' => trim((string) ($_POST['address'] ?? '')),
            'status' => trim((string) ($_POST['status'] ?? 'Active')),
        ];

        if ($photoUpload['error'] !== '') {
            $error = $photoUpload['error'];
        } elseif ($id === '' || $payload['transcript_id'] === '' || $payload['name'] === '') {
            $error = 'Transcript ID and student name are required.';
        } elseif (wbi_update_transcript($id, $payload)) {
            $notice = 'Transcript record updated successfully.';
            $editId = '';
            $editItem = null;
        } else {
            $error = 'Unable to update transcript record. Transcript ID may already exist.';
        }
    }
}

$editItem = $editId !== '' ? wbi_find_transcript_by_id($editId) : null;

$allTranscripts = wbi_get_transcripts();
$filteredTranscripts = array_values(array_filter($allTranscripts, function ($item) use ($search) {
    if ($search === '') {
        return true;
    }

    $needle = wbi_normalize_lookup_value($search);
    $haystack = [
        (string) ($item['transcript_id'] ?? ''),
        (string) ($item['name'] ?? ''),
        (string) ($item['grade'] ?? ''),
        (string) ($item['status'] ?? ''),
        (string) ($item['parent_contact'] ?? ''),
    ];

    foreach ($haystack as $value) {
        if (strpos(wbi_normalize_lookup_value($value), $needle) !== false) {
            return true;
        }
    }

    return false;
}));

$totalRecords = count($allTranscripts);
$activeCount = count(array_filter($allTranscripts, function ($item) {
    return strcasecmp((string) ($item['status'] ?? ''), 'Active') === 0;
}));
$graduatedCount = count(array_filter($allTranscripts, function ($item) {
    return strcasecmp((string) ($item['status'] ?? ''), 'Graduated') === 0;
}));
$inactiveCount = max(0, $totalRecords - $activeCount - $graduatedCount);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transcript Admin - WBI</title>
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
                    <span class="admin-eyebrow">Transcript Console</span>
                    <h1 class="admin-hero-title">Transcript Records</h1>
                    <p class="admin-hero-text">Import CSV, add transcript records manually, and manage verification data from this backend page.</p>
                </div>
                <div class="admin-hero-actions">
                    <a class="btn btn-light" href="assets/uploads/transcript-template.csv">CSV Template</a>
                    <a class="btn btn-light" href="verification.php">Verification Portal</a>
                    <a class="btn btn-outline-light" href="admin-dashboard.php">Dashboard</a>
                    <a class="btn btn-outline-light" href="admin-logout.php">Logout</a>
                </div>
            </div>

            <div class="admin-metric-grid">
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-file-earmark-text"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $totalRecords); ?></div><p class="metric-label">Total Records</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-person-check"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $activeCount); ?></div><p class="metric-label">Active</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-mortarboard-fill"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $graduatedCount); ?></div><p class="metric-label">Graduated</p></div>
                <div class="admin-metric-card"><div class="metric-icon"><i class="bi bi-person-dash"></i></div><div class="metric-value"><?php echo htmlspecialchars((string) $inactiveCount); ?></div><p class="metric-label">Other Status</p></div>
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
                            <div class="admin-sidebar-title">Transcripts Nav</div>
                            <div class="admin-sidebar-subtitle">Manage records</div>
                        </div>
                    </div>

                    <nav class="nav flex-column admin-nav nav-pills admin-tabs gap-1">
                        <a class="nav-link" href="admin-dashboard.php">Dashboard</a>
                        <a class="nav-link" href="admin-posts.php">Posts</a>
                        <a class="nav-link" href="admin-admissions.php">Admissions</a>
                        <a class="nav-link active" href="admin-transcripts.php">Transcripts</a>
                    </nav>

                    <hr class="my-3">

                    <div class="d-grid gap-2">
                        <a class="btn btn-school btn-sm" href="#csv-import">Import CSV</a>
                        <a class="btn btn-outline-secondary btn-sm" href="#manual-entry">Add Record</a>
                        <a class="btn btn-outline-secondary btn-sm" href="verification.php">Public Verification</a>
                    </div>
                </div>
            </aside>

            <div class="col-lg-9">
                <div class="admin-panel p-4 mb-4" id="csv-import">
                    <div class="admin-panel-header">
                        <div>
                            <h2 class="admin-panel-title">Import CSV</h2>
                            <p class="admin-panel-subtitle">Upload transcript CSV from backend only. Choose replace or incremental mode.</p>
                        </div>
                    </div>

                    <form method="post" enctype="multipart/form-data" class="row g-3 align-items-end">
                        <input type="hidden" name="action" value="import_csv">
                        <div class="col-md-7">
                            <label class="form-label">CSV File</label>
                            <input class="form-control" type="file" name="transcript_sheet" accept=".csv,text/csv" required>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label">Import Mode</label>
                            <select class="form-select" name="import_mode">
                                <option value="replace">Replace all records</option>
                                <option value="incremental">Incremental (add/update by Transcript ID)</option>
                            </select>
                        </div>
                        <div class="col-12 d-flex flex-wrap gap-2">
                            <button class="btn btn-school" type="submit">Import CSV</button>
                            <a class="btn btn-outline-secondary" href="assets/uploads/transcript-template.csv">Download CSV Template</a>
                        </div>
                    </form>
                </div>

                <div class="admin-panel p-4 mb-4" id="manual-entry">
                    <div class="admin-panel-header">
                        <div>
                            <h2 class="admin-panel-title">Manual Transcript Entry</h2>
                            <p class="admin-panel-subtitle">Admin can input transcript records directly from backend.</p>
                        </div>
                    </div>

                    <form method="post" enctype="multipart/form-data" class="row g-3">
                        <input type="hidden" name="action" value="create_transcript">
                        <div class="col-md-6"><label class="form-label">Transcript ID</label><input class="form-control" name="transcript_id" placeholder="e.g. WBI-TR-1001" required></div>
                        <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" placeholder="Student full name" required></div>
                        <div class="col-md-4"><label class="form-label">Grade</label><input class="form-control" name="grade" placeholder="e.g. Grade 9"></div>
                        <div class="col-md-4"><label class="form-label">Date of Birth</label><input class="form-control" type="date" name="date_of_birth"></div>
                        <div class="col-md-4"><label class="form-label">Gender</label><input class="form-control" name="gender"></div>
                        <div class="col-md-6"><label class="form-label">Parent Contact</label><input class="form-control" name="parent_contact"></div>
                        <div class="col-md-6"><label class="form-label">Status</label><input class="form-control" name="status" value="Active"></div>
                        <div class="col-12"><label class="form-label">Address</label><input class="form-control" name="address"></div>
                        <div class="col-12"><label class="form-label">Upload Student Photo (JPG, PNG, WEBP up to 3MB)</label><input class="form-control" type="file" name="student_photo" accept="image/jpeg,image/png,image/webp"></div>
                        <div class="col-12"><label class="form-label">Photo URL / Path</label><input class="form-control" name="photo" placeholder="https://... or assets/uploads/..." ></div>
                        <div class="col-12"><button class="btn btn-school" type="submit">Add Transcript Record</button></div>
                    </form>
                </div>

                <div class="admin-panel p-4 mb-4">
                    <div class="admin-panel-header">
                        <div>
                            <h2 class="admin-panel-title">Search Transcript Records</h2>
                            <p class="admin-panel-subtitle">Search by transcript ID, name, grade, contact, or status.</p>
                        </div>
                    </div>

                    <form method="get" class="row g-2 align-items-end">
                        <div class="col-md-9">
                            <label class="form-label">Search</label>
                            <input class="form-control" name="q" value="<?php echo htmlspecialchars($search); ?>" placeholder="Type transcript ID, student name, or grade">
                        </div>
                        <div class="col-md-3 d-grid">
                            <button class="btn btn-school" type="submit">Search</button>
                        </div>
                    </form>
                </div>

                <?php if ($editItem): ?>
                    <div class="admin-panel p-4 mb-4">
                        <div class="admin-panel-header">
                            <div>
                                <h2 class="admin-panel-title">Edit Transcript Record</h2>
                                <p class="admin-panel-subtitle">Update student transcript details and save changes.</p>
                            </div>
                        </div>

                        <form method="post" enctype="multipart/form-data" class="row g-3">
                            <input type="hidden" name="action" value="update_transcript">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) ($editItem['id'] ?? '')); ?>">
                            <div class="col-md-6"><label class="form-label">Transcript ID</label><input class="form-control" name="transcript_id" value="<?php echo htmlspecialchars((string) ($editItem['transcript_id'] ?? '')); ?>" required></div>
                            <div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" value="<?php echo htmlspecialchars((string) ($editItem['name'] ?? '')); ?>" required></div>
                            <div class="col-md-4"><label class="form-label">Grade</label><input class="form-control" name="grade" value="<?php echo htmlspecialchars((string) ($editItem['grade'] ?? '')); ?>"></div>
                            <div class="col-md-4"><label class="form-label">Date of Birth</label><input class="form-control" type="date" name="date_of_birth" value="<?php echo htmlspecialchars((string) ($editItem['date_of_birth'] ?? '')); ?>"></div>
                            <div class="col-md-4"><label class="form-label">Gender</label><input class="form-control" name="gender" value="<?php echo htmlspecialchars((string) ($editItem['gender'] ?? '')); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Parent Contact</label><input class="form-control" name="parent_contact" value="<?php echo htmlspecialchars((string) ($editItem['parent_contact'] ?? '')); ?>"></div>
                            <div class="col-md-6"><label class="form-label">Status</label><input class="form-control" name="status" value="<?php echo htmlspecialchars((string) ($editItem['status'] ?? 'Active')); ?>"></div>
                            <div class="col-12"><label class="form-label">Address</label><input class="form-control" name="address" value="<?php echo htmlspecialchars((string) ($editItem['address'] ?? '')); ?>"></div>
                            <div class="col-12"><label class="form-label">Upload Student Photo (optional)</label><input class="form-control" type="file" name="student_photo" accept="image/jpeg,image/png,image/webp"></div>
                            <div class="col-12"><label class="form-label">Photo URL / Path</label><input class="form-control" name="photo" value="<?php echo htmlspecialchars((string) ($editItem['photo'] ?? '')); ?>" placeholder="https://... or assets/uploads/..." ></div>
                            <div class="col-12 d-flex flex-wrap gap-2">
                                <button class="btn btn-school" type="submit">Save Changes</button>
                                <a class="btn btn-outline-secondary" href="admin-transcripts.php<?php echo $search !== '' ? '?q=' . urlencode($search) : ''; ?>">Cancel Edit</a>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>

                <div class="admin-panel p-4">
                    <div class="admin-panel-header">
                        <div>
                            <h2 class="admin-panel-title">Transcript Table</h2>
                            <p class="admin-panel-subtitle">Showing <?php echo htmlspecialchars((string) count($filteredTranscripts)); ?> of <?php echo htmlspecialchars((string) $totalRecords); ?> records.</p>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    <th>Transcript ID</th>
                                    <th>Name</th>
                                    <th>Grade</th>
                                    <th>Status</th>
                                    <th>Parent Contact</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($filteredTranscripts as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars((string) ($item['transcript_id'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($item['name'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($item['grade'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($item['status'] ?? '')); ?></td>
                                        <td><?php echo htmlspecialchars((string) ($item['parent_contact'] ?? '')); ?></td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-2">
                                                <a class="btn btn-sm btn-outline-primary" href="admin-transcripts.php?edit_id=<?php echo urlencode((string) ($item['id'] ?? '')); ?><?php echo $search !== '' ? '&amp;q=' . urlencode($search) : ''; ?>">Edit</a>
                                                <a class="btn btn-sm btn-outline-secondary" target="_blank" href="verification-result.php?id=<?php echo urlencode((string) ($item['id'] ?? '')); ?>">View</a>
                                                <form method="post" class="d-inline">
                                                    <input type="hidden" name="action" value="delete_transcript">
                                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars((string) ($item['id'] ?? '')); ?>">
                                                    <button class="btn btn-sm btn-outline-danger" type="submit" onclick="return confirm('Delete this transcript record?');">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($filteredTranscripts)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No transcript records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
