<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->passes()) {
            $data = [
                'email'    => $request->email,
                'password' => $request->password,
            ];
            if (Auth::attempt($data)) {
                session()->flash('success', 'Selamat Datang!');
                return response()->json([
                    'status'   => true,
                    'redirect' => route('dashboard'),
                ]);
            } else {
                session()->flash('error', 'Email/Password salah.');
                return response()->json([
                    'status'   => true,
                    'redirect' => route('login'),
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
