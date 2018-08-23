<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name', 'user_first_name', 'user_last_name', 'user_email', 'password', 'permission_fk'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Get all user details.
    public function getUsers()
    {
        return User::where('user_status', 1)->get();
    }

    // Users have a single permission level.
    public function permission()
    {
        return $this->hasOne('App\Models\Permission', 'id', 'permission_fk');
    }

    // Warning: terrible override hack below.
    // This is because the forgotten password and reset password functionality requires the email column in the user table to be named "email".
    // If you change it to something else (as I've done here), you're SOL.
    // See: https://laracasts.com/discuss/channels/laravel/email-column-name-different-for-password-reset?page=1
    // Also: https://twitter.com/themsaid/status/920700828742246401
    public function getEmailForPasswordReset()
    {
        return $this->user_email;
    }

    public function routeNotificationFor($driver)
    {
        if (method_exists($this, $method = 'routeNotificationFor'.Str::studly($driver))) {
            return $this->{$method}();
        }

        switch ($driver) {
            case 'database':
                return $this->notifications();
            case 'mail':
                return $this->user_email;
            case 'nexmo':
                return $this->phone_number;
        }
    }

}
