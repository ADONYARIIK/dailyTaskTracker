<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Password::defaults(function () {
            if ($this->app->isLocal()) {
                return Password::min(8);
            }

            return Password::min(8)
                ->mixedCase()
                ->uncompromised()
                ->letters()
                ->numbers()
                ->symbols();
        });

        $loginRateLimiterResponse = function (Request $request) {
            if ($request->expectsJson()) {
                return response()->json(
                    [
                        'attempt' => 'Too many login attempts. Please try again in 1 minute.'
                    ],
                    429
                );
            }

            return back()
                ->withErrors(['attempt' => 'Too many login attempts. Please try again in 1 minute.'])
                ->withInput($request->except('password'));
        };

        RateLimiter::for('login', function (Request $request) use ($loginRateLimiterResponse) {
            return [
                Limit::perMinute(100)->by($request->ip())->response($loginRateLimiterResponse),
                Limit::perMinute(5)->by($request->input('email'))->response($loginRateLimiterResponse),
            ];
        });

        RateLimiter::for('password-reset-request', function (Request $request) {
            return [
                Limit::perHour(10)->by($request->ip()),
                Limit::perHour(3)->by($request->input('email')),
            ];
        });

        RateLimiter::for('password-reset', function (Request $request) {
            return [
                Limit::perHour(5)->by($request->ip()),
                Limit::perHour(3)->by($request->input('email')),
            ];
        });
    }
}
