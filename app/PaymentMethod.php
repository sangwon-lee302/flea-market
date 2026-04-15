<?php

namespace App;

enum PaymentMethod: int
{
    case ConvenienceStore = 1;
    case CreditCard       = 2;

    public function label(): string
    {
        return match ($this) {
            self::ConvenienceStore => __('enums.payment_method.convenience_store'),
            self::CreditCard       => __('enums.payment_method.credit_card'),
        };
    }
}
