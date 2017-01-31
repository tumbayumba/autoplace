<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\Ean */

$this->title = 'Create Ean';
$this->params['breadcrumbs'][] = ['label' => 'Eans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ean-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
