<?php

namespace core\forms\manage\catalog\Car;

use core\entities\catalog\car\Car;
use core\forms\CompositeForm;
use core\helpers\CarHelper;


/**
 * @property CategoriesForm $categories
 */
class CarEditForm extends CompositeForm
{
    public $name;

    public function __construct(Car $car, $config = [])
    {
        $this->name = $car->name;
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
        return ['categories'];
    }
}