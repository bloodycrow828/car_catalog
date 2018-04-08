<?php

/* @var $this yii\web\View */
/* @var $car Car */

use core\entities\catalog\car\Car;
use core\helpers\PriceHelper;
use yii\helpers\Html;

$this->title = $car->name;

$this->params['breadcrumbs'][] = ['label' => 'Catalog', 'url' => ['index']];
foreach ($car->category->parents as $parent) {
    if (!$parent->isRoot()) {
        $this->params['breadcrumbs'][] = ['label' => $parent->name, 'url' => ['category', 'id' => $parent->id]];
    }
}
$this->params['breadcrumbs'][] = ['label' => $car->category->name, 'url' => ['category', 'id' => $car->category->id]];
$this->params['breadcrumbs'][] = $car->name;

$this->params['active_category'] = $car->category;

?>

<div class="row">
    <div class="col-sm-8">
        <ul class="thumbnails">
            <?php if ($car->photo): ?>
                <li>
                    <a class="thumbnail" href="<?= $car->photo->getThumbFileUrl('file', 'catalog_origin') ?>">
                        <img src="<?= $car->photo->getThumbFileUrl('file', 'catalog_car_main') ?>"
                             alt="<?= Html::encode($car->name) ?>"/>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="col-sm-4">
        <h1><?= Html::encode($car->name) ?></h1>
        <ul class="list-unstyled">
            <li>
                <h2><?= PriceHelper::format($car->price) ?></h2>
            </li>
        </ul>
    </div>
</div>



