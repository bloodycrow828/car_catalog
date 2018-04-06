<?php
namespace common\fixtures;

use yii\test\ActiveFixture;

class UserFixture extends ActiveFixture
{
    public $modelClass = 'core\entities\User\User';
    public $dataFile = '@backend/tests/_data/login_data.php';
}