<?php

namespace core\entities\catalog;

use core\dataModels\CategoryData;


class Category extends CategoryData
{

    public static function create($name, $slug, $title, $description): self
    {
        $category = new static();
        $category->name = $name;
        $category->slug = $slug;
        $category->title = $title;
        $category->description = $description;
        return $category;
    }

    public function edit($name, $slug, $title, $description): void
    {
        $this->name = $name;
        $this->slug = $slug;
        $this->title = $title;
        $this->description = $description;
    }

    public function getHeadingTile(): string
    {
        return $this->title ?: $this->name;
    }
}