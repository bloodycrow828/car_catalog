<?php

namespace core\repositories\catalog;

use core\entities\catalog\Category;
use core\repositories\exceptions\NotFoundException;

class CategoryRepository
{
    public function get($id): Category
    {
        if (!$category = Category::findOne($id)) {
            throw new NotFoundException('Модель не найдена.');
        }
        return $category;
    }

    public function save(Category $category): void
    {
        if (!$category->save()) {
            throw new \RuntimeException('Ошибка сохранения.');
        }
    }

    public function remove(Category $category): void
    {
        if (!$category->delete()) {
            throw new \RuntimeException('Ошибка удаления.');
        }
    }
}