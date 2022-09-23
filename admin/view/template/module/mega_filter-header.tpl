<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">

<div class="modal fade" id="dialog-set-tooltip">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><?php echo $text_set_tooltip; ?></h4>
      </div>
      <div class="modal-body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $text_close; ?></button>
        <button type="button" class="btn btn-primary"><?php echo $text_save; ?></button>
      </div>
    </div>
  </div>
</div>
	<link type="text/css" href="<?php echo $HTTP_URL; ?>view/stylesheet/mf/css/bootstrap.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo $HTTP_URL; ?>view/stylesheet/mf/css/jquery-ui.min.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo $HTTP_URL; ?>view/stylesheet/mf/css/style.css?v2" rel="stylesheet" />

	<script type="text/javascript">
		$ = jQuery = $.noConflict(true);
	</script>

	<script type="text/javascript" src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/js/jquery.min.js"></script>

	<script type="text/javascript">
		var $$			= $.noConflict(true),
			$jQuery		= $$;
		
		jQuery().ready(function(){
			jQuery('[data-toggle="dropdown"]').dropdown();
		});
	</script>

	<script type="text/javascript" src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/js/bootstrap.js"></script>
	<script type="text/javascript" src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/js/selectpicker.js"></script>
	<script type="text/javascript" src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/js/json.js"></script>

	<script type="text/javascript" src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/js/jquery.form.js"></script>
	<script type="text/javascript" src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/js/jquery-ui.min.js"></script>

	<div class="page-header">
		<div class="container-fluid">
			<div class="pull-right">
				<?php if( $tab_active == 'settings' ) { ?>
					<button id="mf-save-form2" type="submit" data-toggle="tooltip" title="<?php echo $text_replace_settings; ?>" class="btn btn-danger">
						<i class="fa fa-save"></i>
					</button>
				<?php } ?>
				<?php if( ! empty( $action ) ) { ?>
					<button id="mf-save-form" type="button" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
				<?php } ?>
				<a href="<?php echo $back; ?>" data-toggle="tooltip" title="<?php echo $button_back; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a>
			</div>
			
			<script type="text/javascript">
				var MF_AJAX_PARAMS = '<?php echo ! empty( $HTTP_URL ) ? "&option=com_mijoshop&format=raw" : ""; ?>';
				
				jQuery('#mf-save-form').click(function(){
					if( jQuery('#mfp-form').attr('data-to-ajax')!='1' ) {
						jQuery('#mfp-form').submit();
						
						return false;
					}
				});
				jQuery('#mf-save-form2').click(function(){
					if( confirm( '<?php echo $text_are_you_sure; ?>' ) ) {
						jQuery('#mfp-form').append('<input name="replace_settings" value="1" type="hidden" />').submit();
					}
					
					return false;
				});
				
				jQuery().ready(function(){
					jQuery('#mf-main-content').on('click', 'button[data-mf-action="set-tooltip"]', function(){
						var $dialog = jQuery( '#dialog-set-tooltip' ),
							$body = $dialog.find('.modal-body').html('<p><center><?php echo $text_loading; ?>...</center></p>'),
							$title = $dialog.find('.modal-title'),
							params = '&type=' + jQuery(this).attr('data-mf-type') + '&idx=' + jQuery(this).attr('data-mf-idx') + '&id=' + jQuery(this).attr('data-mf-id'),
							url = '<?php echo $action_set_tooltip; ?>'.replace(/&amp;/g,'&') + params + MF_AJAX_PARAMS;
						
						$dialog.find('button.btn-primary').unbind('click').bind('click', function(){
							var data = {};
							
							$body.find('textarea').each(function(){
								data[jQuery(this).attr('name')] = jQuery(this).val();
							});
							
							jQuery.post( url, data );
							
							$dialog.modal('hide');
						});
						
						$dialog.modal();
						
						jQuery.get( url, {}, function( response ){
							$body.html( response );
							
							var title = $body.find('[data-type=title]').html();
							
							if( title != '' ) {
								$title.html( '<?php echo addslashes( $text_set_tooltip ); ?> / ' + title );
							}
						});
						
						return false;
					});
				});
				
				function mf_create_progress( text ) {
					if( typeof text == 'undefined' ) {
						text = '<?php echo $text_loading_please_wait; ?>';
					}
					
					return jQuery('<div style="position:absolute; z-index:99; left: 0; top: 0; background: rgba(255,255,255,0.5);" class="mega-filter-pro">')
						.append('<div style="color: #fff; margin: 0 auto; margin-top:100px; width: 300px; background: rgba(0,0,0,0.6); padding: 10px; border-radius: 5px; text-align: center;">' + text + '</div>')
						.width( jQuery('#mf-main-content').outerWidth(true)+30 )
						.height( jQuery('#content').outerHeight(true) )
						.prependTo( jQuery('#mf-main-content') );
				}
				
				function mf_fix_url( url ) {
					return url.replace(/&amp;/g,'&')+MF_AJAX_PARAMS;
				}
				
				function mf_init_items_table( idx, type, action ) {
					var $ = jQuery;
					
					function reload( url, $progress, id, type ) {
						var $table = $('#' + idx + '_mf-' + type + '-table'),
							$pagination = $('#' + idx + '_mf-' + type + '-content div.pagination:first');
						
						$.get( mf_fix_url( url ), {}, function( response ){
							response = response.replace( /<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/gi, '' );
							
							var $tmp = $('<tmp>').html( response );

							$table.hide().removeAttr('id').after( $tmp.find( '#' + idx + '_mf-' + type + '-table' ) );
							$pagination.hide().removeAttr('id').after( $tmp.find( '#' + idx + '_mf-' + type + '-content div.pagination:first' ) );
							
							$table.find('input,select,button').remove();
							$pagination.remove();

							if( typeof $progress != 'undefined' ) {
								$progress.remove();
							}
							
							if( typeof id != 'undefined' ) {
								$('#' + idx + '_mf-' + type + '-content .selectpicker_mf.selectpicker_mf[data-id='+idx+'_mf-'+type+'-table]').find('option[value="' + id + '"]').removeAttr('data-subtext').removeAttr('disabled').removeData('subtext');
								$('#' + idx + '_mf-' + type + '-content .selectpicker_mf.selectpicker_mf[data-id='+idx+'_mf-'+type+'-table]').mf_selectpicker('refresh');
							}
						});
					}
					
					function save( url ) {
						var $progress = mf_create_progress();
						
						$.post( mf_fix_url( action ) + '&ajax_save=1', $('#mfp-form').serialize(), function(){
							if( typeof url == 'function' ) {
								url( $progress );
							} else {
								action = url;

								reload( url, $progress, undefined, type );
							}
						});
					}
					
					if( action != '' ) {
						$('#' + idx + '_mf-' + type + '-content').on('click', '.pagination a', function(){
							var url = $(this).attr('href').replace(/&amp;/g,'&');

							save( url );

							return false;
						});
						
						$('#' + idx + '_mf-' + type + '-content').on('click', 'a[data-mf-action="remove-' + type + '"],a[data-mf-action="remove-' + type + '_group"]', function(){
							var id = $(this).attr('data-mf-id'),
								type = $(this).attr('data-mf-type');

							save(function( $progress ){
								$.post(mf_fix_url( '<?php echo $action_remove_item; ?>' ), {
									'id' : id,
									'idx' : idx,
									'type' : type
								}, function(){
									reload( action, $progress, id, type );
								});
							});

							return false;
						});
					}
					
					$('#' + idx + '_mf-' + type + '-content .selectpicker_mf').mf_selectpicker().on('changed.bs.select', function(e){
						var $self = $(this),
							type = $self.attr('data-type'),
							id = $self.attr('data-id')?$self.attr('data-id'):idx + '_mf-' + type + '-table',
							$cnt = $('#' + id),
							val = $self.val(),
							$option = $self.find('option[value="' + val + '"]'),
							item = {
								group: $option.attr('data-group')||null,
								value: val,
								group_id: $option.attr('data-group_id')||null,
								name: $option.attr('data-name')||null,
								type: $option.attr('data-type')||null
							};
						
						$cnt.find('[data-tr-type=empty]').remove();
						
						$self.find('option[value="' + val + '"]').attr('disabled', true).attr('data-subtext', '<?php echo $text_this_item_is_already_added; ?>');
						$self.prop('selectedIndex', -1).mf_selectpicker('refresh');
						
						var $tr = $('<tr>').append('<td colspan="10" class="text-center"><?php echo $text_loading; ?>...</td>').prependTo( $cnt ),
							params = {
								'_type' : type,
								'_name' : $self.attr('data-name')  + ( item.group_id ? '[' + item.group_id + '][items]' : '' ) + '[' + item.value + ']',
								'mf_id' : item.value,
								'name' :  item.name,
								'IDX' : idx
							};
								
						if( item.group != null ) {
							params['group_name'] = item.group;
						}
								
						if( item.type != null ) {
							params['type'] = item.type;
						}

						$.ajax({
							data: params,
							url: mf_fix_url( '<?php echo $action_render_element; ?>' ),
							type: 'post',
							success: function( response ){
								$self.val('');
								
								$tr.after(response.replace('<head/>','')).remove();
							}
						});
						
					});
				};
			</script>
			
			<h1><?php echo $heading_title; ?></h1>
			<ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
					<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
	<div class="container-fluid">
		<?php if( ! empty( $notification_new_version_is_available ) ) { ?>
			<div class="alert alert-info"><i class="fa fa-exclamation-circle"></i> <?php echo $notification_new_version_is_available; ?>
				<button type="button" class="close" data-dismiss="alert" id="close-notification-new-version">&times;</button>
			</div>
		
			<script>
				$('#close-notification-new-version').click(function(){
					$.get( mf_fix_url( '<?php echo $action_close_notification_new_version; ?>' ) );
				});
			</script>
		<?php } ?>
		<?php if ( ! empty( $_error_warning ) ) { ?>
			<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $_error_warning; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<?php if ( ! empty( $_success ) ) { ?>
			<div class="alert alert-success"><i class="fa fa-exclamation-circle"></i> <?php echo $_success; ?>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		<?php } ?>
		<?php if( ! empty( $refresh_ocmod_cache ) ) { ?>
			<div class="alert alert-info" id="msg-refresh_ocmod_cache"><i class="fa fa-exclamation-circle"></i> <span>Refreshing cache of OCMod, please wait...</span>
				<button type="button" class="close" data-dismiss="alert">&times;</button>
			</div>
		
			<script type="text/javascript">
				(function(){
					var urls = <?php echo json_encode( $refresh_ocmod_cache ); ?>;
					
					function next() {
						var url = urls.shift();
						
						jQuery.get( url.replace( /&amp;/, '&' ), {}, function(){
							if( urls.length ) {
								next();
							} else {
								jQuery('#msg-refresh_ocmod_cache').removeClass('alert-info').addClass('alert-success').find('span').text('OCMod cache has been refreshed');
							}
						});
					}
					
					next();
				})();
			</script>
		<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
			</div>
			<div class="panel-body mega-filter-pro" id="mf-main-content">
				<?php if( ! empty( $action ) ) { ?>
					<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="mfp-form" class="form-horizontal">
				<?php } ?>
					<?php if( $tab_active != 'license' ) { ?>
						<ul class="nav nav-tabs">
							<li<?php if( $tab_active == $_name ) { ?> class="active"<?php } ?>><a href="<?php echo $tab_layout_link; ?>"><i class="glyphicon glyphicon-file"></i> <?php echo $tab_layout; ?></a></li>
							<li<?php if( $tab_active == 'attributes' ) { ?> class="active"<?php } ?>><a href="<?php echo $tab_attributes_link; ?>"><i class="glyphicon glyphicon-list"></i> <?php echo $tab_attributes; ?></a></li>
							<li<?php if( $tab_active == 'options' ) { ?> class="active"<?php } ?>><a href="<?php echo $tab_options_link; ?>"><i class="glyphicon glyphicon-list"></i> <?php echo $tab_options; ?></a></li>
							<?php if( isset( $tab_filters_link ) ) { ?>
								<li<?php if( $tab_active == 'filters' ) { ?> class="active"<?php } ?>><a href="<?php echo $tab_filters_link; ?>"><i class="glyphicon glyphicon-filter"></i> <?php echo $tab_filters; ?></a></li>
							<?php } ?>
							<li<?php if( $tab_active == 'settings' ) { ?> class="active"<?php } ?>><a href="<?php echo $tab_settings_link; ?>"><i class="glyphicon glyphicon-cog"></i> <?php echo $tab_settings; ?></a></li>
							<li<?php if( $tab_active == 'seo' ) { ?> class="active"<?php } ?>><a href="<?php echo $tab_seo_link; ?>"><i class="glyphicon glyphicon-link"></i> <?php echo $tab_seo; ?></a></li>
							<li<?php if( $tab_active == 'about' ) { ?> class="active"<?php } ?>><a style="display: block" href="<?php echo $tab_about_link; ?>"><i class="glyphicon glyphicon-question-sign"></i> <?php echo $tab_about; ?></a></li>
							<li style="display: block; float:left; padding: 8px 0 0 5px;"><?php echo $text_before_change_tab; ?></li>
						</ul>
					<?php } ?>