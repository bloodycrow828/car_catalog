<?php

namespace core\entities\catalog\queries;

use paulzi\nestedsets\NestedSetsQueryTrait;
use yii\db\ActiveQuery;

class CategoryQuery extends ActiveQuery
{
     use NestedSetsQueryTrait;
}