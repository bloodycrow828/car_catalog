<?php

namespace core\forms\manage\catalog\Car;

use yii\base\Model;
use yii\web\UploadedFile;

class PhotoForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules(): array
    {
        return [
            [['file'], 'file','extensions' => 'png, jpg, gif'],
        ];
    }

    public function beforeValidate(): bool
    {
        if (parent::beforeValidate()) {
            $this->file = UploadedFile::getInstance($this, 'file');
            return true;
        }
        return false;
    }
}