<?php

namespace App;

enum PaymentMethod: string
{
    case ConvenienceStore = 'convenience_store';
    case CreditCard       = 'credit_card';

    public function label(): string
    {
        return __("enums.payment_method.{$this->value}");
    }
}
