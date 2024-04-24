<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;
    protected $table = 'one_time_password';
    protected $fillable = [
        'email',
        'token',
        'expires_at',
    ];

    public function createOTP($email)
    {
        $token = rand(100000,999999);
        $otp = OTP::create([
            'email' => $email,
            'token' => $token,
            'expires_at' => now()->addMinutes(5),
        ]);
        if($otp){
            return $token;
        }
        return null;
    }
}
