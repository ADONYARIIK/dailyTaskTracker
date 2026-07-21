<?php

declare(strict_types=1);

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use SensitiveParameter;

class ResetPassword
{
    public function execute(User $user, #[SensitiveParameter] string $newPassword): void
    {
        $user->password = Hash::make($newPassword);
        $user->remember_token = Str::random(60);

        $user->save();

        event(new PasswordReset($user));
    }
}
