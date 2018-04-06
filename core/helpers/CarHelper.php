<?php

namespace core\helpers;


use core\entities\catalog\car;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class CarHelper
{


    public static function statusList(): array
    {
        return [
            Car::STATUS_DRAFT => 'Деактивирован',
            Car::STATUS_ACTIVE => 'Активен',
        ];
    }

    public static function statusName($status): string
    {
        return ArrayHelper::getValue(self::statusList(), $status);
    }

    public static function statusLabel($status): string
    {
        switch ($status) {
            case Car::STATUS_DRAFT:
                $class = 'label label-default';
                break;
            case Car::STATUS_ACTIVE:
                $class = 'label label-success';
                break;
            default:
                $class = 'label label-default';
        }

        return Html::tag('span', ArrayHelper::getValue(self::statusList(), $status), [
            'class' => $class,
        ]);
    }

    public static function attributeLabels(): array
    {
        return [
            'title' => 'Наименование',
            'price' => 'Цена',
            'category_id' => 'Категория',
            'status' => 'Статус',
        ];
    }
}