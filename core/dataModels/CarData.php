<?php

namespace core\dataModels;

use core\entities\catalog\car\CategoryAssignment;
use core\entities\catalog\car\Photo;
use core\entities\catalog\car\queries\CarQuery;
use core\entities\catalog\Category;
use core\helpers\CarHelper;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;

/**
 * Автомобили.
 *
 * @property integer $id            Id
 * @property integer $status        Статус видимости (0 - не опубликован, 1-опубликован)
 * @property integer $category_id   Модельный ряд
 * @property string $name           Название
 * @property string $photo_id       Изображение
 * @property integer $price         Цена
 * @property integer $date          Дата выпуска
 * @property string $url            Ссылка на автомобиль
 * @property integer $created_at    Дата создания
 * @property integer $updated_at    Дата обновления
 *
 * @property Category $category
 * @property CategoryAssignment[] $categoryAssignments
 * @property Category[] $categories
 * @property Photo $photo
 * @property Photo $mainPhoto
 */
class CarData extends ActiveRecord
{
    public static function tableName(): string
    {
        return '{{%car}}';
    }

    public function attributeLabels(): array
    {
        return CarHelper::attributeLabels();
    }

    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getCategoryAssignments(): ActiveQuery
    {
        return $this->hasMany(CategoryAssignment::class, ['car_id' => 'id']);
    }

    public function getCategories(): ActiveQuery
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])->via('categoryAssignments');
    }

    public function getPhoto(): ActiveQuery
    {
        return $this->hasOne(Photo::class, ['id' => 'photo_id']);
    }


    public function behaviors(): array
    {
        return [
            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['categoryAssignments', 'photo'],
            ],
        ];
    }


    public function transactions(): array
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL,
        ];
    }

    public static function find(): CarQuery
    {
        return new CarQuery(static::class);
    }
}