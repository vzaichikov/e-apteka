<style>
	.panel-title > i {font-size:32px; float:right; position: relative; bottom: 25px;}
</style>

<?php if (!empty($delivery_text_ukraine)) { ?>
	<div class="panel panel-success">
		<div class="panel-heading">
			<span class="panel-title"  data-toggle="collapse" data-target="#delivery_text_ukraine">
				<h3><?php echo $delivery_title_ukraine; ?></h3>
				<i class="fa fa-caret-down" style=""></i>
			</span>
		</div>
		<div id="delivery_text_ukraine" class="collapse panel-body"><?php echo $delivery_text_ukraine; ?></div>
	</div>	
<? } ?>

<?php if (!empty($delivery_text_kyiv)) { ?>
	<div class="panel panel-success">
		<div class="panel-heading">
			<span class="panel-title" data-toggle="collapse" data-target="#delivery_text_kyiv">
				<h3><?php echo $delivery_title_kyiv; ?></h3>
				<i class="fa fa-caret-down" style=""></i>
			</span>
		</div>
		<div id="delivery_text_kyiv" class="collapse panel-body"><?php echo $delivery_text_kyiv; ?></div>
	</div>	
<? } ?>

<?php if (!empty($delivery_text_payment)) { ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<span class="panel-title" data-toggle="collapse" data-target="#delivery_text_payment">
				<h3><?php echo $delivery_title_payment; ?></h3>
				<i class="fa fa-caret-down" style=""></i>
			</span>
		</div>
		<div id="delivery_text_payment" class="collapse panel-body"><?php echo $delivery_text_payment; ?></div>
	</div>	
<? } ?>