<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\CategoryMappingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-mapping-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'mh_cat_id') ?>

    <?= $form->field($model, 'browse_node') ?>

    <?= $form->field($model, 'mh_desc') ?>

    <?= $form->field($model, 'amz_desc') ?>

    <?php // echo $form->field($model, 'host_id') ?>

    <?php // echo $form->field($model, 'fulfillment_latency') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
