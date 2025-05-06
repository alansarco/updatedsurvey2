<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    protected function redirectTo(Request $request)
    {
        if (auth()->user()->email === 'admin@gmail.com') {
            return route('admin.dashboard');
        }
        
        return route('dashboard');
    }
}
