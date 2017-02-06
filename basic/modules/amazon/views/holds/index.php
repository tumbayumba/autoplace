<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="row">
	<?= Yii::$app->session->getFlash('hold_file_upload'); ?>
</div>

<div class="row">	
	<div class="panel panel-primary">
		<div class="panel-heading">Download hold file</div>
		<div class="panel-body">
			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

			    <?= $form->field($model, 'csvFile')->fileInput() ?>

			    <button class="btn btn-primary">Submit</button>

			<?php ActiveForm::end() ?>
		</div>
	</div>
</div>

<div class="row">
	<div class="panel panel-primary">
		<div class="panel-heading">Create files for delete</div>
		<div class="panel-body">
		    <?php echo Html::a( 'Create', Url::toRoute(['/amazon/holds/createfiles']), ['class'=>'btn btn-primary'] )?>
		</div>
	</div>
	
</div>

<div class="row">
	<div class="panel panel-primary">
		<div class="panel-heading">Files</div>
		<div class="panel-body">
		    <ul>
		    		<?php foreach($files as $file):?>
		    			<?php if($file!='.' && $file!='..'): ?>
		    				<li class="list-group-item"><?php echo Html::a( $file, Url::toRoute(['/amazon/holds/download','file'=>$file]), ['style'=>'text-decoration:none;'] )?></li>
		    			<?php endif;?>
		    		<?php endforeach;?>
		    </ul>
		</div>
	</div>
	
</div>