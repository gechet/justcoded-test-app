<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\models\Photo;

/* @var $this yii\web\View */
/* @var $model app\models\Product */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'qty',
            'price',
            'sale_price',
            'sale_qty',
            'description:ntext',
            [
                'attribute' => 'category',
                'value' => $model->categoryRow,
                'format' => 'raw',
            ],
        ],
    ]) ?>
    <?php if ($model->photos) { ?>
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
</div>
