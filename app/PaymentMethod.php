<?php

namespace App;

enum PaymentMethod: int
{
    case ConvenienceStore = 1;
    case CreditCard       = 2;

    /**
     * Return a corresponding label for each case.
     */
    public function label(): string
    {
        return match ($this) {
            self::ConvenienceStore => __('enums.payment_method.convenience_store'),
            self::CreditCard       => __('enums.payment_method.credit_card'),
        };
    }

    /**
     * Return an array whose keys are backed values and values are labels.
     */
    public static function jsList(): array
    {
        return collect(self::cases())->mapWithKeys(fn ($case) => [
            $case->value => $case->label(),
        ])->all();
    }
}
