<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginContoroller extends Controller
{
    /**
     * 認証処理
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(Request  $request)
    {
        $user_info = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($user_info)) {
            $request->session()->regenerate();
            return redirect()->route('roomList.index');
        }

        return redirect()->back();
    }
}
