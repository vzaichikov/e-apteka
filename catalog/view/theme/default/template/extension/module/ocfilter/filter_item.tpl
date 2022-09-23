<div class="list-group-item ocfilter-option" id="option-<?php echo $option['option_id']; ?>">
  <div class="ocf-option-name">
    <?php echo $option['name']; ?>

		<?php if ($option['type'] == 'slide' || $option['type'] == 'slide_dual') { ?>
    <span id="left-value-<?php echo $option['option_id']; ?>"><?php echo $option['slide_value_min_get']; ?></span>
		<?php if ($option['type'] == 'slide_dual') { ?>
		-&nbsp;<span id="right-value-<?php echo $option['option_id']; ?>"><?php echo $option['slide_value_max_get']; ?></span>
		<?php } ?>
    <?php echo $option['postfix']; ?>
    <?php } ?>
  </div>

  <div class="ocf-option-values">
    <?php if ($option['type'] == 'slide' || $option['type'] == 'slide_dual') { ?>

    <?php include 'filter_slider_item.tpl'; ?>

    <?php } else { ?>

    <?php if ($option['selectbox']) { ?>
    <div class="dropdown">
      <button class="btn btn-block btn-<?php echo (isset($selecteds[$option['option_id']]) ? 'warning' : 'default'); ?> dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        <i class="pull-right fa fa-angle-down"></i>
        <span class="pull-left text-left">
        	<?php if (isset($selecteds[$option['option_id']])) { ?>
					<?php foreach ($selecteds[$option['option_id']]['values'] as $value) { ?>
          <?php echo $value['name']; ?><br />
					<?php } ?>
        	<?php } else { ?>
        	<?php echo $text_any; ?>
        	<?php } ?>
        </span>
      </button>
      <div class="dropdown-menu">
        <?php include 'value_list.tpl'; ?>
      </div>
    </div>
    <?php } else { ?>

    <?php include 'value_list.tpl'; ?>

    <?php } ?>

    <?php } ?>
  </div>
</div>