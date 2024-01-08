<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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

        $maxUserId = User::where('user_id', 'like', 'C%')->max('user_id');
        $userID = 'C' . str_pad(($maxUserId ? (int) substr($maxUserId, 1) : 0) + 1, 7, '0', STR_PAD_LEFT);


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
            'role_id' => 3,
            'image' => json_encode($imagesPaths),
        ]);

        $coach = Coach::create([
            'user_id' => $userID,
            'wins' => $validatedData['wins'] ?? 0,
            'losses' => $validatedData['losses'] ?? 0,
            'draws' => $validatedData['draws'] ?? 0,
        ]);

        return response()->json(['message' => 'Coach registered successfully', 'images' => $imagesPaths]);
    }
}
