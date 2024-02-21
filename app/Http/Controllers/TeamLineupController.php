<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Models\TeamLineup;
use Exception;

class TeamLineupController extends Controller
{
    // Thêm một cầu thủ vào đội hình
    public function store(Request $request)
    {
        try {
            // Validate request data
            $this->validate($request, [
                'game_id' => 'required|integer',
                'user_id' => 'required|string',
                'position' => 'required|string|max:255',
                'is_starting_player' => 'required|boolean',
                'formation' => 'required|string|max:10'
            ]);

            // Create new team lineup record
            $teamLineup = TeamLineup::create([
                'game_id' => $request->game_id,
                'user_id' => $request->user_id,
                'position' => $request->position,
                'is_starting_player' => $request->is_starting_player,
                'formation' => $request->formation
            ]);

            // Return success response
            return response()->json(['message' => 'Player added to lineup successfully', 'teamLineup' => $teamLineup], 200);
        } catch (ValidationException $e) {
            // Return validation error response
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            // Return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Sửa thông tin của một cầu thủ trong đội hình
    public function update(Request $request, $lineup_id)
    {
        try {
            // Validate request data
            $this->validate($request, [
                'position' => 'nullable|string|max:255',
                'is_starting_player' => 'nullable|boolean',
                'formation' => 'nullable|string|max:10'
            ]);

            // Find team lineup record
            $teamLineup = TeamLineup::find($lineup_id);

            if ($teamLineup) {
                // Update team lineup record
                $teamLineup->update($request->only(['position', 'is_starting_player', 'formation']));

                // Return success response
                return response()->json(['message' => 'Team lineup updated successfully', 'teamLineup' => $teamLineup], 200);
            } else {
                // Return error response if team lineup not found
                return response()->json(['message' => 'Team lineup not found'], 404);
            }
        } catch (ValidationException $e) {
            // Return validation error response
            return response()->json(['errors' => $e->errors()], 400);
        } catch (Exception $e) {
            // Return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Xóa một cầu thủ khỏi đội hình
    public function delete($lineup_id)
    {
        try {
            // Find team lineup record
            $teamLineup = TeamLineup::find($lineup_id);

            if ($teamLineup) {
                // Delete team lineup record
                $teamLineup->delete();

                // Return success response
                return response()->json(['message' => 'Player removed from lineup successfully'], 200);
            } else {
                // Return error response if team lineup not found
                return response()->json(['message' => 'Team lineup not found'], 404);
            }
        } catch (Exception $e) {
            // Return error response
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update_possison(Request $request){
        try {
            // Tìm cầu thủ hiện tại đang đảm nhận vị trí mới
            $currentPlayer = TeamLineup::where('game_id', $request->gameId)
                ->where('position', $request->newPosition)
                ->where('is_starting_player', 1)
                ->first();

            if ($currentPlayer) {
                // Đặt is_starting_player của cầu thủ hiện tại thành 0
                $currentPlayer->is_starting_player = 0;
                $currentPlayer->save();
            }

            // Tìm cầu thủ mới
            $newPlayer = TeamLineup::where('game_id', $request->gameId)
                ->where('user_id', $request->newPlayerUserId)
                ->first();

            if ($newPlayer) {
                // Cập nhật thông tin cho cầu thủ mới
                $newPlayer->position = $request->newPosition;
                $newPlayer->is_starting_player = 1;
                $newPlayer->save();
            }

            return response()->json(['message' => 'Player position switched successfully'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
