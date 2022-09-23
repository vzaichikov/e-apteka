<?php if ($show_options_limit > 0 && count($options) > $show_options_limit) { ?>
<?php $hidden_options = array_splice($options, $show_options_limit, count($options)); ?>
<?php } else { ?>
<?php $hidden_options = array(); ?>
<?php } ?>

<?php foreach ($options as $option) { ?>

<?php include 'filter_item.tpl'; ?>

<?php } ?>

<?php if ($hidden_options) { ?>
<?php if ($show_options) { ?>
<?php $class = 'collapse in'; ?>
<?php } else { ?>
<?php $class = 'collapse'; ?>
<?php } ?>
<div class="<?php echo $class; ?>" id="ocfilter-hidden-options">
  <?php foreach ($hidden_options as $option) { ?>

  <?php include 'filter_item.tpl'; ?>

  <?php } ?>
</div>
<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#ocfilter-hidden-options" aria-expanded="false"><i class="fa"></i></button>
<?php } ?>


