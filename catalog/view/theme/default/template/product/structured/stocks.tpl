<style>
	.table-stocks {margin-bottom:0px;}
	.table-stocks > tbody > tr {border-bottom: 1px solid #ddd;}
	.table-stocks > tbody > tr:last-child {border-bottom: none;}
	.product-layout__btn-cart.bbtn-warning{border-color: #FF7815; background-color: #FF7815;}
	.bbtn.bbtn-small{font-size:12px; padding:8px 5px; font-weight:400; height:30px;}

	.table-borderless,
	.table-borderless > thead > tr,
	.table-borderless > tbody > tr > td,
	.table-borderless > tbody > tr > th,
	.table-borderless > tfoot > tr > td,
	.table-borderless > tfoot > tr > th,
	.table-borderless > thead > tr > td,
	.table-borderless > thead > tr > th {
		border: none;
	}
</style>

<table class="table table-responsive table-stocks table-borderless">	
	<tbody>
		<?php foreach ($stocks as $stock) { ?>
			<tr>
				<td class="hidden-xs">
					<i class="fa <?php echo $stock['stock_icon']; ?> <?php echo $stock['text_class']; ?>" aria-hidden="true"></i>
				</td>			
				<td>
					<?php echo $stock['address']; ?>
					<?php if (empty($stock['can_not_deliver'])) { ?>						
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
					<?php if (empty($stock['can_not_deliver'])) { ?>
						<button class="bbtn bbtn-small bbtn-<?php if ((int)$stock['stock'] >= 3) { ?>success<? } else { ?>warning<?php } ?> product-layout__btn-cart" onclick="$('input[name=\'oneclick_location_id\']').val('<?php echo $stock['location_id']; ?>'); callFastOrderPopup(this);"><?php echo $text_make_reserve;?></button>
					<?php }?>
				</td>

			</tr>
		<? } ?>
	</tbody>
</table>