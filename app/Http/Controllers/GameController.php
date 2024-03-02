<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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

            return response()->json(['matches' => $gameResources], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $game = Game::with('club', 'stadium', 'gameDetail')->findOrFail($id);
            $gameResource = new GameResource($game);

            return response()->json(['match' => $gameResource], 200);

        } catch (Exception $e) {
            return response()->json(['message' => 'The match does not exist.'], 404);
        }
    }

    public function matchLive()
    {
        try {
            $liveMatches = Game::with('club', 'stadium', 'gameDetail')
                ->where('state', 'in_progress')
                ->get();

            return response()->json(['live_matches' => GameResource::collection($liveMatches)], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No live matches found.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function matchHistory()
    {
        try {
            $historyMatches = Game::with('club', 'stadium', 'gameDetail')
                ->where('state', 'finished')
                ->get();

            return response()->json(['history_matches' => GameResource::collection($historyMatches)], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No finished matches found.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function matchComeUp()
    {
        try {
            $upcomingMatches = Game::with('club', 'stadium', 'gameDetail')
                ->whereIn('state', ['coming_up', 'pending'])
                ->get();

            return response()->json(['upcoming_matches' => GameResource::collection($upcomingMatches)], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'No upcoming matches found.'], 404);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
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
            $game->load('club', 'stadium', 'gameDetail');

            $gameResource = new GameResource($game);

            return response()->json(['match' => $gameResource], 200);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate($this->validationService->getGameValidationRules($request));

            $existingGame = Game::where('game_date', $request->input('game_date'))
                ->where('game_time', $request->input('game_time'))
                ->first();

            if ($existingGame) {
                return response()->json(['message' => 'There is already a game at this date and time.'], 400);
            }

            // Cập nhật thông tin trận đấu
            $game = Game::findOrFail($id);
            $game->update($request->all());

            $gameResource = new GameResource($game);
            return response()->json(['match' => $gameResource], 200);
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
