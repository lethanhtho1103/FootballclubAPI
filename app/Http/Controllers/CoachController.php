<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Coach;

class CoachController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,Email',
            'password' => 'required|string|max:255',
            'date_of_birth' => 'date',
            'nationality' => 'string|max:100',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'wins' => 'integer',
            'losses' => 'integer',
            'draws' => 'integer',
        ]);

        $userID = 'C' . str_pad(User::where('user_id', 'like', 'C%')->max('user_id') + 1, 7, '0', STR_PAD_LEFT);

        $imagesPaths = [];

        if ($request->hasFile('images')) {
            $images = $request->file('images');

            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();

                $imagePath = $image->storeAs("upload/user/{$userID}", $imageName, 'public');
                $imagesPaths[] = $imagePath;
            }
        }

        $user = User::create([
            'user_id' => $userID,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'date_of_birth' => $validatedData['dateOfBirth'],
            'Nationality' => $validatedData['nationality'],
            'Role_ID' => 3,
            'images' => json_encode($imagesPaths),
        ]);

        $coach = Coach::create([
            'user_id' => $userID,
            'Wins' => $validatedData['wins'],
            'Losses' => $validatedData['losses'],
            'Draws' => $validatedData['draws'],
        ]);

        return response()->json(['message' => 'Coach registered successfully']);
    }
}
