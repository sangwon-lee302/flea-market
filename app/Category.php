<?php

namespace App;

enum Category: string
{
    case Fashion     = 'fashion';
    case Electronics = 'electronics';
    case Furniture   = 'furniture';
    case Womens      = 'womens';
    case Mens        = 'mens';
    case Cosmetics   = 'cosmetics';
    case Books       = 'books';
    case Games       = 'games';
    case Sports      = 'sports';
    case Kitchen     = 'kitchen';
    case Handmade    = 'handmade';
    case Accessories = 'accessories';
    case Toys        = 'toys';
    case BabiesKids  = 'babies_kids';

    /**
     * Return a corresponding label for each case.
     */
    public function label(): string
    {
        return __("enums.category.{$this->value}");
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
