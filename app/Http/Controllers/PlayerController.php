<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\Player;

class PlayerController extends Controller
{
    // Register player
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,Email',
            'password' => 'required|string|max:255',
            'date_of_birth' => 'date',
            'nationality' => 'string|max:100',
            'position' => 'string|max:100',
            'jersey_number' => 'integer',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Accept multiple images
        ]);

        $maxUserId = User::where('user_id', 'like', 'P%')->max('user_id');
        $userID = 'P' . str_pad(($maxUserId ? (int) substr($maxUserId, 1) : 0) + 1, 7, '0', STR_PAD_LEFT);


        $imagesPaths = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . Str::random(10) . '.' . $image->getClientOriginalExtension();

                    $imagePath = $image->storeAs("upload/users/{$userID}", $imageName, 'public');

                    if ($imagePath) {
                        $imagesPaths[] = Storage::url($imagePath);
                    } else {
                        // Xử lý lỗi khi không thể lưu trữ hình ảnh
                        return response()->json(['error' => 'Failed to store image'], 500);
                    }
                } else {
                    // Xử lý lỗi khi hình ảnh không hợp lệ
                    return response()->json(['error' => 'Invalid image file'], 400);
                }
            }
        }

        $user = User::create([
            'user_id' => $userID,
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'date_of_birth' => $validatedData['date_of_birth'],
            'nationality' => $validatedData['nationality'],
            'role_id' => 4, // Player role
            'images' => json_encode($imagesPaths),
        ]);

        $player = Player::create([
            'user_id' => $userID,
            'goal' => 0,
            'assist' => 0,
            'position' => $validatedData['position'],
            'jersey_number' => $validatedData['jersey_number'],
        ]);

        return response()->json(['message' => 'Player registered successfully']);
    }
}
