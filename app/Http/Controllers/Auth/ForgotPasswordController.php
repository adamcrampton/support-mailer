<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use App\Models\Config;
use App\Traits\AdminTrait;

class ForgotPasswordController extends Controller
{
    private $configData;

    use AdminTrait;
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        // Get global config.
        $this->configData = $this->getGlobalConfig();
        $this->adminSections = $this->getAdminSections();
    }

    // Override so we can pass custom data to front end.
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email', [
            'config' => $this->configData,
            'adminSections' => $this->adminSections
        ]);
    }

    // Warning: terrible override hack below.
    // This is because the forgotten password and reset password functionality requires the email column in the user table to be named "email".
    // If you change it to something else (as I've done here), you're SOL.
    // See: https://laracasts.com/discuss/channels/laravel/email-column-name-different-for-password-reset?page=1
    // Also: https://twitter.com/themsaid/status/920700828742246401
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only('user_email')
        );

        return $response == Password::RESET_LINK_SENT
                    ? $this->sendResetLinkResponse($response)
                    : $this->sendResetLinkFailedResponse($request, $response);
    }

    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['user_email' => 'required|email']);
    }
}
