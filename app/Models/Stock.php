<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'quantity', 'expiration_date', 'expired', 'food_id'
    ];

    protected $casts = [
        'quantity' => 'double',
        'expired' => 'boolean',
        'food_id' => 'integer'
    ];

    public function food(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Food::class);
    }
}
