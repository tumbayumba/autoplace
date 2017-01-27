<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\Hosts */

$this->title = 'Create Hosts';
$this->params['breadcrumbs'][] = ['label' => 'Hosts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hosts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
