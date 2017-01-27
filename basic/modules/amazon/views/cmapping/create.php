<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\amazon\models\CategoryMapping */

$this->title = 'Create Category Mapping';
$this->params['breadcrumbs'][] = ['label' => 'Category Mappings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-mapping-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
