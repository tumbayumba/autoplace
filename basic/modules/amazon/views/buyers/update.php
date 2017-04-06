<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\Buyers */

$this->title = 'Update Buyers: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Buyers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="buyers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
