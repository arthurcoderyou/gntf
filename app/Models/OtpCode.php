<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OtpCode extends Model
{
    public $table = "otp_codes";
    protected $fillable = [
        'user_id', 
        'otp_code', 
        'expires_at',
        'guardian_email',
        'used',
        'player_registration_id'
    ];

    public static function generateOtp($player_registration, $guardian_email = null) {
        $user = $player_registration->user;
    
        // Check if there's an existing valid OTP for the same user and registration
        $existingOtp = self::where('user_id', $user->id)
            ->where('player_registration_id', $player_registration->id)
            ->where('expires_at', '>', now()) // Ensure OTP is not expired
            ->where('used', false); // Ensure OTP is not used

        if(!empty($guardian_email)){
            $existingOtp = $existingOtp->where('guardian_email', $guardian_email);
        }


        $existingOtp = $existingOtp->first();
    
        if ($existingOtp) {


            $existingOtp->updated_at = now();
            $existingOtp->save();

            return $existingOtp->otp_code; // Return existing OTP if valid
        }
    
        // Generate new 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    

        if(!empty($guardian_email)){
            // Delete old OTPs for the same user and registration
            self::where('user_id', $user->id)
                ->where('player_registration_id', $player_registration->id)
                ->where('guardian_email', $guardian_email)
                ->delete();
        }else{
            // Delete old OTPs for the same user and registration
            self::where('user_id', $user->id)
                ->where('player_registration_id', $player_registration->id)
                ->delete();
        }
        


        
        if(!empty($guardian_email)){
            // Create new OTP entry
            $newOtp = self::create([
                'user_id' => $user->id,
                'otp_code' => $otp,
                'guardian_email' => $guardian_email,
                'expires_at' => now()->addMinutes(10),
                'player_registration_id' => $player_registration->id,
            ]);
        }else{
            // Create new OTP entry for guardian email
            $newOtp = self::create([
                'user_id' => $user->id,
                'otp_code' => $otp, 
                'expires_at' => now()->addMinutes(10),
                'player_registration_id' => $player_registration->id,
            ]);
        }
        
    
        return $newOtp->otp_code; // Return the newly generated OTP
    }



 
    


}
