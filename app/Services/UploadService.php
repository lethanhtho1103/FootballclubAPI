<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class UploadService
{
    public function uploadImage($request, $userID)
    {
        $imagePath = '';

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            if ($image->isValid()) {
                $imageName = time() . Str::random(10) . '.' . $image->getClientOriginalExtension();

                $imagePath = $image->storeAs("upload/users/{$userID}", $imageName, 'public');

                if (!$imagePath) {
                    throw new Exception('Failed to store image');
                }
            } else {
                throw new Exception('Invalid image file');
            }
        }

        return Storage::url($imagePath);
    }
}
