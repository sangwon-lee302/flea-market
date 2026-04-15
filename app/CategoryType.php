<?php

namespace App;

enum CategoryType: string
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

    public function label(): string
    {
        return __("enums.condition.{$this->value}");
    }
}
