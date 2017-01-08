<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use app\models\Photo;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form yii\widgets\ActiveForm */
$model->category = ArrayHelper::getColumn($model->categories, 'id');
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'qty')->textInput() ?>

    <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_price')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sale_qty')->textInput() ?>
    
    <?= $form->field($model, 'category')->widget(Select2::className(), [
        'data' => $categories,
        'options' => [
            'multiple' => true,
        ],
    ]) ?>

    <?php if (!$model->isNewRecord && $model->photos) { ?>
    <div class="row">
        <?php foreach ($model->photos as $photo) { ?>
        <div class="col-md-4">
            <div class="thumbnail">
                <img src="<?= Photo::STORAGE_PATH . $photo->file ?>">
            </div>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    
    <?= $form->field($model, 'photo[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>
    
    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
