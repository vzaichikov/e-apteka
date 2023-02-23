<?php if (!empty($likreestr)) { ?>
<style>
	.likreestr-mobile{
		font-size:14px;
	}
	.likreestr-mobile .panel{
		margin-bottom:10px;
	}
	.likreestr-mobile .panel-heading{
		padding:5px 15px;
	}
	.likreestr-mobile .panel-body{
		padding:5px 15px;
	}
	.likreestr-mobile .panel-title{
		font-size:15px;
	}
</style>

<div class="row likreestr-mobile">
	<div class="col-xs-12">

		<?php foreach ($likreestr as $key => $value) {  ?>	
		<?php if ($value) { ?>		
		<div class="panel panel-info">
			<div class="panel-heading">
				<span class="panel-title"><?php echo $key; ?></span>
			</div>
			<div class="panel-body"><?php echo $value; ?></div>
		</div>								
		<?php } ?>	
		<?php } ?>											
	</div>
</div>
<?php } ?>