<?php

namespace App\Libraries;

class MediaUpload
{
    protected array $allowedExt = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];
    protected array $allowedMime = [
        'image/jpeg',
        'image/jpg',
        'image/pjpeg',
        'image/png',
        'image/x-png',
        'image/webp',
        'image/svg+xml',
        'image/gif',
        'application/octet-stream', // some browsers/OS send this; we still verify by extension/image
    ];
    protected int $maxSize = 10485760; // 10MB

    public function upload($file, string $subdir, array $meta = []): array
    {
        if ($file === null) {
            return ['success' => false, 'error' => 'No file received.'];
        }

        if ($file->getError() === UPLOAD_ERR_NO_FILE) {
            return ['success' => false, 'error' => 'No file chosen.'];
        }

        if (!$file->isValid() || $file->hasMoved()) {
            return ['success' => false, 'error' => $file->getErrorString() ?: 'Invalid upload.'];
        }

        $ext = strtolower((string) ($file->getClientExtension() ?: $file->guessExtension() ?: ''));
        // Normalize jpeg
        if ($ext === 'jpeg') {
            $ext = 'jpg';
        }

        if (!in_array($ext, $this->allowedExt, true) && $ext !== 'jpeg') {
            return ['success' => false, 'error' => 'Invalid file extension: ' . ($ext ?: 'unknown')];
        }

        $mime = (string) $file->getMimeType();
        $mimeOk = in_array($mime, $this->allowedMime, true) || str_starts_with($mime, 'image/');
        if (!$mimeOk) {
            return ['success' => false, 'error' => 'Invalid MIME type: ' . $mime];
        }

        if ($file->getSize() > $this->maxSize) {
            return ['success' => false, 'error' => 'File exceeds 10MB limit.'];
        }

        $original = $file->getClientName();
        if (preg_match('/\.(php|phtml|phar|exe|sh|bat|js|html?)$/i', $original)) {
            return ['success' => false, 'error' => 'Executable files are not allowed.'];
        }

        $subdir = trim($subdir, '/');
        $destDir = rtrim(ROOTPATH, '/\\') . DIRECTORY_SEPARATOR . 'uploaded_folder' . DIRECTORY_SEPARATOR . $subdir;

        if (!is_dir($destDir)) {
            if (!@mkdir($destDir, 0777, true) && !is_dir($destDir)) {
                return ['success' => false, 'error' => 'Could not create upload folder.'];
            }
        }
        @chmod($destDir, 0777);

        if (!is_writable($destDir)) {
            return ['success' => false, 'error' => 'Upload folder is not writable: uploaded_folder/' . $subdir];
        }

        $safeName = bin2hex(random_bytes(8)) . '_' . time() . '.' . ($ext === 'jpeg' ? 'jpg' : $ext);
        $fullPath = $destDir . DIRECTORY_SEPARATOR . $safeName;
        $tmpPath  = $file->getTempName();

        if (!is_uploaded_file($tmpPath)) {
            return ['success' => false, 'error' => 'Invalid upload temp file.'];
        }

        if (!@move_uploaded_file($tmpPath, $fullPath)) {
            $last = error_get_last();
            return [
                'success' => false,
                'error'   => 'Could not save file to uploaded_folder/' . $subdir
                    . (!empty($last['message']) ? ' (' . $last['message'] . ')' : ' — check folder permissions'),
            ];
        }
        @chmod($fullPath, 0644);

        if (!is_file($fullPath)) {
            return ['success' => false, 'error' => 'Upload failed — file was not saved.'];
        }

        $relative = $subdir . '/' . $safeName;

        // Extra safety: non-svg must be a real image
        $width = null;
        $height = null;
        if ($ext !== 'svg') {
            if (!is_file($fullPath)) {
                return ['success' => false, 'error' => 'Saved file missing.'];
            }
            $info = @getimagesize($fullPath);
            if ($info === false && $mime !== 'image/svg+xml') {
                @unlink($fullPath);
                return ['success' => false, 'error' => 'File is not a valid image.'];
            }
            if ($info) {
                $width = $info[0];
                $height = $info[1];
            }
        }

        $db = \Config\Database::connect();
        $db->table('media')->insert([
            'original_name' => $original,
            'file_name'     => $safeName,
            'file_path'     => $relative,
            'file_type'     => 'image',
            'mime_type'     => $mime ?: 'image/' . $ext,
            'file_size'     => (int) filesize($fullPath),
            'width'         => $width,
            'height'        => $height,
            'alt_text'      => $meta['alt_text'] ?? null,
            'title'         => $meta['title'] ?? null,
            'module'        => $meta['module'] ?? null,
            'module_id'     => $meta['module_id'] ?? null,
            'created_at'    => date('Y-m-d H:i:s'),
            'updated_at'    => date('Y-m-d H:i:s'),
        ]);

        return [
            'success'  => true,
            'media_id' => (int) $db->insertID(),
            'path'     => $relative,
            'url'      => uploaded_folder_url($relative),
        ];
    }

    public function deleteByPath(string $path, bool $force = false): bool
    {
        $db = \Config\Database::connect();
        $path = ltrim($path, '/');

        $refs = $db->table('media')->where('file_path', $path)->where('deleted_at', null)->countAllResults();
        if ($refs > 1 && !$force) {
            return false;
        }

        $db->table('media')->where('file_path', $path)->update([
            'deleted_at' => date('Y-m-d H:i:s'),
        ]);

        $still = $db->table('media')
            ->where('file_path', $path)
            ->where('deleted_at', null)
            ->countAllResults();

        if ($still === 0) {
            $full = ROOTPATH . 'uploaded_folder/' . $path;
            if (is_file($full)) {
                @unlink($full);
            }
        }

        return true;
    }
}
