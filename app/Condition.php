<?php

namespace App;

enum Condition: string
{
    case LIKE_NEW = 'like_new';
    case GOOD     = 'good';
    case FAIR     = 'fair';
    case BAD      = 'bad';

    public function label(): string
    {
        return __("enums.condition.{$this->value}");
    }
}
