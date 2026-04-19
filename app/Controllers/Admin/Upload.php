<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use Cloudinary\Cloudinary;

class Upload extends BaseController
{
    private const ALLOWED_MIME = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
    private const MAX_BYTES    = 5 * 1024 * 1024; // 5 MB

    public function store(): \CodeIgniter\HTTP\ResponseInterface
    {
        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return $this->error('No valid file provided.', 422);
        }

        if (!in_array($file->getMimeType(), self::ALLOWED_MIME)) {
            return $this->error('Only JPEG, PNG, WebP and GIF images are allowed.', 422);
        }

        if ($file->getSize() > self::MAX_BYTES) {
            return $this->error('File must be under 5 MB.', 422);
        }

        try {
            $cloudinary = new Cloudinary(getenv('CLOUDINARY_URL'));

            $result = $cloudinary->uploadApi()->upload(
                $file->getTempName(),
                [
                    'folder'        => 'jnv/images',
                    'resource_type' => 'image',
                ]
            );

            return $this->json(['url' => $result['secure_url']]);
        } catch (\Exception $e) {
            log_message('error', 'Cloudinary image upload failed: ' . $e->getMessage());
            return $this->error('Upload failed. Please try again.', 500);
        }
    }
}
