<?php

namespace App;

enum CategoryType: string
{
    case FASHION     = 'fashion';
    case ELECTRONICS = 'electronics';
    case FURNITURE   = 'furniture';
    case WOMENS      = 'womens';
    case MENS        = 'mens';
    case COSMETICS   = 'cosmetics';
    case BOOKS       = 'books';
    case GAMES       = 'games';
    case SPORTS      = 'sports';
    case KITCHEN     = 'kitchen';
    case HANDMADE    = 'handmade';
    case ACCESSORIES = 'accessories';
    case TOYS        = 'toys';
    case BABIES_KIDS = 'babies_kids';

    public function label(): string
    {
        return __("enums.condition.{$this->value}");
    }
}
