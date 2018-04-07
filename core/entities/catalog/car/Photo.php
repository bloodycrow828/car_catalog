<?php

namespace core\entities\catalog\car;

use core\services\common\WaterMarker;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
 * @property integer $car_id
 * @property string $file
 *
 * @mixin ImageUploadBehavior
 */
class Photo extends ActiveRecord
{
    public static function create(UploadedFile $file): self
    {
        $photo = new static();
        $photo->file = $file;
        return $photo;
    }

    public static function tableName(): string
    {
        return '{{%photos}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/cars/[[id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/cars/[[id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/cars/[[id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/cars/[[id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 480, 'height' => 360],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_car_main' => ['processor' => [new WaterMarker(750, 1000, '@frontend/web/image/logo.png'), 'process']],
                    'catalog_car_additional' => ['width' => 66, 'height' => 66],
                    'catalog_origin' => ['processor' => [new WaterMarker(1024, 768, '@frontend/web/image/logo.png'), 'process']],
                ],
            ],
        ];
    }
}