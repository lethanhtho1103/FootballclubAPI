<?php

namespace App\Services;

class ValidationService
{
    public function getUserValidationRules($request)
    {
        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,Email',
            'password' => 'required|string|min:8|max:50',
            'date_of_birth' => 'date',
            'nationality' => 'string|max:50',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp,PNG,JPG|max:2048',
        ];
    }

    public function getCoachValidationRules($request)
    {
        return [
            'wins' => 'integer',
            'losses' => 'integer',
            'draws' => 'integer',
        ];
    }

    public function getPlayerValidationRules($request)
    {
        return [
            'position' => 'string|max:50',
            'jersey_number' => 'integer|min:1|max:99',
        ];
    }

}
