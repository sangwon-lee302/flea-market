<?php

namespace App;

enum Condition: string
{
    case LikeNew = 'like_new';
    case Good    = 'good';
    case Fair    = 'fair';
    case Bad     = 'bad';

    public function label(): string
    {
        return __("enums.condition.{$this->value}");
    }
}
