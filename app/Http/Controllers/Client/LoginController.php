<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\RegisterRequest;
use App\Services\Client\UserService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $user;

    public function __construct(UserService $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        return view('client.login');
    }

    public function login(Request $request)
    {
        if (!Auth::guard('cus')->attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            return redirect()->route('login.index')->with('error', 'Email or Password wrong');
        }
        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::guard('cus')->logout();
        return redirect()->route('home');
    }

    public function signup()
    {
        return view('client.register');
    }

    public function register(RegisterRequest $request)
    {
        try {
             $this->user->register($request);
        return redirect()->route('login.user')->with('success', CREATE_SUCCESS);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
