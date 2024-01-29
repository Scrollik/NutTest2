<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\If_;

use function Laravel\Prompts\password;

class LoginController extends Controller
{
    public function create()
    {
        return view('auth.auth');
    }

    public function store(Request $request)
    {
        $user = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
        if (!Auth::attempt($user)) {
            return back()
                ->withInput()
                ->withErrors([
                    'email' => trans('auth.failed')
                ]);
        }
        $request->session()->regenerate();
        return redirect('/');
    }

    public function destroy(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
