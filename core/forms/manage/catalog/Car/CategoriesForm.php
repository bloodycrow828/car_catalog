<?php

namespace core\forms\manage\catalog\Car;

use core\entities\catalog\car\Car;
use core\entities\catalog\Category;
use core\helpers\CategoriesHelper;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class CategoriesForm extends Model
{
    public $main;
    public $others = [];

    public function __construct(Car $car = null, $config = [])
    {
        if ($car) {
            $this->main = $car->category_id;
            $this->others = ArrayHelper::getColumn($car->categoryAssignments, 'category_id');
        }
        parent::__construct($config);
    }

    public function categoriesList(): array
    {
        return ArrayHelper::map(Category::find()->andWhere(['>', 'depth', 0])->orderBy('lft')->asArray()->all(), 'id', function (array $category) {
            return ($category['depth'] > 1 ? str_repeat('-- ', $category['depth'] - 1) . ' ' : '') . $category['name'];
        });
    }

    public function rules(): array
    {
        return [
            ['main', 'required'],
            ['main', 'integer'],
            ['others', 'each', 'rule' => ['integer']],
            ['others', 'default', 'value' => []],
        ];
    }

    public function attributeLabels(): array
    {
        return CategoriesHelper::attributeLabels();
    }


}