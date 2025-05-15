<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PasswordResetHelper
{
    /**
     * Generate a new reset token for the email
     *
     * @param string $email
     * @return string
     */
    public static function createToken($email)
    {
        // Delete any existing token for this email
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        
        // Create a new token
        $token = Str::random(64);
        
        // Store the token with the email
        DB::table('password_reset_tokens')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        
        return $token;
    }
    
    /**
     * Validate if a token is valid for a given email
     *
     * @param string $email
     * @param string $token
     * @return bool
     */
    public static function validateToken($email, $token)
    {
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $email)
            ->where('token', $token)
            ->first();
            
        if (!$resetRecord) {
            return false;
        }
        
        // Check if token is expired (24 hours)
        $createdAt = Carbon::parse($resetRecord->created_at);
        if ($createdAt->diffInHours(Carbon::now()) > 24) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return false;
        }
        
        return true;
    }
    
    /**
     * Delete a token after it's been used
     *
     * @param string $email
     * @return void
     */
    public static function deleteToken($email)
    {
        DB::table('password_reset_tokens')->where('email', $email)->delete();
    }
}