<?php


namespace Users\Enums;


use Spatie\Enum\Laravel\Enum;



/**
 * @method static self direct()
 * @method static self percentage()
 *
 * @method static bool isDirect(int|string $value = null)
 * @method static bool isPercentage(int|string $value = null)
 */
final class DiscountType extends Enum
{
    public static function labels(): array
    {
        return [
            'percentage' => 'Percentage',
            'direct' => 'Direct'
        ];
    }
}
