<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\FieldMapping */

$this->title = 'Create Field Mapping';
$this->params['breadcrumbs'][] = ['label' => 'Field Mappings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="field-mapping-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
