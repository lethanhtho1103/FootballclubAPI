<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

use App\Services\UploadService;
use App\Services\ValidationService;
use App\Helpers\UserHelper;

use App\Models\User;
use App\Models\Player;

class PlayerController extends Controller
{
    private $uploadService;
    private $validationService;

    public function __construct(UploadService $uploadService, ValidationService $validationService)
    {
        $this->uploadService = $uploadService;
        $this->validationService = $validationService;
    }

    public function register(Request $request)
    {
        try {
            // Lấy các quy tắc xác thực từ ValidationService
            $validatedData = $this->validationService->getUserValidationRules($request)
                            + $this->validationService->getPlayerValidationRules($request);

            // Thực hiện xác thực dữ liệu
            $this->validate($request, $validatedData);

            // Tạo user ID độc nhất cho HLV
            $userID = UserHelper::generateUserID('P');

            // Upload ảnh với sự trợ giúp của UploadService
            $imagesPaths = $this->uploadService->uploadImages($request, $userID);

            $user = User::create([
                'user_id' => $userID,
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'date_of_birth' =>  $request['date_of_birth'],
                'nationality' => $request['nationality'],
                'role_id' => 4,
                'images' => json_encode($imagesPaths),
            ]);

            $player = Player::create([
                'user_id' => $userID ?? 'P0000000',
                'goal' => 0,
                'assist' => 0,
                'position' => $request['position'],
                'jersey_number' => $request['jersey_number'],
            ]);

            return response()->json(['message' => 'Player registered successfully', 'user' => $user]);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
