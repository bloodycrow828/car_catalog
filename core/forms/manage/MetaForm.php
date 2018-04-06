<?php

namespace core\forms\manage;

use core\entities\Meta;
use yii\base\Model;

class MetaForm extends Model
{
    public $title;
    public $description;

    public function __construct(Meta $meta = null, $config = [])
    {
        if ($meta) {
            $this->title = $meta->title;
            $this->description = $meta->description;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['title'], 'string', 'max' => 255],
            [['description'], 'string'],
        ];
    }
}