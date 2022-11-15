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
    
      //This function can be tested in condition, decision, path coverage in CartFeaturesTest
      public function test_comanda_valida($order_status_id, $booking_id, $recipes): bool {
        if($order_status_id > 0 && $order_status_id < 25) {
            $booking = Booking::where('id', $booking_id)->first();
            if ($booking) {
                if (count($recipes) > 0) {
                    return true;
                }
            }
        }
    return false;
    }
}
