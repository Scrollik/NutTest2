<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
   public function  create()
   {
       return view('register.register');
   }
   public function store(Request $request)
   {
       $request->validate([
          'email' => ['required','email','unique:users'],
          'password' => ['required','confirmed','min:6'] ,
       ]);
      $user =  User::create([
          'email' => $request->email,
          'password' => $request->password,
       ]);
      if ($user)
      {
          return redirect('/');
      }
   }
}
