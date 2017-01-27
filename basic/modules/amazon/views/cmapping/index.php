<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\amazon\models\CategoryMappingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Category Mappings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-mapping-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Category Mapping', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'mh_cat_id',
            'browse_node',
            'mh_desc:ntext',
            'amz_desc:ntext',
            'host_id',
            'fulfillment_latency',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
