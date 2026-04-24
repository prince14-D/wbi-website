<?php

function wbi_prepare_upload_dir($absoluteDir)
{
    if (!is_dir($absoluteDir)) {
        if (!@mkdir($absoluteDir, 0775, true) && !is_dir($absoluteDir)) {
            return [false, 'Upload directory is missing and could not be created.'];
        }
    }

    if (!is_writable($absoluteDir)) {
        @chmod($absoluteDir, 0775);
    }

    if (!is_writable($absoluteDir)) {
        return [false, 'Upload directory is not writable. Please set folder permissions to 755 or 775.'];
    }

    return [true, ''];
}

function wbi_handle_post_image_upload($inputName, $existingPath = '')
{
    if (!isset($_FILES[$inputName]) || !is_array($_FILES[$inputName])) {
        return ['path' => $existingPath, 'error' => ''];
    }

    $file = $_FILES[$inputName];

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['path' => $existingPath, 'error' => ''];
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['path' => $existingPath, 'error' => 'Image upload failed. Please try again.'];
    }

    $tmpPath = $file['tmp_name'] ?? '';
    $size = (int) ($file['size'] ?? 0);

    if (!is_uploaded_file($tmpPath)) {
        return ['path' => $existingPath, 'error' => 'Invalid uploaded file.'];
    }

    if ($size > 3 * 1024 * 1024) {
        return ['path' => $existingPath, 'error' => 'Image must be 3MB or less.'];
    }

    $mimeType = mime_content_type($tmpPath);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mimeType])) {
        return ['path' => $existingPath, 'error' => 'Only JPG, PNG, or WEBP images are allowed.'];
    }

    $extension = $allowed[$mimeType];
    $filename = 'post_' . bin2hex(random_bytes(8)) . '.' . $extension;
    $uploadDir = __DIR__ . '/../assets/uploads/posts';
    [$ok, $dirError] = wbi_prepare_upload_dir($uploadDir);
    if (!$ok) {
        return ['path' => $existingPath, 'error' => $dirError];
    }

    $relativePath = 'assets/uploads/posts/' . $filename;
    $targetPath = __DIR__ . '/../' . $relativePath;

    if (!move_uploaded_file($tmpPath, $targetPath)) {
        return ['path' => $existingPath, 'error' => 'Unable to save uploaded image.'];
    }

    if ($existingPath !== '') {
        wbi_remove_uploaded_post_image($existingPath);
    }

    return ['path' => $relativePath, 'error' => ''];
}

function wbi_remove_uploaded_post_image($relativePath)
{
    $cleanPath = str_replace('..', '', (string) $relativePath);

    if (strpos($cleanPath, 'assets/uploads/posts/') !== 0) {
        return;
    }

    $fullPath = __DIR__ . '/../' . $cleanPath;
    if (is_file($fullPath)) {
        @unlink($fullPath);
    }
}

function wbi_handle_admission_photo_upload($inputName)
{
    if (!isset($_FILES[$inputName]) || !is_array($_FILES[$inputName])) {
        return ['path' => '', 'error' => 'Please upload a student photo.'];
    }

    $file = $_FILES[$inputName];

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['path' => '', 'error' => 'Please upload a student photo.'];
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['path' => '', 'error' => 'Photo upload failed. Please try again.'];
    }

    $tmpPath = $file['tmp_name'] ?? '';
    $size = (int) ($file['size'] ?? 0);

    if (!is_uploaded_file($tmpPath)) {
        return ['path' => '', 'error' => 'Invalid uploaded file.'];
    }

    if ($size > 3 * 1024 * 1024) {
        return ['path' => '', 'error' => 'Photo must be 3MB or less.'];
    }

    $mimeType = mime_content_type($tmpPath);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mimeType])) {
        return ['path' => '', 'error' => 'Only JPG, PNG, or WEBP images are allowed.'];
    }

    $uploadDir = __DIR__ . '/../assets/uploads/admissions';
    [$ok, $dirError] = wbi_prepare_upload_dir($uploadDir);
    if (!$ok) {
        return ['path' => '', 'error' => $dirError];
    }

    $filename = 'adm_' . bin2hex(random_bytes(8)) . '.' . $allowed[$mimeType];
    $relativePath = 'assets/uploads/admissions/' . $filename;
    $targetPath = __DIR__ . '/../' . $relativePath;

    if (!move_uploaded_file($tmpPath, $targetPath)) {
        return ['path' => '', 'error' => 'Unable to save uploaded photo.'];
    }

    return ['path' => $relativePath, 'error' => ''];
}

function wbi_remove_uploaded_admission_photo($relativePath)
{
    $cleanPath = str_replace('..', '', (string) $relativePath);

    if (strpos($cleanPath, 'assets/uploads/admissions/') !== 0) {
        return;
    }

    $fullPath = __DIR__ . '/../' . $cleanPath;
    if (is_file($fullPath)) {
        @unlink($fullPath);
    }
}

function wbi_handle_transcript_photo_upload($inputName, $existingPath = '')
{
    if (!isset($_FILES[$inputName]) || !is_array($_FILES[$inputName])) {
        return ['path' => $existingPath, 'error' => ''];
    }

    $file = $_FILES[$inputName];

    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['path' => $existingPath, 'error' => ''];
    }

    if (($file['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
        return ['path' => $existingPath, 'error' => 'Photo upload failed. Please try again.'];
    }

    $tmpPath = $file['tmp_name'] ?? '';
    $size = (int) ($file['size'] ?? 0);

    if (!is_uploaded_file($tmpPath)) {
        return ['path' => $existingPath, 'error' => 'Invalid uploaded file.'];
    }

    if ($size > 3 * 1024 * 1024) {
        return ['path' => $existingPath, 'error' => 'Photo must be 3MB or less.'];
    }

    $mimeType = mime_content_type($tmpPath);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
    ];

    if (!isset($allowed[$mimeType])) {
        return ['path' => $existingPath, 'error' => 'Only JPG, PNG, or WEBP images are allowed.'];
    }

    $uploadDir = __DIR__ . '/../assets/uploads/transcripts';
    [$ok, $dirError] = wbi_prepare_upload_dir($uploadDir);
    if (!$ok) {
        return ['path' => $existingPath, 'error' => $dirError];
    }

    $filename = 'tr_' . bin2hex(random_bytes(8)) . '.' . $allowed[$mimeType];
    $relativePath = 'assets/uploads/transcripts/' . $filename;
    $targetPath = __DIR__ . '/../' . $relativePath;

    if (!move_uploaded_file($tmpPath, $targetPath)) {
        return ['path' => $existingPath, 'error' => 'Unable to save uploaded photo.'];
    }

    if ($existingPath !== '' && strpos($existingPath, 'assets/uploads/transcripts/') === 0) {
        wbi_remove_uploaded_transcript_photo($existingPath);
    }

    return ['path' => $relativePath, 'error' => ''];
}

function wbi_remove_uploaded_transcript_photo($relativePath)
{
    $cleanPath = str_replace('..', '', (string) $relativePath);

    if (strpos($cleanPath, 'assets/uploads/transcripts/') !== 0) {
        return;
    }

    $fullPath = __DIR__ . '/../' . $cleanPath;
    if (is_file($fullPath)) {
        @unlink($fullPath);
    }
}
