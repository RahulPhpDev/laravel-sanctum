<?php


namespace App\Service;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken;

trait SanctumToken
{
    use HasApiTokens;

    /**
     * Create a new personal access token for the user.
     *
     * @param  string  $name
     * @param  string $plainTextToken
     * @param  array  $abilities
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createToken(string $name, $plainTextToken = null ,  array $abilities = ['*'])
    {
//        hash('sha256', $plainTextToken = Str::random(40)),
        $plainTextToken  = $plainTextToken ?? Str::random(40);
        $token = $this->tokens()->create([
            'name' => $name,
            'token' =>  hash('sha256',$plainTextToken ),
            'abilities' => $abilities,
        ]);
        PersonalAccessToken::unguard();
        $token->original_token =  $plainTextToken;
        $token->save();
        PersonalAccessToken::reguard();
        Log::channel('tokens')->info($token->plainTextToken);
        Log::info($token->plainTextToken);
        return new NewAccessToken($token, $token->id.'|'.$plainTextToken);
    }
}
