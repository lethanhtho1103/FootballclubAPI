<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

    // Get coach

    public function index()
    {
        try {
            $coaches = Coach::with('user:id,user_id,name,email,date_of_birth,nationality,images,role_id,created_at,updated_at')
                ->get();

            $formattedcoaches = $coaches->map(function ($coach) {
                return [
                    'user_id' => $coach->user->user_id,
                    'name' => $coach->user->name,
                    'email' => $coach->user->email,
                    'date_of_birth' => $coach->user->date_of_birth,
                    'nationality' => $coach->user->nationality,
                    'images' => $coach->user->images,

                    'wins' => $coach->wins,
                    'losses' => $coach->losses,
                    'draws' => $coach->draws,
                    'detail' => $coach->detail,
                ];
            });

            return response()->json(['coaches' => $formattedcoaches], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($slug)
    {
        try {
            // Chuyển đổi slug thành tên
            $name = Str::title(str_replace('-', ' ', $slug));

            // Tìm HLV dựa trên tên
            $coach = Coach::join('users', 'coaches.user_id', '=', 'users.user_id')
                ->select('coaches.*', 'users.name as user_name', 'users.email', 'users.date_of_birth', 'users.nationality', 'users.images', 'users.role_id', 'users.created_at as user_created_at', 'users.updated_at as user_updated_at')
                ->where('users.name', $name)
                ->firstOrFail();

            $formattedCoach = [
                'user_id' => $coach->user->user_id,
                'name' => $coach->user->name,
                'email' => $coach->user->email,
                'date_of_birth' => $coach->user->date_of_birth,
                'nationality' => $coach->user->nationality,
                'images' => $coach->user->images,

                'wins' => $coach->wins,
                'losses' => $coach->losses,
                'draws' => $coach->draws,
                'detail' => $coach->detail,
            ];

            return response()->json(['coach' => $formattedCoach], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }
}
