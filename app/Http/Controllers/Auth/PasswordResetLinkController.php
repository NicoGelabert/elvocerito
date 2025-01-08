<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // We will send the password reset link to this user.
        $status = $this->sendResetLink($request->email);

        // Determine the response based on the status
        if ($status == Password::RESET_LINK_SENT) {
            return back()->with('status', __($status));
        }

        // If the password reset link was not sent, throw a validation exception
        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    /**
     * Send the password reset link.
     *
     * @param string $email
     * @return string
     */
    protected function sendResetLink(string $email): string
    {
        // Send the password reset link
        return Password::sendResetLink(['email' => $email]);
    }
}
