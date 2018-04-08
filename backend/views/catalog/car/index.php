<?php


use backend\forms\catalog\CarSearch;
use core\entities\catalog\car\Car;
use core\helpers\CarHelper;
use core\helpers\PriceHelper;
use kartik\date\DatePicker;
use kartik\grid\GridView;
use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $searchModel CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Автомобили';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <p>
        <?= Html::a('Добавить автомобиль', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php
    $layout = <<< HTML
{input1}{separator}{input2}
<span class="input-group-addon kv-date-remove">
    <i class="glyphicon glyphicon-remove"></i>
</span>
HTML;
    ?>
    <div class="box">
        <div class="box-body">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    [
                        'value' => function (Car $model) {
                            return $model->photo ? Html::img($model->photo->getThumbFileUrl('file', 'admin')) : null;
                        },
                        'format' => 'raw',
                        'contentOptions' => ['style' => 'width: 100px'],
                    ],
                    [
                        'attribute' => 'name',
                        'value' => function (Car $model) {
                            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'url',
                        'value' => function (Car $model) {
                            return Html::a('car/' . Html::encode($model->url),
                                \Yii::$app->params['frontendHostInfo'] . '/car/' . $model->url, ['target' => '_blank']);
                        },
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'category_id',
                        'filter' => $searchModel->categoriesList(),
                        'label' => 'Категория',
                        'value' => 'category.name',
                    ],
                    [
                        'attribute' => 'price',
                        'filter' => Html::input('text', $searchModel->formName() . '[price_at]', $searchModel->price_at,
                                ['style' => 'width:40px']) .
                            Html::input('text', $searchModel->formName() . '[price_to]', $searchModel->price_to,
                                ['style' => 'width:40px']),
                        'value' => function (Car $model) {
                            return PriceHelper::format($model->price);
                        },
                    ],
                    [
                        'attribute' => 'date',
                        'filter' => DatePicker::widget([
                            'model' => $searchModel,
                            'attribute' => 'date_from',
                            'attribute2' => 'date_to',
                            'type' => DatePicker::TYPE_RANGE,
                            'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
                            'layout' => $layout,
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'dd.mm.yyyy',
                                'todayHighlight' => true
                            ]
                        ]),
                        'format' => ['date', 'dd.MM.Y']
                    ],
                    [
                        'attribute' => 'updated_at',
                        'format' => ['date', 'dd.MM.Y']
                    ],
                    [
                        'attribute' => 'status',
                        'filter' => $searchModel->statusList(),
                        'value' => function (Car $model) {
                            return CarHelper::statusLabel($model->status);
                        },
                        'format' => 'raw',
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
