<?php
$class = 'col-sm-3 hidden-xs';

if ($is_category) {
  $class = 'col-xlg-2 col-md-3 hidden-sm hidden-xs';
}
?><?php if ($modules) { ?>
<aside id="column-left" class="<?php echo $class; ?>">
  <?php foreach ($modules as $module) { ?>
  <?php echo $module; ?>
  <?php } ?>
</aside>
<?php } ?>