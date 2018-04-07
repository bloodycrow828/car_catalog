<?php

/* @var $this yii\web\View */
/* @var $car Car */

use core\entities\catalog\car\Car;
use core\helpers\PriceHelper;
use yii\helpers\Html;
use yii\helpers\Url;

$url = Url::to(['product', 'id' =>$car->id]);

?>

<div class="product-layout product-list col-xs-12">
    <div class="product-thumb">
        <?php if ($car->photo): ?>
            <div class="image">
                <a href="<?= Html::encode($url) ?>">
                    <img src="<?= Html::encode($car->photo->getThumbFileUrl('file', 'catalog_list')) ?>" alt="" class="img-responsive" />
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
            <div class="button-group">
                <button type="button" href="<?= Url::to(['/shop/cart/add', 'id' => $car->id]) ?>" data-method="post"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md">Add to Cart</span></button>
                <button type="button" data-toggle="tooltip" title="Add to Wish List" href="<?= Url::to(['/cabinet/wishlist/add', 'id' => $car->id]) ?>" data-method="post"><i class="fa fa-heart"></i></button>
                <button type="button" data-toggle="tooltip" title="Compare this Product" onclick="compare.add('<?= $car->id ?>');"><i class="fa fa-exchange"></i></button>
            </div>
        </div>
    </div>
</div>


