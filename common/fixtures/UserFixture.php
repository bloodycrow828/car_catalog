<?php
namespace common\fixtures;

use yii\test\ActiveFixture;
use core\entities\User\User;

class UserFixture extends ActiveFixture
{
    public $modelClass = User::class;
    public $dataFile = '@backend/tests/_data/login_data.php';
}