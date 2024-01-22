<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matching;
use App\Services\ValidationService;

class MatchController extends Controller
{
    private $validationService;

    public function __construct(ValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    public function index()
    {
        $matches = Matching::all();

        return response()->json(['matches' => $matches], 200);
    }

    public function show($id)
    {
        $match = Matching::find($id);

        if (!$match) {
            return response()->json(['message' => 'Match not found'], 404);
        }

        return response()->json(['match' => $match], 200);
    }

    public function store(Request $request)
    {
        // Validate the request using the provided validation rules
        $this->validate($request, $this->validationService->getMatchingValidationRules());

        $match = Matching::create($request->all());

        return response()->json(['message' => 'Match created successfully', 'match' => $match], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate the request using the provided validation rules
        $this->validate($request, $this->validationService->getMatchingValidationRules());

        $match = Matching::find($id);

        if (!$match) {
            return response()->json(['message' => 'Match not found'], 404);
        }

        $match->update($request->all());

        return response()->json(['message' => 'Match updated successfully', 'match' => $match], 200);
    }

    public function destroy($id)
    {
        $match = Matching::find($id);

        if (!$match) {
            return response()->json(['message' => 'Match not found'], 404);
        }

        $match->delete();

        return response()->json(['message' => 'Match deleted successfully'], 200);
    }
}
