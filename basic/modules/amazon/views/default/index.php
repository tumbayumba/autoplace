<?php use yii\helpers\Url;?>
<div class="amazon-default-index">
	<div class="row">
		<div class="col-md-4">
			<ul class="nav nav-pills nav-stacked">
				<li><a href="<?=Url::toRoute('/amazon/buyers');?>">Buyers</a></li>
				<li><a href="<?=Url::toRoute('/amazon/placement');?>">Placement</a></li>
				<li><a href="<?=Url::toRoute('/amazon/revaluation');?>">Revaluation</a></li>
				<li><a href="<?=Url::toRoute('/amazon/holds');?>">Holds</a></li>
				<li><a href="<?=Url::toRoute('/amazon/cmapping');?>">Category mapping</a></li>
				<li><a href="<?=Url::toRoute('/amazon/fmapping');?>">Fields mapping</a></li>
			    <li><a href="<?=Url::toRoute('/amazon/hosts');?>">Hosts</a></li>
			    <li><a href="<?=Url::toRoute('/amazon/ean');?>">Eans</a></li>
			</ul>
		</div>
	</div>
    
</div>
