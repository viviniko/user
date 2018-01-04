<?php

namespace Viviniko\User\Models;

use Viviniko\User\Notifications\PasswordUpdated;
use Viviniko\User\Notifications\Registered;
use Viviniko\User\Notifications\ResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Config;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstname', 'lastname', 'email', 'password', 'phone', 'avatar', 'is_active', 'reg_ip', 'log_num', 'log_date', 'log_ip'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('user.users_table');
    }

    /**
     * Always encrypt password when it is updated.
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getNameAttribute()
    {
        $name = "{$this->firstname} {$this->lastname}";

        return trim($name) ? $name : ucfirst(explode('@', $this->email, 2)[0]);
    }

    public function socialNetworks()
    {
        return $this->hasOne(UserSocialNetworks::class, 'user_id');
    }

    public function addresses()
    {
        return $this->morphMany(Config::get('address.address'), 'addressable');
    }

    public function orders()
    {
        return $this->hasMany(config('sale.order'));
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }
    /**
     * Send the registered notification.
     *
     * return void
     */
    public function sendRegisteredNotification()
    {
        $this->notify(new Registered());
    }

    /**
     * Send the password updated notification.
     *
     * return void
     */
    public function sendPasswordUpdatedNotification()
    {
        $this->notify(new PasswordUpdated());
    }

}