<?php

namespace App\Services;

use App\Models\User;
use OTPHP\TOTP;

class OTPService
{
    /**
     * @param User $user
     * @return void
     */
    public function sendOTP(User $user)
    {
        $secret = $this->getUserSecret($user);

        // we generate otp with that secret
        $code = $this->generateOTP($secret);

        // constuct your message
        $message =  "Your verification code is $code";

        // TODO
        // You can fire your event to send this message to your user as sms or email

    }

    /**
     * @param User $user
     * @return mixed
     */
    protected function getUserSecret(User $user): mixed
    {
        // if user has a secret
        if($user->two_factor_secret) {
            return $user->two_factor_secret;
        }

        // user doesn't we create one for the user
        $otp = TOTP::create();
        $secret = $otp->getSecret();

        $user->update(['two_factor_secret'=> $secret]);

        return $secret;
    }

    /**
     * Generates and OTP code from secret and timestamp (time token)
     *
     * @param $secret $secret [explicite description]
     *
     * @return string
     */
    protected function generateOTP($secret): string
    {
        $timestamp = time();

        $otp = TOTP::create($secret);

        return $otp->at($timestamp);
    }

    /**
     * Verify that the incoming code is valid
     *
     * @param $user $user [explicite description]
     * @param $code $code [explicite description]
     *
     * @return bool
     */
    public function verifyOTP($user, $code): bool
    {
        $secret = $this->getUserSecret($user);

        $timestamp = time();

        $otp = TOTP::create($secret);

        return $otp->verify($code, $timestamp);
    }
}
