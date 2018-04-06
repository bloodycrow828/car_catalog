<?php

namespace core\helpers;

class PriceHelper
{
    public static function format($price): string
    {
        return number_format($price, 0, '.', ' ');
    }

    public static function attributeLabels(): array
    {
        return [
            'price' => 'Цена'
        ];
    }
} 