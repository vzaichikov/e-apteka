<?php if ($show_values_limit > 0 && count($option['values']) > $show_values_limit) { ?>
<?php $hidden_values = array_splice($option['values'], $show_values_limit, count($option['values'])); ?>
<?php } else { ?>
<?php $hidden_values = array(); ?>
<?php } ?>

<?php foreach ($option['values'] as $value) { ?>
<?php include 'value_item.tpl'; ?>
<?php } ?>

<?php if ($hidden_values) { ?>
<div class="collapse" id="ocfilter-hidden-values-<?php echo $option['option_id']; ?>">
  <hr style="margin:0 0 10px;" />
  <?php foreach ($hidden_values as $value) { ?>
  <?php include 'value_item.tpl'; ?>
  <?php } ?>
</div>
<div class="collapse-value">
  <button type="button" data-target="#ocfilter-hidden-values-<?php echo $option['option_id']; ?>" data-toggle="collapse" class="btn btn-block"><?php echo $text_show_all; ?> <i class="fa fa-fw"></i></button>
</div>
<?php } ?>
