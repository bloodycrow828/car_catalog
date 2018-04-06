<?php

namespace core\forms\manage\catalog\Car;

use core\entities\catalog\car;
use core\helpers\PriceHelper;
use yii\base\Model;

class PriceForm extends Model
{
    public $new;

    public function __construct(Car $car = null, $config = [])
    {
        if ($car) {
            $this->new = $car->price_new;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['new'], 'required'],
            [['new'], 'integer', 'min' => 0],
        ];
    }

    public function attributeLabels(): array
    {
        return PriceHelper::attributeLabels();
    }


}