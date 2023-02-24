<div class="row attributes-mobile">
	<div class="col-xs-12">

		<?php if ($manufacturer) { ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<span class="panel-title"><?php echo $text_manufacturer; ?></span>
			</div>
			<div class="panel-body"><a href="<?php echo $manufacturers; ?>" title="<?php echo $manufacturer; ?>"><?php echo $manufacturer; ?></a></div>
		</div>	
		<?php } ?>

		<?php foreach ($attribute_groups as $attribute_group) { ?>
		<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
		<?php if ($attribute['text']) { ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<span class="panel-title"><?php echo $attribute['name']; ?></span>
			</div>
			<div class="panel-body"><?php echo $attribute['text']; ?></div>
		</div>		
		<?php } ?>
		<?php } ?>												
		<?php } ?>	

		<?php if ($gtin) { ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<span class="panel-title">EAN</span>
			</div>
			<div class="panel-body"><?php echo $gtin; ?></div>
		</div>	
		<?php } ?>

		<?php if ($atx_tree) { ?>
		<div class="panel panel-info">
			<div class="panel-heading">
				<span class="panel-title">ATX</span>
			</div>
			<div class="panel-body">
				<?php foreach ($atx_tree as $atx) { ?>
				<?php if ($atx['atx_code'] == $reg_atx_1) { ?>
				<b><?php echo $atx['atx_code']; ?></b>
				<?php } else { ?>
				<?php echo $atx['atx_code']; ?>
				<?php } ?>
				<a href="<?php echo $atx['href']?>" title="<?php echo $atx['name']; ?>"><?php echo $atx['name']; ?></a><br />
				<?php } ?>
				
			</div>
		</div>	
		<?php } ?>

	</div>
</div>