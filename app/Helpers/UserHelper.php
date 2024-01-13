<?php
namespace App\Helpers;

use App\Models\User;

class UserHelper
{
    public static function generateUserID($prefix)
    {
        $maxUserId = User::where('user_id', 'like', "{$prefix}%")->max('user_id');
        $userID = $prefix . str_pad(($maxUserId ? (int) substr($maxUserId, strlen($prefix)) : 0) + 1, 7, '0', STR_PAD_LEFT);

        return $userID;
    }
}
