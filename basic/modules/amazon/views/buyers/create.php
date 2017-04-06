<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\Buyers */

$this->title = 'Create Buyers';
$this->params['breadcrumbs'][] = ['label' => 'Buyers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="buyers-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
