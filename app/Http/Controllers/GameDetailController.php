<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

use App\Services\ValidationService;
use App\Models\GameDetail;
use App\Http\Resources\GameDetailResource;

class GameDetailController extends Controller
{
    protected $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function store(Request $request)
    {
        try {
            $request->validate($this->validationService->getGameDetailValidationRules($request));

            $gameDetail = GameDetail::create($request->all());
            // $gameDetail->load('game');

            $gameDetailResource = $gameDetail;

            return response()->json(['message' => 'Game detail stored successfully', 'data' => $gameDetailResource], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate($this->validationService->getGameDetailValidationRules($request));

            $gameDetail = GameDetail::findOrFail($id);
            $gameDetail->update($request->all());
            // $gameDetail->load('game');



            return response()->json(['message' => 'Game detail updated successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Game detail not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete($id)
    {
        try {
            $gameDetail = GameDetail::findOrFail($id);
            $gameDetail->delete();

            return response()->json(['message' => 'Game detail deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Game detail not found'], 404);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
