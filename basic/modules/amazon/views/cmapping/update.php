<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\CategoryMapping */

$this->title = 'Update Category Mapping: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Category Mappings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="category-mapping-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
