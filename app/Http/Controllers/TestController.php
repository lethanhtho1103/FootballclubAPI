<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Exception;

use App\Services\UploadService;
use App\Services\ValidationService;
use App\Helpers\UserHelper;
use App\Http\Resources\PlayerResource;

use App\Models\User;
use App\Models\Player;

class TestController extends Controller
{
    public function updateImg(Request $request, $user_id)
    {

        $user = User::where('user_id', $user_id)->first();

        $oldImage = $user->image;

        $oldImagePath = str_replace('/storage/', 'public/', $oldImage);

        // Kiểm tra xem ảnh cũ có tồn tại hay không
        if (Storage::exists($oldImagePath)) {
            // Nếu tồn tại, xóa ảnh cũ
            // Storage::delete($oldImagePath);
            echo "Ok 1";
        }



    }
}
