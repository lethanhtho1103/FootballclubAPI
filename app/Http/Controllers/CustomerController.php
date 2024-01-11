<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class CustomerController extends Controller
{
    public function register(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,Email',
            'password' => 'required|string|max:255',
        ]);

        $maxUserId = User::where('user_id', 'like', 'U%')->max('user_id');
        $userID = 'U' . str_pad(($maxUserId ? (int) substr($maxUserId, 1) : 0) + 1, 7, '0', STR_PAD_LEFT);

        $user = User::create([
            'user_id' => $userID ?? 'U0000001',
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password'])
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user]);
    }
}
