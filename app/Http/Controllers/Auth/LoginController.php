<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\Config;
use App\Traits\AdminTrait;

class LoginController extends Controller
{
    private $configData;

    use AdminTrait;
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

        // Get global config.
        $this->configData = $this->getGlobalConfig();
        $this->adminSections = $this->getAdminSections();
    }

    // Set custom username.
    public function username()
    {
        return 'user_email';
    }

    // Override default functions so we can can configure routing and pass data around.
    public function showLoginForm()
    {
        return view('auth.login', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections
        ]);
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/admin');
    }
}
