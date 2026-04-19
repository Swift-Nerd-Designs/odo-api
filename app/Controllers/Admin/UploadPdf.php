<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Cloudinary\Cloudinary;

/**
 * Admin\UploadPdf
 *
 * Accepts a PDF upload and stores it on Cloudinary under jnv/documents.
 * Route: POST /admin/upload-pdf  (adminauth filter)
 */
class UploadPdf extends BaseController
{
    private const MAX_BYTES = 20 * 1024 * 1024; // 20 MB

    public function store(): \CodeIgniter\HTTP\ResponseInterface
    {
        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return $this->error('No valid file provided.', 422);
        }

        $mime = $file->getMimeType();
        $name = strtolower($file->getClientName());

        if ($mime !== 'application/pdf' && !str_ends_with($name, '.pdf')) {
            return $this->error('Only PDF files are accepted.', 422);
        }

        if ($file->getSize() > self::MAX_BYTES) {
            return $this->error('File must be under 20 MB.', 422);
        }

        try {
            $cloudinary = new Cloudinary(getenv('CLOUDINARY_URL'));

            // Strip extension for the public_id, Cloudinary preserves the original name
            $publicId = 'jnv/documents/' . pathinfo($file->getClientName(), PATHINFO_FILENAME);

            $result = $cloudinary->uploadApi()->upload(
                $file->getTempName(),
                [
                    'public_id'     => $publicId,
                    'resource_type' => 'raw',
                    'use_filename'  => true,
                    'unique_filename' => true,
                ]
            );

            return $this->json([
                'url'      => $result['secure_url'],
                'filename' => $file->getClientName(),
                'size'     => $this->formatBytes($file->getSize()),
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Cloudinary PDF upload failed: ' . $e->getMessage());
            return $this->error('Upload failed. Please try again.', 500);
        }
    }

    private function formatBytes(int $bytes): string
    {
        $mb = $bytes / 1024 / 1024;
        return 'PDF · ~' . round($mb, 1) . ' MB';
    }
}
