<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\CategoryMapping */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-mapping-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'mh_cat_id')->textInput() ?>

    <?= $form->field($model, 'browse_node')->textInput() ?>

    <?= $form->field($model, 'mh_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'amz_desc')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'host_id')->textInput() ?>

    <?= $form->field($model, 'fulfillment_latency')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
