<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Actions\Auth\ResetPassword;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\SendPasswordResetEmailRequest;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use SensitiveParameter;

class PasswordResetController extends Controller
{
    public function showPasswordResetRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendPasswordResetEmail(SendPasswordResetEmailRequest $request): RedirectResponse
    {
        $email = $request->string('email');

        Password::sendResetLink(['email' => $email]);

        return back()->with('status', 'If an account with this email exists, we will send a password reset link.');
    }

    public function showPasswordResetForm(#[SensitiveParameter] string $token, Request $request): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->string('email'),
        ]);
    }

    public function resetPassword(ResetPasswordRequest $request, ResetPassword $resetPassword): RedirectResponse
    {
        $requestData = $request->validated();

        $status = Password::reset($requestData, fn (User $user, #[SensitiveParameter] string $newPassword) => $resetPassword
            ->execute($user, $newPassword));

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        logger()->debug('Password reset failed', ['status' => $status, 'email' => $requestData['email'] ?? null]);

        return back()->withInput($request->only('email'))->withErrors(['email' => 'Failed to reset your password']);
    }
}
