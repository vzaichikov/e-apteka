<?php echo $header; ?>
<div class="container">
  <div class="row">
    <div id="content" class="col-md-12"><?php echo $content_top; ?><?php echo $content_bottom; ?></div>
  </div>
</div>








<?php if(false) { ?>
<div class="container">
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?><?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php } ?>

<?php echo $footer; ?>