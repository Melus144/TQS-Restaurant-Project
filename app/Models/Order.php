<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_status_id', 'booking_id'
    ];

    protected $casts = [
        'order_status_id' => 'integer',
        'booking_id' => 'integer'
    ];

    public function orderStatus(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(OrderStatus::class);
    }

    public function booking(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Booking::class);
    }

    public function recipes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->withPivot(['quantity', 'price'])->withTimestamps();
    }

    public function getFoodTypes(): array
    {
        $foodTypes = array();

        foreach ($this->recipes as $recipe) {
            array_push($foodTypes, Recipe::FOOD_TYPES[$recipe->food_type]);
        }

        return $foodTypes;
    }

    public function getFestive()
    {
        return $this->booking->getFestive();
    }

  
}
