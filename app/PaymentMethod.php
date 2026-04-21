<?php

namespace App;

enum PaymentMethod: int
{
    case Konbini = 1;
    case Card    = 2;

    /**
     * Return a corresponding label for each case.
     */
    public function label(): string
    {
        return match ($this) {
            self::Konbini => __('enums.payment_method.konbini'),
            self::Card    => __('enums.payment_method.card'),
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
