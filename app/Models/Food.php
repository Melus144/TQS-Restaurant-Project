<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    use HasFactory;

    const NAME_MAX_LENGTH = 250;
    const UNITS_MAX_LENGTH = 20;
    const TYPE_MAX_LENGTH = 50;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'units', 'type'
    ];

    protected $casts = [
        'stock' => 'double'
    ];

    public function stocks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Stock::class);
    }

    public function recipes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Recipe::class)->withPivot(['quantity']);
    }

    public function setNonExpiredStocks()
    {
        $stocks = 0.0;

        foreach ($this->stocks as $stock) {
            if ($stock->expiration_date > \Carbon\Carbon::now()->timestamp && !$stock->expired) {
                $stocks = $stocks + $stock->quantity;
            }
        }

        $recipes = $this->recipes;

        foreach ($recipes as $recipe) {
            foreach ($recipe->orders as $order) {
                $stocks = $stocks - ($order->pivot->quantity * $recipe->pivot->quantity);
            }
        }

        $this->stock = $stocks;
        $this->save();
    }
}
