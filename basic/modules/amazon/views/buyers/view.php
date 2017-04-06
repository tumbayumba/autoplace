<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\Buyers */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Buyers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyers-view">

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
            'buyer_name',
            'email:email',
            'country',
            'item_id:ntext',
            'title',
            'price',
            'sale_date',
            'sku',
            'source',
            'link:ntext',
            'description:ntext',
        ],
    ]) ?>

</div>
