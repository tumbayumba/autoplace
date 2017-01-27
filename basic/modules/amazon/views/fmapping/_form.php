<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\FieldMapping */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="field-mapping-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'host_id')->textInput() ?>

    <?= $form->field($model, 'amz_field')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'pl_field')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
