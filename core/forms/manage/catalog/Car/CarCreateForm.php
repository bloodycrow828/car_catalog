<?php

namespace core\forms\manage\catalog\Car;

use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\forms\manage\Shop\Product\CategoriesForm;


/**
 * @property PriceForm $price
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 * @property PhotoForm $photo
 */
class CarCreateForm extends CompositeForm
{
    public $name;

    public function __construct($config = [])
    {
        $this->price = new PriceForm();
        $this->meta = new MetaForm();
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
        return ['price', 'meta', 'categories', 'photo'];
    }
}