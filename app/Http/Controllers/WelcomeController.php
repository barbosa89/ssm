<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;

class WelcomeController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        if (User::count() > 0) {
            return redirect()->route('login');
        }

        return redirect()->route('register');
    }
}
