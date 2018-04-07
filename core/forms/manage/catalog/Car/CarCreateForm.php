<?php

namespace core\forms\manage\catalog\Car;

use core\forms\CompositeForm;


/**
 * @property PriceForm $price
 * @property CategoriesForm $categories
 * @property PhotoForm $photo
 */
class CarCreateForm extends CompositeForm
{
    public $name;

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
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    protected function internalForms(): array
    {
        return ['price', 'categories', 'photo'];
    }
}