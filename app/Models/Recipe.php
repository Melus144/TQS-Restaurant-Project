<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    const NAME_MAX_LENGTH = 250;

    const TYPE_STARTERS = 0;
    const TYPE_FIRST_COURSE = 1;
    const TYPE_MAIN_COURSE = 2;
    const TYPE_DESERT = 3;
    const TYPE_COMPLEMENTS = 4;
    const TYPE_DRINKS = 5;

    const FOOD_TYPES = [
        'Cárnicos', 'Lácteos', 'Especias', 'Vegetales', 'Cereales', 'Mariscos', 'Otros'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'price', 'type', 'food_type', 'available', 'image'
    ];

    protected $casts = [
        'price' => 'double',
        'type' => 'integer',
        'food_type' => 'integer',
        'available' => 'boolean'
    ];

    public function food(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Food::class)->withPivot(['quantity']);
    }

    public function orders(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot(['quantity', 'price']);
    }

    public function hasStock(): bool
    {
//        $stockAvailable = true;
//        if (isset($this->food)) {
//
//            $ingredients = $this->food;
//            foreach ($ingredients as $ingredient) {
//                if (isset($ingredient->stocks)) {
//                    foreach ($ingredient->stocks as $stock) {
//                        if ($stock->expired) {
//                            $stockAvailable = false;
//                        }
//                    }
//                }
//            }
//        }
//
//        return $stockAvailable;

        if (count($this->food) <= 0) {
            return false;
        }

        foreach ($this->food as $food) {
            $food->setNonExpiredStocks();
            if ($food->refresh()->stock <= 0) {
                return false;
            }
        }

        return true;
    }
}
