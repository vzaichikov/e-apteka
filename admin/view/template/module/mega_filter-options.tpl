<?php

	require_once DIR_TEMPLATE . 'module/mega_filter-fn.tpl';

	if( ! isset( $IDX ) )
		$IDX = 0;

?>


<ul class="nav nav-tabs">
	<li class="active"><a href="#options-tab-custom" data-toggle="tab"><?php echo $tab_custom; ?></a></li>
	<li><a href="#options-tab-default" data-toggle="tab"><?php echo $tab_default; ?></a></li>
</ul>
<div class="tab-content" id="<?php echo $IDX; ?>_mf-options-content">
	<div class="tab-pane active" id="options-tab-custom">
		<div style="margin: 7px 0; padding: 3px 5px; background: #ffffdf; border: 1px solid #e9eeb1; float: right;">
			<i class="fa fa-info-circle"></i> <?php echo $text_custom_tab_info_options; ?>
		</div>
		
		<div class="col-md-4" style="padding: 10px 0;">
			<select 
				class="form-control selectpicker_mf" 
				data-live-search="true" 
				data-live-search-placeholder="<?php echo $text_find_by; ?>: <?php echo $text_option_name; ?>"
				title="<?php echo $text_add_option; ?>"
				id="find-options-by-name<?php echo $IDX; ?>" 
				data-name="<?php echo $_optionsName; ?>"
				data-type="options"
			>
				<?php foreach( $optionsToSelect as $item ) { ?>
					<option value="<?php echo $item['id']; ?>"
						<?php foreach( $item as $k => $v ) { ?>
							<?php echo $k != 'disabled' ? 'data-' : ''; ?><?php echo $k; ?>="<?php echo $v; ?>"
						<?php } ?>
					><?php echo $item['label']; ?></option>
				<?php } ?>
			</select>
		</div>
		
		<table class="table table-hover options" id="<?php echo $IDX; ?>_mf-options-table" data-on-off-all="<?php echo empty( $on_off_all ) ? '0' : '1'; ?>">
			<thead>
				<tr>
					<th class="text-left"><?php echo $text_option_name; ?></th>
					<th class="text-center" width="90"><?php echo $text_enabled; ?></th>
					<th class="text-center" width="120"><?php echo $text_type; ?></th>
					<th class="text-left" width="250"><?php echo $text_display_as_type; ?></th>
					<th class="text-center" width="150"><?php echo $text_collapsed_by_default; ?></th>
					<th class="text-center" width="180"><?php echo $text_display_list_of_items; ?></th>
					<th class="text-center" width="180"><?php echo $text_sort_order_values; ?></th>
					<th class="text-left" width="100"><?php echo $text_sort_order; ?></th>
					<th class="text-center" width="70"><?php echo $text_remove; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if( $optionItems ) { ?>
					<?php foreach( $optionItems as $item_id => $item ) { ?>
						<?php echo mf_render_element('options', array(
							'name' => $item['name'],
							'type' => $item['type'],
							'_name' => $_optionsName . '[' . $item['option_id'] . ']',
							'_values' => isset( $_optionsValues[$item['option_id']] ) ? $_optionsValues[$item['option_id']] : array(),
							'mf_id' => $item['option_id'],
							'IDX' => $IDX,
							'lang' => $__lang
						)); ?>
					<?php } ?>
				<?php } else { ?>
					<tr data-tr-type="empty"><td colspan="9" class="text-center"><?php echo $text_list_is_empty; ?></td></tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="pagination">
			<?php echo $pagination; ?>
		</div>
	</div>
	<div class="tab-pane" id="options-tab-default">
		<div style="margin: 7px 0; padding: 3px 5px; background: #ffffdf; border: 1px solid #e9eeb1; float: right;">
			<i class="fa fa-info-circle"></i> <?php echo $text_default_tab_info_options; ?>
		</div>
		<table class="table table-hover attributes" id="<?php echo $IDX; ?>_mf-options-table-default">
			<thead>
				<tr>
					<th class="text-left" width="120"><?php echo $text_enabled; ?></th>
					<th class="text-center"><?php echo $text_display_as_type; ?></td>
					<th class="text-center"><?php echo $text_collapsed_by_default; ?></th>
					<th class="text-center"><?php echo $text_display_list_of_items; ?></th>
					<th class="text-center"><?php echo $text_sort_order_values; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php echo mf_render_element('options', array(
					'_name' => $_optionsName . '[default]',
					'_values' => isset( $_optionsValues['default'] ) ? $_optionsValues['default'] : array(),
					'mf_id' => 'default',
					'IDX' => $IDX,
					'lang' => $__lang
				)); ?>
			</tbody>
		</table>		
	</div>
</div>

<script type="text/javascript">
	(function( action ){
		if( action == '' ) return;
		
		mf_init_items_table( '<?php echo $IDX; ?>', 'options', action );
	})('<?php echo $action; ?>');
</script>