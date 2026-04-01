<?php

namespace App;

enum PaymentMethod: string
{
    case CONVENIENCE_STORE = 'convenience_store';
    case CREDIT_CARD       = 'credit_card';

    public function label(): string
    {
        return __("enums.payment_method.{$this->value}");
    }
}
