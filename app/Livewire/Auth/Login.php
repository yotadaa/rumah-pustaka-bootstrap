<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


use App\Models\User;

class Login extends Component
{
    public $email, $password;

    public function render()
    {
        return view('livewire.auth.login');
    }

    public function submit()
    {
        // Validate inputs
        $this->validate([
            'email' => 'required|string|max:255',
            'password' => 'required|string|min:8|max:255',
        ]);

        $credentials = ['email' => $this->email, 'password' => $this->password];
        $user = User::where('email', $this->email)->first();

        if (Auth::attempt($credentials)) {
            // Force login if needed (for debugging)
            Auth::loginUsingId($user->id);  // Manually log in
            session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }


        // If authentication fails, return with error message
        $this->addError('email', 'The provided credentials do not match our records.');
        redirect()->route('admin.dashboard');
    }
}
