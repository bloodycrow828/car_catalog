<?php

namespace core\repositories\catalog;

use core\entities\catalog\car\Car;
use core\repositories\exceptions\NotFoundException;

class CarRepository
{

    public function get($id): Car
    {
        if (!$car = Car::findOne($id)) {
            throw new NotFoundException('Автомобиль не найден.');
        }
        return $car;
    }

    public function existsByModel($id): bool
    {
        return Car::find()->andWhere(['brand_id' => $id])->exists();
    }

    public function existsByMainCategory($id): bool
    {
        return Car::find()->andWhere(['category_id' => $id])->exists();
    }

    public function save(Car $car): void
    {
        if (!$car->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Car $car): void
    {
        if (!$car->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}