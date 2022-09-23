<?php if ($option['color']) { ?>
<div class="ocf-color" style="background-color: #<?php echo $value['color']; ?>;"></div>
<?php } ?>

<?php if ($option['image']) { ?>
<div class="ocf-image" style="background-image: url(<?php echo $value['image']; ?>);"></div>
<?php } ?>

<?php if ($value['selected']) { ?>
<label id="v-<?php echo $value['id']; ?>" class="ocf-selected" data-option-id="<?php echo $option['option_id']; ?>">
  <input type="<?php echo $option['type']; ?>" name="ocf[<?php echo $option['option_id']; ?>]" value="<?php echo $value['params']; ?>" checked="checked" class="ocf-target" autocomplete="off" />
  <?php echo $value['name']; ?>
  <?php if ($show_counter) { ?>
  <small class="badge"></small>
  <?php } ?>
</label>
<?php } else if ($value['count']) { ?>
<label id="v-<?php echo $value['id']; ?>" data-option-id="<?php echo $option['option_id']; ?>">
  <input type="<?php echo $option['type']; ?>" name="ocf[<?php echo $option['option_id']; ?>]" value="<?php echo $value['params']; ?>" class="ocf-target" autocomplete="off" />
  <?php echo $value['name']; ?>
  <?php if ($show_counter) { ?>
  <small class="badge"><?php echo $value['count']; ?></small>
  <?php } ?>
</label>
<?php } else { ?>
<label id="v-<?php echo $value['id']; ?>" class="disabled" data-option-id="<?php echo $option['option_id']; ?>">
  <input type="<?php echo $option['type']; ?>" name="ocf[<?php echo $option['option_id']; ?>]" value="" disabled="disabled" class="ocf-target" autocomplete="off" />
  <?php echo $value['name']; ?>
  <?php if ($show_counter) { ?>
  <small class="badge">0</small>
  <?php } ?>
</label>
<?php } ?>