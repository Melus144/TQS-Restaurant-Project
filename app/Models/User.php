<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    const FIRSTNAME_MAX_LENGTH = 50;
    const LASTNAME_MAX_LENGTH = 50;
    const PHONE_MAX_LENGTH = 15;
    const EMAIL_MAX_LENGTH = 100;
    const PASSWORD_MAX_LENGTH = 50;

    protected $fillable = [
        'firstname',
        'lastname',
        'phone',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $append = [
        'fullname'
    ];

    public function getFullnameAttribute(): string
    {
        return $this->firstname . ' ' . $this->lastname;
    }


}
