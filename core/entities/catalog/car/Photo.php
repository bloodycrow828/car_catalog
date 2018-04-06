<?php

namespace core\entities\catalog\car;

use core\services\WaterMarker;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yiidreamteam\upload\ImageUploadBehavior;

/**
 * @property integer $id
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

    public function isIdEqualTo($id): bool
    {
        return $this->id == $id;
    }

    public static function tableName(): string
    {
        return '{{%catalog_photos}}';
    }

    public function behaviors(): array
    {
        return [
            [
                'class' => ImageUploadBehavior::class,
                'attribute' => 'file',
                'createThumbsOnRequest' => true,
                'filePath' => '@staticRoot/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'fileUrl' => '@static/origin/products/[[attribute_product_id]]/[[id]].[[extension]]',
                'thumbPath' => '@staticRoot/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbUrl' => '@static/cache/products/[[attribute_product_id]]/[[profile]]_[[id]].[[extension]]',
                'thumbs' => [
                    'admin' => ['width' => 100, 'height' => 70],
                    'thumb' => ['width' => 640, 'height' => 480],
                    'catalog_list' => ['width' => 228, 'height' => 228],
                    'catalog_product_main' => ['processor' => [new WaterMarker(750, 1000, '@frontend/web/image/logo.png'), 'process']],
                    'catalog_product_additional' => ['width' => 66, 'height' => 66],
                    'catalog_origin' => ['processor' => [new WaterMarker(1024, 768, '@frontend/web/image/logo.png'), 'process']],
                ],
            ],
        ];
    }
}