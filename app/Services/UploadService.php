<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class UploadService
{
    public function uploadImage($request, $entityType, $entityID)
    {
        $imagePath = '';

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $imageName = time() . Str::random(10) . '.' . $image->getClientOriginalExtension();

                $uploadPath = $this->getUploadPath($entityType, $entityID);

                $imagePath = $image->storeAs($uploadPath, $imageName, 'public');

                if (!$imagePath) {
                    throw new Exception('Failed to store image');
                }
            } else {
                throw new Exception('Invalid image file');
            }
        }

        return Storage::url($imagePath);
    }

    public function uploadPDF($request, $entityType, $entityID)
    {
        $pdfPath = '';

        if ($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');

            if ($pdf->isValid()) {
                $pdfName = time() . Str::random(10) . '.' . $pdf->getClientOriginalExtension();

                $uploadPath = $this->getUploadPath($entityType, $entityID);

                $pdfPath = $pdf->storeAs($uploadPath, $pdfName, 'public');

                if (!$pdfPath) {
                    throw new Exception('Failed to store PDF');
                }
            } else {
                throw new Exception('Invalid PDF file');
            }
        }

        return Storage::url($pdfPath);
    }

    private function getUploadPath($entityType, $entityID)
    {
        switch ($entityType) {
            case 'user':
                return "upload/users/{$entityID}";
            case 'stadium':
                return "upload/stadiums/{$entityID}";
            case 'club':
                return "upload/clubs/{$entityID}";
            case 'contract':
                return "upload/contracts";
            default:
                throw new Exception('Invalid entity type 1');
        }
    }
}
