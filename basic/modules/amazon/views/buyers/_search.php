<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\BuyersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="buyers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'buyer_name') ?>

    <?= $form->field($model, 'email') ?>

    <?= $form->field($model, 'country') ?>

    <?= $form->field($model, 'item_id') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'sale_date') ?>

    <?php // echo $form->field($model, 'sku') ?>

    <?php // echo $form->field($model, 'source') ?>

    <?php // echo $form->field($model, 'link') ?>

    <?php // echo $form->field($model, 'description') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
