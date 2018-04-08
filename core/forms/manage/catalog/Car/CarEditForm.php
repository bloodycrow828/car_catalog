<?php

namespace core\forms\manage\catalog\Car;

use core\entities\catalog\car\Car;
use core\forms\CompositeForm;
use core\helpers\CarHelper;
use core\validators\SlugValidator;


/**
 * @property CategoriesForm $categories
 */
class CarEditForm extends CompositeForm
{
    public $name;
    public $slug;

    public function __construct(Car $car, $config = [])
    {
        $this->name = $car->name;
        $this->slug = $car->url;
        $this->categories = new CategoriesForm($car);
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['name', 'slug'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['slug'], SlugValidator::class],
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