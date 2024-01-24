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
use App\Http\Resources\PlayerResource;

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
            $imagePath= $this->uploadService->uploadImage($request, 'user', $userID);

            $user = User::create([
                'user_id' => $userID,
                'name' => $request['name'],
                'email' => $request['email'],
                'password' => Hash::make($request['password']),
                'date_of_birth' => $request['date_of_birth'],
                'nationality' => $request['nationality'],
                'flag' => $request['flag'],
                'role_id' => 4,
                'image' => $imagePath,
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


    // Get players
    public function index()
    {
        try {
            $players = Player::with('user:id,user_id,name,email,date_of_birth,nationality,flag,image,role_id,created_at,updated_at')
                ->get();

            $playerResources = PlayerResource::collection($players);

            return response()->json(['players' => $playerResources], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($slug)
    {
        try {
            // Chuyển đổi slug thành tên
            $name = Str::title(str_replace('-', ' ', $slug));

            // Tìm cầu thủ dựa trên tên
            $player = Player::join('users', 'players.user_id', '=', 'users.user_id')
            ->select('players.*', 'users.*')
            ->where('users.name', $name)
            ->firstOrFail();

            $playersResource = new PlayerResource($player);

            return response()->json(['player' => $playersResource], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }


}
