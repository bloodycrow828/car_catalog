<?php

/* @var $this yii\web\View */
/* @var $car Car */

use core\entities\catalog\car\Car;
use core\helpers\PriceHelper;
use yii\helpers\Html;

$url = '/car/' . $car->url;

?>

<div class="product-layout product-list col-xs-12">
    <div class="product-thumb">
        <?php if ($car->photo): ?>
            <div class="image">
                <a href="<?= Html::encode($url) ?>">
                    <img src="<?= Html::encode($car->photo->getThumbFileUrl('file', 'catalog_list')) ?>" alt=""
                         class="img-responsive"/>
                </a>
            </div>
        <?php endif; ?>
        <div>
            <div class="caption">
                <h4><a href="<?= Html::encode($url) ?>"><?= Html::encode($car->name) ?></a></h4>
                <p class="price">
                    <span class="price-new">$<?= PriceHelper::format($car->price) ?></span>
                </p>
            </div>
        </div>
    </div>
</div>


