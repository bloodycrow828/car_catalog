<?php
namespace common\fixtures;

use yii\test\ActiveFixture;
use core\entities\catalog\Category;

class CategoriesFixture extends ActiveFixture
{
    public $modelClass = Category::class;
    public $dataFile = '@backend/tests/_data/categories_data.php';
}