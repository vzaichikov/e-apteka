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

<div class="pull-left">
	<?php foreach( $languages as $language ) { ?>
		<?php if( $language['language_id'] == $language_id ) { ?>
			<button type="button" class="btn btn-sm btn-primary"><img src="<?php echo version_compare( VERSION, '2.2.0.0', '>=' ) ? 'language/' . $language['code'] . '/' . $language['code'] . '.png' : 'view/image/flags/' . $language['image']; ?>" alt="" /> <?php echo $language['name']; ?></button>
		<?php } else { ?>
			<a data-param="language_id" data-val="<?php echo $language['language_id']; ?>" href="<?php echo $aliases_url; ?>&language_id=<?php echo $language['language_id']; ?>&store_id=<?php echo $store_id; ?>" class="btn btn-sm btn-info"><img src="<?php echo version_compare( VERSION, '2.2.0.0', '>=' ) ? 'language/' . $language['code'] . '/' . $language['code'] . '.png' : 'view/image/flags/' . $language['image']; ?>" /> <?php echo $language['name']; ?></a>
		<?php } ?>
	<?php } ?>
</div>

<div class="pull-right">
	<div class="pull-left" style="padding: 5px 5px 0 0;"><?php echo $text_stores; ?>:</div>
	<?php foreach( $stores as $store ) { ?>
		<?php if( $store['store_id'] == $store_id ) { ?>
			<button type="button" class="btn btn-sm btn-primary"><?php echo $store['name']; ?></button>
		<?php } else { ?>
			<a data-param="store_id" data-val="<?php echo $store['store_id']; ?>" href="<?php echo $aliases_url; ?>&store_id=<?php echo $store['store_id']; ?>&language_id=<?php echo $language_id; ?>" class="btn btn-sm btn-info"><?php echo $store['name']; ?></a>
		<?php } ?>
	<?php } ?>
</div>

<div class="clearfix"></div>
		
<br /><br />
<table class="table">
	<thead>
		<tr>
			<th width="50%"><?php echo $text_url; ?></th>
			<th colspan="2"><?php echo $text_seo_url; ?></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>
				<input type="text" class="form-control" id="val-url" value="<?php echo $val_url; ?>" />
				<small>e.g.: http://your-shop.com/desktops?mfp=price[0,100],manufacturers[8],3-clockspeed[100mhz]</small>
			</td>
			<td>
				<input type="text" class="form-control" id="val-alias" value="<?php echo $val_alias; ?>" />
				<small>e.g.: cheap-apple-desktops</small>
			</td>
			<td width="50">
				<button type="button" class="btn btn-sm btn-success" id="insert-alias"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo $text_insert; ?></button>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<table class="table table-tbody">
					<tbody>
						<tr>
							<td>
								<?php echo $entry_meta_title; ?><br >
								<input type="text" class="form-control" id="val-meta-title" value="<?php echo $val_meta_title; ?>" />
							</td>
							<td>
								<?php echo $entry_meta_description; ?><br >
								<textarea class="form-control" id="val-meta-description"><?php echo $val_meta_description; ?></textarea>
							</td>
							<td>
								<?php echo $entry_meta_keyword; ?><br >
								<textarea class="form-control" id="val-meta-keyword"><?php echo $val_meta_keyword; ?></textarea>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<?php echo $entry_h1; ?><br >
								<input type="text" class="form-control" id="val-h1" value="<?php echo $val_h1; ?>" />
							</td>
							<td>
								<?php echo $entry_description; ?><br >
								<textarea class="form-control" id="val-description"><?php echo $val_description; ?></textarea>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>

