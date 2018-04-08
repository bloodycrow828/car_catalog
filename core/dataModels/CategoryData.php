<?php

namespace core\dataModels;

use core\entities\catalog\queries\CategoryQuery;
use paulzi\nestedsets\NestedSetsBehavior;
use yii\db\ActiveRecord;

/**
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $title
 * @property string $description
 * @property integer $lft
 * @property integer $rgt
 * @property integer $depth
 *
 * @mixin NestedSetsBehavior
 */
class  CategoryData extends ActiveRecord
{

    public static function tableName(): string
    {
        return '{{%categories}}';
    }

    public function behaviors(): array
    {
        return [
            NestedSetsBehavior::class,
        ];
    }

    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find(): CategoryQuery
    {
        return new CategoryQuery(static::class);
    }
}