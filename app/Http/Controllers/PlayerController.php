<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
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
use App\Models\TeamLineup;

class PlayerController extends Controller
{
    private $uploadService;
    private $validationService;

    public function __construct(UploadService $uploadService, ValidationService $validationService)
    {
        $this->uploadService = $uploadService;
        $this->validationService = $validationService;
    }

    // Get players
    public function index()
    {
        try {
            $players = Player::with('user', 'contract')
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
                // ->with('contract')
                ->firstOrFail();

            $playersResource = new PlayerResource($player);

            return response()->json(['player' => $playersResource], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        }
    }

    // Lấy player chưa có trong đội hình
    public function player_up($game_id){
        try {
            $selectedPlayers = TeamLineup::where('game_id', $game_id)
            ->pluck('user_id')
            ->toArray();

            $allPlayers = Player::all()->pluck('user_id')->toArray();

            // Lọc ra các cầu thủ chưa được chọn
            $availablePlayers = array_diff($allPlayers, $selectedPlayers);

            $players = Player::join('users', 'players.user_id', '=', 'users.user_id')
                ->select('players.*', 'users.*')
                ->whereIn('user_id', $availablePlayers)
                ->get();

            // Lấy thông tin chi tiết của các cầu thủ chưa được chọn
            $players = PlayerResource::collection($players);

            return response()->json(['players' => $players], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
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
            $imagePath = $this->uploadService->uploadImage($request, 'user', $userID);

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

    public function update(Request $request, $user_id)
    {
        try {
            // Kiểm tra dữ liệu vào
            $this->validate($request, [
                'name' => 'string|max:255',
                'email' => [
                    'email',
                    Rule::unique('users', 'email')->ignore($user_id, 'user_id'),
                ],
                'date_of_birth' => 'nullable|date',
                'nationality' => 'nullable|string|max:255',
                'image' => 'image|mimes:jpeg,png,jpg,webp,PNG,JPG|max:2048',
                'flag' => 'nullable|string|max:255',
                'position' => 'nullable|string|max:255',
                'jersey_number' => 'nullable|string|max:255',
                'goal' => 'nullable|integer',
                'assist' => 'nullable|integer',
                'detail' => 'nullable|string',
            ]);

            // Tìm cầu thủ cần cập nhật
            $player = Player::where('user_id', $user_id)->first();

            if ($player) {
                // Lấy các quy tắc xác thực từ ValidationService


                // Tìm người dùng liên quan và cập nhật thông tin người dùng
                $user = User::where('user_id', $user_id)->first();

                if ($user) {
                    $user->update($request->only(['name', 'email', 'date_of_birth', 'nationality', 'flag']));

                    // Lấy đường dẫn ảnh cũ để xóa
                    $oldImage = $user->image;

                    // Kiểm tra và tải lên ảnh người dùng mới nếu có
                    if ($request->hasFile('image')) {
                        if ($oldImage) {

                            $oldImagePath = str_replace('/storage/', 'public/', $oldImage);

                            // Kiểm tra xem ảnh cũ có tồn tại hay không
                            if (Storage::exists($oldImagePath)) {
                                Storage::delete($oldImagePath);
                            }
                        }

                        // Tải lên ảnh mới
                        $userImageURL = $this->uploadService->uploadImage($request, 'user', $user->user_id);
                        $user->image = $userImageURL;
                    }

                    // Lưu người dùng cập nhật vào cơ sở dữ liệu
                    $user->save();

                    // Cập nhật thông tin cầu thủ
                    $player->fill($request->only(['position', 'jersey_number', 'goal', 'assist', 'detail']));

                    // Lưu cầu thủ cập nhật vào cơ sở dữ liệu
                    $player->save();
                }

                // Trả về thông báo thành công và thông tin cầu thủ cập nhật
                return response()->json(['message' => 'Player updated successfully', 'player' => new PlayerResource($player)], 200);
            } else {
                // Trả về thông báo nếu cầu thủ không tồn tại
                return response()->json(['message' => 'Player not found'], 404);
            }
        } catch (ValidationException $e) {
            // Trả về thông báo lỗi xác thực nếu có lỗi
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            // Trả về thông báo lỗi nếu có lỗi khác
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($user_id)
    {
        try {
            // Tìm cầu thủ cần xóa
            $player = Player::where('user_id', $user_id)->first();

            if ($player) {
                // Tìm và xóa người dùng liên quan
                $user = User::where('user_id', $user_id)->first();

                if ($user) {
                    $directoryToDelete = 'public/upload/users/' . $user->user_id;

                    // Check if the directory exists
                    if (Storage::exists($directoryToDelete)) {
                        // Delete the directory along with its contents
                        Storage::deleteDirectory($directoryToDelete);
                    }
                    // Xóa người dùng
                    $user->delete();
                }

                return response()->json(['message' => 'Player deleted successfully'], 200);
            } else {
                // Trả về thông báo nếu cầu thủ không tồn tại
                return response()->json(['message' => 'Player not found'], 404);
            }
        } catch (Exception $e) {
            // Trả về thông báo lỗi nếu có lỗi khác
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


}
