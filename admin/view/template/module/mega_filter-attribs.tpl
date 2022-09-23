<?php

	require_once DIR_TEMPLATE . 'module/mega_filter-fn.tpl';

	if( ! isset( $IDX ) )
		$IDX = 0;

?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#attribs-tab-custom" data-toggle="tab"><?php echo $tab_custom; ?></a></li>
	<li><a href="#attribs-tab-default-groups" data-toggle="tab"><?php echo $tab_default_groups; ?></a></li>
	<li><a href="#attribs-tab-default" data-toggle="tab"><?php echo $tab_default; ?></a></li>
</ul>
<div class="tab-content" id="<?php echo $IDX; ?>_mf-attribs-content">
	<div class="tab-pane active" id="attribs-tab-custom">
		<div style="margin: 7px 0; padding: 3px 5px; background: #ffffdf; border: 1px solid #e9eeb1; float: right;">
			<i class="fa fa-info-circle"></i> <?php echo $text_custom_tab_info_attributes; ?>
		</div>
		
		<div class="col-md-4" style="padding: 10px 0;">
			<select 
				class="form-control selectpicker_mf" 
				data-live-search="true" 
				data-live-search-placeholder="<?php echo $text_find_by; ?>: <?php echo $text_attribute_name; ?>"
				title="<?php echo $text_add_attribute; ?>"
				id="find-attribs-by-name<?php echo $IDX; ?>" 
				data-name="<?php echo $_attribsName; ?>"
				data-type="attribs"
			>
				<?php foreach( $attribsToSelect as $item ) { ?>
					<option value="<?php echo $item['id']; ?>"
						<?php foreach( $item as $k => $v ) { ?>
							<?php echo $k != 'disabled' ? 'data-' : ''; ?><?php echo $k; ?>="<?php echo $v; ?>"
						<?php } ?>
					><?php echo $item['label']; ?></option>
				<?php } ?>
			</select>
		</div>
		
		<table class="table table-hover" id="<?php echo $IDX; ?>_mf-attribs-table">
			<thead>
				<tr>
					<th class="text-left"><?php echo $text_attribute_name; ?></th>
					<th class="text-left" width="120"><?php echo $text_enabled; ?></th>
					<th class="text-center" width="270"><?php echo $text_display_as_type; ?></td>
					<th class="text-center" width="150"><?php echo $text_collapsed_by_default; ?></th>
					<th class="text-center" width="180"><?php echo $text_display_list_of_items; ?></th>
					<th class="text-center" width="150"><?php echo $text_sort_order_values; ?></th>
					<th class="text-center" width="70"><?php echo $text_sort_order; ?></th>
					<th class="text-center" width="70"><?php echo $text_remove; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if( $items ) { ?>
					<?php foreach( $items as $item_group_id => $item ) { ?>
						<?php foreach( $item['childs'] as $childKey => $child ) { ?>
							<?php echo mf_render_element('attribs', array(
								'group_name' => $item['name'],
								'name' => $child['name'],
								'_name' => $_attribsName . '[' . $child['attribute_group_id'] . '][items][' . $child['attribute_id'] . ']',
								'_values' => isset( $_attribsValues[$child['attribute_group_id']]['items'][$child['attribute_id']] ) ? $_attribsValues[$child['attribute_group_id']]['items'][$child['attribute_id']] : array(),
								'mf_id' => $child['attribute_id'],
								'IDX' => $IDX,
								'lang' => $__lang
							)); ?>
						<?php } ?>
					<?php } ?>
				<?php }  else { ?>
					<tr data-tr-type="empty"><td colspan="8" class="text-center"><?php echo $text_list_is_empty; ?></td></tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="pagination">
			<?php echo $pagination; ?>
		</div>
	</div>
	<div class="tab-pane" id="attribs-tab-default-groups">
		<div style="margin: 7px 0; padding: 3px 5px; background: #ffffdf; border: 1px solid #e9eeb1; float: right;">
			<i class="fa fa-info-circle"></i> <?php echo $text_default_groups_tab_info_attributes; ?>
		</div>
		
		<div class="col-md-4" style="padding: 10px 0;">
			<select 
				class="form-control selectpicker_mf" 
				data-live-search="true" 
				data-live-search-placeholder="<?php echo $text_find_by; ?>: <?php echo $text_attribute_group_name; ?>"
				title="<?php echo $text_add_attribute_group; ?>"
				id="find-attribs-group-by-name<?php echo $IDX; ?>" 
				data-name="<?php echo $_attribsName; ?>[default_group]"
				data-id="<?php echo $IDX; ?>_mf-attribs_group-table"
				data-type="attribs_group"
			>
				<?php foreach( $attribsGroupToSelect as $item ) { ?>
					<option value="<?php echo $item['id']; ?>"
						<?php foreach( $item as $k => $v ) { ?>
							<?php echo $k != 'disabled' ? 'data-' : ''; ?><?php echo $k; ?>="<?php echo $v; ?>"
						<?php } ?>
					><?php echo $item['label']; ?></option>
				<?php } ?>
			</select>
		</div>
		
		<table class="table table-hover" id="<?php echo $IDX; ?>_mf-attribs_group-table">
			<thead>
				<tr>
					<th class="text-left"><?php echo $text_attribute_group_name; ?></th>
					<th class="text-left" width="120"><?php echo $text_enabled; ?></th>
					<th class="text-center" width="270"><?php echo $text_display_as_type; ?></td>
					<th class="text-center" width="150"><?php echo $text_collapsed_by_default; ?></th>
					<th class="text-center" width="180"><?php echo $text_display_list_of_items; ?></th>
					<th class="text-center" width="150"><?php echo $text_sort_order_values; ?></th>
					<th class="text-center" width="70"><?php echo $text_sort_order; ?></th>
					<th class="text-center" width="70"><?php echo $text_remove; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if( $itemsGroup ) { ?>
					<?php foreach( $itemsGroup as $item_group_id => $item ) { ?>
						<?php echo mf_render_element('attribs_group', array(
							'name' => $item['name'],
							'_name' => $_attribsName . '[default_group][' . $item['attribute_group_id'] . ']',
							'_values' => isset( $_attribsValues['default_group'][$item['attribute_group_id']] ) ? $_attribsValues['default_group'][$item['attribute_group_id']] : array(),
							'mf_id' => $item['attribute_group_id'],
							'IDX' => $IDX,
							'lang' => $__lang
						)); ?>
					<?php } ?>
				<?php }  else { ?>
					<tr data-tr-type="empty"><td colspan="8" class="text-center"><?php echo $text_list_is_empty; ?></td></tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="pagination">
			<?php echo $paginationGroup; ?>
		</div>
	</div>
	<div class="tab-pane" id="attribs-tab-default">
		<div style="margin: 7px 0; padding: 3px 5px; background: #ffffdf; border: 1px solid #e9eeb1; float: right;">
			<i class="fa fa-info-circle"></i> <?php echo $text_default_tab_info_attributes; ?>
		</div>
		<table class="table table-hover attributes" id="<?php echo $IDX; ?>_mf-attribs-table-default">
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
				<?php echo mf_render_element('attribs', array(
					'_name' => $_attribsName . '[default]',
					'_values' => isset( $_attribsValues['default'] ) ? $_attribsValues['default'] : array(),
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
		
		mf_init_items_table( '<?php echo $IDX; ?>', 'attribs', action );
	})('<?php echo $action; ?>');
</script>