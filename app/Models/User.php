<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * Represents a user in the system. A user has attributes such as name, email,
 * password, account type, and statuses like activation or blocking.
 *
 * @package App\Models
 *
 * @property int $id The unique identifier for the user.
 * @property string $name The name of the user.
 * @property string $email The email address of the user.
 * @property string $password The hashed password of the user.
 * @property string|null $password_salt An optional salt for the user's password.
 * @property \Illuminate\Support\Carbon|null $last_login The timestamp of the user's last login.
 * @property string|null $account_type The type of user account (e.g., admin, regular).
 * @property bool $activated Indicates if the user account is activated.
 * @property bool $blocked Indicates if the user account is blocked.
 * @property \Illuminate\Support\Carbon|null $email_verified_at The date and time when the email was verified.
 * @property string|null $remember_token A token used to remember the user session.
 * @method static paginate(mixed $input)
 * @method static create(mixed $validated)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'password_salt',
        'last_login',
        'account_type',
        'activated',
        'blocked',
        'email_verified_at',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array $hidden
     */
    protected $hidden = [
        'password',
        'password_salt',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array $casts
     */
    protected $casts = [
        'id' => 'integer',
        'last_login' => 'datetime',
        'activated' => 'boolean',
        'blocked' => 'boolean',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'password_salt' => 'hashed',
    ];
}
