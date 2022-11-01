<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory;

    const STATUS_MAX_LENGTH = 250;

    const ORDER_STATUS_WAITING = 'En espera';
    const ORDER_STATUS_CONFIRMED = 'Confirmada';
    const ORDER_STATUS_CANCELLED = 'Cancel·lada';
    const ORDER_STATUS_IN_PROCESS = 'En procés';
    const ORDER_STATUS_DELIVERED = 'Servida';
    const ORDER_STATUS_PAID = 'Pagada';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status'
    ];

    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeWaiting($query)
    {
        return $query->where('status', self::ORDER_STATUS_WAITING)->first();
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', self::ORDER_STATUS_CONFIRMED)->first();
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', self::ORDER_STATUS_CANCELLED)->first();
    }

    public function scopeInProcess($query)
    {
        return $query->where('status', self::ORDER_STATUS_IN_PROCESS)->first();
    }

    public function scopeDelivered($query)
    {
        return $query->where('status', self::ORDER_STATUS_DELIVERED)->first();
    }

    public function scopePaid($query)
    {
        return $query->where('status', self::ORDER_STATUS_PAID)->first();
    }
}
