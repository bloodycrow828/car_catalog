<?php

namespace core\forms\manage\catalog\Car;

use core\forms\CompositeForm;
use core\helpers\CarHelper;
use core\validators\SlugValidator;


/**
 * @property PriceForm $price
 * @property CategoriesForm $categories
 * @property PhotoForm $photo
 */
class CarCreateForm extends CompositeForm
{
    public $name;
    public $slug;

    public function __construct($config = [])
    {
        $this->price = new PriceForm();
        $this->categories = new CategoriesForm();
        $this->photo = new PhotoForm();
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name'], 'string', 'max' => 255],
            ['slug', SlugValidator::class],
        ];
    }

    public function attributeLabels(): array
    {
        return CarHelper::attributeLabels();
    }

    protected function internalForms(): array
    {
        return ['price', 'categories', 'photo'];
    }
}