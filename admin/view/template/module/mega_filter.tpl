<?php require DIR_TEMPLATE . 'module/' . $_name . '-header.tpl'; ?>

<div class="col-xs-2">
	<ul class="nav nav-tabs tabs-left" id="nav-tabs">
		<?php $module_row = 1; ?>

		<?php foreach ($modules as $row => $module) { ?>
			<li<?php echo $module_row == 1 ? ' class="active"' : ''; ?>>
				<a href="#tab-module-<?php echo $row; ?>" id="module-<?php echo $row; ?>">
					<b><span><?php echo ! empty( $module['name'] ) ? $module['name'] : $tab_module . ' ' . $row; ?></span></b>
					<span class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></span>
				</a>
			</li>
			<?php $module_row++; ?>
		<?php } ?>
		<li id="module-add"><a style="background: none !important; border:none !important;" id="add-new-module" class="pull-right"><span class="btn btn-success btn-xs pull-right"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo $button_add_module; ?></span></a></li>
	</ul>
</div>

<div class="col-xs-10">
	<div class="tab-content" id="tab-content"></div>
</div>

<div class="clearfix"></div>

<script type="text/javascript">
	$jQuery(document).on('click', '.scrollbox div a', function() {
		var $self	= jQuery(this),
			$parent	= $self.parent(),
			$box	= $parent.parent();

		$parent.remove();

		$box.find('div:odd').attr('class', 'odd');
		$box.find('div:even').attr('class', 'even');
	});

	if( typeof Array.prototype.indexOf == 'undefined' ) {
		Array.prototype.indexOf = function(obj, start) {
			for( var i = ( start || 0 ), j = this.length; i < j; i++ ) {
				if( this[i] === obj ) { return i; }
			}

			return -1;
		};
	}

////////////////////////////////////////////////////////////////////////////////

jQuery('#mf-save-form').click(function(){
	MFP.save( '<?php echo $text_saving_please_wait; ?>', function(){
		var $form = $$('#mfp-form');
		
		$form.after($$('<form id="mf-form">')
			.attr('method', 'post')
			.attr('action', $form.attr('action'))
		);
	
		$$('#mf-form').submit();
	});
});

jQuery('#mfp-form').attr('data-to-ajax','1');