<?php if( $records ) { ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th width="50%"><?php echo $text_url_params; ?></th>
				<th><?php echo $text_seo_url; ?></th>
				<th width="100"></th>
			</tr>
		</thead>
		<tbody>
			<?php foreach( $records as $record ) { ?>
				<?php
				
					$url = $alias = HTTPS_CATALOG;
					
					if( $record['store_id'] && isset( $stores[$record['store_id']] ) ) {
						$url = $alias = empty( $stores[$record['store_id']]['ssl'] ) ? $stores[$record['store_id']]['url'] : $stores[$record['store_id']]['ssl'];
						$url = $alias = rtrim( $url, '/' ) . '/';
					}
					
					$url .= $record['path'] . ( $record['path'] ? '/' : '' ) . 'mfp,' . $record['mfp'];
					$alias .= $record['path'] . '/' . $record['alias'];
				
				?>
				<tr>
					<td colspan="3">
						<table class="table table-tbody">
							<tbody>
								<tr>
									<td width="50%" colspan="3">
										<a href="<?php echo $url; ?>" target="_blank" data-name="url"><?php echo $url; ?></a>
									</td>
									<td colspan="3">
										<a href="<?php echo $alias; ?>" target="_blank" data-name="alias" data-val="<?php echo $record['alias']; ?>"><?php echo $alias; ?></a>
									</td>
									<td width="100" class="text-center">
										<a href="#" data-id-to-remove="<?php echo $record['mfilter_url_alias_id']; ?>" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-remove"></i></a>
										<a href="#" data-id-to-edit="<?php echo $record['mfilter_url_alias_id']; ?>" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
									</td>
								</tr>
								<?php if( ! empty( $record['meta_title'] ) || ! empty( $record['meta_description'] ) || ! empty( $record['meta_keyword'] ) ) { ?>
									<tr>
										<td colspan="2">
											<?php echo $entry_meta_title; ?><br >
											<input type="text" class="form-control" data-name="meta-title" readonly="readonly" value="<?php echo $record['meta_title']; ?>" />
										</td>
										<td colspan="2">
											<?php echo $entry_meta_description; ?><br >
											<textarea class="form-control" data-name="meta-description" readonly="readonly"><?php echo $record['meta_description']; ?></textarea>
										</td>
										<td colspan="2">
											<?php echo $entry_meta_keyword; ?><br >
											<textarea class="form-control" data-name="meta-keyword" readonly="readonly"><?php echo $record['meta_keyword']; ?></textarea>
										</td>
										<td></td>
									</tr>
								<?php } ?>
								<?php if( ! empty( $record['description'] ) || ! empty( $record['h1'] ) ) { ?>
									<tr>
										<td colspan="2">
											<?php echo $entry_h1; ?><br >
											<input type="text" class="form-control" data-name="h1" readonly="readonly" value="<?php echo $record['h1']; ?>" />
										</td>
										<td colspan="3">
											<?php echo $entry_description; ?><br >
											<textarea class="form-control" data-name="description" readonly="readonly"><?php echo $record['description']; ?></textarea>
										</td>
										<td></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</td>
				</tr>
			<?php } ?>
		</tbody>
	</table>

	<?php echo $pagination; ?>
<?php } ?>

<script type="text/javascript">
	(function(){
		var to_remove_id = null;
		
		function ajax( action, paramsPost, paramsGet ) {
			if( typeof params == 'undefined' ) {
				params = {};
			}
			
			$('#tab-seo-aliases').html('<center><?php echo $text_loading; ?>...</center>')
			
			$.post( '<?php echo $aliases_url; ?>'.replace( /&amp;/g, '&' ) + 
					'&action=' + action + 
					'&language_id=<?php echo $language_id; ?>&store_id=<?php echo $store_id; ?>' +
					( paramsGet ? '&' + paramsGet : ''), 
				paramsPost, 
				function( response ){
					$('#tab-seo-aliases').html( response );
				}
			);
		}
		
		$('#insert-alias').click(function(){
			var url = $('#val-url').val(),
				alias = $('#val-alias').val(),
				meta_title = $('#val-meta-title').val(),
				meta_description = $('#val-meta-description').val(),
				meta_keyword = $('#val-meta-keyword').val(),
				description = $('#val-description').val(),
				h1 = $('#val-h1').val();

			ajax( 'insert', {
				url: url,
				alias: alias,
				meta_title: meta_title,
				meta_description: meta_description,
				meta_keyword: meta_keyword,
				description: description,
				h1: h1,
				to_remove_id: to_remove_id
			});
			
			to_remove_id = null;

			return false;
		});
		
		$('a[data-param]').click(function(){
			var param = $(this).attr('data-param'),
				val = $(this).attr('data-val');
			
			ajax( '', {}, param + '=' + val );
			
			return false;
		});
		
		$('a[data-id-to-remove]').click(function(){
			if( confirm( '<?php echo $text_are_you_sure; ?>' ) ) {
				var id = $(this).attr('data-id-to-remove');

				ajax( 'remove', {
					id: id,
					page: <?php echo $page; ?>
				});
			}
			
			return false;
		});
		
		$('a[data-id-to-edit]').click(function(){
			var $tr = $(this).parent().parent().parent();
			
			$tr.find(':input[data-name]').each(function(){
				var name = $(this).attr('data-name');
				
				$('#val-'+name).val( $(this).val() );
			});
			
			$tr.find('a[data-name]').each(function(){
				var name = $(this).attr('data-name');
				
				$('#val-'+name).val( name == 'alias' ? $(this).attr('data-val') : $(this).html() );
			});
			
			to_remove_id = $(this).attr('data-id-to-edit');
			
			$tr.remove();
			
			return false;
		});
		
		$('.pagination a').click(function(){
			var page = $(this).attr('href').match(/page=([0-9]+)/);
			
			page = page && typeof page[1] != 'undefined' ? page[1] : 1;
			
			ajax( '', {}, 'page='+page);
		
			return false;
		});
	})( jQuery );
</script>