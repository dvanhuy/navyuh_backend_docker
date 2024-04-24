<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Notifications\EmailVerification;
use App\Notifications\ResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'social_id',
        'social_type',
        'role',
        'avatar',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function createTokenAccess(){
        return $this->createToken('myapptoken',["*"],now()->addDays(2))->plainTextToken;
    }

    public function sendEmailVerificationNotification()
    {
        $this->email_verification_token = Str::random(30);
        $this->save();
        $this->notify(new EmailVerification($this->id,$this->email_verification_token));
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function checkOTP($token)
    {
        $otp = OTP::where('email',$this->email)
            ->where('expires_at','>=',now())
            ->orderBy('created_at','desc')
            ->first();
        if ($token == $otp->token){
            return true;
        }
        return false;
    }

    public function getUserFromToken(Request $request){
        $tokenn = PersonalAccessToken::findToken($request->bearerToken());
        return $tokenn->tokenable;
    }
}
