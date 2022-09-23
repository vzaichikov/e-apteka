<style>
	.table-stocks > tbody > tr > td{border: 0px;}
	.table-stocks > tbody > tr {border: 1px solid #ddd;}
	.text-warning{color: #FF7815;}
	.product-layout__btn-cart.bbtn-warning{border-color: #FF7815; background-color: #FF7815;}
	.bbtn.bbtn-small{font-size:12px; padding:8px 5px; font-weight:400; height:30px;}
</style>

<table class="table table-bordered table-responsive table-stocks">	
	<?php foreach ($stocks as $stock) { ?>
		<tr style="border-bottom:0px;">
			<td class="hidden-xs">
				<?php if ((int)$stock['stock'] >= 3) { ?>
					<i class="fa fa-check text-success" aria-hidden="true"></i>
				<?php } elseif ((int)$stock['stock'] > 0) { ?>
					<i class="fa fa-check text-warning" aria-hidden="true"></i>
				<?php } else { ?>
					<i class="fa fa-times text-danger"></i>
				<?php } ?>
			</td>
			<td>
				<?php echo $stock['address']; ?>
				<span class="hidden-xs">
				<br />
				<span class="product-stock-map__time"><i class="fa fa-clock-o <? echo $stock['faclass']; ?>"></i> <i><?php echo $stock['open']; ?></i></span>

				<?php if ($stock['gmaps_link']) { ?>
					&nbsp;&nbsp;<a href="<?php echo $stock['gmaps_link']; ?>" target="_blank"><?php echo $text_make_route; ?></a>					
				<?php } ?>
				</span>
			</td>
			<td style="white-space: nowrap;" class="<?php if ((int)$stock['stock'] >= 3) { ?>text-success<? } elseif ((int)$stock['stock'] > 0) { ?>text-warning<?php } else { ?>text-danger<? } ?>">
				<b><?php echo $stock['stock']; ?> шт.</b>
			</td>			
			<td style="white-space: nowrap;">
				<?php if ((int)$stock['stock'] > 0) { ?>
				<button class="bbtn bbtn-small bbtn-<?php if ((int)$stock['stock'] >= 3) { ?>success<? } else { ?>warning<?php } ?> product-layout__btn-cart" onclick="$('input[name=\'oneclick_location_id\']').val('<?php echo $stock['location_id']; ?>'); callFastOrderPopup(this);"><?php echo $text_make_reserve;?></button>
				<?php }?>
			</td>		
		</tr>
		<tr class="hidden-xlg hidden-md hidden-lg hidden-sm" style="border-top:0px;">
			<td colspan="4">
				<span class="product-stock-map__time"><i class="fa fa-clock-o <? echo $stock['faclass']; ?>"></i> <i><?php echo $stock['open']; ?></i></span>
				&nbsp;&nbsp;<a href="<?php echo $stock['gmaps_link']; ?>" target="_blank"><?php echo $text_make_route; ?></a></span>
			</td>
		</tr>
	<? } ?>
</table>