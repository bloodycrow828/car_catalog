<?php

use core\entities\catalog\car\Car;
use core\forms\manage\catalog\Car\PhotoForm;
use core\helpers\CarHelper;
use core\helpers\PriceHelper;
use kartik\file\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $car Car */
/* @var $photoForm PhotoForm */
/* @var $modificationsProvider yii\data\ActiveDataProvider */

$this->title = $car->name;
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <p>
        <?php if ($car->isActive()): ?>
            <?= Html::a('Деактивировать', ['deactivate', 'id' => $car->id], ['class' => 'btn btn-primary', 'data-method' => 'post']) ?>
        <?php else: ?>
            <?= Html::a('Активировать', ['activate', 'id' => $car->id], ['class' => 'btn btn-success', 'data-method' => 'post']) ?>
        <?php endif; ?>
        <?= Html::a('Удалить', ['delete', 'id' => $car->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="row">
        <div class="col-md-6">
            <div class="box">
                <div class="box-header with-border">Общие
                    сведения <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>',
                        ['update', 'id' => $car->id], ['class' => 'btn btn-primary pull-right']) ?>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $car,
                        'attributes' => [
                            'id',
                            [
                                'attribute' => 'status',
                                'value' => CarHelper::statusLabel($car->status),
                                'format' => 'raw',
                            ],
                            'name',
                            'url',
                            [
                                'attribute' => 'category_id',
                                'value' => ArrayHelper::getValue($car, 'category.name'),
                            ],
                            [
                                'label' => 'Дополнительные категории',
                                'value' => implode(', ', ArrayHelper::getColumn($car->categories, 'name')),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">
                    Цена <?= Html::a('<i class="fa fa-pencil" aria-hidden="true"></i>',
                        ['price', 'id' => $car->id], ['class' => 'btn btn-primary pull-right']) ?>
                </div>
                <div class="box-body">
                    <?= DetailView::widget([
                        'model' => $car,
                        'attributes' => [
                            [
                                'attribute' => 'price',
                                'value' => PriceHelper::format($car->price),
                            ],
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="box" id="photo">
        <div class="box-header with-border">Фото атомобиля</div>
        <div class="box-body">
            <?php if ($car->photo): ?>
                <div class="row">
                    <div class="col-md-2 col-xs-3" style="text-align: center">
                        <div class="btn">
                            <?= Html::a('<span class="glyphicon glyphicon-remove"></span>',
                                ['delete-photo', 'id' => $car->id],
                                [
                                    'class' => 'btn btn-default',
                                    'data-method' => 'post',
                                    'data-confirm' => 'Удалить изображение?',
                                ]); ?>
                        </div>
                        <div>
                            <?= Html::a(Html::img($car->photo->getThumbFileUrl('file')),
                                $car->photo->getUploadedFileUrl('file'),
                                ['class' => 'thumbnail', 'target' => '_blank']
                            ) ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php $form = ActiveForm::begin([
                'options' => ['enctype' => 'multipart/form-data'],
            ]); ?>

            <?= $form->field($photoForm, 'file')->label(false)->widget(FileInput::class, [
                'options' => ['accept' => 'image/*']
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Загрузить', ['class' => 'btn btn-success']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>

</div>
