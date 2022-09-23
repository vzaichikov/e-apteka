<?php if ($show_price) { ?>
<div class="list-group-item ocfilter-option" data-toggle="popover-price">
  <div class="ocf-option-name">
		<?php echo $text_price; ?>&nbsp;<?php echo $symbol_left; ?>
    <span id="price-from"><?php echo $min_price_get; ?></span>&nbsp;-&nbsp;<span id="price-to"><?php echo $max_price_get; ?></span><?php echo $symbol_right; ?>
	</div>

  <div class="ocf-option-values">
		<div id="scale-price" class="scale ocf-target" data-option-id="p"
      data-start-min="<?php echo $min_price_get; ?>"
      data-start-max="<?php echo $max_price_get; ?>"
      data-range-min="<?php echo $min_price; ?>"
      data-range-max="<?php echo $max_price; ?>"
      data-element-min="#price-from"
      data-element-max="#price-to"
      data-control-min="#min-price-value"
      data-control-max="#max-price-value"
    ></div>
  </div>
</div>
<?php } ?>