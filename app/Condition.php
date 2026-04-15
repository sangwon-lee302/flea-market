<?php

namespace App;

enum Condition: int
{
    case LikeNew = 1;
    case Good    = 2;
    case Fair    = 3;
    case Bad     = 4;

    public function label(): string
    {
        return match ($this) {
            self::LikeNew => __('enums.condition.like_new'),
            self::Good    => __('enums.condition.good'),
            self::Fair    => __('enums.condition.fair'),
            self::Bad     => __('enums.condition.bad'),
        };
    }
}
