<?php

use core\forms\manage\catalog\Car\CarCreateForm;
use kartik\widgets\FileInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model CarCreateForm */

$this->title = 'Добавить Автомобиль';
$this->params['breadcrumbs'][] = ['label' => 'Автомобили', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-create">

    <?php $form = ActiveForm::begin([
        'options' => ['enctype' => 'multipart/form-data']
    ]); ?>
    <div class="row">
        <div class="col-md-6">

            <div class="box box-default">
                <div class="box-header with-border">Общие сведения</div>
                <div class="box-body">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>

                <div class="box-header with-border">Price</div>
                <div class="box-body">
                    <?= $form->field($model->price, 'new')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="box box-default">
                <div class="box-header with-border">Categories</div>
                <div class="box-body">
                    <?= $form->field($model->categories, 'main')->dropDownList($model->categories->categoriesList(), ['prompt' => '']) ?>
                    <?= $form->field($model->categories, 'others')->checkboxList($model->categories->categoriesList()) ?>
                </div>
            </div>
        </div>
    </div>


    <div class="box box-default">
        <div class="box-header with-border">Photos</div>
        <div class="box-body">
            <?= $form->field($model->photo, 'file')->widget(FileInput::class, [
                'options' => ['accept' => 'image/*']
            ]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
