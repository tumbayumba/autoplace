<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\Hosts */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hosts-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sku_prefix')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'external_product_id_type')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'brand_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'manufacturer')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'currency')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'feed_product_type')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
