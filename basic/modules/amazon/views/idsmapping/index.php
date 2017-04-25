<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\amazon\models\IdsMappingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ids Mappings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ids-mapping-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Ids Mapping', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'product_id',
            'sku',
            'asin',
            'host_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
