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
use App\Models\Coach;

class CoachController extends Controller
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
                            + $this->validationService->getCoachValidationRules($request);

            // Thực hiện xác thực dữ liệu
            $this->validate($request, $validatedData);

            // Tạo user ID độc nhất cho HLV
            $userID = UserHelper::generateUserID('C');

            // Upload ảnh với sự trợ giúp của UploadService
            $imagesPaths = $this->uploadService->uploadImages($request, $userID);

            $user = User::create([
                'user_id' => $userID ?? 'C0000000',
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'date_of_birth' =>  $request['date_of_birth'],
                'nationality' => $request['nationality'],
                'role_id' => 3,
                'images' => json_encode($imagesPaths),
            ]);

            $coach = Coach::create([
                'user_id' => $userID,
                'wins' => $request['wins'] ?? 0,
                'losses' => $request['losses'] ?? 0,
                'draws' => $request['draws'] ?? 0,
            ]);

            return response()->json(['message' => 'Coach registered successfully', 'user' => $user]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
