<?php

function wbi_storage_path($fileName)
{
    return __DIR__ . '/../storage/' . $fileName;
}

function wbi_storage_read($fileName)
{
    $path = wbi_storage_path($fileName);

    if (!file_exists($path)) {
        file_put_contents($path, "[]\n", LOCK_EX);
    }

    $raw = file_get_contents($path);
    $decoded = json_decode($raw, true);

    return is_array($decoded) ? $decoded : [];
}

function wbi_storage_write($fileName, $items)
{
    $path = wbi_storage_path($fileName);
    $json = json_encode($items, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    file_put_contents($path, $json . "\n", LOCK_EX);
}

function wbi_get_news($limit = null)
{
    $items = wbi_storage_read('news.json');

    usort($items, function ($a, $b) {
        return strcmp($b['created_at'], $a['created_at']);
    });

    if ($limit !== null) {
        return array_slice($items, 0, (int) $limit);
    }

    return $items;
}

function wbi_add_news($title, $summary, $content, $imagePath = '')
{
    $items = wbi_storage_read('news.json');
    $items[] = [
        'id' => uniqid('news_', true),
        'title' => trim($title),
        'summary' => trim($summary),
        'content' => trim($content),
        'image_path' => trim($imagePath),
        'created_at' => date('c'),
    ];
    wbi_storage_write('news.json', $items);
}

function wbi_find_news($id)
{
    $items = wbi_storage_read('news.json');
    foreach ($items as $item) {
        if (($item['id'] ?? '') === $id) {
            return $item;
        }
    }

    return null;
}

function wbi_update_news($id, $title, $summary, $content, $imagePath = '')
{
    $items = wbi_storage_read('news.json');

    foreach ($items as &$item) {
        if (($item['id'] ?? '') === $id) {
            $item['title'] = trim($title);
            $item['summary'] = trim($summary);
            $item['content'] = trim($content);
            $item['image_path'] = trim($imagePath);
            $item['updated_at'] = date('c');
            wbi_storage_write('news.json', $items);
            return true;
        }
    }

    return false;
}

function wbi_delete_news($id)
{
    $items = wbi_storage_read('news.json');
    $initialCount = count($items);

    $items = array_values(array_filter($items, function ($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    if (count($items) !== $initialCount) {
        wbi_storage_write('news.json', $items);
        return true;
    }

    return false;
}

function wbi_get_jobs($limit = null)
{
    $items = wbi_storage_read('jobs.json');

    usort($items, function ($a, $b) {
        return strcmp($b['created_at'], $a['created_at']);
    });

    if ($limit !== null) {
        return array_slice($items, 0, (int) $limit);
    }

    return $items;
}

function wbi_add_job($title, $summary, $content, $deadline = '', $imagePath = '')
{
    $items = wbi_storage_read('jobs.json');
    $items[] = [
        'id' => uniqid('job_', true),
        'title' => trim($title),
        'summary' => trim($summary),
        'content' => trim($content),
        'deadline' => trim($deadline),
        'image_path' => trim($imagePath),
        'created_at' => date('c'),
    ];
    wbi_storage_write('jobs.json', $items);
}

function wbi_find_job($id)
{
    $items = wbi_storage_read('jobs.json');
    foreach ($items as $item) {
        if (($item['id'] ?? '') === $id) {
            return $item;
        }
    }

    return null;
}

function wbi_update_job($id, $title, $summary, $content, $deadline = '', $imagePath = '')
{
    $items = wbi_storage_read('jobs.json');

    foreach ($items as &$item) {
        if (($item['id'] ?? '') === $id) {
            $item['title'] = trim($title);
            $item['summary'] = trim($summary);
            $item['content'] = trim($content);
            $item['deadline'] = trim($deadline);
            $item['image_path'] = trim($imagePath);
            $item['updated_at'] = date('c');
            wbi_storage_write('jobs.json', $items);
            return true;
        }
    }

    return false;
}

function wbi_delete_job($id)
{
    $items = wbi_storage_read('jobs.json');
    $initialCount = count($items);

    $items = array_values(array_filter($items, function ($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    if (count($items) !== $initialCount) {
        wbi_storage_write('jobs.json', $items);
        return true;
    }

    return false;
}

function wbi_get_blogs($limit = null)
{
    $items = wbi_storage_read('blogs.json');

    usort($items, function ($a, $b) {
        return strcmp($b['created_at'], $a['created_at']);
    });

    if ($limit !== null) {
        return array_slice($items, 0, (int) $limit);
    }

    return $items;
}

function wbi_add_blog($title, $summary, $content, $imagePath = '')
{
    $items = wbi_storage_read('blogs.json');
    $items[] = [
        'id' => uniqid('blog_', true),
        'title' => trim($title),
        'summary' => trim($summary),
        'content' => trim($content),
        'image_path' => trim($imagePath),
        'created_at' => date('c'),
    ];
    wbi_storage_write('blogs.json', $items);
}

function wbi_find_blog($id)
{
    $items = wbi_storage_read('blogs.json');
    foreach ($items as $item) {
        if (($item['id'] ?? '') === $id) {
            return $item;
        }
    }

    return null;
}

function wbi_update_blog($id, $title, $summary, $content, $imagePath = '')
{
    $items = wbi_storage_read('blogs.json');

    foreach ($items as &$item) {
        if (($item['id'] ?? '') === $id) {
            $item['title'] = trim($title);
            $item['summary'] = trim($summary);
            $item['content'] = trim($content);
            $item['image_path'] = trim($imagePath);
            $item['updated_at'] = date('c');
            wbi_storage_write('blogs.json', $items);
            return true;
        }
    }

    return false;
}

function wbi_delete_blog($id)
{
    $items = wbi_storage_read('blogs.json');
    $initialCount = count($items);

    $items = array_values(array_filter($items, function ($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    if (count($items) !== $initialCount) {
        wbi_storage_write('blogs.json', $items);
        return true;
    }

    return false;
}

function wbi_get_principal_list($limit = null)
{
    $items = wbi_storage_read('principal_list.json');

    usort($items, function ($a, $b) {
        return strcmp($b['created_at'], $a['created_at']);
    });

    if ($limit !== null) {
        return array_slice($items, 0, (int) $limit);
    }

    return $items;
}

function wbi_add_principal_list($title, $summary, $content, $imagePath = '')
{
    $items = wbi_storage_read('principal_list.json');
    $items[] = [
        'id' => uniqid('plist_', true),
        'title' => trim($title),
        'summary' => trim($summary),
        'content' => trim($content),
        'image_path' => trim($imagePath),
        'created_at' => date('c'),
    ];
    wbi_storage_write('principal_list.json', $items);
}

function wbi_find_principal_list($id)
{
    $items = wbi_storage_read('principal_list.json');
    foreach ($items as $item) {
        if (($item['id'] ?? '') === $id) {
            return $item;
        }
    }

    return null;
}

function wbi_update_principal_list($id, $title, $summary, $content, $imagePath = '')
{
    $items = wbi_storage_read('principal_list.json');

    foreach ($items as &$item) {
        if (($item['id'] ?? '') === $id) {
            $item['title'] = trim($title);
            $item['summary'] = trim($summary);
            $item['content'] = trim($content);
            $item['image_path'] = trim($imagePath);
            $item['updated_at'] = date('c');
            wbi_storage_write('principal_list.json', $items);
            return true;
        }
    }

    return false;
}

function wbi_delete_principal_list($id)
{
    $items = wbi_storage_read('principal_list.json');
    $initialCount = count($items);

    $items = array_values(array_filter($items, function ($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    if (count($items) !== $initialCount) {
        wbi_storage_write('principal_list.json', $items);
        return true;
    }

    return false;
}

function wbi_get_activities($limit = null)
{
    $items = wbi_storage_read('activities.json');

    usort($items, function ($a, $b) {
        return strcmp($b['created_at'], $a['created_at']);
    });

    if ($limit !== null) {
        return array_slice($items, 0, (int) $limit);
    }

    return $items;
}

function wbi_add_activity($title, $summary, $content, $imagePath = '')
{
    $items = wbi_storage_read('activities.json');
    $items[] = [
        'id' => uniqid('activity_', true),
        'title' => trim($title),
        'summary' => trim($summary),
        'content' => trim($content),
        'image_path' => trim($imagePath),
        'created_at' => date('c'),
    ];
    wbi_storage_write('activities.json', $items);
}

function wbi_find_activity($id)
{
    $items = wbi_storage_read('activities.json');
    foreach ($items as $item) {
        if (($item['id'] ?? '') === $id) {
            return $item;
        }
    }

    return null;
}

function wbi_update_activity($id, $title, $summary, $content, $imagePath = '')
{
    $items = wbi_storage_read('activities.json');

    foreach ($items as &$item) {
        if (($item['id'] ?? '') === $id) {
            $item['title'] = trim($title);
            $item['summary'] = trim($summary);
            $item['content'] = trim($content);
            $item['image_path'] = trim($imagePath);
            $item['updated_at'] = date('c');
            wbi_storage_write('activities.json', $items);
            return true;
        }
    }

    return false;
}

function wbi_delete_activity($id)
{
    $items = wbi_storage_read('activities.json');
    $initialCount = count($items);

    $items = array_values(array_filter($items, function ($item) use ($id) {
        return ($item['id'] ?? '') !== $id;
    }));

    if (count($items) !== $initialCount) {
        wbi_storage_write('activities.json', $items);
        return true;
    }

    return false;
}

function wbi_delete_admission($id)
{
    $items = wbi_storage_read('admissions.json');
    $initialCount = count($items);
    $removedPhoto = '';

    foreach ($items as $index => $item) {
        if (($item['id'] ?? '') === $id) {
            $removedPhoto = (string) ($item['student_photo'] ?? '');
            unset($items[$index]);
            break;
        }
    }

    $items = array_values($items);

    if (count($items) !== $initialCount) {
        wbi_storage_write('admissions.json', $items);
        if ($removedPhoto !== '') {
            wbi_remove_uploaded_admission_photo($removedPhoto);
        }
        return true;
    }

    return false;
}

function wbi_get_admissions($limit = null)
{
    $items = wbi_storage_read('admissions.json');

    usort($items, function ($a, $b) {
        return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
    });

    if ($limit !== null) {
        return array_slice($items, 0, (int) $limit);
    }

    return $items;
}

function wbi_find_admission($id)
{
    $items = wbi_storage_read('admissions.json');
    foreach ($items as $item) {
        if (($item['id'] ?? '') === $id) {
            return $item;
        }
    }

    return null;
}

function wbi_find_admission_by_application_number($applicationNumber)
{
    $needle = trim((string) $applicationNumber);
    if ($needle === '') {
        return null;
    }

    $items = wbi_storage_read('admissions.json');
    foreach ($items as $item) {
        if (strcasecmp((string) ($item['application_number'] ?? ''), $needle) === 0) {
            return $item;
        }
    }

    return null;
}

function wbi_add_admission($payload)
{
    $items = wbi_storage_read('admissions.json');
    $id = uniqid('adm_', true);
    $applicationNumber = 'WBI-ADM-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));

    $record = [
        'id' => $id,
        'application_number' => $applicationNumber,
        'student_type' => trim((string) ($payload['student_type'] ?? 'new')),
        'student_name' => trim((string) ($payload['student_name'] ?? '')),
        'date_of_birth' => trim((string) ($payload['date_of_birth'] ?? '')),
        'gender' => trim((string) ($payload['gender'] ?? '')),
        'grade_applying' => trim((string) ($payload['grade_applying'] ?? '')),
        'previous_school' => trim((string) ($payload['previous_school'] ?? '')),
        'last_class_completed' => trim((string) ($payload['last_class_completed'] ?? '')),
        'parent_name' => trim((string) ($payload['parent_name'] ?? '')),
        'parent_phone' => trim((string) ($payload['parent_phone'] ?? '')),
        'parent_email' => trim((string) ($payload['parent_email'] ?? '')),
        'address' => trim((string) ($payload['address'] ?? '')),
        'student_photo' => trim((string) ($payload['student_photo'] ?? '')),
        'status' => 'Pending',
        'admin_note' => '',
        'created_at' => date('c'),
        'updated_at' => date('c'),
    ];

    $items[] = $record;
    wbi_storage_write('admissions.json', $items);

    return $record;
}

function wbi_update_admission_review($id, $status, $adminNote = '')
{
    $allowedStatuses = ['Pending', 'Approved', 'Declined'];
    if (!in_array($status, $allowedStatuses, true)) {
        return false;
    }

    $items = wbi_storage_read('admissions.json');
    foreach ($items as &$item) {
        if (($item['id'] ?? '') === $id) {
            $item['status'] = $status;
            $item['admin_note'] = trim((string) $adminNote);
            $item['updated_at'] = date('c');
            wbi_storage_write('admissions.json', $items);
            return true;
        }
    }

    return false;
}

function wbi_get_transcripts($limit = null)
{
    $items = wbi_storage_read('transcripts.json');

    usort($items, function ($a, $b) {
        return strcmp($b['created_at'] ?? '', $a['created_at'] ?? '');
    });

    if ($limit !== null) {
        return array_slice($items, 0, (int) $limit);
    }

    return $items;
}

function wbi_replace_transcripts(array $records)
{
    wbi_storage_write('transcripts.json', array_values($records));
}

function wbi_find_transcript_by_id($id)
{
    $needle = trim((string) $id);
    if ($needle === '') {
        return null;
    }

    $items = wbi_storage_read('transcripts.json');
    foreach ($items as $item) {
        if (strcasecmp((string) ($item['id'] ?? ''), $needle) === 0) {
            return $item;
        }
    }

    return null;
}

function wbi_find_transcript_by_transcript_id($transcriptId)
{
    $needle = wbi_normalize_lookup_value($transcriptId);
    if ($needle === '') {
        return null;
    }

    $items = wbi_storage_read('transcripts.json');
    foreach ($items as $item) {
        $recordId = wbi_normalize_lookup_value((string) ($item['transcript_id'] ?? ''));
        if ($recordId === $needle) {
            return $item;
        }
    }

    return null;
}

function wbi_upsert_transcript($payload)
{
    $items = wbi_storage_read('transcripts.json');

    $transcriptId = trim((string) ($payload['transcript_id'] ?? ''));
    if ($transcriptId === '') {
        return ['created' => false, 'updated' => false, 'record' => null];
    }

    $normalizedNeedle = wbi_normalize_lookup_value($transcriptId);
    $name = trim((string) ($payload['name'] ?? ''));
    $grade = trim((string) ($payload['grade'] ?? ''));
    $dob = trim((string) ($payload['date_of_birth'] ?? ''));
    $parentContact = trim((string) ($payload['parent_contact'] ?? ''));
    $photo = trim((string) ($payload['photo'] ?? ''));
    $gender = trim((string) ($payload['gender'] ?? ''));
    $address = trim((string) ($payload['address'] ?? ''));
    $status = trim((string) ($payload['status'] ?? 'Active'));

    foreach ($items as &$item) {
        $recordId = wbi_normalize_lookup_value((string) ($item['transcript_id'] ?? ''));
        if ($recordId === $normalizedNeedle) {
            $item['transcript_id'] = $transcriptId;
            $item['name'] = $name;
            $item['grade'] = $grade;
            $item['date_of_birth'] = $dob;
            $item['parent_contact'] = $parentContact;
            $item['photo'] = $photo;
            $item['gender'] = $gender;
            $item['address'] = $address;
            $item['status'] = $status !== '' ? $status : 'Active';
            $item['updated_at'] = date('c');
            wbi_storage_write('transcripts.json', $items);
            return ['created' => false, 'updated' => true, 'record' => $item];
        }
    }

    $record = [
        'id' => uniqid('tr_', true),
        'transcript_id' => $transcriptId,
        'name' => $name,
        'grade' => $grade,
        'date_of_birth' => $dob,
        'parent_contact' => $parentContact,
        'photo' => $photo,
        'gender' => $gender,
        'address' => $address,
        'status' => $status !== '' ? $status : 'Active',
        'created_at' => date('c'),
        'updated_at' => date('c'),
    ];

    $items[] = $record;
    wbi_storage_write('transcripts.json', $items);
    return ['created' => true, 'updated' => false, 'record' => $record];
}

function wbi_update_transcript($id, $payload)
{
    $items = wbi_storage_read('transcripts.json');

    $transcriptId = trim((string) ($payload['transcript_id'] ?? ''));
    $name = trim((string) ($payload['name'] ?? ''));
    $grade = trim((string) ($payload['grade'] ?? ''));
    $dob = trim((string) ($payload['date_of_birth'] ?? ''));
    $parentContact = trim((string) ($payload['parent_contact'] ?? ''));
    $photo = trim((string) ($payload['photo'] ?? ''));
    $gender = trim((string) ($payload['gender'] ?? ''));
    $address = trim((string) ($payload['address'] ?? ''));
    $status = trim((string) ($payload['status'] ?? 'Active'));

    if ($transcriptId === '') {
        return false;
    }

    $normalizedNeedle = wbi_normalize_lookup_value($transcriptId);
    foreach ($items as $item) {
        if ((string) ($item['id'] ?? '') !== (string) $id) {
            $recordId = wbi_normalize_lookup_value((string) ($item['transcript_id'] ?? ''));
            if ($recordId === $normalizedNeedle) {
                return false;
            }
        }
    }

    foreach ($items as &$item) {
        if ((string) ($item['id'] ?? '') === (string) $id) {
            $item['transcript_id'] = $transcriptId;
            $item['name'] = $name;
            $item['grade'] = $grade;
            $item['date_of_birth'] = $dob;
            $item['parent_contact'] = $parentContact;
            $item['photo'] = $photo;
            $item['gender'] = $gender;
            $item['address'] = $address;
            $item['status'] = $status !== '' ? $status : 'Active';
            $item['updated_at'] = date('c');
            wbi_storage_write('transcripts.json', $items);
            return true;
        }
    }

    return false;
}

function wbi_delete_transcript($id)
{
    $items = wbi_storage_read('transcripts.json');
    $initialCount = count($items);

    $items = array_values(array_filter($items, function ($item) use ($id) {
        return (string) ($item['id'] ?? '') !== (string) $id;
    }));

    if (count($items) !== $initialCount) {
        wbi_storage_write('transcripts.json', $items);
        return true;
    }

    return false;
}

function wbi_normalize_lookup_value($value)
{
    $value = trim((string) $value);
    if ($value === '') {
        return '';
    }

    $parts = preg_split('/\s+/', strtolower($value));
    return implode(' ', array_filter($parts, function ($part) {
        return $part !== '';
    }));
}

function wbi_normalize_lookup_date($value)
{
    $value = trim((string) $value);
    if ($value === '') {
        return '';
    }

    $timestamp = strtotime($value);
    if ($timestamp === false) {
        return strtolower($value);
    }

    return date('Y-m-d', $timestamp);
}

function wbi_verify_transcript_record($transcriptId, $studentName, $dateOfBirth, $grade = '')
{
    $idNeedle = wbi_normalize_lookup_value($transcriptId);
    $nameNeedle = wbi_normalize_lookup_value($studentName);
    $dobNeedle = wbi_normalize_lookup_date($dateOfBirth);
    $gradeNeedle = wbi_normalize_lookup_value($grade);

    if ($idNeedle === '' && $nameNeedle === '' && $dobNeedle === '') {
        return null;
    }

    $items = wbi_storage_read('transcripts.json');
    foreach ($items as $item) {
        $idMatch = true;
        if ($idNeedle !== '') {
            $recordId = wbi_normalize_lookup_value((string) ($item['transcript_id'] ?? ''));
            $idMatch = ($recordId === $idNeedle);
        }

        $nameMatch = true;
        if ($nameNeedle !== '') {
            $recordName = wbi_normalize_lookup_value((string) ($item['name'] ?? ''));
            $nameMatch = ($recordName === $nameNeedle);
        }

        $dobMatch = true;
        if ($dobNeedle !== '') {
            $recordDob = wbi_normalize_lookup_date((string) ($item['date_of_birth'] ?? ''));
            $dobMatch = ($recordDob === $dobNeedle);
        }

        $gradeMatch = true;
        if ($gradeNeedle !== '') {
            $recordGrade = wbi_normalize_lookup_value((string) ($item['grade'] ?? ''));
            $gradeMatch = ($recordGrade === $gradeNeedle);
        }

        if ($idMatch && $nameMatch && $dobMatch && $gradeMatch) {
            return $item;
        }
    }

    return null;
}
