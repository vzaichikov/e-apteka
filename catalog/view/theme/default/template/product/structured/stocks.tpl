<style>
	.table-stocks > tbody > tr > td{border: 0px;}
	.table-stocks > tbody > tr {border: 1px solid #ddd;}
	.product-layout__btn-cart.bbtn-warning{border-color: #FF7815; background-color: #FF7815;}
	.bbtn.bbtn-small{font-size:12px; padding:8px 5px; font-weight:400; height:30px;}
</style>

<table class="table table-bordered table-responsive table-stocks">	
	<?php foreach ($stocks as $stock) { ?>
		<tr style="border-bottom:0px;">
			<td class="hidden-xs">
				<i class="fa <?php echo $stock['stock_icon']; ?> <?php echo $stock['text_class']; ?>" aria-hidden="true"></i>
			</td>

			
			<td>
				<?php echo $stock['address']; ?>
				<?php if (empty($stock['can_not_deliver'])) { ?>
					<br /><small class="text-success"><b><?php echo $text_we_work_while_no_light; ?></b></small>
					<span class="hidden-xs">
						<br />
						<span class="product-stock-map__time"><i class="fa fa-clock-o <? echo $stock['faclass']; ?>"></i> <i><?php echo $stock['open']; ?></i></span>

						<?php if ($stock['gmaps_link']) { ?>
							&nbsp;&nbsp;<a href="<?php echo $stock['gmaps_link']; ?>" target="_blank"><?php echo $text_make_route; ?></a>					
						<?php } ?>
					</span>
				<?php } ?>
			</td>


			<td style="white-space: nowrap;" class="hidden-xs <?php echo $stock['text_class']; ?>">
				<b><?php echo $stock['stock_text']; ?></b>
			</td>

			<td style="white-space: nowrap;" class="text-right">
				<div class="hidden-xlg hidden-md hidden-lg hidden-sm <?php echo $stock['text_class']; ?>"><b><?php echo $stock['stock_text']; ?></b></div>

				<?php if (empty($stock['can_not_deliver'])) { ?>
					<button class="bbtn bbtn-small bbtn-<?php if ((int)$stock['stock'] >= 3) { ?>success<? } else { ?>warning<?php } ?> product-layout__btn-cart" onclick="$('input[name=\'oneclick_location_id\']').val('<?php echo $stock['location_id']; ?>'); callFastOrderPopup(this);"><?php echo $text_make_reserve;?></button>
				<?php }?>
			</td>

		</tr>

		<?php if (empty($stock['can_not_deliver'])) { ?>
			<tr class="hidden-xlg hidden-md hidden-lg hidden-sm" style="border-top:0px;">
				<td colspan="4">
					<span class="product-stock-map__time"><i class="fa fa-clock-o <? echo $stock['faclass']; ?>"></i> <i><?php echo $stock['open']; ?></i></span>
					&nbsp;&nbsp;<a href="<?php echo $stock['gmaps_link']; ?>" target="_blank"><?php echo $text_make_route; ?></a></span>
				</td>
			</tr>
		<?php } ?>
	<? } ?>
</table>