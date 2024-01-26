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
            'flag' => 'string|max:10',
            'image' => 'image|mimes:jpeg,png,jpg,webp,PNG,JPG|max:2048',
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

    public function getGameValidationRules($request)
    {
        return [
            'club_id' => 'required|exists:clubs,club_id',
            'stadium_id' => 'required|exists:stadiums,stadium_id',
            'game_date' => 'required|date',
            'game_time' => 'required|date_format:H:i:s',
            'goals_scored' => 'integer|min:0',
            'goals_conceded' => 'integer|min:0',
            'result' => 'string|max:5',
            'state' => 'string|max:100',
            'host' => 'integer',
            'remaining_seats' => 'integer',
        ];
    }

    public function getStadiumValidationRules($request)
    {
        return [
            'name' => 'required|unique:stadiums,name|max:100',
            'address' => 'required|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,webp,PNG,JPG|max:2048',
            'capacity' => 'integer|min:0'
        ];
    }

    public function getClubValidationRules($request){
        return [
            'name' => 'required|unique:clubs,name|max:100',
            'image' => 'image|mimes:jpeg,png,jpg,webp,PNG,JPG|max:2048',
        ];
    }
}
