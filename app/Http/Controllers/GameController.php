<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

use App\Services\ValidationService;
use App\Models\Game;
use App\Http\Resources\GameResource;

class GameController extends Controller
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index()
    {
        try {
            $games = Game::with('club', 'stadium', 'gameDetail')->get();
            $gameResources = GameResource::collection($games);

            return response()->json(['games' => $gameResources], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $game = Game::with('club', 'stadium', 'gameDetail')->findOrFail($id);
            $gameResource = new GameResource($game);

            return response()->json(['games' => $gameResource], 200);

        } catch (Exception $e) {
            return response()->json(['message' => 'The match does not exist.'], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->validationService->getGameValidationRules($request));

            // Kiểm tra xem có trận đấu nào bị trùng ngày và giờ hay không
            $existingGame = Game::where('game_date', $request->input('game_date'))
                ->where('game_time', $request->input('game_time'))
                ->first();

            if ($existingGame) {
                return response()->json(['message' => 'There is already a game at this date and time.'], 400);
            }

            // Tạo mới trận đấu
            $game = Game::create($request->all());
            $games = Game::with('club', 'stadium', 'gameDetail')->where('game_id', $game->game_id)->get();

            return new GameResource($game);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate($this->validationService->getGameValidationRules($request));

            // Cập nhật thông tin trận đấu
            $game = Game::findOrFail($id);
            $game->update($request->all());

            return new GameResource($game);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function delete($id)
    {
        try {
            $game = Game::findOrFail($id);
            $game->delete();

            return response()->json(['message' => 'The match has been successfully deleted.']);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
