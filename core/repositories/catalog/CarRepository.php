<?php

namespace core\repositories\catalog;

use core\entities\catalog\car;
use core\repositories\exceptions\NotFoundException;

class CarRepository
{

    public function get($id): Car
    {
        if (!$product = Car::findOne($id)) {
            throw new NotFoundException('Автомобиль не найден.');
        }
        return $product;
    }

    public function existsByModel($id): bool
    {
        return Car::find()->andWhere(['brand_id' => $id])->exists();
    }

    public function existsByMainCategory($id): bool
    {
        return Car::find()->andWhere(['category_id' => $id])->exists();
    }

    public function save(Car $product): void
    {
        if (!$product->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Car $product): void
    {
        if (!$product->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}