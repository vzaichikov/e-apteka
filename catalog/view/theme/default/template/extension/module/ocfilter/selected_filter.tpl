<?php if ($selecteds) { ?>
<div class="list-group-item selected-options">
  <?php foreach ($selecteds as $option) { ?>
  <div class="ocfilter-option">
    <span><?php echo $option['name']; ?>:</span>
    <?php foreach ($option['values'] as $value) { ?>
    <button type="button" onclick="location = '<?php echo $value['href']; ?>';" class="btn btn-xs btn-danger" style="padding: 1px 4px;"><i class="fa fa-times"></i> <?php echo $value['name']; ?></button>
    <?php } ?>
  </div>
  <?php } ?>
	<?php $count = count($selecteds); $selected = $selecteds; $first = array_shift($selected); ?>
  <?php if ($count > 1 || count($first['values']) > 1) { ?>
  <button type="button" onclick="location = '<?php echo $link; ?>';" class="clear-all-filter btn btn-block btn-danger" style="border-radius: 0;"><i class="fa fa-times-circle"></i> <?php echo $text_cancel_all; ?></button>
  <?php } ?>
</div>
<?php } ?>