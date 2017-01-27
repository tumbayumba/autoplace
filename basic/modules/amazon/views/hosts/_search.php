<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\HostsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hosts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sku_prefix') ?>

    <?= $form->field($model, 'external_product_id_type') ?>

    <?= $form->field($model, 'brand_name') ?>

    <?= $form->field($model, 'manufacturer') ?>

    <?php // echo $form->field($model, 'currency') ?>

    <?php // echo $form->field($model, 'lang') ?>

    <?php // echo $form->field($model, 'feed_product_type') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
