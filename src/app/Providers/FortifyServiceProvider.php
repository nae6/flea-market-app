<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;
use App\Http\Responses\LoginResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use App\Http\Responses\RegisterResponse;
use Laravel\Fortify\Contracts\LogoutResponse as LogoutResponseContract;
use App\Http\Responses\LogoutResponse;


class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FortifyLoginRequest::class, LoginRequest::class);

        $this->app->singleton(LoginResponseContract::class, LoginResponse::class);

        $this->app->singleton(RegisterResponseContract::class, RegisterResponse::class);

        $this->app->singleton(LogoutResponseContract::class, LogoutResponse::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function()
        {
            return view('auth.register');
        });

        Fortify::loginView(function ()
        {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;
            return Limit::perMinute(5)->by($email . $request->ip());
        });

        Fortify::authenticateUsing(function (LoginRequest $request)
        {
            Validator::make(
                $request->only(['email', 'password']),
                $request->rules(),
                $request->messages()
            )->validate();

            $user = User::where('email', $request->email)->first();

            if ($user && Hash::check($request->password, $user->password))
                {
                    return $user;
                }

            throw ValidationException::withMessages
            ([
                'password' => 'ログイン情報が登録されていません',
            ]);
        });
    }
}
