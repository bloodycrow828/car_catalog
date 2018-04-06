<?php

namespace core\forms\manage\catalog\car;

use core\entities\catalog\car;
use core\forms\CompositeForm;
use core\forms\manage\MetaForm;
use core\forms\manage\Shop\Product\CategoriesForm;
use core\helpers\CarHelper;


/**
 * @property MetaForm $meta
 * @property CategoriesForm $categories
 */
class CarEditForm extends CompositeForm
{
    public $name;

    public function __construct(Car $car, $config = [])
    {
        $this->name = $car->name;
        $this->meta = new MetaForm($car->meta);
        $this->categories = new CategoriesForm($car);
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels(): array
    {
        return CarHelper::attributeLabels();
    }

    protected function internalForms(): array
    {
        return ['meta', 'categories'];
    }
}