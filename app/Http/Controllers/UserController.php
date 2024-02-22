<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Exception;

use App\Helpers\UserHelper;
use App\Services\UploadService;
use App\Services\ValidationService;

use App\Models\User;


class UserController extends Controller
{
    private $uploadService;
    private $validationService;

    public function __construct(UploadService $uploadService, ValidationService $validationService)
    {
        $this->uploadService = $uploadService;
        $this->validationService = $validationService;
    }

    public function index()
    {
        try {
            $users = User::where('user_id', 'like', 'U%')->get();
            return response()->json(['users' => $users], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($user_id)
    {
        try {
            $user = User::where('user_id', $user_id)->firstOrFail();
            return response()->json(['user' => $user], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $this->validationService->getUserValidationRules($request);
            $validatedData['confirm_password'] = 'required|string|same:password';
            // Thực hiện xác thực dữ liệu
            $this->validate($request, $validatedData);

            $userID = UserHelper::generateUserID('U');

            $imagePath = null;
            // $imagePath = $this->uploadService->uploadImage($request, 'user', $userID);
            // $imagePath = $imagePath != "/storage/" ? $imagePath : null;

            $user = User::create([
                'user_id' => $userID ?? 'U0000000',
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'role_id' => 5,
                'image' => $imagePath ?? null,
            ]);

            return response()->json(['message' => 'User registered successfully', 'user' => $user]);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $user_id)
    {
        try {
            $validatedData = $this->validationService->getUserValidationRules($request);
            // $validatedData['confirm_password'] = 'nullable|string|same:password';

            // Thực hiện xác thực dữ liệu
            $this->validate($request, $validatedData);

            $user = User::where('user_id', $user_id)->where('user_id', 'like', 'U%')->firstOrFail();

            $user->update($request->only(['name', 'email']));

            // if ($request->hasFile('image')) {
            //     $imagePath = $this->uploadService->uploadImage($request, 'user', $user_id);
            //     $user->image = $imagePath;
            //     $user->save();
            // }

            return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);

        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($user_id)
    {
        try {
            $user = User::where('user_id', $user_id)->where('user_id', 'like', 'U%')->firstOrFail();

            $directoryToDelete = 'public/upload/users/' . $user->user_id;

            // Check if the directory exists
            if (Storage::exists($directoryToDelete)) {
                // Delete the directory along with its contents
                Storage::deleteDirectory($directoryToDelete);
            }

            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
