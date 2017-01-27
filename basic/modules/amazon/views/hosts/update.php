<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\Hosts */

$this->title = 'Update Hosts: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="hosts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
