<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\Ean */

$this->title = 'Update Ean: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Eans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="ean-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
