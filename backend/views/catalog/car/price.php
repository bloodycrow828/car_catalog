<?php

use core\entities\catalog\car\Car;
use core\forms\manage\catalog\Car\PriceForm;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $car Car */
/* @var $model PriceForm */

$this->title = 'Цена: ' . $car->name;
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $car->name, 'url' => ['view', 'id' => $car->id]];
$this->params['breadcrumbs'][] = 'Цены';
?>
<div class="car-price">

    <?php $form = ActiveForm::begin(); ?>

    <div class="box box-default">
        <div class="box-header with-border">Цена</div>
        <div class="box-body">
            <?= $form->field($model, 'new')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
