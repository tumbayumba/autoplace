<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\amazon\models\HostsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Hosts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hosts-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Hosts', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sku_prefix',
            'external_product_id_type',
            'brand_name',
            'manufacturer',
            // 'currency',
            // 'lang',
            // 'feed_product_type',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
