<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Exception;

use App\Helpers\UserHelper;
use App\Services\UploadService;
use App\Services\ValidationService;

use App\Models\User;


class CustomerController extends Controller
{
    private $uploadService;
    private $validationService;

    public function __construct(UploadService $uploadService, ValidationService $validationService)
    {
        $this->uploadService = $uploadService;
        $this->validationService = $validationService;
    }

    public function register(Request $request) {
        try {
            $validatedData = $this->validationService->getUserValidationRules($request);
            $validatedData['confirm_password'] = 'required|string|same:password';
            // Thực hiện xác thực dữ liệu
            $this->validate($request, $validatedData);

            $userID = UserHelper::generateUserID('U');

            $user = User::create([
                'user_id' => $userID ?? 'U0000000',
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password'])
            ]);

            return response()->json(['message' => 'User registered successfully', 'user' => $user]);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
