<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Exception;

class UploadService
{
    public function uploadImages($request, $userID)
    {
        $imagesPaths = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    if ($image->isValid()) {
                        $imageName = time() . Str::random(10) . '.' . $image->getClientOriginalExtension();

                        $imagePath = $image->storeAs("upload/users/{$userID}", $imageName, 'public');

                        if ($imagePath) {
                            $imagesPaths[] = Storage::url($imagePath);
                        } else {
                            throw new Exception('Failed to store image');
                        }
                    } else {
                        throw new Exception('Invalid image file');
                    }
                }
            }
        return $imagesPaths;
    }
}
