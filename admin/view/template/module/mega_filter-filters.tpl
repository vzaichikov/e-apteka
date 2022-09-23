<?php

	require_once DIR_TEMPLATE . 'module/mega_filter-fn.tpl';

	if( ! isset( $IDX ) )
		$IDX = 0;

?>

<?php if( empty( $filters_view ) ) { ?>
	<div style="padding:5px">
		<?php echo $text_display_based_on_category; ?>: 
		<?php echo mf_render_btn_group( $text_yes, $text_no, $_filtersName . '[based_on_category]', ! empty( $_filtersValues['based_on_category'] ) ); ?>
	</div><br />
<?php } ?>

<ul class="nav nav-tabs">
	<li class="active"><a href="#filters-tab-custom" data-toggle="tab"><?php echo $tab_custom; ?></a></li>
	<li><a href="#filters-tab-default" data-toggle="tab"><?php echo $tab_default; ?></a></li>
</ul>
<div class="tab-content" id="<?php echo $IDX; ?>_mf-filters-content">
	<div class="tab-pane active" id="filters-tab-custom">
		<div style="margin: 7px 0; padding: 3px 5px; background: #ffffdf; border: 1px solid #e9eeb1; float: right;">
			<i class="fa fa-info-circle"></i> <?php echo $text_custom_tab_info_filters; ?>
		</div>
		
		<div class="col-md-4" style="padding: 10px 0;">
			<select 
				class="form-control selectpicker_mf" 
				data-live-search="true" 
				data-live-search-placeholder="<?php echo $text_find_by; ?>: <?php echo $text_filter_name; ?>"
				title="<?php echo $text_add_filter; ?>"
				id="find-filters-by-name<?php echo $IDX; ?>" 
				data-name="<?php echo $_filtersName; ?>"
				data-type="filters"
			>
				<?php foreach( $filtersToSelect as $item ) { ?>
					<option value="<?php echo $item['id']; ?>"
						<?php foreach( $item as $k => $v ) { ?>
							<?php echo $k != 'disabled' ? 'data-' : ''; ?><?php echo $k; ?>="<?php echo $v; ?>"
						<?php } ?>
					><?php echo $item['label']; ?></option>
				<?php } ?>
			</select>
		</div>
		
		<table class="table table-hover filters" id="<?php echo $IDX; ?>_mf-filters-table" data-on-off-all="<?php echo empty( $on_off_all ) ? '0' : '1'; ?>">
			<thead>
				<tr>
					<th class="text-left"><?php echo $text_filter_name; ?></th>
					<th class="text-left" width="100"><?php echo $text_enabled; ?></th>
					<th class="text-left" width="300"><?php echo $text_display_as_type; ?></th>
					<th class="text-center" width="150"><?php echo $text_collapsed_by_default; ?></th>
					<th class="text-center" width="180"><?php echo $text_display_list_of_items; ?></th>
					<th class="text-center" width="180"><?php echo $text_sort_order_values; ?></th>
					<th class="text-left" width="60"><?php echo $text_sort_order; ?></th>
					<th class="text-center" width="70"><?php echo $text_remove; ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if( $filterItems ) { ?>
					<?php foreach( $filterItems as $item_id => $item ) { ?>
						<?php echo mf_render_element('filters', array(
							'name' => $item['name'],
							'_name' => $_filtersName . '[' . (int)$item['filter_group_id'] . ']',
							'_values' => isset( $_filtersValues[(int)$item['filter_group_id']] ) ? $_filtersValues[(int)$item['filter_group_id']] : array(),
							'mf_id' => $item['filter_group_id'],
							'IDX' => $IDX,
							'lang' => $__lang
						)); ?>
					<?php } ?>
				<?php } else { ?>
						<tr data-tr-type="empty"><td colspan="8" class="text-center"><?php echo $text_list_is_empty; ?></td></tr>
				<?php } ?>
			</tbody>
		</table>

		<div class="pagination">
			<?php echo $pagination; ?>
		</div>
	</div>
	<div class="tab-pane" id="filters-tab-default">
		<div style="margin: 7px 0; padding: 3px 5px; background: #ffffdf; border: 1px solid #e9eeb1; float: right;">
			<i class="fa fa-info-circle"></i> <?php echo $text_default_tab_info_filters; ?>
		</div>
		<table class="table table-hover attributes" id="<?php echo $IDX; ?>_mf-filters-table-default">
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
				<?php echo mf_render_element('filters', array(
					'_name' => $_filtersName . '[default]',
					'_values' => isset( $_filtersValues['default'] ) ? $_filtersValues['default'] : array(),
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
		
		mf_init_items_table( '<?php echo $IDX; ?>', 'filters', action );
	})('<?php echo $action; ?>');
</script>