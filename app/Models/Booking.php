<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    const NAME_MAX_LENGTH = 150;
    const EMAIL_MAX_LENGTH = 150;
    const PHONE_MAX_LENGTH = 20;
    const TABLE_MAX_LENGTH = 150;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'phone', 'date', 'people', 'table'
    ];

    protected $casts = [
        'people' => 'integer'
    ];

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getFestive(): bool
    {
        $date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->date);

        if ($date->isSaturday() || $date->isSunday()) {
            return true;
        }

        return false;
    }
}