var MFP = {
	_cnt		: null,
	_cntId		: '#tab-content',
	_row		: 1,
	_tab		: 1,
	_name		: '<?php echo $_name; ?>',
	_hasFilters	: <?php echo isset( $tab_filters_link ) ? 'true' : 'false'; ?>,
	_hasVehicles: <?php echo empty( $action_mfv ) ? 'false' : 'true'; ?>,
	_hasLevels	: <?php echo empty( $action_mfl ) ? 'false' : 'true'; ?>,
	_langs		: null,
	_layouts	: null,
	_settings	: null,
	_externalViews : 0,
	
	langImage: function( lang ) {
		var url = 'view/image/flags/' + lang.image;
		
		<?php if( version_compare( VERSION, '2.2.0.0', '>=' ) ) { ?>
			url = 'language/' + lang.code + '/' + lang.code + '.png';	
		<?php } ?>
			
		return url;
	},

	init: function( modules, firstModule ) {
		var self = this;
		
		self._cnt		= jQuery(self._cntId);
		
		jQuery('#add-new-module').click(function(){
			if( jQuery(this).attr('disabled') ) return false;
			
			self._row = jQuery('#nav-tabs > li:not([id="module-add"]):last');
			
			if( self._row.length ) {
				self._row = parseInt( self._row.find('> a').attr('id').split('-')[1] ) + 1;
			} else {
				self._row = 1;
			}
			
			(function( row ){
				var $li = jQuery('<li>')
					.append(jQuery('<a>')
						.attr({
							'href'	: '#tab-module-' + row,
							'id'	: 'module-' + row
						})
						.append('<b><span><?php echo $tab_module; ?> ' + row + '</span></b>')
						.append(jQuery('<span>')
							.addClass('btn btn-danger btn-xs pull-right')
							.append(jQuery('<i>')
								.addClass('glyphicon glyphicon-remove')
							)
						)
					);

				jQuery('#module-add')
					.before( $li );
				
				self._initTab( $li );
				self._selectTab( $li, false );
				
				self.addModule('', null);
			})( self._row );
			
			return false;
		});
		
		$$('#nav-tabs > li:not([id=module-add])').each(function(){
			self._initTab( $$(this) );
		});
		
		$$('#nav-tabs > li:not([id=module-add]):first a').trigger('click');
	},
	
	u: function( url ) {
		return url + '&_=' + Math.floor(new Date().getTime() / 1000);
	},
	
	_selectTab: function( $tab, load ) {
		if( ! $tab.length ) return;
	
		var self = this,
			newId = $tab.find('a').attr('id').split('-')[1],
			currId = $$('#tab-content > div.active');
		
		if( ! currId.length ) {
			currId = null;
		} else {
			currId = currId.attr('id').split('-')[2];
		}
		
		if( currId == newId )
			return;
		
		function selectTab() {
			function showTab( data ) {
				$$('#nav-tabs > li.active').removeClass('active');
				$$('#tab-content > div').remove();

				$tab.addClass('active');
				
				self._row = newId;
				self._externalViews = 0;
				
				self.addModule(data.name, data);
			}
			
			if( load ) {
				var $progress = self.createProgress('<?php echo $text_loading_please_wait; ?>');
				
				$$.get( self.u( '<?php echo $action_get_data; ?>'.replace(/&amp;/g,'&') + MF_AJAX_PARAMS + '&mf_id=' + newId ), {}, function( response ){
					$progress.remove();
					showTab( $$.parseJSON( response ) );
				});
			} else {
				showTab({name:''});
			}
		}
		
		if( currId !== null ) {
			self.save( '<?php echo $text_loading_please_wait; ?>', function(){
				selectTab();
				
				return true;
			});
		} else {
			selectTab();
		}
	},
	
	_initTab: function( $tab ) {
		var self = this;
		
		$tab.find('> a').each(function(){
			var row = $$(this).attr('id').split('-')[1];
			
			$$(this).find('.btn-danger').click(function(){
				if( confirm( '<?php echo $text_are_you_sure; ?>' ) ) {
					jQuery('#module-'+row).parent().remove();
					jQuery('#tab-module-'+row).remove();

					$$.get( self.u( '<?php echo $action_remove_data; ?>'.replace(/&amp;/g,'&') + MF_AJAX_PARAMS + '&mf_id=' + row ) );

					if( row == self._row ) {
						self._selectTab( $$('#nav-tabs li:not([id=module-add]):first'), true );
					}
				}
				
				return false;
			});
			
			$$(this).click(function(){
				if( $$(this).attr('disabled') ) return false;
				
				self._selectTab( $tab, true );
				
				return false;
			});
		});
	},
	
	createProgress: function( text ){
		return mf_create_progress( text );
	},
	
	save: function( txt, fn, pager ) {
		var $module = $$('#tab-content > .tab-pane.active');
		
		if( ! $module.length ) {
			if( fn() === true ) {
				$progress.remove();
			}
			
			return;
		}
		
		var
			$progress = this.createProgress( txt ),
			id = $module.attr('id').split('-')[2],
			perPage = 500,
			tmp = jQuery('#mfp-form').formToArray(),
			pages = Math.ceil( tmp.length / perPage )-1;
			pager = typeof pager == 'undefined' || ! pager ? 0 : 1;
			
		function getData( idx ) {
			var data = [];
			
			for( var i = idx * perPage; i < idx * perPage + perPage; i++ ) {
				if( typeof tmp[i] == 'undefined' ) break;
				
				data.push( tmp[i] );
			}
			
			return $$.param( data );
		}
		
		function save( idx ) {
			$$.post( '<?php echo $action_save_data; ?>'.replace(/&amp;/g,'&') + MF_AJAX_PARAMS + '&mf_idx=' + idx + '&mf_count=' + pages + '&mf_id=' + id + '&mf_pager=' + pager, getData( idx ), function(){
				if( idx < pages ) {
					save( idx + 1 );
				} else {
					if( fn( $progress ) === true ) {
						$progress.remove();
					}
				}
			});
		}
		
		save( 0 );
	},
	
	addModule: function( name, data, row ){		
		var self	= this,
			/**
			 * Name of tab
			 */
			$name	= jQuery('<table class="table table-tbody">')
				.append(jQuery('<tr>')
					.append( '<td><?php echo $entry_name; ?></td>' )
					.append(jQuery('<td>')
						.append( self.createField( 'text', '[name]', name, { 'class' : 'mf_tab_name', 'id' : 'name-' + self._row } ) )
					)
				),
			/**
			 * Title
			 */
			$title	= jQuery('<div>')
				.append((function(){
					var $ul = jQuery('<ul id="language-' + self._row + '" class="nav nav-tabs">'),
						k = 0, i;
					
					for( i in self._langs ) {
						if( typeof self._langs[i] == 'function' ) continue;
						
						$ul.append(jQuery('<li' + ( k ? '' : ' class="active"' ) + '>')
							.append(jQuery('<a data-toggle="tab" href="#tab-language-' + self._row + '-' + self._langs[i].language_id + '">')
								.append(jQuery('<img src="' + self.langImage( self._langs[i] ) + '" title="' + self._langs[i].name + '">'))
								.append( ' ' + self._langs[i].name )
							)
						);
						k++;
					}
					
					return $ul;
				})())
				.append((function(){
					var $tc = jQuery('<div class="tab-content">'),
						k = 0, i;
					
					for( i in self._langs ) {
						if( typeof self._langs[i] == 'function' ) continue;
						
						$tc.append(jQuery('<div class="tab-pane' + ( k ? '' : ' active' ) + '" id="tab-language-' + self._row + '-' + self._langs[i].language_id + '">')
							.append(jQuery('<table class="table table-tbody">')
								.append(jQuery('<tr>')
									.append(jQuery('<td width="200"><?php echo $entry_title; ?></td>'))
									.append(jQuery('<td data-name="title-' + i + '">'))
								)
							)
						);
						k++;
					}
					
					return $tc;
				})()), 
			$tabs	= jQuery('<ul id="c-tabs-' + self._row + '" class="nav nav-tabs">')
				.append((function(){
					var html = '';
				
					html += '<li class="active"><a data-toggle="tab" href="#tab-' + self._row + '-settings"><i class="glyphicon glyphicon-cog"></i> <?php echo $tab_settings; ?></a></li>';
					html += '<li><a data-toggle="tab" href="#tab-' + self._row + '-base-attributes"><i class="glyphicon glyphicon-wrench"></i> <?php echo $tab_base_attributes; ?></a></li>';
					html += '<li><a data-toggle="tab" href="#tab-' + self._row + '-attribs"><i class="glyphicon glyphicon-list"></i> <span><?php echo $tab_attributes; ?></span></a></li>';
					html += '<li><a data-toggle="tab" href="#tab-' + self._row + '-options"><i class="glyphicon glyphicon-list"></i> <span><?php echo $tab_options; ?></span></a></li>';
					
					if( self._hasFilters ) {
						html += '<li><a data-toggle="tab" href="#tab-' + self._row + '-filters"><i class="glyphicon glyphicon-filter"></i> <span><?php echo $tab_filters; ?></span></a></li>';
					}
				
					if( self._hasVehicles ) {
						html += '<li><a data-toggle="tab" href="#tab-' + self._row + '-vehicles"><i class="fa fa-truck"></i> <span><?php echo $tab_vehicles; ?></span></a></li>';
					}
				
					if( self._hasLevels ) {
						html += '<li><a data-toggle="tab" href="#tab-' + self._row + '-levels"><i class="fa fa-list"></i> <span><?php echo $tab_levels; ?></span></a></li>';
					}
					
					html += '<li><a data-toggle="tab" href="#tab-' + self._row + '-categories"><i class="glyphicon glyphicon-list-alt"></i> <?php echo $tab_categories; ?></a></li>';
					html += '<li><a data-toggle="tab" href="#tab-' + self._row + '-configuration"><i class="glyphicon glyphicon-wrench"></i> <span><?php echo $tab_configuration; ?></span></a></li>';
					
					return html;
				})()),
			$tc		= jQuery('<div class="tab-content">')
				/**
				 * SETTINGS
				 */
				.append(jQuery('<div id="tab-' + self._row + '-settings" class="tab-pane active">')
					.append(jQuery('<table class="table table-tbody">')
						.append(jQuery('<tr>')
							.append('<td width="200"><?php echo $entry_layout; ?><span class="help"><?php echo $text_checkbox_guide; ?></span></td>')
							.append(jQuery('<td data-name="layout">'))
						)
						.append(jQuery('<tr id="category_id-input-' + self._row + '" data-name="layout-1">')
							.append('<td><?php echo $entry_show_in_categories; ?><span class="help"><?php echo $text_autocomplete; ?></span></td>')
							.append(jQuery('<td data-name="category-name">'))
						)
						.append(jQuery('<tr id="category_id-list-' + self._row + '" data-name="category-list">')
							.append('<td><span class="help"><?php echo $text_checkbox_guide; ?></span></td>')
							.append(jQuery('<td>')
								.append( self.createScrollbox( 'category_id-', 'delete', '[category_id][]', data && data.__categories ? data.__categories : [] ) )
							)
						)
						.append(jQuery('<tr id="category_id-hide-input-' + self._row + '" data-name="category-hide-input">')
							.append('<td><?php echo $entry_hide_in_categories; ?><span class="help"><?php echo $text_autocomplete; ?></span></td>')
							.append(jQuery('<td data-name="category-hide-name">'))
						)
						.append(jQuery('<tr id="category_id-hide-list-' + self._row + '" data-name="category-hide-list">')
							.append('<td><span class="help"><?php echo $text_checkbox_guide; ?></span></td>')
							.append(jQuery('<td>')
								.append( self.createScrollbox( 'hide_category_id-', 'delete', '[hide_category_id][]', data && data.__hideCategories ? data.__hideCategories : [] ) )
							)
						)
						.append(jQuery('<tr>')
							.append('<td><?php echo $entry_store; ?></td>')
							.append('<td data-name="store-id"></td>')
						)
						.append(jQuery('<tr>')
							.append('<td><?php echo $entry_customer_groups; ?><span class="help"><?php echo $text_checkbox_guide; ?></span></td>')
							.append('<td data-name="customer-groups"></td>')
						)
						.append(jQuery('<tr>')
							.append('<td><?php echo $entry_position; ?></td>')
							.append('<td data-name="position"></td>')
						)
						.append(jQuery('<tr>')
							.append('<td><?php echo $entry_display_options_inline_horizontal; ?></td>')
							.append('<td data-name="inline-horizontal"></td>')
						)
						.append(jQuery('<tr>')
							.append('<td><?php echo $entry_display_always_as_widget; ?></td>')
							.append('<td data-name="display_always_as_widget"></td>')
						)
						.append(jQuery('<tr>')
							.append('<td style="vertical-align:middle;"><?php echo $entry_widget_with_swipe; ?></td>')
							.append('<td data-name="widget_with_swipe"></td>')
						)
						.append(jQuery('<tr>')
							.append('<td><?php echo $entry_display_selected_filters; ?></td>')
							.append('<td data-name="display_selected_filters"></td>')
						)
						.append(jQuery('<tr>')
							.append('<td><?php echo $entry_status; ?></td>')
							.append('<td data-name="status"></td>')
						)
						.append(jQuery('<tr>')
							.append('<td><?php echo $entry_sort_order; ?></td>')
							.append('<td data-name="sort-order"></td>')
						)
					)
				)
				/**
				 * BASE ATTRIBUTES
				 */
				.append( self.createContainer( 'base-attributes', 'base_attribs' ) )
				/**
				 * ATTRIBUTES
				 */
				.append( self.createContainer( 'attribs' ) )
				/**
				 * OPTIONS
				 */
				.append( self.createContainer( 'options' ) )
				/**
				 * FILTERS
				 */
				.append( self._hasFilters ? self.createContainer( 'filters' ) : '' )
				/**
				 * VEHICLES
				 */
				.append( self._hasVehicles ? self.createContainer( 'vehicles' ) : '' )
				/**
				 * MF Levels
				 */
				.append( self._hasLevels ? self.createContainer( 'levels' ) : '' )
				/**
				 * CATEGORIES
				 */
				.append( jQuery('<div data-name="categories">') )
				/**
				 * CONFIGURATION
				 */
				.append( self.createContainer( 'configuration' ) ),
			$module = jQuery('<div id="tab-module-' + self._row + '" class="tab-pane">')
				.append( $name )
				.append( $title )
				.append( $tabs )
				.append( $tc );
		
		self._cnt.append( $module );
		
		if( data !== null ) {
			self._initModule( $module, data );
		}
	},
	
	count: function( obj ) {
		var count = 0;
		
		for( var i in obj ) {
			count++;
		}
		
		return count;
	},
	
	_initModule: function( $module, data ) {
		var self = this,
			row = $module.attr('id').split('-')[1];
		
		$module.addClass('active');
		
		/**
		 * Title
		 */
		for( var i in self._langs ) {
			if( typeof self._langs[i] == 'function' ) continue;

			$module.find('[data-name="title-' + i + '"]').append( self.createField( 
				'text', 
				'[title][' + self._langs[i].language_id + ']',
				typeof data['title'] != 'undefined' && typeof data['title'][self._langs[i].language_id] != 'undefined' ? data['title'][self._langs[i].language_id] : '',
				{ 'style' : 'width:400px' }
			));
		}
	
		/**
		 * Layout
		 */		
		$module.find('[data-name="layout"]').append( self.createScrollbox( 'layout_id-', 'checkbox', '[layout_id][]', self._layouts, 'layout_id', typeof data['layout_id'] != 'undefined' ? data['layout_id'] : [] ) );
		
		$module.find('[data-name="layout-1"]')[typeof data['layout_id'] == 'undefined' || data['layout_id'].indexOf( self._settings['layout_c'] ) < 0?'hide':'show']();
		
		$module.find('[data-name="category-name"]')
			.append( self.createField( 'text', null, '', { 'name' : 'category-name' } ) )
			.append( self.createField( 'checkbox', '[category_id_with_childs]', '1', {
				'checked'	: data['category_id_with_childs'] ? true : false,
				'style'		: 'margin: 0 5px; vertical-align:middle;'
			}))
			.append( '<?php echo $text_apply_also_to_childs; ?>' );
		
		$module.find('[data-name="category-list"]')[typeof data['layout_id'] == 'undefined' || data['layout_id'].indexOf( self._settings['layout_c'] ) < 0?'hide':'show']();
		
		$module.find('[data-name="category-hide-input"]')[typeof data['layout_id'] == 'undefined' || data['layout_id'].indexOf( self._settings['layout_c'] ) < 0?'hide':'show']();
		
		$module.find('[data-name="category-hide-name"]')
			.append( self.createField( 'text', null, '', { 'name' : 'category-hide-name' } ) )
			.append( self.createField( 'checkbox', '[hide_category_id_with_childs]', '1', {
				'checked'	: data['hide_category_id_with_childs'] ? true : false,
				'style'		: 'margin: 0 5px; vertical-align:middle;'
			}))
			.append( '<?php echo $text_apply_also_to_childs; ?>' );
		
		$module.find('[data-name="category-hide-list"]')[typeof data['layout_id'] == 'undefined' || data['layout_id'].indexOf( self._settings['layout_c'] ) < 0?'hide':'show']();
		
		/**
		 * Stores
		 */
		$module.find('[data-name="store-id"]')
			.append( self.createScrollbox( 'store_id-', 'checkbox', '[store_id][]', self._stores, 'store_id', typeof data['store_id'] != 'undefined' ? data['store_id'] : [] ) );
		
		/**
		 * Customer group
		 */
		$module.find('[data-name="customer-groups"]')
			.append( self.createScrollbox( 'customer_groups-', 'checkbox', '[customer_groups][]', self._customerGroups, 'customer_group_id', typeof data['customer_groups'] != 'undefined' ? data['customer_groups'] : [] ) );
		
		/**
		 * Position
		 */
		$module.find('[data-name="position"]')
			.append( self.createField( 'radio_group', '[position]', typeof data['position'] == 'undefined' ? 'column_left' : data['position'], {
				'multiOptions' : {
					'items' : [
						[ 'column_left', '<?php echo $text_column_left; ?>' ],
						[ 'column_right', '<?php echo $text_column_right; ?>' ],
						[ 'content_top', '<?php echo $text_content_top; ?>' ]
					]
				}
			}))
			.append('<span class="hide"><?php echo addslashes( $text_display_always_as_widget ); ?></span>');
		
		/**
		 * Inline horizontal
		 */
		$module.find('[data-name="inline-horizontal"]')
			.append( self.createField( 'radio_group', '[inline_horizontal]', typeof data['inline_horizontal'] == 'undefined' ? '0' : data['inline_horizontal'], {
				'multiOptions' : {
					'items' : [
						[ '0', '<?php echo $text_no; ?>' ],
						[ '1', '<?php echo $text_yes; ?>' ]
					]
				}
			}));
		
		/**
		 * Display always as widget
		 */
		$module.find('[data-name="display_always_as_widget"]')
			.append( self.createField( 'radio_group', '[display_always_as_widget]', typeof data['display_always_as_widget'] == 'undefined' ? '0' : data['display_always_as_widget'], {
				'multiOptions' : {
				'items' : [
					[ '1', '<?php echo $text_yes; ?>' ],
					[ '0', '<?php echo $text_no; ?>' ]
				]}})
			);
		
		/**
		 * Widget with swipe
		 */
		$module.find('[data-name="widget_with_swipe"]')
			.append( self.createField( 'radio_group', '[widget_with_swipe]', typeof data['widget_with_swipe'] == 'undefined' ? '1' : data['widget_with_swipe'], {
				'multiOptions' : {
				'items' : [
					[ '1', '<?php echo $text_yes; ?>' ],
					[ '0', '<?php echo $text_no; ?>' ]
				]}})
			)
			.append( '&nbsp;&nbsp;&nbsp;<img src="<?php echo $HTTP_URL; ?>view/stylesheet/mf/images/swipe.jpg" style="vertical-align:middle;" alt="" />' );
		
		/**
		 * Display selected filters
		 */
		$module.find('[data-name="display_selected_filters"]')
			.append( self.createField( 'radio_group', '[display_selected_filters]', typeof data['display_selected_filters'] == 'undefined' ? '0' : data['display_selected_filters'], {
				'multiOptions' : {
					'items' : [
						[ 'over_filter', '<?php echo $text_over_filter; ?>' ],
						[ 'over_results', '<?php echo $text_over_results; ?>' ],
						[ '0', '<?php echo $text_disabled; ?>' ]
					]
				}
			}
		));
		
		/**
		 * Status
		 */
		$module.find('[data-name="status"]')
			.append( self.createField( 'radio_group', '[status]', typeof data['status'] == 'undefined' ? '1' : data['status'], {
				'multiOptions' : {
					'items' : [
						[ '1', '<?php echo $text_enabled; ?>' ],
						[ 'pc', '<?php echo $text_pc; ?>' ],
						[ 'mobile', '<?php echo $text_mobile; ?>' ],
						[ '0', '<?php echo $text_disabled; ?>' ]
					]
				}
			}
		));
		
		/**
		 * Sort
		 */
		$module.find('[data-name="sort-order"]')
			.append( self.createField( 'text', '[sort_order]', data['sort_order'], {
				'size' : '3'
			}
		));
		
		/**
		 * Categories
		 */
		$module.find('[data-name="categories"]').before( self.createCategories( data['categories'], data ) ).remove();
		
		////////////////////////////////////////////////////////////////////////
		
		/**
		 * Load external views for attributes/options/filters
		 */
		$module.find('[data-load-type]').bind('click',function(){
			var _this		= jQuery(this),
				parent		= _this.parent(),
				type		= _this.attr('data-load-type'),
				row			= parent.attr('id').split('-')[1],
				tab			= jQuery('a[href="#' + parent.attr('id') + '"] span'),
				tab_name	= tab.text(),
				container	= parent.find('> .cnt'),
				$progress	= null;
				
			if( _this.attr('data-loaded') && ! confirm( '<?php echo $text_are_you_sure; ?>' ) ) {
				return false;
			}
				
//			parent.find('.mf-filter button').unbind('click').bind('click', function(){
//				self.save('<?php echo $text_loading_please_wait; ?>', function(){
//					load('&filter=' + encodeURIComponent( parent.find('.mf-filter input').val() ), function( container ){
//						container.find('a[href*="tab-custom"]').trigger('click');
//					});
//					
//					return true;
//				});
//			});

			container.html( '<center><?php echo $text_loading; ?></center>' );
			
			function load( params, onload ) {
				var action_ldv = '<?php echo $action_ldv; ?>'.replace(/&amp;/g,'&')+MF_AJAX_PARAMS,
					url = action_ldv,
					data = { 'name' : '<?php echo $_name; ?>_module[' + type + ']', 'type' : type, 'idx' : row };
				
				if( ! params && _this.attr('data-loaded') ) {
					url += '&mf_default=1';
				}
				
				_this.attr('data-loaded', 1);
				
				self.startExternalViewLoad();
				
				tab.text( '<?php echo $text_loading; ?>...' );
				
				jQuery.get( self.u( url+params ), data, function( response ){
					tab.text( tab_name );
					
					container.html( response );
					self.stopExternalViewLoad();
					
					if( $progress != null ) {
						$progress.remove();
						$progress = null;
					}

					container.find('.pagination a').click(function(){
						var page = jQuery(this).attr('href').match(/page=([0-9]+)/);
						
						page = page ? page[1] : 1;

						self.save( '<?php echo $text_loading_please_wait; ?>', function(){
							$progress = self.createProgress( '<?php echo $text_loading_please_wait; ?>' );

							load( '&page=' + page, function(){
								jQuery('#' + row + '_mf-' + type + '-content').parent().find('a[href*="tab-custom"]').trigger('click');
							});

							return true;
						});

						return false;
					});
					
					mf_init_items_table( row, type, '' );
					
					container.find('[data-toggle="dropdown"]').dropdown();
					
					jQuery('#' + row + '_mf-' + type + '-content').on('click', 'a[data-mf-action="remove-' + type + '"],a[data-mf-action="remove-' + type + '_group"]', function(){
						var id = jQuery(this).attr('data-mf-id'),
							type = jQuery(this).attr('data-mf-type');
						
						self.save( '<?php echo $text_loading_please_wait; ?>', function( $progress ){
							jQuery.post(mf_fix_url( '<?php echo $action_remove_item; ?>' ), {
								'id' : id,
								'idx' : row,
								'type' : type
							}, function(){
								var $table = jQuery('#' + row + '_mf-' + type + '-table'),
									$pagination = jQuery('#' + row + '_mf-' + type + '-content div.pagination');

								jQuery.get( self.u( action_ldv ), data, function( response ){
									var $tmp = jQuery('<tmp>').html( response );

									$table.after( $tmp.find( '#' + row + '_mf-' + type + '-table' ) ).remove();
									$pagination.after( $tmp.find( '#' + row + '_mf-' + type + '-content div.pagination' ) ).remove();

									$progress.remove();
								});
							});
						});
							
						$('#' + row + '_mf-' + type + '-content .selectpicker_mf,.selectpicker_mf[data-id='+row+'_mf-'+type+'-table]').find('option[value="' + id + '"]').removeAttr('data-subtext').removeAttr('disabled').removeData('subtext');
						$('#' + row + '_mf-' + type + '-content .selectpicker_mf,.selectpicker_mf[data-id='+row+'_mf-'+type+'-table]').mf_selectpicker('refresh');

						return false;
					});
					
					if( type == 'levels' ) {
						function removeLevel( $button ) {
							$button.click(function(){
								container.find('[data-idx=' + jQuery(this).attr('data-idx') + ']').remove();
								
								container.find('#level-labels > [data-idx]').each(function(i){
									var name = self._name + '_module[levels][level_label][' + i + ']';
									
									jQuery(this).attr('data-idx', i).find('[data-idx]').attr('data-idx',i);
									jQuery(this).find('> div').each(function(){
										jQuery(this).find('> span:first').text( '#' + ( i + 1 ));
									});
									jQuery(this).find('input[name]').each(function(){
										jQuery(this).attr('name', name + '[' + jQuery(this).attr('data-language-id') + ']');
									});
								});
								
								return false;
							});
						}
						
						removeLevel( container.find('.remove-level-label') );
					
						container.find('#add-level-label').click(function(){
							var idx = container.find('#level-labels > div').length,
								name = self._name + '_module[levels][level_label][' + idx + ']';
							
							container.find('#level-labels')
								.append((function(){
									var out = '',
										first = false;
								
									for( var i in self._langs ) {
										out += '<div class="input-group" style="padding: 1px 0;">';
										out += '<span class="input-group-addon">#' + ( idx + 1 ) + '</span>';
										
										out += '<span class="input-group-addon">';
										out += '<img src="' + self.langImage( self._langs[i] ) + '" title="" />';
										out += '</span>';
										
										out += '<input type="text" name="' + name + '[' + self._langs[i].language_id + ']' + '" data-language-id="' + self._langs[i].language_id + '" value="" class="form-control" />';
										
										if( ! first ) {
											out += '<span class="input-group-addon">';
											out += '<button class="btn btn-xs btn-danger remove-level-label" data-idx="' + idx + '" style="margin: -2px 0;"><i class="fa fa-remove"></i></button>';
											out += '</span>';
											first = true;
										}
										
										out += '</div>';
									}
									
									return '<div data-idx="' + idx + '">' + ( idx ? '<hr style="margin: 5px 0" />' : '' ) + out + '</div>';
								})());
								
							removeLevel( container.find('.remove-level-label[data-idx="' + idx + '"]') );
							
							return false;
						});
					}
					
					if( typeof onload == 'function' ) {
						onload( container );
					}
				});
			}
			
			load('');

			return false;
		});
		
		/**
		 * Show/hide the fielts of selecting categories after select/unselect the template of category
		 */
		$module.find('input[type=checkbox][id^=layout_id-]').unbind('change').bind('change', function(){
			var id	= jQuery(this).attr('id').split('-');
			
			$module.find('input[type=checkbox][id^=layout_id-' + id[1] + '][value=' + self._settings['layout_c'] + ']').each(function(){
				var $items = jQuery('tr[id=category_id-input-' + id[1] + '],tr[id=category_id-list-' + id[1] + '],tr[id=category_id-hide-input-'+id[1]+'],tr[id=category_id-hide-list-'+id[1]+']');
				
				if( ! jQuery(this).is(':checked') ) {
					$items.hide();
				} else {
					$items.removeAttr('style');
				}
			});
		});

		/**
		 * Autocomplete the filed of name of category for the list where module should be visible
		 */
		$module.find('input[name="category-name"]:not([autocomplete])').each(function(){
			var $self = jQuery(this),
				id = $self.parent().parent().attr('id'),
				nr = id.split('-')[2],
				$c = jQuery('#category_id-list-' + nr).find('.scrollbox');
			
			jQuery(this).attr('autocomplete','1').autocomplete({
				delay: 500,
				source: function(request, response) {
					if( $self.val() ) {
						jQuery.ajax({
							url: 'index.php?route=module/mega_filter/category_autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent($self.val())+MF_AJAX_PARAMS,
							dataType: 'json',
							success: function(json) {		
								response(jQuery.map(json, function(item) {
									return {
										label: item.name,
										value: item.category_id
									};
								}));
							}
						});
					}
				}, 
				select: function(event, ui) {
					$c.find('input[value=' + ui.item.value + ']').parent().remove();

					$c.append('<div>' + ui.item.label + '<a class="btn btn-danger btn-xs pull-right"><i class="fa fa-remove"></i></a><input type="hidden" name="<?php echo $_name; ?>_module[category_id][]" value="' + ui.item.value + '" /></div>');

					$c.find('div:odd').attr('class', 'odd');
					$c.find('div:even').attr('class', 'even');

					return false;
				},
				focus: function(event, ui) {
				return false;
			}
			});
		});

		/**
		 * Autocomplete the filed of name of category for the list where module should be hidden
		 */
		$module.find('input[name="category-hide-name"]:not([autocomplete])').each(function(){
			var $self = jQuery(this),
				id = jQuery(this).parent().parent().attr('id'),
				nr = id.split('-')[3],
				$c = jQuery('#category_id-hide-list-' + nr).find('.scrollbox');
			
			jQuery(this).attr('autocomplete','1').autocomplete({
				delay: 500,
				source: function(request, response) {
					if( $self.val() ) {
						jQuery.ajax({
							url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent($self.val()) + MF_AJAX_PARAMS,
							dataType: 'json',
							success: function(json) {		
								response(jQuery.map(json, function(item) {
									return {
										label: item.name,
										value: item.category_id
									};
								}));
							}
						});
					}
				}, 
				select: function(event, ui) {
					$c.find('input[value=' + ui.item.value + ']').parent().remove();

					$c.append('<div>' + ui.item.label + '<a class="btn btn-danger btn-xs pull-right"><i class="fa fa-remove"></i></a><input type="hidden" name="<?php echo $_name; ?>_module[hide_category_id][]" value="' + ui.item.value + '" /></div>');

					$c.find('div:odd').attr('class', 'odd');
					$c.find('div:even').attr('class', 'even');

					return false;
				},
				focus: function(event, ui) {
					return false;
				}
			});
		});
		
		/**
		 * Auto change the name of tab after enter its name in field "name" 
		 */
		$module.find('input.mf_tab_name').bind('change keyup', function(){
			var val = jQuery(this).val(),
				id	= jQuery(this).attr('id').split('-')[1];
			
			if( ! val ) {
				val = '<?php echo $tab_module; ?> ' + id;
			}
			
			jQuery('#module-' + id).find('b > span').text( val );
		}).trigger('change');
		
		/**
		 * Change the position if selected "Display type" as widget
		 */
		$module.find('[data-name="display_always_as_widget"] input[type=radio]').change(function(){
			var $position = $module.find('[data-name="position"]');
			
			$position.find('input[type=radio]').prop('checked', false).parent().removeClass('active');
			
			if( jQuery(this).val() == '1' ) {
				$position.find('input[type=radio]').each(function(i){
					if( jQuery(this).attr('value') == 'content_top' ) {
						$position.find('> div.btn-group:first').addClass('hide');
						$position.find('> span:last').removeClass('hide');
						
						jQuery(this).prop('checked',true).trigger('change').parent().addClass('active');
						
						return false;
					}
				});
			} else {
				$position.find('> div.btn-group:first').removeClass('hide');
				$position.find('> span:last').addClass('hide');
				
				$position.find('input[type=radio]:first').prop('checked',true).trigger('change').parent().addClass('active');
			}
		});
		
		if( $module.find('[data-name="display_always_as_widget"] input:checked').val() == '1' ) {
			$module.find('[data-name="display_always_as_widget"] input:checked').trigger('change');
		}
		
		$module.find('input[name="mega_filter_module[position]"]').change(function(){
			$module.find('[data-name="inline-horizontal"]').parent()[jQuery(this).val()=='content_top'&&$module.find('[data-name="display_always_as_widget"] input:checked').val() != '1'?'removeClass':'addClass']('hide');
		});
		
		$module.find('input[name="mega_filter_module[position]"]:checked').trigger('change');
		
		$module.find('a[data-load-type]').trigger('click');
	},
	
	startExternalViewLoad: function(){
		this._externalViews++;
		
		jQuery('#mf-save-form,#add-new-module,#nav-tabs > li > a[id^="module-"]').attr('disabled', true);
	},
	
	stopExternalViewLoad: function(){
		this._externalViews--;
		
		if( this._externalViews <= 0 ) {
			this._externalViews = 0;
			jQuery('#mf-save-form,#add-new-module,#nav-tabs > li > a[id^="module-"]').removeAttr('disabled');
		}
	},
	
	createCategories: function( data, _data ) {
		var self	= this,
			row		= self._row,
			idx		= 0,
			box		= jQuery('<div id="tab-' + row + '-categories" class="tab-pane">')
				.append(jQuery('<div class="btn-group btn-group-sm" style="margin: 10px 0">')
					.append(jQuery('<button type="button" disabled="disabled" class="btn btn-default" style="color: #000; opacity: 1;"><?php echo $entry_add_new_type; ?></button>'))
					.append(jQuery('<button type="button" data-type="related" class="btn btn-primary enable"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo $text_related; ?></button>'))
					.append(jQuery('<button type="button" data-type="tree" class="btn btn-primary enable"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo $text_tree; ?></button>'))
					.append(jQuery('<button type="button" data-type="cat_checkbox" class="btn btn-primary enable"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo $text_cat_checkbox; ?></button>'))
				),
			cnt		= jQuery('<div class="cnt">')
				.appendTo( box ),
			types	= {
				'related'		: '<?php echo $text_related; ?>',
				'tree'			: '<?php echo $text_tree; ?>',
				'cat_checkbox'	: '<?php echo $text_cat_checkbox; ?>'
			};
				
		box.find('[data-type]').click(function(){
			var type = jQuery(this).attr('data-type');
			
			if( type == 'tree' ) {
				if( cnt.find('[data-type="tree"]').length ) {
					alert( '<?php echo addslashes( $error_tree_categories_duplicate ); ?>' );

					return false;
				} else if( cnt.find('[data-type="cat_checkbox"]').length ) {
					alert( '<?php echo addslashes( $error_tree_checkbox_categories ); ?>' );

					return false;
				} else if( ! MFP._settings.show_products_from_subcategories ) {
					alert( '<?php echo addslashes( $text_tree_categories_info ); ?>' );
				}
			} else if( type == 'cat_checkbox' ) {
				if( cnt.find('[data-type="cat_checkbox"]').length ) {
					alert( '<?php echo addslashes( $error_cat_checkbox_categories_duplicate ); ?>' );

					return false;
				} else if( cnt.find('[data-type="tree"]').length ) {
					alert( '<?php echo addslashes( $error_tree_checkbox_categories ); ?>' );

					return false;
				} else if( ! MFP._settings.show_products_from_subcategories ) {
					alert( '<?php echo addslashes( $text_tree_categories_info ); ?>' );
				}
			}
			
			add( type );
			
			mf_footer_ready();
			
			return false;
		});
		
		function add( type, data ) {
			var tbody	= jQuery('<tbody>'),
				name	= self._name + '_module[categories][' + idx + ']',
				lIdx	= 0;
			
			function addLevel( names ) {
				tbody.find('tr.add_level').before( jQuery('<tr class="levels">')
					.append( '<td class="text-right"><?php echo $entry_level_name; ?></td>' )
					.append(jQuery('<td>')
						.append((function(){
							var $div = jQuery('<div class="pull-left">'),
								i, j = 0;
							
							for( i in self._langs ) {
								if( typeof self._langs[i] == 'function' ) continue;
						
								if( j )
									$div.append('<div style="height:3px"></div>');
							
								$div.append('<img src="' + self.langImage( self._langs[i] ) + '"> ')
									.append(self.createField( 'text', null, typeof names != 'undefined' && typeof names[self._langs[i].language_id] != 'undefined' ? names[self._langs[i].language_id] : '', {
											'name'	: name + '[levels][' + lIdx + '][' + self._langs[i].language_id + ']'
										})
									);
								j++;
							}
							
							return $div;
						})())
						.append(jQuery('<a href="#" class="btn btn-danger btn-xs pull-left" style="margin: -3px 0 0 3px"><i class="glyphicon glyphicon-remove"></i></a>')
							.click(function(){
								jQuery(this).parent().parent().remove();
								
								return false;
							})
						)
					) 
				);
				
				lIdx++;
			}
			
			if( type == 'related' ) {
				tbody.append(jQuery('<tr>')
					.append('<td><?php echo $entry_root_category; ?><span class="help"><?php echo $text_autocomplete; ?></span></td>')
					.append(jQuery('<td>')
						.append( '<input type="radio"' + ( typeof data != 'undefined' && data.root_category_type == 'top_category' ? ' checked="checked"' : '' ) + ' name="' + name + '[root_category_type]" value="top_category" style="margin: 0; vertical-align: middle;" id="root-cat-type-' + self._row + '-' + idx + '-a" /> <label for="root-cat-type-' + self._row + '-' + idx + '-a" style="margin-right:10px"><?php echo $text_top_category; ?></label>' )
						.append( '<input type="radio"' + ( typeof data != 'undefined' && data.root_category_type == 'by_url' ? ' checked="checked"' : '' ) + ' name="' + name + '[root_category_type]" value="by_url" style="margin: 0; vertical-align: middle;" id="root-cat-type-' + self._row + '-' + idx + '-b" /> <label for="root-cat-type-' + self._row + '-' + idx + '-b" style="margin-right:10px"><?php echo $text_current_category; ?></label>' )
						.append( '<input type="radio"' + ( typeof data != 'undefined' && data.root_category_type == 'default_category' ? ' checked="checked"' : '' ) + ' name="' + name + '[root_category_type]" value="default_category" style="margin: 0; vertical-align: middle;" id="root-cat-type-' + self._row + '-' + idx + '-c" /> <label for="root-cat-type-' + self._row + '-' + idx + '-c" style="margin-right:10px"><?php echo $text_or_select_category; ?></label>' )
						.append( self.createField( 'text', null, ! _data || ! data || ! _data.__categoriesNames || typeof _data.__categoriesNames[data.root_category_id] == 'undefined' ? '' : _data.__categoriesNames[data.root_category_id].replace(/&gt;/g, '>') ).each(function(){
							var $self = jQuery(this);
						
							setTimeout(function(){
								$self.attr('autocomplete','1').autocomplete({
									delay: 500,
									source: function( request, response ) {
										if( $self.val() ) {
											jQuery.ajax({
												url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent( $self.val() ) + MF_AJAX_PARAMS,
												dataType: 'json',
												success: function(json) {		
													response(jQuery.map(json, function(item) {
														return {
															label: item.name,
															value: item.category_id
														};
													}));
												}
											});
										}
									},
									select: function( event, ui ) {
										var $parent = $self.parent();

										$parent.find('[name="' + name + '[root_category_id]"]').remove();
										$parent.append( self.createField( 'hidden', null, ui.item.value, {
											'name' : name + '[root_category_id]'
										}));

										$self.val( ui.item.label );

										return false;
									},
									focus: function( event, ui ) {
										return false;
									}
								});
							},1000);
						}).change(function(){
							if( ! jQuery(this).val() )
								jQuery(this).parent().find('[name="' + name + '[root_category_id]"]').remove();
						}))
						.append( typeof data == 'undefined' ? '' : self.createField( 'hidden', null, data.root_category_id, {
							'name' : name + '[root_category_id]'
						}))
					)
				).append(jQuery('<tr class="add_level">')
					.append('<td></td>')
					.append(jQuery('<td>')
						.append(jQuery('<a href="#" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-plus-sign"></i> <?php echo $text_add_level; ?></a>')
							.click(function(){
								addLevel();
							
								return false;
							})
						)
					)
				);
			
				// auto levels
				tbody.append(jQuery('<tr>')
					.append('<td width="200"><?php echo $text_auto_levels; ?>:</td>')
					.append(jQuery('<td>')
						.append( self.render_btn_group( name + '[auto_levels]', typeof data == 'undefined' || data.auto_levels != '1' ? false : true ) )
					)
				);
			
				// show button
				tbody.append(jQuery('<tr>')
					.append('<td width="200"><?php echo $entry_show_button; ?></td>')
					.append(jQuery('<td>')
						.append( self.render_btn_group( name + '[show_button]', typeof data == 'undefined' || data.show_button != '1' ? false : true ) )
					)
				);
			} else if( type == 'tree' ) {
				// always show 'Go back to top' if possible
				tbody.append(jQuery('<tr>')
					.append('<td width="200"><?php echo $entry_always_show_go_back_to_top; ?></td>')
					.append(jQuery('<td>')
						.append( self.render_btn_group( name + '[show_go_back_to_top]', typeof data == 'undefined' || data.show_go_back_to_top != '1' ? false : true ) )
					)
				);
			}
			
			// collapsed
			tbody.append(jQuery('<tr>')
				.append('<td width="200"><?php echo $text_collapsed_by_default; ?>:</td>')
				.append(jQuery('<td>')
					.append( self.render_btn_collapsed( name + '[collapsed]', typeof data == 'undefined' ? '0' : data.collapsed ) )
				)
			);
			
			// sort
			tbody.append(jQuery('<tr>')
				.append('<td width="200"><?php echo $entry_sort_order; ?></td>')
				.append(jQuery('<td>')
					.append( self.createField( 'text', null, typeof data == 'undefined' ? '' : data.sort_order, {
						'name'	: name + '[sort_order]',
						'size'	: '3'
					}))
					.append( self.createField( 'hidden', null, type, {
						'name'	: name + '[type]'
					}))
				)
			);
			
			cnt.append(jQuery('<table class="table table-tbody" data-type="' + type + '">')
				.append(jQuery('<thead>')
					.append(jQuery('<tr>')
						.append(jQuery('<th colspan="2">')
							.append(jQuery('<div class="pull-left">')
								.append((function(){
									var $div = jQuery('<div class="input-group input-group-sm">')
										.append('<span class="input-group-addon">#' + types[type] + '</span>'),
										j = 0;
									
									for( var i in self._langs ) {
										if( typeof self._langs[i] == 'function' ) continue;
						
										$div.append( self.createField( 'text', null, typeof data == 'undefined' ? '' : ( typeof data.name == 'undefined' || typeof data.name[self._langs[i].language_id] == 'undefined' ? '' : data.name[self._langs[i].language_id] ), {
											'name'	: name + '[name][' + self._langs[i].language_id + ']',
											'class'	: 'form-control',
											'style'	: 'width:300px; margin: ' + ( j ? '2' : '0' ) + 'px 3px 0 0;',
											'placeholder' : '<?php echo $text_categories; ?>'
										})).append(' <img src="' + self.langImage( self._langs[i] ) + '" style="margin: ' + ( j ? '12px 0 10px' : '10px 0 8px' ) + ';">').append('<br>');
										
										j++;
									}
									
									return $div;
								})())
							)
							.append(jQuery('<a href="#" class="btn btn-danger btn-xs pull-right"><i class="glyphicon glyphicon-remove"></i></a>')
								.click(function(){
									jQuery(this).parent().parent().parent().parent().remove();
									
									return false;
								})
							)
						)
					)
				)
				.append( tbody )
			);
			
			if( typeof data != 'undefined' && data.levels != 'undefined' ) {
				for( var i in data.levels ) {
					if( typeof data.levels[i] == 'function' ) continue;
			
					addLevel( data.levels[i] );
				}
			}
			
			idx++;
		}
		
		for( var i in data ) {
			add( data[i].type, data[i] );
		}
		
		return box;
	},
	
	render_btn_group: function( name, enabled ) {
		var html = '';
		
		html += '<div class="btn-group" data-toggle="fm-buttons">';
		html += '<label class="btn btn-primary btn-xs' + ( enabled ? ' active' : '' ) + '" data-toggle="tooltip" title="<?php echo $text_yes; ?>">';
		html += '<input type="radio" name="' + name + '"' + ( enabled ? ' checked="checked"' : '' ) + ' value="1"><i class="fa fa-check"></i>';
		html += '</label>';
		html += '<label class="btn btn-primary btn-xs' + ( ! enabled ? ' active' : '' ) + '" data-toggle="tooltip" title="<?php echo $text_no; ?>">';
		html += '<input type="radio" name="' + name + '"' + ( ! enabled ? ' checked="checked"' : '' ) + ' value="0"><i class="fa fa-remove"></i>';
		html += '</label>';
		html += '</div>';
		
		return html;
	},
	
	render_btn_collapsed: function( name, value ) {
		var html = '';
		
		html += '<div class="btn-group" data-toggle="fm-buttons">';
		html += '<label class="btn btn-primary btn-xs' + ( value == '1' ? ' active' : '' ) + '" data-toggle="tooltip" title="<?php echo $text_yes; ?>">';
		html += '<input type="radio" name="' + name + '"' + ( value == '1' ? ' checked="checked"' : '' ) + ' value="1"><i class="fa fa-check"></i>';
		html += '</label>';
		html += '<label class="btn btn-primary btn-xs' + ( ! value || value == '0' ? ' active' : '' ) + '" data-toggle="tooltip" title="<?php echo $text_no; ?>">';
		html += '<input type="radio" name="' + name + '"' + ( ! value || value == '0' ? ' checked="checked"' : '' ) + ' value="0"><i class="fa fa-remove"></i>';
		html += '</label>';
		html += '<label class="btn btn-primary btn-xs' + ( value == 'pc' ? ' active' : '' ) + '" data-toggle="tooltip" title="<?php echo $text_pc; ?>">';
		html += '<input type="radio" name="' + name + '"' + ( value == 'pc' ? ' checked="checked"' : '' ) + ' value="pc"><i class="fa fa-desktop"></i>';
		html += '</label>';
		html += '<label class="btn btn-primary btn-xs' + ( value == 'mobile' ? ' active' : '' ) + '" data-toggle="tooltip" title="<?php echo $text_mobile; ?>">';
		html += '<input type="radio" name="' + name + '"' + ( value == 'mobile' ? ' checked="checked"' : '' ) + ' value="mobile"><i class="fa fa-phone"></i>';
		html += '</label>';
		html += '</div>';
		
		return html;
	},
	
	createContainer: function( id, type ) {
		var self	= this,
			cnt		= jQuery('<div class="cnt">'),
			tmp;
	
		if( typeof type == 'undefined' )
			type = id;
		
		tmp = jQuery('#tmp-' + self._row + '-' + type);
		
		if( tmp.length ) {
			cnt.append( tmp );
			tmp.removeAttr('style');
		}
		
		var placeholder = {
			'attribs' : '<?php echo $text_attribute_name; ?>',
			'options' : '<?php echo $text_option_name; ?>',
			'filters' : '<?php echo $text_filter_name; ?>'
		};
		
		return jQuery('<div id="tab-' + self._row + '-' + id + '" class="tab-pane">')
			.append((function(){
				<?php if( ! empty( $action_mfv ) ) { ?>
					if( type == 'vehicles' ) {
						return $('<a href="#" class="btn btn-xs btn-primary" style="float:right; margin: 4px 0;">')
							.html( '<i class="fa fa-truck"></i> <?php echo $text_go_to_mfv; ?>' )
							.click(function(){
								self.save( '<?php echo $text_loading_please_wait; ?>', function(){
									document.location = '<?php echo $action_mfv; ?>'.replace('&amp;','&');

									return false;
								});
								
								return false;
							});
					}
				<?php } ?>
		
				<?php if( ! empty( $action_mfl ) ) { ?>
					if( type == 'levels' ) {
						return $('<a href="#" class="btn btn-xs btn-primary" style="float:right; margin: 4px 0;">')
							.html( '<i class="fa fa-list"></i> <?php echo $text_go_to_mfl; ?>' )
							.click(function(){
								self.save( '<?php echo $text_loading_please_wait; ?>', function(){
									document.location = '<?php echo $action_mfl; ?>'.replace('&amp;','&');

									return false;
								});
								
								return false;
							});
					}
				<?php } ?>
				
				return '<a href="#" data-load-type="' + type + '" class="btn btn-xs btn-danger" style="float:right; margin: 4px 0;"><i class="glyphicon glyphicon-trash"></i> <?php echo $text_reset_to_default_values; ?></a><div class="clearfix"></div>';
			})())
			.append( cnt )
			.append((function(){
				if( type == 'vehicles' ) {
					return '<a href="#" data-load-type="vehicles" class="hide"></a>';
				} else if( type == 'levels' ) {
					return '<a href="#" data-load-type="levels" class="hide"></a>';
				}
			
				return '';
			})());
	},
	
	createScrollbox: function( id, type, name, items, key, values ) {
		var self	= this,
			cnt		= jQuery('<div class="scrollbox">'),
			k = 0, i;
			
		if( ! jQuery.isArray( values ) )
			values = [ values ];
			
		for( i in items ) {
			if( typeof items[i] == 'function' ) continue;
			
			var $div = jQuery('<div>')
				.addClass( k % 2 ? 'odd' : 'even' );
				
			switch( type ) {
				case 'checkbox' : {					
					$div.append( self.createField( 'checkbox', name, items[i][key], {
						'id'		: id + self._row,
						'checked'	: self.indexOf( values, items[i][key] ) > -1 ? true : false,
						'style'		: 'vertical-align: middle; margin: 0;'
					})).append( ' ' + items[i]['name'] );
					
					break;
				}
				case 'delete' : {
					$div.append( items[i] );
					$div.append( '<a class="btn btn-xs btn-danger pull-right"><i class="fa fa-remove"></i></a>' );
					$div.append( self.createField( 'hidden', name, i ) );
					
					break;
				}
			}
			
			cnt.append( $div );
				
			k++;
		}
		
		var $div = jQuery('<div>')
			.append( cnt );
		
		if( type == 'checkbox' ) {
			$div.append(jQuery('<a onclick="jQuery(this).parent().find(\':checkbox\').prop(\'checked\', true).trigger(\'change\');">')
				.text( '<?php echo $text_select_all; ?>' )
			)
			.append( ' / ' )
			.append(jQuery('<a onclick="jQuery(this).parent().find(\':checkbox\').prop(\'checked\', false).trigger(\'change\');">')
				.text( '<?php echo $text_unselect_all; ?>' )
			);
		}
			
		return $div;
	},
	
	/**
	 * Wewnętrzna funkcja wyszukiwania
	 *
	 * @param object|array arr
	 * @param string val
	 * @returns Number 
	 */
	indexOf: function( arr, val ) {
		for( var i in arr ) {
			if( typeof arr[i] == 'function' ) continue;
			
			if( arr[i] == val ) return i;
		}

		return -1;
	},
	
	/**
	 * Utwórz pole
	 *
	 * @param string type
	 * @param string name
	 * @param string value
	 * @param object attribs
	 * @returns jQuery
	 */
	createField: function( type, name, value, attribs ) {
		var self	= this,
			cnt;
			
		if( typeof value == 'undefined' ) {
			value = '';
		}
		
		function multiOptions( items, fn ) {
			for( var i = 0; i < items.length; i++ ) {
				if( typeof attribs['multiOptions'].items[i] == 'function' ) continue;
					
				var k = typeof attribs['multiOptions'].key != 'undefined' ? attribs['multiOptions'].items[i][attribs['multiOptions'].key] : attribs['multiOptions'].items[i][0],
					l = typeof attribs['multiOptions'].label != 'undefined' ? attribs['multiOptions'].items[i][attribs['multiOptions'].label] : attribs['multiOptions'].items[i][1];
				
				fn( k, l, k == value );
			}
		}
		
		switch( type ) {
			case 'select' : {
				cnt = jQuery('<select>');
				
				multiOptions( attribs['multiOptions'].items, function(k, l, selected){
					cnt.append(jQuery('<option>')
						.attr('value', k)
						.attr('selected', selected)
						.text(l)
					);
				});
				
				delete attribs['multiOptions'];
				
				break;
			}
			case 'radio_group' : {
				cnt = jQuery('<div class="btn-group" data-toggle="fm-buttons">');
				
				multiOptions( attribs['multiOptions'].items, function(k, l, selected){
					cnt.append(jQuery('<label class="btn btn-primary btn-xs' + ( selected ? ' active' : '' ) + '">')
						.append(jQuery('<input type="radio" style="display:none">')
							.attr('value', k)
							.attr('name', self._name + '_module' + name)
							.attr('checked', selected)
						)
						.append(l)
					);
				});
				
				delete attribs['multiOptions'];
				
				break;
			}
			default : {
				cnt = jQuery('<input>')
					.attr('type', type)
					.attr('value', value);
				
				break;
			}
		}
		
		if( type != 'radio_group' ) {
			if( name !== null ) {
				cnt.attr('name', self._name + '_module' + name);
			}

			for( var i in attribs ) {
				if( typeof attribs[i] == 'function' ) continue;

				cnt.attr( i, attribs[i] );
			}
		}
		
		return cnt;
	}
};

MFP._langs				= <?php echo json_encode( $languages ); ?>;
MFP._layouts			= <?php echo json_encode( $layouts ); ?>;
MFP._settings			= <?php echo json_encode( $settings ); ?>;
MFP._stores				= <?php echo json_encode( $stores ); ?>;
MFP._customerGroups		= <?php echo json_encode( $customerGroups ); ?>;

MFP.init( <?php echo json_encode( $modules ); ?> );
</script> 

<?php require DIR_TEMPLATE . 'module/' . $_name . '-footer.tpl'; ?>