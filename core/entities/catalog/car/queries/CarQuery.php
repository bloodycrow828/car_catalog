<?php

namespace core\entities\catalog\car\queries;


use core\entities\catalog\car\Car;
use yii\db\ActiveQuery;

class CarQuery extends ActiveQuery
{
    /**
     * @param null $alias
     * @return $this
     */
    public function active($alias = null): self
    {
        return $this->andWhere([
            ($alias ? $alias . '.' : '') . 'status' => Car::STATUS_ACTIVE,
        ]);
    }
}