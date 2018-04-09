<?php

namespace score\tests\unit\entities\Catalog\Category;

use Codeception\Test\Unit;
use core\entities\catalog\Category;

class CreateTest extends Unit
{
    public function testSuccess()
    {
        $category = Category::create(
            $name = 'Name',
            $slug = 'slug',
            $title = 'Full header',
            $description = 'Description'
        );

        $this->assertEquals($name, $category->name);
        $this->assertEquals($slug, $category->slug);
        $this->assertEquals($title, $category->title);
        $this->assertEquals($description, $category->description);
    }
}