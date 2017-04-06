<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\amazon\models\BuyersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Buyers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Buyers', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'buyer_name',
            'email:email',
            'country',
            //'item_id:ntext',
            'title',
            'price',
            'sale_date',
            //'sku',
            'source',
            //'link:ntext',
            [
                'attribute' => 'link',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::a($data->link, $data->link, array('target'=>'_blank'));
                },
            ],
            //'description:ntext',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
