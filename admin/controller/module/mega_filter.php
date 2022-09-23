<?php

/**
 * Mega Filter
 * 
 * @license Commercial
 * @author info@ocdemo.eu
 */
class ControllerModuleMegaFilter extends Controller {
	
	private static $_tmp_sort_parameters = NULL;
	
	/**
	 * List of errors
	 *
	 * @var array
	 */
	private $error			= array();
	
	private $_name			= 'mega_filter';
	
	private $_version		= '2.0.5.2';
	
	private $_cache_dir;
	
	private $_stores_list	= NULL;
	
	private $data = array();
	
	private $_mijoshop_update = array(
		'../../mijoshop/opencart.php' => array(
			'foreach ($modules as $module) {' => array(
				'$idx=0;',
				'$idxs=array();',
				'foreach( $modules as $k => $v ) {$idxs[] = $k;}',
				'foreach ($modules as $module) {',
				'$idx++;',
			),
			'if (isset($part[0]) && self::$config->get($part[0] . \'_status\') and $part[0] == $module_name) {' => array(
				'if (isset($part[0]) && self::$config->get($part[0] . \'_status\') and $part[0] == $module_name and $part[0] != \'mega_filter\') {'
			),
			'$setting_info    = MijoShop::get(\'utility\')->getModule($part[1]);' => array(
				'$setting_info    = MijoShop::get(\'utility\')->getModule($part[1]);',
				'if( $part[0] == \'mega_filter\' ) {',
					'$setting_info = $controller->config->get( \'mega_filter_module\' );',
					'$setting_info = $setting_info[$idxs[$idx-1]];',
					'$setting_info[\'_idx\'] = $idxs[$idx-1];',
				'}'
			)
		)
	);
	
	public function __construct($registry) {
		parent::__construct($registry);
		
		$this->_cache_dir = DIR_SYSTEM . 'cache_mfp';
		
		$this->data['HTTP_URL'] = '';
		$this->data['action_set_tooltip'] = $this->url->link('module/' . $this->_name . '/setTooltip', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_render_element'] = $this->url->link('module/' . $this->_name . '/render_element', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_remove_item'] = $this->url->link('module/' . $this->_name . '/remove_item', 'token=' . $this->session->data['token'], 'SSL');
	
		if( class_exists( 'MijoShop' ) ) {
			$this->data['HTTP_URL'] = HTTP_CATALOG . 'opencart/admin/';
		}
		
		$this->load->model('module/mega_filter');
	}
	
	private function _cacheWritable() {
		return is_dir( $this->_cache_dir ) && is_writable( $this->_cache_dir );
	}
	
	private function _mfDirWritable() {
		/* @var $css string */
		$css = DIR_SYSTEM . '../catalog/view/theme/default/stylesheet/mf';
		
		/* @var $js string */
		$js = DIR_SYSTEM . '../catalog/view/javascript/mf';
		
		return is_dir( $css ) && is_dir( $js ) && is_writable( $css ) && is_writable( $js );
	}

	/**
	 * Init
	 */
	private function _init( $tab ) {
		if( ! $this->config->get( $this->_name . '_settings' ) && $this->request->get['route'] != 'extension/extension/module/install' ) {
			$this->response->redirect($this->url->link('module/' . $this->_name . '/install', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		/* @var $lang array */
		$lang = $this->language->load('module/' . $this->_name);
		
		$this->data = array_merge($this->data, $lang);
		$this->data['__lang'] = $lang;
		
		// current tabaktywna zakładka
		$this->data['tab_active'] = $tab;
		
		// links of tabs
		$this->data['tab_layout_link']		= $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['tab_attributes_link']	= $this->url->link('module/' . $this->_name . '/attributes', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['tab_options_link']		= $this->url->link('module/' . $this->_name . '/options', 'token=' . $this->session->data['token'], 'SSL');
		
		if( $this->model_module_mega_filter->hasFilters() ) {
			$this->data['tab_filters_link']		= $this->url->link('module/' . $this->_name . '/filters', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		$this->model_module_mega_filter->createSettingsTable();
		
		$this->data['tab_settings_link']	= $this->url->link('module/' . $this->_name . '/settings', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['tab_seo_link']	= $this->url->link('module/' . $this->_name . '/seo', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['tab_about_link']		= $this->url->link('module/' . $this->_name . '/about', 'token=' . $this->session->data['token'], 'SSL');
		
		// links
		$this->data['action']	= $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL');
		$this->data['back']		= $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['_name']	= $this->_name;
		
		if( $this->config->get( 'mfilter_vehicle_version' ) && $this->config->get( 'mfilter_vehicle_license' ) ) {
			$this->data['action_mfv'] = $this->url->link('module/mfilter_vehicle', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		if( $this->config->get( 'mfilter_level_version' ) && $this->config->get( 'mfilter_level_license' ) ) {
			$this->data['action_mfl'] = $this->url->link('module/mfilter_level', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		// breacrumbs
		$this->data['breadcrumbs'] = array();
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link(version_compare( VERSION, '2.3.0.0', '>=' ) ? 'common/dashboard' : 'common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link(version_compare( VERSION, '2.3.0.0', '>=' ) ? 'extension/extension' : 'extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		// title
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->_messages();
		
		$curr_ver = $this->config->get('mfilter_version');
		
		// install/update
		if( ! $curr_ver || version_compare( $curr_ver, $this->_version, '<' ) || $this->_isOldMFilterPlus() ) {			
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			$stores = array(0);
			
			foreach( $this->model_setting_store->getStores() as $row ) {
				$stores[] = $row['store_id'];
			}
			
			// if update
			if( $curr_ver ) {
				// @since 2.0.4.4.5.2
				$this->model_module_mega_filter->updateDB();
			
				// @since 1.2.9.2
				if( $this->_writableCss() ) {						
					$this->_updateCss();
				}
			}
			////////////////////////////////////////////////////////////////////
			
			// @since 2.0.3.2
			$this->model_module_mega_filter->createUrlAliasTable();
			
			$this->model_module_mega_filter->changeTypeOfValueFieldInSettingTable();
			
			// add templates of MFP //////////////////////////////////////////////
			
			$add_routes = array(
				'Mega Filter PRO' => 'module/mega_filter/results',
				'Manufacturer info' => 'product/manufacturer/info'
			);
			
			foreach( $add_routes as $name => $route ) {
				if( ! $this->db->query( "SELECT COUNT(*) AS c FROM " . DB_PREFIX . "layout_route WHERE route LIKE '" . $this->db->escape( $route ) . "'")->row['c'] ) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "layout SET name='" . $this->db->escape( $name ) . "'");
					$layout_id = $this->db->getLastId();

					foreach( $stores as $store_id ) {
						$this->db->query("INSERT INTO " . DB_PREFIX . "layout_route SET layout_id='" . $layout_id . "', store_id='" . $store_id . "', route='" . $this->db->escape( $route ) . "'");
					}
				}
			}
			
			////////////////////////////////////////////////////////////////////
			
			foreach( $stores as $store_id ) {
				$this->model_setting_setting->editSetting('mfilter_version', array(
					'mfilter_version' => $this->_version
				), $store_id);
			}
			
			if( $tab != 'installprogress' ) {
				$this->_installMFilterPlus();
			}
			
			if( $curr_ver ) {
				/* @since v2.0.4.4 */
				$this->verifyLicense( $tab );
				
				if( NULL != ( $mlicense = $this->config->get( 'mfilter_license' ) ) ) {
					if( true !== ( $response = $this->activate( $mlicense['order_id'], $mlicense['email'] ) ) ) {
						if( $response ) {
							$this->session->data['error'] = $response;
						}
						
						$this->response->redirect($this->url->link('module/' . $this->_name . '/license', 'token=' . $this->session->data['token'], 'SSL'));
					}
				}
				
				$this->session->data['success'] = $this->language->get('success_updated');
			
				$this->response->redirect($this->url->link('module/' . $this->_name . '/about', 'token=' . $this->session->data['token'] . ( $this->isOCMod() ? '&refresh_ocmod_cache=1' : '' ), 'SSL'));
			}
		} else if( ! file_exists( DIR_SYSTEM . '../catalog/view/theme/default/template/module/mega_filter.tpl' ) ) {
			$this->_setErrors(array(
				'warning' => $this->language->get( 'error_missing_template_file' )
			));
		}
		
		if( is_readable( __FILE__ ) ) {
			// check if user copied files of template
			$files = glob( DIR_SYSTEM . '../catalog/view/theme/*/template/module/mega_filter.tpl' );
			$source = filemtime( DIR_SYSTEM . '../catalog/view/theme/default/template/module/mega_filter.tpl' );
			
			foreach( $files as $id => $file ) {
				$file = realpath( $file );
				$parts = explode( DIRECTORY_SEPARATOR, $file );
				
				array_pop( $parts ); // name of file
				array_pop( $parts ); // catalog 'module'
				array_pop( $parts ); // catalog 'template'
				
				$theme = array_pop( $parts );
				
				if( $theme == 'default' || ! is_readable( $file ) ) {
					unset( $files[$id] );
				} else {
					$time = filemtime( $file );
					
					if( $source - $time > 60 * 10 ) {
						$files[$id] = '<span style="margin-left:15px; display: inline-block;"> - /catalog/view/theme/<b>' . $theme . '</b>/template/module/mega_filter.tpl</span>';
					} else {
						unset( $files[$id] );
					}
				}
			}
			
			if( $files ) {
				$this->_setErrors(array(
					'warning' => sprintf( $this->language->get( 'error_upgrade_template_file' ), implode( '<br>', $files ) )
				));
			}
		}
		
		if( class_exists( 'MijoShop' ) && version_compare( $this->config->get('mfilter_mijoshop'), $curr_ver, '<' ) ) {
			$warnings = array();
			
			foreach( $this->_mijoshop_update as $file => $changes ) {
				$file = realpath( DIR_SYSTEM . $file );
				
				if( file_exists( $file ) && is_readable( $file ) ) {
					$tmp = NULL;
					
					if( file_exists( $file . '_backup_mf' ) ) {
						if( is_readable( $file . '_backup_mf' ) ) {
							$tmp = file_get_contents( $file . '_backup_mf' );
						} else {
							$warnings[] = sprintf( 'No permission to read the file "%s"', $file . '_backup_mf' );
						}
					} else {
						$tmp = file_get_contents( $file );
					}
					
					if( $tmp !== NULL ) {
						foreach( $changes as $search => $replace ) {
							$replace = implode( "\n", $replace );

							if( mb_strpos( $tmp, $search, 0, 'utf-8' ) !== false ) {
								$tmp = str_replace( $search, $replace, $tmp );
							} else if( mb_strpos( $tmp, $replace, 0, 'utf-8' ) === false ) {
								$warnings[] = sprintf( 'In the file "%s" not found string "%s"', $file, $search );
							}
						}
					}
					
					if( ! $warnings ) {
						if( ! is_writable( dirname( $file ) ) ) {
							$warnings[] = sprintf( 'No permission to create a copy of the file "%s" in directory "%s"', $file, dirname( $file ) );
						} else if( ! is_writable( $file ) ) {
							$warnings[] = sprintf( 'No permission to modify the file "%s"', $file );
						} else if( $tmp !== NULL ) {
							if( ! file_exists( $file . '_backup_mf' ) ) {
								copy( $file, $file . '_backup_mf' );
							}
							
							file_put_contents( $file, $tmp );
						}
					}
				}
			}
			
			if( empty( $warnings ) ) {
				$this->_saveSettings('mfilter_mijoshop', array(
					'mfilter_mijoshop' => $this->_version
				));
			} else {
				$warnings[] = 'You need to manually find and replace the following strings:';
				$warnings[] = '';
				
				foreach( $this->_mijoshop_update as $file => $changes ) {
					$file = realpath( DIR_SYSTEM . $file );
					
					foreach( $changes as $search => $replace ) {
						$warnings[] = sprintf( 'String: <pre>%s</pre> replace to: <pre>%s</pre> in file <b>%s</b>', $search, implode( "\n", $replace ), $file );
						$warnings[] = '';
					}
				}
				
				$warnings[] = sprintf( 'Remember to make backup your files! <a href="%s">Click here when you done</a>', $this->url->link('module/' . $this->_name . '/mijoshop_manually', 'token=' . $this->session->data['token'], 'SSL') );
				
				$this->_setErrors(array(
					'warning' => implode( '<br />', $warnings )
				));
			}
		}
		
		/* @since v2.0.4.4 */
		$this->verifyLicense( $tab );
		
		$this->data['header'] = $this->load->controller('common/header');
		$this->data['column_left'] = $this->load->controller('common/column_left');
		$this->data['footer'] = $this->load->controller('common/footer');
		
		if( NULL != ( $mlicense = $this->config->get( 'mfilter_license' ) ) ) {
			if( ! file_exists( DIR_SYSTEM . 'library/mfilter_core.php' ) || strpos( file_get_contents( DIR_SYSTEM . 'library/mfilter_core.php' ), 'MegaFilterCore' ) === false ) {
				$this->_setErrors(array(
					'warning' => 'Detected missing files - please <a href="' . $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'] . '&reactivate=1', 'SSL') . '">click here</a> to fix problem',
				));
				
				if( ! empty( $this->request->get['reactivate'] ) ) {
					$this->activate( $mlicense['order_id'], $mlicense['email'] );
					
					$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
				}
			} else if( NULL != ( $isOCMod = $this->isOCMod() ) && NULL != ( $isVQMod = $this->isVQMod() ) ) {
				$this->_setErrors(array(
					'warning' => sprintf('
						You can\'t use version VQMod and OCMod in the same time. 
						Please remove one type of the following files:<br /><br />
							1) <strong>VQMod</strong><br />
								<code>%s</code>%s
								
								<br /><br />------------------ <strong>OR</strong> ------------------<br /><br />
								
							2) <strong>OCMod</strong><br />
								<code>%s</code>%s
						', 
						implode( '</code><br /><code>', $isVQMod ), 
						count( $isVQMod ) > 1 && count( $isOCMod ) == 1 ? '<br /><br /><strong>Notice:</strong> It seems that you have installed some fix in VQMod so you shouldn\'t use OCMod' : '',
						implode( '</code><br /><code>', $isOCMod ),
						count( $isOCMod ) > 1 && count( $isVQMod ) == 1 ? '<br /><br /><strong>Notice:</strong> It seems that you have installed some fix in OCMod so you shouldn\'t use VQMod' : ''
					)
				));
				
				$this->session->data['mfp_refresh_ocmod_cache'] = true;
			} else if( ! empty( $this->request->get['refresh_ocmod_cache'] ) ) {
				$this->data['refresh_ocmod_cache'] = array(
					$this->url->link('extension/modification/clear', 'token=' . $this->session->data['token'], 'SSL'),
					$this->url->link('extension/modification/refresh', 'token=' . $this->session->data['token'], 'SSL')
				);
			} else if( ! empty( $this->session->data['mfp_refresh_ocmod_cache'] ) ) {
				unset( $this->session->data['mfp_refresh_ocmod_cache'] );
				
				$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'] . '&refresh_ocmod_cache=1', 'SSL'));
			}
		}
	}
	
	/* @since v2.0.4.4 */
	private function verifyLicense( $tab ) {
		if( isset( $this->request->get['route'] ) && in_array( $this->request->get['route'], array( 'extension/extension/module/install', 'extension/extension/module/uninstall' ) ) ) {
			return;
		}
		
		if( ! in_array( $tab, array( 'license', 'installprogress' ) ) && ! $this->config->get('mfilter_license') ) {
			$this->response->redirect($this->url->link('module/' . $this->_name . '/license', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	public function mijoshop_manually() {
		$this->_saveSettings('mfilter_mijoshop', array(
			'mfilter_mijoshop' => $this->_version
		));
		
		$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
	}
	
	private function _saveSettings( $group, $data ) {
		if( $this->_stores_list === NULL ) {
			$this->load->model('setting/store');

			$this->_stores_list = array(0);

			foreach( $this->model_setting_store->getStores() as $row ) {
				$this->_stores_list[] = $row['store_id'];
			}
		}
		
		$this->load->model('setting/setting');
		
		foreach( $this->_stores_list as $store_id ) {
			$this->model_setting_setting->editSetting($group, $data, $store_id);
		}
	}
	
	private function _hasMFilterPlus() {
		if( ! file_exists( DIR_SYSTEM . 'library/mfilter_plus.php' ) ) {
			return false;
		}
		
		return true;
	}
	
	private function _isOldMFilterPlus() {		
		if( ! $this->_hasMFilterPlus() ) {
			return false;
		}
		
		$curr_ver = $this->config->get('mfilter_plus_version');
		
		require_once DIR_SYSTEM . 'library/mfilter_plus.php';
		
		return version_compare( $curr_ver, Mfilter_Plus::getInstance( $this )->version(), '<' );
	}
	
	private function _messages() {		
		// notifications
		if( isset( $this->session->data['success'] ) ) {
			$this->data['_success'] = $this->session->data['success'];
			
			unset( $this->session->data['success'] );
		}
		
		if( isset( $this->session->data['error'] ) ) {
			$this->_setErrors(array(
				'warning' => $this->session->data['error']
			));
			
			unset( $this->session->data['error'] );
		}
	}
	
	public function get_data() {
		$json = array();
		
		if( isset( $this->request->get['mf_id'] ) ) {
			$json = $this->model_module_mega_filter->getSettings( $this->request->get['mf_id'] );
		}
		
		// Categories //////////////////////////////////////////////////////////
		
		$json['__categoriesNames'] = array();
		
		$categories_ids = array();
		
		if( ! empty( $json['categories'] ) ) {
			foreach( $json['categories'] as $category_id ) {
				if( ! empty( $category_id['root_category_id'] ) ) {
					$categories_ids[] = (int) $category_id['root_category_id'];
				}
			}
		}
			
		if( ! empty( $json['category_id'] ) ) {				
			foreach( $json['category_id'] as $category_id ) {
				$categories_ids[] = $category_id;
			}
		}
		
		if( ! empty( $json['hide_category_id'] ) ) {			
			foreach( $json['hide_category_id'] as $category_id ) {
				$categories_ids[] = $category_id;
			}
		}
		
		if( ! empty( $categories_ids ) ) {			
			foreach( $this->model_module_mega_filter->getCategoriesByIds( $categories_ids ) as $category ) {
				$json['__categoriesNames'][$category['category_id']] = ( $category['path'] ? $category['path'] . ' &gt; ' : '' ) . $category['name'];
			}
		}
		
		// Show in Categories //////////////////////////////////////////////////
		
		$json['__categories'] = array();
			
		if( ! empty( $json['category_id'] ) ) {				
			foreach( $json['category_id'] as $category_id ) {
				if( ! isset( $json['__categoriesNames'][$category_id] ) ) continue;
				
				$json['__categories'][$category_id] = $json['__categoriesNames'][$category_id];
			}
		}
		
		// Hide in Categories //////////////////////////////////////////////////		
		$json['__hideCategories'] = array();
		
		if( ! empty( $json['hide_category_id'] ) ) {			
			foreach( $json['hide_category_id'] as $category_id ) {
				if( empty( $json['__categoriesNames'][$category_id] ) ) continue;
				
				$json['__hideCategories'][$category_id] = $json['__categoriesNames'][$category_id];
			}
		}
		
		////////////////////////////////////////////////////////////////////////
		
		echo json_encode( $json );
		
		die();
	}
	
	public function remove_data() {
		if( isset( $this->request->get['mf_id'] ) && $this->checkPermission() ) {
			$this->model_module_mega_filter->removeSettings( $this->request->get['mf_id'] );
		}
		
		die();
	}
	
	private function _save( & $data, & $store ) {
		foreach( $data as $k => $v ) {
			if( is_array( $v ) ) {
				$tmp = isset( $store[$k] ) ? $store[$k] : array();
				
				$this->_save( $v, $tmp );
				
				$store[$k] = $tmp;
			} else {
				$store[$k] = $v;
			}
		}
	}
	
	public function save_data() {
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$idx	= (int) $this->request->get['mf_idx'];
			$count	= (int) $this->request->get['mf_count'];
			$pager	= (bool) $this->request->get['mf_pager'];
			$mf_id	= (int) $this->request->get['mf_id'];
			
			if( ! $idx || ! isset( $this->session->data['mf_data_to_save'] ) ) {
				$settings	= $this->config->get($this->_name . '_settings' );
				
				$this->session->data['mf_data_to_save'] = array(
					'attribs'		=> (array) $this->config->get( $this->_name . '_attribs' ),
					'options'		=> (array) $this->config->get( $this->_name . '_options' ),
					'base_attribs'	=> (array) $settings['attribs'],
					'configuration'	=> array()
				);
				
				if( $this->model_module_mega_filter->hasFilters() ) {
					$this->session->data['mf_data_to_save']['filters'] = (array) $this->config->get( $this->_name . '_filters' );
				}
				
				if( NULL != ( $module = $this->model_module_mega_filter->getSettings( $mf_id ) ) ) {
					if( isset( $module['attribs'] ) ) {
						$this->session->data['mf_data_to_save']['attribs'] = $module['attribs'];
					}
					
					if( isset( $module['options'] ) ) {
						$this->session->data['mf_data_to_save']['options'] = $module['options'];
					}
					
					if( isset( $module['filters'] ) ) {
						$this->session->data['mf_data_to_save']['filters'] = $module['filters'];
					}
					
					if( isset( $module['base_attribs'] ) ) {
						$this->session->data['mf_data_to_save']['base_attribs'] = $module['base_attribs'];
					}
					
					if( isset( $module['configuration'] ) ) {
						$this->session->data['mf_data_to_save']['configuration'] = $module['configuration'];
					}
				}
			}
			
			$this->_save( $this->request->post[$this->_name.'_module'], $this->session->data['mf_data_to_save'] );
			
			if( ! $pager && $idx == $count ) {				
				$settings = $this->config->get( $this->_name . '_settings' );
				
				if( empty( $this->session->data['mf_data_to_save']['layout_id'] ) ) {
					$this->session->data['mf_data_to_save']['layout_id'] = array();
				}
				
				if( ! in_array( $settings['layout_c'], $this->session->data['mf_data_to_save']['layout_id'] ) ) {
					$this->session->data['mf_data_to_save']['category_id'] = array();
				}
			
				if( empty( $this->session->data['mf_data_to_save']['store_id'] ) ) {
					$this->session->data['mf_data_to_save']['store_id'] = array( 0 );
				}
				
				if( NULL == ( $data = $this->model_module_mega_filter->getSettings( $mf_id ) ) ) {
					$data = array();
				}
				
				$this->model_module_mega_filter->saveSettings( $mf_id, $this->session->data['mf_data_to_save'] );
				
				$this->db->query("
					DELETE FROM 
						`" . DB_PREFIX . "layout_module` 
					WHERE 
						`code` REGEXP '^mega_filter." . $mf_id . "$'
				");
				
				if( ! empty( $this->session->data['mf_data_to_save']['layout_id'] ) ) {
					foreach( $this->session->data['mf_data_to_save']['layout_id'] as $layout_id ) {
						$this->db->query("
							INSERT INTO 
								`" . DB_PREFIX . "layout_module` 
							SET
								`layout_id` = '" . (int)$layout_id . "',
								`code` = 'mega_filter." . (int)$mf_id . "',
								`position` = '" . $this->db->escape( $this->session->data['mf_data_to_save']['position'] ) . "',
								`sort_order` = '" . $this->db->escape( $this->session->data['mf_data_to_save']['sort_order'] ) . "'
						");
					}
				}
				
				unset( $this->session->data['mf_data_to_save'] );
				
				if( $this->_writableCss() ) {
					$this->_updateCss();
				}
				
				$this->_clearCacheByIdx( $mf_id );
			}
		}
		
		die();
	}
	
	private function _clearCacheByIdx( $idx ) {
		if( $this->_cacheWritable() && NULL != ( $files = glob($this->_cache_dir . '/idx.' . $idx . '.*') ) ) {
			foreach( $files as $file ) {
				if( strlen( basename( $file ) ) > 32 ) {
					@ unlink( $file );
				}
			}
		}
	}
	
	/**
	 * Main settings
	 */
	public function index() {
		$this->_init( $this->_name );
		
		// load models
		$this->load->model('design/layout');
		$this->load->model('localisation/language');
		$this->load->model('design/layout');
		$this->load->model('catalog/category');
		$this->load->model('setting/store');
		
		$settings = $this->config->get( $this->_name . '_settings' );
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$modules = $this->model_module_mega_filter->getAllSettings();
		
		$this->_setParams(array(
			'modules'		=> $modules
		), array());
		
		// parameters
		$this->data['token']		= $this->session->data['token'];
		$this->data['layouts']		= $this->model_design_layout->getLayouts();
		$this->data['languages']	= $this->model_localisation_language->getLanguages();		
		$this->data['layouts']		= $this->model_design_layout->getLayouts();
		$this->data['settings']		= $settings;
		
		// Stores //////////////////////////////////////////////////////////////
		
		$this->data['stores'][] = array(
			'store_id' => 0,
			'name'     => $this->config->get('config_name') . $this->language->get('text_default')
		);
				
		foreach( $this->model_setting_store->getStores() as $result ) {
			$this->data['stores'][] = array(
				'store_id' => $result['store_id'],
				'name'     => $result['name']
			);
		}
		
		// Groups of customers /////////////////////////////////////////////////
		
		if( version_compare( VERSION, '2.1.0.0', '>=' ) ) {
			$this->load->model('customer/customer_group');
			
			$customerGroups = $this->model_customer_customer_group->getCustomerGroups(array());
		} else {
			$this->load->model('sale/customer_group');
			
			$customerGroups = $this->model_sale_customer_group->getCustomerGroups(array());
		}
		
		$this->data['customerGroups'] = array();
		
		foreach( $customerGroups as $result ) {
			$this->data['customerGroups'][] = array(
				'customer_group_id' => $result['customer_group_id'],
				'name' => $result['name']
			);
		}
		
		////////////////////////////////////////////////////////////////////////
		
		$this->data['action_ldv']			= $this->url->link('module/' . $this->_name . '/ldv', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_save_data']		= $this->url->link('module/' . $this->_name . '/save_data', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_get_data']		= $this->url->link('module/' . $this->_name . '/get_data', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_remove_data']	= $this->url->link('module/' . $this->_name . '/remove_data', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_on_off_all']	= $this->url->link('module/' . $this->_name . '/on_off_all', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_remove_item']	= $this->url->link('module/' . $this->_name . '/remove_item', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->checkLatestVersion();
				
		$this->response->setOutput( $this->load->view('module/mega_filter.tpl', $this->data) );
	}
	
	public function render_element() {
		require_once DIR_TEMPLATE . 'module/mega_filter-fn.tpl';
		
		/* @var $data array */
		$data = $this->request->post;
		
		$data['lang'] = $this->language->load('module/' . $this->_name);
		
		/* @var $idx int */
		$idx = $this->request->post['IDX'];
		
		/* @var $type string */
		$type = $this->request->post['_type'];
		
		$data['_values'] = array();
		
		$config = $this->config->get($this->_name . '_' . $type);
		
		if( $idx ) {
			$config2 = $this->model_module_mega_filter->getSettings( $idx );
			
			if( ! empty( $config2[$type]['default'] ) ) {
				$config = $config2[$type];
			}
		}
			
		if( ! empty( $config['default'] ) ) {
			$data['_values'] = $config['default'];
		}
		
		$this->response->setOutput(mf_render_element($type, $data));
	}
	
	protected function __keys( $items ) {
		if( empty( $items ) ) {
			return array();
		}
		
		/* @var $keys array */
		$keys = array();
		
		foreach( $items as $k => $v ) {
			if( $k == 'default' || $k == 'default_group' ) continue;
			
			if( ! empty( $v['items'] ) && is_array( $v['items'] ) ) {
				foreach( $v['items'] as $k2 => $v2 ) {
					$keys[] = $k2;
				}
			} else {
				$keys[] = $k;
			}
		}
		
		return $keys;
	}
	
	protected function toSelect( $type, $idx = 0 ) {
		/* @var $list array */
		$list = array();
		
		/* @var $keys array */
		$keys = array();
		
		if( $idx ) {
			$keys = $this->model_module_mega_filter->getSettings( $idx );
			
			if( $type == 'attribs_group' ) {
				$keys = empty( $keys['attribs']['default_group'] ) ? array() : array_keys( $keys['attribs']['default_group'] );
			} else {
				$keys = empty( $keys[$type] ) ? array() : $this->__keys( $keys[$type] );
			}
		} else {
			$keys = $this->__keys( $this->config->get($this->_name . '_' . $type) );
		}
		
		if( $type == 'attribs' ) {
			foreach( $this->model_module_mega_filter->getAttributes() as $attribute ) {
				$list[] = array(
					'label' => $attribute['name'] . ' [' . $attribute['attribute_group'] . ']',
					'name' => $attribute['name'],
					'group' => $attribute['attribute_group'],
					'group_id' => $attribute['attribute_group_id'],
					'id' => $attribute['attribute_id']
				);
			}
		} else if( $type == 'attribs_group' ) {
			foreach( $this->model_module_mega_filter->getAttributesGroup() as $attribute_group ) {
				$list[] = array(
					'label' => $attribute_group['name'],
					'name' => $attribute_group['name'],
					'id' => $attribute_group['attribute_group_id']
				);
			}
		} else if( $type == 'options' ) {
			foreach( $this->model_module_mega_filter->getOptions() as $option ) {
				$list[] = array(
					'label' => $option['name'],
					'name' => $option['name'],
					'id' => $option['option_id'],
					'type' => $option['type']
				);
			}
		} else if( $type == 'filters' ) {
			foreach( $this->model_module_mega_filter->getFilters() as $filter ) {
				$list[] = array(
					'label' => $filter['name'],
					'name' => $filter['name'],
					'id' => $filter['filter_group_id']
				);
			}
		}
		
		foreach( $list as $k => $v ) {
			if( in_array( $v['id'], $keys ) ) {
				$list[$k]['disabled'] = 'disabled';
				$list[$k]['subtext'] = $this->language->get( 'text_this_item_is_already_added' );
			}
		}
		
		return $list;
	}
	
	public function remove_item() {
		if( ! $this->hasPermission() ) return;
		
		/* @var $type string */
		$type = $this->request->post['type'];
		
		/* @var $id int */
		$id = $this->request->post['id'];
		
		/* @var $idx int */
		$idx = isset( $this->request->post['idx'] ) ? $this->request->post['idx'] : null;
		
		/* @var $config array */
		$config = $idx ? $this->model_module_mega_filter->getSettings( $idx ) : $this->config->get($this->_name . '_' . $type);
		
		/* @var $values array */
		$values = & $config;
		
		if( $idx ) {
			if( $type == 'attribs_group' ) {
				if( ! isset( $config['attribs']['default_group'] ) ) {
					$config['attribs']['default_group'] = array();
				}
				
				$values = & $config['attribs']['default_group'];
			} else {
				$values = & $values[$type];
			}
		}
		
		if( $type == 'attribs' ) {
			foreach( $values as $k => $v ) {
				if( ! empty( $v['items'] ) ) {
					foreach( $v['items'] as $k2 => $v2 ) {
						if( $k2 == $id ) {
							unset( $values[$k]['items'][$k2] );

							break;
						}
					}
				}
				
				if( $k != 'default' && $k != 'default_group' && empty( $values[$k]['items'] ) ) {
					unset( $values[$k] );
				}
			}
		} else if( in_array( $type, array( 'options', 'filters', 'attribs_group' ) ) ) {
			unset( $values[$id] );
		}
		
		if( $idx ) {			
			$this->model_module_mega_filter->saveSettings( $idx, $config );
		} else {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			// main store
			$this->model_setting_setting->editSetting($this->_name . '_' . $type, array( $this->_name . '_' . $type => $values ));

			// other stores		
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($this->_name . '_' . $type, array( $this->_name . '_' . $type => $values ), $result['store_id']);
			}
		}
	}
	
	public function ldv() {
		/* @var $lang array */
		$lang = $this->language->load('module/' . $this->_name);
		
		$this->data = array_merge($this->data, $lang);
		$this->data['__lang'] = $lang;
		
		$this->data['_name']	= $this->_name;
		$this->data['name']		= $this->request->get['name'];
		$this->data['type']		= $this->request->get['type'];
		$this->data['IDX']		= $this->request->get['idx'];
		$this->data['action']	= '';
		
		$this->load->model('localisation/language');
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->data['mfp_plus_version'] = $this->_hasMFilterPlus();
		$this->data['tagsSupport'] = $this->data['mfp_plus_version'] && version_compare( $this->config->get('mfilter_plus_version'), '1.2.2', '>=' );
		
		/* @var $page int */
		$page	= isset( $this->request->get['page'] ) ? $this->request->get['page'] : 1;		
		
		/* @var $limit int */
		$limit	= 100;
		
		/* @var $filter array */
		$filter	= array(
			'only_ids' => array(),
			'start' => ( $page - 1 ) * $limit,
			'limit' => $limit
		);
			
		/* @var $filterGroup array */
		$filterGroup = array();
		
		/* @var $type string */
		$type = $this->data['type'];
		
		/* @var $idx int */
		$idx = $this->data['IDX'];
		
		switch( $type ) {
			case 'base_attribs' : {
				$settings	= $this->config->get($this->_name . '_settings' );
				$this->data['base_attribs'] = $settings['attribs'];
				
				break;
			}
			case 'options'	:
			case 'filters'	:
			case 'attribs'	: {
				$this->data[$type] = $this->config->get($this->_name . '_' . $type);
				
				if( $type == 'attribs' ) {
					$this->data[$type.'_group'] = $this->config->get($this->_name . '_' . $type . '_group');
				}
				
				$this->data[$type.'ToSelect'] = $this->toSelect( $type, empty( $this->request->get['mf_default'] ) ? $idx : 0 );
				$this->data[$type.'GroupToSelect'] = $this->toSelect( $type . '_group', empty( $this->request->get['mf_default'] ) ? $idx : 0 );
				
				break;
			}
			case 'configuration': $this->data['configuration']	= $this->config->get($this->_name . '_settings' ); break;
			case 'vehicles'		: $this->data['vehicles']		= $this->config->get($this->_name . '_vehicles' ); break;
			case 'levels'		: $this->data['levels']			= $this->config->get($this->_name . '_levels' ); break;
		}
		
		if( ! empty( $this->request->get['mf_default'] ) && $this->hasPermission() ) {
			$data = $this->model_module_mega_filter->getSettings( $idx );
			
			$data[$type] = in_array( $type, array( 'attribs', 'options', 'filters' ) ) ? $this->data[$type] : array();
			
			if( $type == 'attribs' ) {
				$data[$type.'_group'] = $this->data[$type.'_group'];
			}
			
			$this->model_module_mega_filter->saveSettings( $idx, $data );
		} else if( empty( $this->request->get['mf_default'] ) && NULL != ( $module = $this->model_module_mega_filter->getSettings( $idx ) ) ) {
			if( isset( $module[$type] ) ) {
				$this->data[$type] = $module[$type];
			}
			
			if( $type == 'attribs' ) {
				$this->data[$type.'_group'] = isset( $module[$type]['default_group'] ) ? $module[$type]['default_group'] : array();
			}
		}

		if( ! empty( $this->data[$type] ) ) {
			if( $type == 'attribs' ) {
				foreach( $this->data[$type] as $v ) {
					if( ! empty( $v['items'] ) ) {
						$filter['only_ids'] = array_merge( $filter['only_ids'], array_keys( $v['items'] ) );
					}
				}
				
				$filterGroup['only_ids'] = ! empty( $this->data[$type.'_group'] ) ? array_keys( $this->data[$type.'_group'] ) : array();
			} else if( in_array( $type, array( 'options', 'filters' ) ) ) {
				foreach( array_keys( $this->data[$type] ) as $v ) {
					if( is_numeric( $v ) ) {
						$filter['only_ids'][] = (int) $v;
					}
				}
			}
		}
		
		if( empty( $filter['only_ids'] ) ) {
			$filter['only_ids'][] = 0;
		}
		
		if( empty( $filterGroup['only_ids'] ) ) {
			$filterGroup['only_ids'][] = 0;
		}
		
		$total = NULL;
		
		if( $type == 'options' ) {
			$this->data['optionItems']	= $this->model_module_mega_filter->getOptions( $filter );
			$total = $this->model_module_mega_filter->getTotalOptions( $filter );
		} else if( $this->model_module_mega_filter->hasFilters() && $type == 'filters' ) {
			$this->data['filterItems'] = $this->model_module_mega_filter->getFilters( $filter );
			$total = $this->model_module_mega_filter->getTotalFilters( $filter );
		} else if( $this->data['type'] == 'attribs' ) {
			$this->data['items']	= $this->_getAttributes( $filter );
			$total					= $this->model_module_mega_filter->getTotalAttributes( $filter );
			
			$this->data['itemsGroup']		= $this->model_module_mega_filter->getAttributesGroup( $filterGroup );
			$this->data['paginationGroup']	= $this->pagination( $this->model_module_mega_filter->getTotalAttributesGroup( $filterGroup ), $page, $limit, 'module/mega_filter/ldv' );
		}
		
		if( $total !== NULL ) {
			$this->data['pagination'] = $this->pagination( $total, $page, $limit, 'module/mega_filter/ldv' );
		}
		
		$this->response->setOutput( $this->load->view('module/mega_filter_ldv.tpl', $this->data) );
	}
	
	private function pagination( $total, $page, $limit, $route, $url = '' ) {
		$pagination = new Pagination();
		$pagination->total = $total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link($route, 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
		
		return $pagination->render();
	}
	
	private function _getAttributes( $data = array() ) {
		$items = array();
		
		foreach( $this->model_module_mega_filter->getAttributes( $data ) as $attribute ) {
			$items[$attribute['attribute_group_id']]['name']		= $attribute['attribute_group'];
			$items[$attribute['attribute_group_id']]['childs'][]	= $attribute;
		}
		
		return $items;
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Settings of attributes
	 */
	public function attributes() {
		$this->_init( 'attributes' );
		
		$page = isset( $this->request->get['page'] ) ? $this->request->get['page'] : 1;
		$config = (array) $this->config->get($this->_name . '_attribs');
		$configGroup = (array) $this->config->get($this->_name . '_attribs_group');
		$limit = 100;
		
		$this->data['action']	= $this->url->link('module/' . $this->_name . '/attributes', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL');
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			if( isset( $this->request->post[$this->_name.'_attribs']['default_group'] ) ) {
				// main store
				$this->model_setting_setting->editSetting($this->_name . '_attribs_group', array( $this->_name . '_attribs_group' => $this->request->post[$this->_name.'_attribs']['default_group'] ));

				// other stores		
				foreach( $this->model_setting_store->getStores() as $result ) {
					$this->model_setting_setting->editSetting($this->_name . '_attribs_group', array( $this->_name . '_attribs_group' => $this->request->post[$this->_name.'_attribs']['default_group'] ), $result['store_id']);
				}
				
				unset( $this->request->post[$this->_name.'_attribs']['default_group'] );
			}
			
			if( ! empty( $this->request->post[$this->_name.'_attribs'] ) ) {
				foreach( $this->request->post[$this->_name.'_attribs'] as $k => $v ) {
					if( $k == 'default' || $k == 'default_group' ) {
						$config[$k] = $v;
					} else {
						foreach( $v['items'] as $k2 => $v2 ) {
							$config[$k]['items'][$k2] = $v2;
						}
					}
				}
				
				$ids = $this->model_module_mega_filter->getAttributesIds();
				
				foreach( $config as $id_g => $conf_g ) {
					if( isset( $config[$id_g]['items'] ) ) {
						foreach( $config[$id_g]['items'] as $id => $conf ) {
							if( ! isset( $ids[$id] ) ) {
								unset( $config[$id_g]['items'][$id] );
							}
						}
					}
					
					if( $id_g != 'default' && empty( $config[$id_g]['items'] ) ) {
						unset( $config[$id_g] );
					}
				}
			}
			
			// main store
			$this->model_setting_setting->editSetting($this->_name . '_attribs', array( $this->_name . '_attribs' => $config ));
			
			// other stores		
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($this->_name . '_attribs', array( $this->_name . '_attribs' => $config ), $result['store_id']);
			}
				
			if( ! empty( $this->request->get['ajax_save'] ) ) {
				return;
			} else {
				$this->session->data['success'] = $this->language->get('text_success');
				
				$this->response->redirect($this->url->link('module/' . $this->_name . '/attributes', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL'));
			}
		}
		
		/* @var $filter array */
		$filter = array(
			'only_ids' => array(),
			'start' => ( $page - 1 ) * $limit,
			'limit' => $limit
		);
		
		/* @var $filterGroup array */
		$filterGroup = $filter;
		
		foreach( $config as $k => $v ) {
			if( $k != 'default' ) {
				$filter['only_ids'] = array_merge( $filter['only_ids'], array_keys( $v['items'] ) );
			}
		}
		
		$filterGroup['only_ids'] = array_keys( $configGroup );
		
		if( ! $filter['only_ids'] ) {
			$filter['only_ids'][] = 0;
		}
		
		if( ! $filterGroup['only_ids'] ) {
			$filterGroup['only_ids'][] = 0;
		}
		
		$this->load->model('tool/image');
		$this->load->model('catalog/attribute_group');
		$this->load->model('localisation/language');
		
		$this->data['items'] = $this->_getAttributes( $filter );
		$this->data['attribsToSelect'] = $this->toSelect('attribs');
		
		$this->data['itemsGroup'] = $this->model_module_mega_filter->getAttributesGroup( $filterGroup );
		$this->data['attribsGroupToSelect'] = $this->toSelect('attribs_group');
		
		if( ! $this->data['items'] && $page > 1 ) {
			$filter['start'] = 0;
			$page = 1;
			
			$this->data['items'] = $this->_getAttributes( $filter );
		}
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$this->data['token'] = $this->session->data['token'];
		$this->data['attribs'] = $config;
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->data['attribGroups'] = $this->model_catalog_attribute_group->getAttributeGroups(array());
		$this->data['action_attribs_by_group'] = $this->url->link('module/' . $this->_name . '/getAttribsByGroupAsJson', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_values_by_attrib'] = $this->url->link('module/' . $this->_name . '/getAttribsValuesByAttribAsJson', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_attribs_save'] = $this->url->link('module/' . $this->_name . '/attribsSave', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_attribs_reset'] = $this->url->link('module/' . $this->_name . '/attribsReset', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['pagination'] = $this->pagination($this->model_module_mega_filter->getTotalAttributes( $filter ), $page, $limit, 'module/mega_filter/attributes');
		$this->data['paginationGroup'] = $this->pagination($this->model_module_mega_filter->getTotalAttributesGroup( $filter ), $page, $limit, 'module/mega_filter/attributes');
		
		$this->response->setOutput( $this->load->view('module/mega_filter_attributes.tpl', $this->data) );
	}
	
	public function attribsReset() {
		if( ! empty( $this->request->post['attr_id'] ) && ! empty( $this->request->post['type'] ) && ! empty( $this->request->post['lang_id'] ) ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			$attr_id = (int)$this->request->post['attr_id'];
			$lang_id = (int)$this->request->post['lang_id'];
			$type = (string)$this->request->post['type'];
			
			switch( $type ) {
				case 'images' : $type = 'img'; break;
				default : $type = 'sort';
			}
			
			// main store
			$this->model_setting_setting->deleteSetting($this->_name . '_at_' . $type . '_' . $attr_id . '_' . $lang_id );
			
			// other stores		
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->deleteSetting($this->_name . '_at_' . $type . '_' . $attr_id . '_' . $lang_id, $result['store_id']);
			}	
		}
	}
	
	public function attribsSave() {
		if( ! empty( $this->request->post['attr_id'] ) && ! empty( $this->request->post['items'] ) || ! empty( $this->request->post['type'] ) && ! empty( $this->request->post['lang_id'] ) ) {
			$data		= array();
			$attr_id	= (int) $this->request->post['attr_id'];
			$lang_id = (int)$this->request->post['lang_id'];
			$type		= $this->request->post['type'];
			
			if( isset( $this->request->post['items'] ) ) {
				foreach( $this->request->post['items'] as $i => $v ) {
					switch( $type ) {
						case 'images' : {
							$data[$v['key']] = $v['img'];

							break;
						}
						case 'sort-values' : {
							$data[$v['key']] = $i;

							break;
						}
					}
				}
			}
			
			switch( $type ) {
				case 'images'		: 
					$type = 'img'; break;
				case 'sort-values'	: 
				default : 
					$type = 'sort'; break;
			}
			
			$key	= $this->_name . '_at_' . $type . '_' . $attr_id . '_' . $lang_id;
			$data	= array( $key => $data );
			
			$this->load->model('setting/store');
			$this->load->model('setting/setting');
			
			// main store
			$this->model_setting_setting->editSetting($key, $data);
			
			// other stores
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($key, $data, $result['store_id']);
			}
		}
	}
	
	public function getAttribsByGroupAsJson() {
		$json = array();
		
		if( ! empty( $this->request->get['attribute_group_id'] ) ) {
			$this->load->model('catalog/attribute');
			$json = $this->model_catalog_attribute->getAttributes(array('filter_attribute_group_id'=>(int)$this->request->get['attribute_group_id']));
		}
		
		$this->response->setOutput( json_encode( $json ) );
	}
	
	public function getAttribsValuesByAttribAsJson() {
		$json = array();
		
		if( ! empty( $this->request->get['attribute_id'] ) && ! empty( $this->request->get['type'] ) && ! empty( $this->request->get['lang_id'] ) ) {
			$this->load->model('tool/image');
			
			/**
			 * Paramters
			 */
			$attribute_id	= $this->request->get['attribute_id'];
			$lang_id		= $this->request->get['lang_id'];
			$type			= $this->request->get['type'];
			$settings		= $this->config->get( $this->_name . '_settings' );
			$attribs		= (array) $this->config->get( $this->_name . '_attribs' );
			$images			= $type == 'images' ? (array) $this->config->get( $this->_name . '_at_img_' . $attribute_id . '_' . $lang_id ) : array();
			
			$unique = array();
			foreach( $this->model_module_mega_filter->getAttribsValues( $attribute_id, $lang_id ) as $row ) {
				$row['text'] = trim( $row['text'] );
				
				if( ! empty( $settings['attribute_separator'] ) ) {
					$row['text'] = array_map( 'trim', explode( $settings['attribute_separator'], $row['text'] ) );
					
					foreach( $row['text'] as $text ) {
						if( isset( $unique[$text] ) ) continue;
						
						$k = md5( $text );
						
						$json[] = array( 'key' => $k, 'val' => $text, 'ival' => isset( $images[$k] ) ? $images[$k] : '', 'img' => isset( $images[$k] ) ? $this->model_tool_image->resize( $images[$k], 100, 100 ) : '' );
						$unique[$text] = true;
					}
				} else if( ! isset( $unique[$row['text']] ) ) {
					$k = md5( $row['text'] );
					$json[] = array( 'key' => $k, 'val' => $row['text'], 'ival' => isset( $images[$k] ) ? $images[$k] : '', 'img' => isset( $images[$k] ) ? $this->model_tool_image->resize( $images[$k], 100, 100 ) : '' );
					$unique[$row['text']] = true;
				}
			}
			
			$this->_sortOptions( $json, ! empty( $attribs[$attribute_id]['sort_order_values'] ) ? $attribs[$attribute_id]['sort_order_values'] : '', $attribute_id, $lang_id );
			
			$json2 = array();
			
			foreach( $json as $v ) {
				$json2[] = $v;
			}
			
			$json = $json2;
		}
		
		$this->response->setOutput( json_encode( $json ) );
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	public function filtersReset() {
		if( ! empty( $this->request->post['filter_id'] ) && ! empty( $this->request->post['type'] ) && ! empty( $this->request->post['lang_id'] ) ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			$filter_id = (int)$this->request->post['filter_id'];
			$lang_id = (int)$this->request->post['lang_id'];
			$type = (string)$this->request->post['type'];
			
			switch( $type ) {
				case 'images' : $type = 'img'; break;
				default : $type = 'sort';
			}
			
			// main store
			$this->model_setting_setting->deleteSetting($this->_name . '_fi_' . $type . '_' . $filter_id . '_' . $lang_id );
			
			// other stores		
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->deleteSetting($this->_name . '_fi_' . $type . '_' . $filter_id . '_' . $lang_id, $result['store_id']);
			}	
		}
	}
	
	public function filtersSave() {
		if( ! empty( $this->request->post['filter_id'] ) && ! empty( $this->request->post['items'] ) || ! empty( $this->request->post['type'] ) && ! empty( $this->request->post['lang_id'] ) ) {
			$data		= array();
			$filter_id	= (int) $this->request->post['filter_id'];
			$lang_id = (int)$this->request->post['lang_id'];
			$type		= $this->request->post['type'];
			
			if( isset( $this->request->post['items'] ) ) {
				foreach( $this->request->post['items'] as $i => $v ) {
					switch( $type ) {
						case 'images' : {
							$data[$v['key']] = $v['img'];

							break;
						}
					}
				}
			}
			
			switch( $type ) {
				case 'images' : {
					$type = 'img'; 
					
					break;
				}
			}
			
			$key	= $this->_name . '_fi_' . $type . '_' . $filter_id . '_' . $lang_id;
			$data	= array( $key => $data );
			
			$this->load->model('setting/store');
			$this->load->model('setting/setting');
			
			// main store
			$this->model_setting_setting->editSetting($key, $data);
			
			// other stores
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($key, $data, $result['store_id']);
			}
		}
	}
	
	public function getFiltersValuesByFilterAsJson() {
		$json = array();
		
		if( ! empty( $this->request->get['filter_id'] ) && ! empty( $this->request->get['type'] ) && ! empty( $this->request->get['lang_id'] ) ) {
			$this->load->model('tool/image');
			
			/**
			 * Parameters 
			 */
			$filter_id	= $this->request->get['filter_id'];
			$lang_id	= $this->request->get['lang_id'];
			$type		= $this->request->get['type'];
			$images		= $type == 'images' ? (array) $this->config->get( $this->_name . '_fi_img_' . $filter_id . '_' . $lang_id ) : array();
			
			foreach( $this->model_module_mega_filter->getFiltersValues( $filter_id, $lang_id ) as $row ) {
				$json[] = array(
					'key' => $row['filter_id'],
					'val' => $row['name'],
					'ival' => isset( $images[$row['filter_id']] ) ? $images[$row['filter_id']] : '',
					'img' => isset( $images[$row['filter_id']] ) ? $this->model_tool_image->resize( $images[$row['filter_id']], 100, 100 ) : ''
				);
			}
		}
		
		$this->response->setOutput( json_encode( $json ) );
	}
	
	private static function _sortItems( $a, $b ) {
		$as = isset( self::$_tmp_sort_parameters['config'][$a['key']] ) ? self::$_tmp_sort_parameters['config'][$a['key']] : count(self::$_tmp_sort_parameters['config']);
		$bs = isset( self::$_tmp_sort_parameters['config'][$b['key']] ) ? self::$_tmp_sort_parameters['config'][$b['key']] : count(self::$_tmp_sort_parameters['config']);
		
		if( $as > $bs )
			return 1;
		
		if( $as < $bs )
			return -1;
		
		return 0;
	}
	
	private function _sortOptions( & $options, $sort, $attribute_id, $lang_id ) {		
		if( $sort ) {
			list( $type, $order ) = explode( '_', $sort );
		} else {
			$type = $order = '';
		}
		
		if( $attribute_id ) {
			$attribute_id = str_replace(array(
				'a_', 'o_', 'f_'
			), '', $attribute_id);
		}
		
		self::$_tmp_sort_parameters = array(
			'attribute_id'	=> $attribute_id,
			'type'			=> $type,
			'order'			=> $order,
			'a'				=> false,
			'options'		=> $options,
			'config'		=> $this->config->get('mega_filter_at_sort_' . $attribute_id . '_' . $lang_id )
		);
		
		if( ! self::$_tmp_sort_parameters['type'] && ! self::$_tmp_sort_parameters['config'] ) {
			self::$_tmp_sort_parameters = NULL;
			
			return;
		}
		
		if( ! self::$_tmp_sort_parameters['type'] && self::$_tmp_sort_parameters['attribute_id'] !== NULL && self::$_tmp_sort_parameters['config'] ) {
			uasort( $options, array( 'ControllerModuleMegaFilter', '_sortItems' ) );
		} else {
			$tmp = array();
			
			foreach( $options as $k => $v ) {
				$tmp['_'.$k] = htmlspecialchars_decode( $v['name'] );
			}
			
			if( $order == 'desc' ) {
				arsort( $tmp, $type == 'string' ? SORT_STRING : SORT_NUMERIC );
			} else {
				asort( $tmp, $type == 'string' ? SORT_STRING : SORT_NUMERIC );
			}
			
			$tmp2 = array();
			
			foreach( $tmp as $k => $v ) {
				$tmp2[trim($k,'_')] = $options[trim($k,'_')];
			}
		
			$options = $tmp2;
		}
			
		self::$_tmp_sort_parameters = NULL;
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Settings of options
	 */
	public function options() {
		$this->_init( 'options' );
		
		$page = isset( $this->request->get['page'] ) ? $this->request->get['page'] : 1;
		$config = (array) $this->config->get($this->_name . '_options');
		$limit = 100;
		
		$this->data['action']	= $this->url->link('module/' . $this->_name . '/options', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL');
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			if( ! empty( $this->request->post[$this->_name . '_options'] ) ) {
				foreach( $this->request->post[$this->_name . '_options'] as $id => $conf ) {
					$config[$id] = $conf;
				}
			}
			
			$ids = array_keys( $this->model_module_mega_filter->getOptions() );
			
			foreach( $config as $id => $conf ) {
				if( $id != 'default' && ! in_array( $id, $ids ) ) {
					unset( $config[$id] );
				}
			}
			
			// main store
			$this->model_setting_setting->editSetting($this->_name . '_options', array(	$this->_name . '_options' => $config ));
			
			// other stores		
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($this->_name . '_options', array(	$this->_name . '_options' => $config ), $result['store_id']);
			}	
			
			if( ! empty( $this->request->get['ajax_save'] ) ) {
				return;
			} else {
				$this->session->data['success'] = $this->language->get('text_success');
						
				$this->response->redirect($this->url->link('module/' . $this->_name . '/options', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL'));
			}
		}
		
		/* @var $filter array */
		$filter = array(
			'only_ids' => array(),
			'start' => ( $page - 1 ) * $limit,
			'limit' => $limit
		);
		
		foreach( array_keys( $config ) as $v ) {
			if( is_numeric( $v ) ) {
				$filter['only_ids'][] = (int) $v;
			}
		}
		
		if( ! $filter['only_ids'] ) {
			$filter['only_ids'][] = 0;
		}
		
		$this->data['token'] = $this->session->data['token'];
		$this->data['optionItems'] = $this->model_module_mega_filter->getOptions( $filter );
		$this->data['optionsToSelect'] = $this->toSelect('options');
		$this->data['options'] = $config;
		$this->data['pagination'] = $this->pagination($this->model_module_mega_filter->getTotalOptions( $filter ), $page, $limit, 'module/mega_filter/options');
		
		if( $this->isAjax() ) {
			$this->data['header'] = $this->data['footer'] = $this->data['column_left'] = '';
		}
		
		$this->response->setOutput( $this->load->view('module/mega_filter_options.tpl', $this->data) );
	}
	
	protected function isAjax() {
		return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	/**
	 * Settings of filters
	 */
	public function filters() {
		$this->_init( 'filters' );
		
		$page = isset( $this->request->get['page'] ) ? $this->request->get['page'] : 1;
		$config = (array) $this->config->get($this->_name . '_filters');
		$limit = 100;
		
		$this->data['action']	= $this->url->link('module/' . $this->_name . '/filters', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL');
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			if( ! empty( $this->request->post[$this->_name . '_filters'] ) ) {
				foreach( $this->request->post[$this->_name . '_filters'] as $id => $conf ) {
					$config[$id] = $conf;
				}
			}
			
			$ids = array_keys( $this->model_module_mega_filter->getFilters() );
			
			foreach( $config as $id => $conf ) {
				if( $id != 'default' && ! in_array( $id, $ids ) ) {
					unset( $config[$id] );
				}
			}
			
			// main store
			$this->model_setting_setting->editSetting($this->_name . '_filters', array(	$this->_name . '_filters' => $config ));
			
			// other stores
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($this->_name . '_filters', array(	$this->_name . '_filters' => $config ), $result['store_id']);
			}	
					
			
			if( ! empty( $this->request->get['ajax_save'] ) ) {
				return;
			} else {
				$this->session->data['success'] = $this->language->get('text_success');
						
				$this->response->redirect($this->url->link('module/' . $this->_name . '/filters', 'token=' . $this->session->data['token'] . '&page=' . $page, 'SSL'));
			}
		}
		
		/* @var $filter array */
		$filter = array(
			'only_ids' => $this->__keys( $config ),
			'start' => ( $page - 1 ) * $limit,
			'limit' => $limit
		);
		
		if( ! $filter['only_ids'] ) {
			$filter['only_ids'][] = 0;
		}
		
		$this->load->model('localisation/language');
		$this->load->model('tool/image');
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		$this->data['filterItems'] = $this->model_module_mega_filter->getFilters( $filter );
		$this->data['filterItemsAll'] = $this->model_module_mega_filter->getFilters();
		$this->data['filtersToSelect'] = $this->toSelect('filters');
		$this->data['filters'] = $config;
		$this->data['filters_view'] = true;
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		$this->data['action_filters_save'] = $this->url->link('module/' . $this->_name . '/filtersSave', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_filters_reset'] = $this->url->link('module/' . $this->_name . '/filtersReset', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_values_by_filter'] = $this->url->link('module/' . $this->_name . '/getFiltersValuesByFilterAsJson', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['pagination'] = $this->pagination($this->model_module_mega_filter->getTotalFilters( $filter ), $page, $limit, 'module/mega_filter/filters');
		
		if( $this->isAjax() ) {
			$this->data['header'] = $this->data['footer'] = $this->data['column_left'] = '';
		}
		
		$this->response->setOutput( $this->load->view('module/mega_filter_filters.tpl', $this->data) );
	}
	
	////////////////////////////////////////////////////////////////////////////
	
	private function _updateCss() {
		/* @var $settings array */
		$settings = $this->config->get( $this->_name . '_settings' );
		
		/* @var $css string */
		$css = $this->_createCss( $settings );
		
		foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . "mfilter_settings`" )->rows as $row ) {
			$value = json_decode( $row['settings'], true );
			
			if( ! empty( $value['configuration'] ) ) {
				$css .= $css ? "\n" : '';
				$css .= $this->_createCss(  $value['configuration'], '.mfilter-box-' . $row['idx'] );
			}
		}
		
		file_put_contents( DIR_SYSTEM . '../catalog/view/theme/default/stylesheet/mf/style-2.css', $css );
		
		$this->_removeCombined_JS_CSS_Files();
	}
	
	private function _removeCombined_JS_CSS_Files() {
		if( file_exists( DIR_SYSTEM . '../catalog/view/theme/default/stylesheet/mf/combined.css' ) ) {
			unlink( DIR_SYSTEM . '../catalog/view/theme/default/stylesheet/mf/combined.css' );
		}
		
		if( file_exists( DIR_SYSTEM . '../catalog/view/javascript/mf/combined.js' ) ) {
			unlink( DIR_SYSTEM . '../catalog/view/javascript/mf/combined.js' );
		}
	}
	
	private function _createCss( $settings, $prefix = '' ) {
		if( $prefix ) {
			$prefix .= ' ';
		}
		
		$css = array();
		
		if( ! empty( $settings['background_color_counter'] ) ) {
			$css[$prefix . '.mfilter-counter'][] = 'background: #' . trim( $settings['background_color_counter'], '#' );
		}
		
		if( ! empty( $settings['text_color_counter'] ) ) {
			$css[$prefix . '.mfilter-counter'][] = 'color: #' . trim( $settings['text_color_counter'], '#' );
		}
		
		if( ! empty( $settings['background_color_counter'] ) ) {
			$css[$prefix . '.mfilter-counter:after'][] = 'border-right-color: #' . trim( $settings['background_color_counter'], '#' );
			$css[trim( $prefix ) . '.mfilter-direction-rtl .mfilter-counter:after'][] = 'left: 100%';
			$css[trim( $prefix ) . '.mfilter-direction-rtl .mfilter-counter:after'][] = 'right: auto';
			$css[trim( $prefix ) . '.mfilter-direction-rtl .mfilter-counter:after'][] = 'border-right-color: none';
			$css[trim( $prefix ) . '.mfilter-direction-rtl .mfilter-counter:after'][] = 'border-left-color: #' . trim( $settings['background_color_counter'], '#' );
		}
		
		if( ! empty( $settings['css_style'] ) ) {
			$css[] = htmlspecialchars_decode( $settings['css_style'] );
		}
	
		if( ! empty( $settings['background_color_search_button'] ) ) {
			$css[] = '
				' . $prefix . '.mfilter-search #mfilter-opts-search_button {
					background-color: #' . trim( $settings['background_color_search_button'], '#' ) . ';
				}
			';
		}
		
		if( ! empty( $settings['background_color_slider'] ) ) {
			$css[] = '
				' . $prefix . '.mfilter-slider-slider .ui-slider-range,
				' . $prefix . '#mfilter-price-slider .ui-slider-range {
					background: #' . trim( $settings['background_color_slider'], '#' ) . ' !important;
				}
			';
		}
		
		if( ! empty( $settings['background_color_header'] ) ) {
			$css[] = '
				' . $prefix . '.mfilter-heading {
					background: #' . trim( $settings['background_color_header'], '#' ) . ';
				}
			';
		}
		
		if( ! empty( $settings['text_color_header'] ) ) {
			$css[] = '
				' . $prefix . '.mfilter-heading {
					color: #' . trim( $settings['text_color_header'], '#' ) . ';
				}
			';
		}

		if( ! empty( $settings['border_bottom_color_header'] ) ) {
			$css[] = '
				' . $prefix . '.mfilter-opts-container {
					border-top-color: #' . trim( $settings['border_bottom_color_header'], '#' ) . ';
				}
			';
		}
		
		if( ! empty( $settings['background_color_widget_button'] ) ) {
			$css[] = '
				' . $prefix . '.mfilter-free-button {
					background-color: #' . trim( $settings['background_color_widget_button'], '#' ) . ';
					border-color: #' . trim( $settings['background_color_widget_button'], '#' ) . ';
				}
			';
		}
		
		/* @var $code string */
		$code = '';
		
		foreach( $css as $key => $val ) {
			if( is_array( $val ) ) {
				$code .= $code ? "\n" : '';
				$code .= $key . " {\n";
				foreach( $val as $val2 ) {
					$code .= "\t" . $val2 . ";\n";
				}
				$code .= "\n}";
			} else {
				$code .= $code ? "\n" : '';
				$code .= $val;
			}
		}
		
		return $code;
	}
	
	private function _writableCss() {
		$path = DIR_SYSTEM . '../catalog/view/theme/default/stylesheet/mf/style-2.css';
		
		if( ! file_exists( $path ) ) {
			return false;
		}
		
		if( ! is_writable( $path ) ) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Settings of module
	 */
	public function settings() {
		$this->_init( 'settings' );
		
		$this->data['action']	= $this->url->link('module/' . $this->_name . '/settings', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['action_clear_cache']	= $this->url->link('module/' . $this->_name . '/clearcache', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['settings'] = $this->config->get($this->_name . '_settings');
		
		if( ! $this->_writableCss() ) {
			$this->_setErrors(array(
				'warning' => $this->language->get( 'error_css_file' )
			));
		}
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			if( ! empty( $this->request->post[$this->_name . '_settings']['cache_enabled'] ) && ! $this->_cacheWritable() ) {
				$this->request->post[$this->_name . '_settings']['cache_enabled'] = '0';
				
				$this->session->data['error'] = $this->language->get('error_cache_dir');
			} else if( ! empty( $this->request->post[$this->_name . '_settings']['combine_js_css_files'] ) && ! $this->_mfDirWritable() ) {
				$this->request->post[$this->_name . '_settings']['combine_js_css_files'] = '0';
				
				$this->session->data['error'] = $this->language->get('error_mf_dir');
			} else {
				$this->session->data['success'] = $this->language->get('text_success');
			}
			
			$this->_saveSettings($this->_name . '_settings', $this->request->post);
			
			if( ! empty( $_POST['replace_settings'] ) ) {
				foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . "mfilter_settings`" )->rows as $row ) {
					$v = json_decode( $row['settings'], true );
					
					if( ! empty( $v['configuration'] ) ) {
						foreach( $v['configuration'] as $k2 => $v2 ) {
							if( isset( $this->request->post[$this->_name . '_settings'][$k2] ) ) {
								$v['configuration'][$k2] = $this->request->post[$this->_name . '_settings'][$k2];
							}
						}
					}
					
					$this->model_module_mega_filter->saveSettings( $row['idx'], $v );
				}
			}
			
			if( $this->_writableCss() ) {
				$this->_updateCss();
			}
			
			if( $this->_hasMFilterPlus() ) {
				$before = empty( $this->data['settings']['attribute_separator'] ) ? '' : $this->data['settings']['attribute_separator'];
				$after = empty( $this->request->post['mega_filter_settings']['attribute_separator'] ) ? '' : $this->request->post['mega_filter_settings']['attribute_separator'];

				if( $before != $after ) {
					$this->response->redirect($this->url->link('module/' . $this->_name . '/installprogress', 'token=' . $this->session->data['token'], 'SSL'));
				}
			}
						
			$this->response->redirect($this->url->link('module/' . $this->_name . '/settings', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if( ! isset( $this->data['settings']['in_stock_status'] ) )
			$this->data['settings']['in_stock_status'] = 7;
		
		$this->load->model('design/layout');
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->load->model('localisation/stock_status');
		$this->data['stockStatuses'] = $this->model_localisation_stock_status->getStockStatuses(array());
		$this->data['mfp_plus_version'] = $this->config->get('mfilter_plus_version');
				
		$this->response->setOutput( $this->load->view('module/mega_filter_settings.tpl', $this->data) );
	}
	
	/**
	 * SEO
	 */
	public function seo() {		
		$this->_init( 'seo' );
		
		$this->data['action'] = $this->url->link('module/' . $this->_name . '/seo', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['aliases_url'] = $this->url->link('module/' . $this->_name . '/aliases', 'token=' . $this->session->data['token'], 'SSL');
		
		$this->data['seo'] = $this->config->get($this->_name . '_seo');
		
		if( ! $this->_writableCss() ) {
			$this->_setErrors(array(
				'warning' => $this->language->get( 'error_css_file' )
			));
		}
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->load->model('setting/setting');
			$this->load->model('setting/store');
			
			// main store
			$this->model_setting_setting->editSetting($this->_name . '_seo', $this->request->post);
			
			// other stores
			foreach( $this->model_setting_store->getStores() as $result ) {
				$this->model_setting_setting->editSetting($this->_name . '_seo', $this->request->post, $result['store_id']);
			}
						
			$this->response->redirect($this->url->link('module/' . $this->_name . '/seo', 'token=' . $this->session->data['token'], 'SSL'));
		}
				
		$this->response->setOutput( $this->load->view('module/mega_filter_seo.tpl', $this->data) );
	}
	
	/**
	 * Aliases
	 */
	public function aliases() {		
		$this->_init( 'aliases' );
		
		$this->load->model('localisation/language');
		$this->load->model('setting/store');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		$this->data['aliases_url'] = $this->url->link('module/' . $this->_name . '/aliases', 'token=' . $this->session->data['token'], 'SSL');
		
		if( NULL == ( $language_id = isset( $this->request->get['language_id'] ) ? $this->request->get['language_id'] : NULL ) ) {
			foreach( $this->data['languages'] as $language ) {
				$language_id = $language['language_id']; break;
			}
		}
		
		$this->data['language_id'] = $language_id;
		$this->data['stores'] = array( 0 => array( 'store_id' => 0, 'name' => $this->language->get( 'text_default' ) ) );
		
		foreach( $this->model_setting_store->getStores() as $v ) {
			$this->data['stores'][] = $v;
		}
		
		if( NULL == ( $store_id = isset( $this->request->get['store_id'] ) ? $this->request->get['store_id'] : NULL ) ) {
			foreach( $this->data['stores'] as $store ) {
				$store_id = $store['store_id']; break;
			}
		}
		
		$this->data['store_id'] = $store_id;
		$this->data['val_url'] = isset( $this->request->post['url'] ) ? $this->request->post['url'] : '';
		$this->data['val_alias'] = isset( $this->request->post['alias'] ) ? $this->request->post['alias'] : '';
		$this->data['val_meta_title'] = isset( $this->request->post['meta_title'] ) ? $this->request->post['meta_title'] : '';
		$this->data['val_meta_description'] = isset( $this->request->post['meta_description'] ) ? $this->request->post['meta_description'] : '';
		$this->data['val_meta_keyword'] = isset( $this->request->post['meta_keyword'] ) ? $this->request->post['meta_keyword'] : '';
		$this->data['val_description'] = isset( $this->request->post['description'] ) ? $this->request->post['description'] : '';
		$this->data['val_h1'] = isset( $this->request->post['h1'] ) ? $this->request->post['h1'] : '';
		
		if( ! empty( $this->request->get['action'] ) && $this->checkPermission() ) {
			switch( $this->request->get['action'] ) {
				case 'insert' : {
					if( 
						NULL != ( $url = isset( $this->request->post['url'] ) ? $this->request->post['url'] : '' ) &&
						NULL != ( $alias = isset( $this->request->post['alias'] ) ? $this->request->post['alias'] : '' ) 
					) {
						$url = parse_url( trim( ( $url ) ) );
						$alias = parse_url( trim( $alias ) );
						
						if( NULL != ( $path = empty( $url['query'] ) ? ( empty( $url['path'] ) ? '' : $url['path'] ) : $url['query'] ) ) {
							$seo = false;
							
							preg_match( '/(\?|&)?mfp(,|=)?(,?[a-z0-9\-_]+\[[^\]]*\])+/', $path, $matches );
							
							if( empty( $matches[0] ) ) {
								$seo = true;
								
								preg_match( '#/mfp/([a-z0-9\-_]+,[^/]+/?)+#', $path, $matches );
								
								if( ! empty( $matches[0] ) ) {
									$mfp = explode( '/', trim( $matches[0], '/' ) );
									
									$matches[0] = '';
									
									foreach( $mfp as $v ) {
										$v = explode( ',', $v );
										$k = array_shift( $v );
										
										$matches[0] .= $matches[0] ? ',' : '';
										$matches[0] .= $k;
										
										if( $k != 'mfp' ) {
											$matches[0] .= '[' . urldecode( implode( ',', $v ) ) . ']';
										}
									}
								}
							}
							
							if( ! empty( $matches[0] ) ) {
								if( ! empty( $alias['path'] ) ) {
									$main = parse_url( HTTP_CATALOG );

									if( ! empty( $main['path'] ) ) {
										$url['path'] = preg_replace( '/^' . preg_quote( $main['path'], '/' ) . '/', '', $url['path'] );
									}
									
									if( ! empty( $this->request->post['to_remove_id'] ) ) {
										$this->db->query( "DELETE FROM `" . DB_PREFIX . "mfilter_url_alias` WHERE `mfilter_url_alias_id`='" . (int) $this->request->post['to_remove_id'] . "'" );
									}
								
									$apath	= $bpath = str_replace( '/', '-', preg_replace( '/ +/', '-', trim( $alias['path'], '/ ' ) ) );
									$loops	= 0;
									
									do {
										$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "url_alias` WHERE `keyword` LIKE '" . $this->db->escape( $apath ) . "'");
										
										if( ! $query->num_rows ) {
											$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "mfilter_url_alias` WHERE `alias` LIKE '" . $this->db->escape( $apath ) . "' AND `store_id` = '" . (int) $store_id . "' AND `language_id` = '" . (int) $language_id . "'");
										}
										
										if( $query->num_rows ) {
											$apath = $bpath . '-' . rand( 0, 10000 );
											$loops++;
										}
									} while( $query->num_rows );
									
									/* @var $meta_title string */
									$meta_title = isset( $this->request->post['meta_title'] ) ? trim( $this->request->post['meta_title'] ) : '';
									
									/* @var $meta_description string */
									$meta_description = isset( $this->request->post['meta_description'] ) ? trim( $this->request->post['meta_description'] ) : '';
									
									/* @var $meta_keyword string */
									$meta_keyword = isset( $this->request->post['meta_keyword'] ) ? trim( $this->request->post['meta_keyword'] ) : '';
									
									/* @var $description string */
									$description = isset( $this->request->post['description'] ) ? trim( $this->request->post['description'] ) : '';
									
									/* @var $h1 string */
									$h1 = isset( $this->request->post['h1'] ) ? trim( $this->request->post['h1'] ) : '';
									
									$this->db->query("
										INSERT INTO `" . DB_PREFIX . "mfilter_url_alias` SET
											`path` = '" . $this->db->escape( empty( $url['path'] ) ? '' : trim( preg_replace( '#/mfp,([a-z0-9\-_]+\[[^\]]*\],?)+|/mfp/([a-z0-9\-_]+,[^/]+/?)+#', '', $url['path'] ), '/' ) ) . "',
											`mfp` = '" . $this->db->escape( preg_replace( '/^mfp(=|,)/', '', $matches[0] ) ) . "',
											`alias` = '" . $this->db->escape( $apath ) . "',
											`language_id` = '" . (int) $language_id . "',
											`store_id` = '" . (int) $store_id . "',
											`meta_title` = " . ( $meta_title === '' ? 'NULL' : "'" . $this->db->escape( $meta_title ) . "'" ) . ",
											`meta_description` = " . ( $meta_description === '' ? 'NULL' : "'" . $this->db->escape( $meta_description ) . "'" ) . ",
											`meta_keyword` = " . ( $meta_keyword === '' ? 'NULL' : "'" . $this->db->escape( $meta_keyword ) . "'" ) . ",
											`description` = " . ( $description === '' ? 'NULL' : "'" . $this->db->escape( $description ) . "'" ) . ",
											`h1` = " . ( $h1 === '' ? 'NULL' : "'" . $this->db->escape( $h1 ) . "'" ) . "
									");
									
									$this->data['_success'] = $this->language->get( 'success_updated' );
									$this->data['val_url'] = $this->data['val_alias'] = '';
									
									if( $loops >= 1 ) {
										$this->data['_success'] .= ' - ' . $this->language->get( 'success_updated_modified_url' );
									}
								} else {
									$this->data['_error_warning'] = $this->language->get( 'error_invalid_seo_url' );
								}
							} else {
								$this->data['_error_warning'] = $this->language->get( 'error_invalid_url' );
							}
						} else {
							$this->data['_error_warning'] = $this->language->get( 'error_invalid_url' );
						}
					} else {
						$this->data['_error_warning'] = $url ? $this->language->get( 'error_invalid_seo_url' ) : $this->language->get( 'error_invalid_url' );
					}
					
					break;
				}
				case 'remove' : {
					if( ! empty( $this->request->post['id'] ) ) {
						$this->db->query( "DELETE FROM `" . DB_PREFIX . "mfilter_url_alias` WHERE `mfilter_url_alias_id`='" . (int) $this->request->post['id'] . "'" );
					}
					
					break;
				}
			}
			
			foreach( $this->data['stores'] as $store ) {
				$this->cache->delete('seo_pro_mfp.'.$this->config->get('store_id'));
			}
		}
		
		$page	= isset( $this->request->get['page'] ) ? (int) $this->request->get['page'] : 1;
		$limit	= 25;
		$total	= $this->db->query( "SELECT COUNT(*) AS `c` FROM `" . DB_PREFIX . "mfilter_url_alias` WHERE `language_id`='" . $language_id . "' AND `store_id`='" . $store_id . "'" )->row['c'];
		
		do {
			$this->data['records'] = $this->db->query( "SELECT * FROM `" . DB_PREFIX . "mfilter_url_alias` WHERE `language_id`='" . $language_id . "' AND `store_id`='" . $store_id . "' LIMIT " . ( ( $page - 1 < 0 ? 0 : $page - 1 ) * $limit ) . ", " . $limit )->rows;
		} while( count( $this->data['records'] ) <= 0 && $page-- );
		
		if( $page < 1 ) {
			$page = 1;
		}
		
		$this->data['pagination'] = $this->pagination($total, $page, $limit, 'module/mega_filter/ldv');
		$this->data['page'] = $page;
		
		$this->response->setOutput( $this->load->view('module/mega_filter_aliases.tpl', $this->data) );
	}
	
	/**
	 * Set errors
	 * 
	 * @param array $errors
	 */
	private function _setErrors( $errors ) {
		foreach( $errors as $name => $default ) {
			$this->data['_error_' . $name] = isset( $this->error[$name] ) ? $this->error[$name] : $default;
		}
	}
	
	/**
	 * Set parameters
	 * 
	 * @param array $params
	 * @param array $record
	 */
	private function _setParams( $params, $record = NULL ) {
		if( ! $record )
			$record = array();
		
		foreach( $params as $param => $default ) {
			if( isset( $this->request->post[$param] ) )
				$this->data[$param] = $this->request->post[$param];
			else if( isset( $record[$param] ) )
				$this->data[$param] = $record[$param];
			else
				$this->data[$param] = $default;
		}
	}
	
	private function _clearCache( $messages ) {
		if( ! $this->_cacheWritable() ) {
			if( $messages ) {
				$this->session->data['error'] = $this->language->get('error_cache_dir');
			}
		} else {	
			$dir	= @ opendir( $this->_cache_dir );
			$items	= 0;

			while( false !== ( $file = readdir( $dir ) ) ) {
				if( strlen( $file ) > 32 && strpos( $file, 'idx.' ) === 0 ) {
					@ unlink( $this->_cache_dir . '/' . $file );

					$items++;
				}
			}

			closedir( $dir );

			if( $messages ) {
				$this->session->data['success'] = sprintf( $this->language->get('success_cache_clear'), $items );
			}
		}
	}
	
	public function clearcache() {
		/* @var $lang array */
		$lang = $this->language->load('module/' . $this->_name);
		
		$this->data = array_merge($this->data, $lang);
		$this->data['__lang'] = $lang;
		
		$this->_clearCache( true );
		
		$this->response->redirect($this->url->link('module/mega_filter/settings', 'token=' . $this->session->data['token'], 'SSL'));
	}
			
	public function category_autocomplete() {
		$json = array();
		
		if (isset($this->request->get['filter_name'])) {			
			$data = array(
				'filter_name' => $this->request->get['filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$results = $this->model_module_mega_filter->getCategories($data);
				
			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'], 
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}		
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}
	
	/**
	 * About
	 */
	public function about() {
		$this->_init( 'about' );
		
		$this->data['ext_version'] = $this->_version;
		$this->data['action'] = '';
		
		$this->data['template'] = $this->config->get('config_template');
		$this->data['template_url'] = '';
		
		if( ! $this->data['template'] ) {
			$this->data['template'] = $this->config->get('config_theme');
		}
		
		if( in_array( $this->data['template'], array( 'theme_default' ,'default' ) ) ) {
			$this->data['template'] = '';
		}
		
		if( $this->data['template'] ) {
			$this->data['template_url'] = 'http://forum.ocdemo.eu/forum/category/mfp-supported-templates?phrase=' . urlencode( $this->data['template'] );
		}
		
		if( $this->config->get('mfilter_plus_version') ) {
			$this->data['plus_version'] = $this->config->get('mfilter_plus_version');
			$this->data['action_rebuild_index'] = $this->url->link('module/' . $this->_name . '/installprogress', 'token=' . $this->session->data['token'], 'SSL');
		}
		
		$this->response->setOutput( $this->load->view('module/mega_filter_about.tpl', $this->data) );
	}
	
	/**
	 * Set tooltip
	 */
	public function setTooltip() {
		$this->load->model('localisation/language');
		
		/* @var $data array */
		$data = array(
			'languages' => array(),
			'title' => '',
			'values' => array()
		);
		
		/* @var $type string */
		$type = $this->request->get['type'];
		
		/* @var $idx int */
		$idx = (int) $this->request->get['idx'];
		
		/* @var $id int */
		$id = (int) $this->request->get['id'];
		
		if( $type == 'filters' ) {
			$type = 'filter_group';
		} else if( $type == 'options' ) {
			$type = 'option';
		} else {
			$type = 'attribute';
		}
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			$this->db->query( "UPDATE `" . DB_PREFIX . $type . "_description` SET `mf_tooltip` = NULL WHERE `" . $type . "_id` = " . $id );
			
			foreach( $this->request->post['languages'] as $language_id => $value ) {
				if( $value !== '' ) {
					$this->db->query( "UPDATE `" . DB_PREFIX . $type . "_description` SET `mf_tooltip` = '" . $this->db->escape( $value ) . "' WHERE `language_id` = " . (int) $language_id . " AND `" . $type . "_id` = " . $id );
				}
			}
			
			$this->_clearCacheByIdx( $idx );
		}
			
		foreach( $this->db->query( "SELECT * FROM `" . DB_PREFIX . $type . "_description` WHERE `" . $type . "_id` = " . $id )->rows as $row ) {
			$data['values'][$row['language_id']] = $row['mf_tooltip'];
			
			if( $row['language_id'] == $this->config->get('config_language_id' ) ) {
				$data['title'] = $row['name'];
			}
		}
		
		foreach( $this->model_localisation_language->getLanguages() as $language ) {
			$data['languages'][$language['language_id']] = $language['name'];
		}
		
		$this->response->setOutput( $this->load->view('module/mega_filter_set_tooltip.tpl', $data) );
	}
	
	private function activate( $order_id = NULL, $email = NULL ) {
		require_once DIR_SYSTEM . 'library/mfilter_activate.php';
		
		return MegaFilterActivate::make( $this )->activate( $this->_version, $order_id, $email );
	}
	
	public function closeNotificationNewVersion() {
		if( null != ( $license = $this->config->get('mfilter_license') ) && null != ( $latest_ver = $this->config->get( 'mfilter_latest_ver' ) ) ) {
			$latest_ver['ignore'] = $latest_ver['ver'];
			
			$this->_saveSettings('mfilter_latest_ver', array(
				'mfilter_latest_ver' => $latest_ver
			));
		}
	}
	
	private function checkLatestVersion() {
		if( null != ( $license = $this->config->get('mfilter_license') ) && ( null == ( $latest_ver = $this->config->get( 'mfilter_latest_ver' ) ) || time() > $latest_ver['time'] ) ) {
			require_once DIR_SYSTEM . 'library/mfilter_activate.php';
			
			/* @var $response array */
			$response = MegaFilterActivate::make( $this )->activate( $this->_version, $license['order_id'], $license['email'], true );
			
			if( is_array( $response ) ) {
				if( ! $latest_ver ) {
					$latest_ver = array();
				}
				
				$latest_ver['time'] = time() + 60 * 60 * 24 * 3;
				$latest_ver['ver'] = $response['latest_version'];
				
				$this->_saveSettings('mfilter_latest_ver', array(
					'mfilter_latest_ver' => $latest_ver
				));
			}
		}
		
		if( ! empty( $latest_ver ) && ( empty( $latest_ver['ignore'] ) || version_compare( $latest_ver['ver'], $latest_ver['ignore'], '>' ) ) ) {
			if( version_compare( $latest_ver['ver'], $this->_version, '>' ) ) {
				$this->data['notification_new_version_is_available'] = sprintf( $this->language->get( 'text_new_version_is_available' ), $latest_ver['ver'] );
				$this->data['action_close_notification_new_version'] = $this->data['action_remove_item'] = $this->url->link('module/' . $this->_name . '/closeNotificationNewVersion', 'token=' . $this->session->data['token'], 'SSL');;
			}
		}
	}
	
	/**
	 * License
	 */
	public function license() {
		if( $this->config->get('mfilter_license') ) {
			$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		$this->_init( 'license' );
		
		$this->data['action'] = $this->url->link('module/' . $this->_name . '/license', 'token=' . $this->session->data['token'], 'SSL');
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' ) {
			if( empty( $_POST['order_id'] ) || empty( $_POST['oc_email'] ) ) {
				$this->data['_error_warning2'] = 'Please enter Order ID and OpenCart email';
			} else if( in_array( $_POST['order_id'], array( '000000', '00000', '0000', '000', '0000000', '00000000' ) ) ) {
				$this->data['_error_warning2'] = 'Your Order ID is invalid. You have to copy your unique Order ID from your account, not an example from image.';
			} else if( true !== ( $msg = $this->activate( $_POST['order_id'], $_POST['oc_email'] ) ) ) {
				$this->data['_error_warning2'] = 'Your Order ID is invalid, please try again or contact us <a href="mailto:info@ocdemo.eu">info@ocdemo.eu</a>';
				
				if( $msg ) {
					$this->data['_error_warning2'] = $msg;
					unset( $this->session->data['error'] );
				}
			} else {
				$this->_saveSettings('mfilter_license', array(
					'mfilter_license' => array(
						'order_id' => md5( $_POST['order_id'] ),
						'email' => md5( mb_strtolower( $_POST['oc_email'], 'utf8' ) ),
						'time' => time()
					)
				));
		
				$this->session->data['success'] = $this->language->get('success_install');

				$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'] . ( $this->isOCMod() ? '&refresh_ocmod_cache=1' : '' ), 'SSL'));
			}
		}
		
		$this->activate();
		
		/* @var $files array */
		$files = array(
			DIR_SYSTEM . 'library/mfilter_core.php',
			DIR_SYSTEM . 'library/mfilter_module.php'
		);
		
		foreach( $files as $k => $v ) {
			if( file_exists( $v ) && is_writable( $v ) ) {
				unset( $files[$k] );
			}
		}
		
		$this->data['files'] = $files;
		
		$this->response->setOutput( $this->load->view('module/mega_filter_license.tpl', $this->data) );
	}
	
	private function _installMFilterPlus() {
		if( ! $this->_hasMFilterPlus() ) {
			return false;
		}
		
		if( ! file_exists( DIR_SYSTEM . 'library/mfilter_plus.php' ) ) {
			return false;
		}

		require_once DIR_SYSTEM . 'library/mfilter_plus.php';
		
		if( Mfilter_Plus::getInstance( $this )->install() ) {
			$this->response->redirect($this->url->link('module/' . $this->_name . '/installprogress', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}
	
	public function installprogress() {
		if( ! $this->_hasMFilterPlus() ) {
			$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		if( $this->request->server['REQUEST_METHOD'] == 'POST' && $this->checkPermission() ) {
			require_once DIR_SYSTEM . 'library/mfilter_plus.php';
			
			echo json_encode( Mfilter_Plus::getInstance( $this )->installprogress() );
			
			return;
		}
		
		$this->_init( 'installprogress' );
		
		$this->data['progress_action'] = $this->url->link('module/' . $this->_name.'/installprogress', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['main_action'] = $this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'] . ( $this->isOCMod() ? '&refresh_ocmod_cache=1' : '' ), 'SSL');
		
		$this->response->setOutput( $this->load->view('module/mega_filter_installprogress.tpl', $this->data) );
	}
	
	/**
	 * Install
	 */
	public function install() {
		if( ! function_exists( 'mb_strpos' ) ) {
			$this->session->data['success'] = "
				You haven't installed a standard php extension php-mbstring. 
				This is a requirement of MFP and also OpenCart in general.
				This is something your hosting company will be required to install and only your hosting company will have the access to do it.
				<br /><br />
				Please contact with the technical support of your hosting company and ask them to install php-mbstring.";
			
			$this->response->redirect($this->url->link('module/' . $this->_name . '/uninstall', 'token=' . $this->session->data['token'], 'SSL'));
		}
		
		/* @var $lang array */
		$lang = $this->language->load('module/' . $this->_name);
		
		$this->data = array_merge($this->data, $lang);
		$this->data['__lang'] = $lang;
		
		// load modules
		$this->load->model('setting/setting');
		$this->load->model('extension/extension');
		$this->load->model('localisation/language');
		
		$titles = array();
		
		foreach( $this->model_localisation_language->getLanguages() as $language ) {
			$titles[$language['language_id']] = 'Mega Filter PRO';
		}
			
		/**
		 * Set default settings
		 */
		$this->model_setting_setting->editSetting($this->_name . '_module', array(
			$this->_name . '_module' => array(
				1 => array(
					'title'			=> $titles,
					'layout_id'		=> array( '3' ),
					'store_id'		=> array( 0 ),
					'position'		=> 'column_left',
					'status'		=> '1',
					'sort_order'	=> ''
				)
			)
		));
		
		$this->model_setting_setting->editSetting($this->_name . '_settings', array(
			$this->_name . '_settings' => array(
				'show_number_of_products'		=> '1',
				'calculate_number_of_products'	=> '1',
				'show_loader_over_results'		=> '1',
				'css_style'					=> '',
				'content_selector'			=> '#mfilter-content-container',
				'refresh_results'			=> 'immediately',
				'attribs'					=> array(
					'price'		=> array(
						'enabled'		=> '1',
						'sort_order'	=> '-1'
					)
				),
				'layout_c'					=> '3',
				'display_live_filter'		=> array(
					'items' => '1'
				)
			)
		));
		
		$this->model_setting_setting->editSetting($this->_name . '_seo', array(
			$this->_name . '_seo' => array(
				'enabled'	=> '0'
			)
		));
		
		$this->model_setting_setting->editSetting($this->_name . '_status', array(
			$this->_name . '_status' => '1'
		));
		
		/**
		 * Check if extension is on the list
		 */
		if( ! in_array( $this->_name, $this->model_extension_extension->getInstalled('module') ) ) {
			$this->model_extension_extension->install('module', $this->_name);
		}
		
		/**
		 * Check duplicates
		 */
		$idx = 0;
		foreach( $this->db->query( "SELECT * FROM " . DB_PREFIX . "extension WHERE code='mega_filter' AND type='module'")->rows as $row ) {
			if( $idx ) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "extension WHERE extension_id='" . (int) $row['extension_id'] . "'");
			}
			
			$idx++;
		}
		
		$this->model_module_mega_filter->updateDB( true );
			
		$this->_installMFilterPlus();
		
		$this->session->data['success'] = $this->language->get('success_install');

		if( version_compare( VERSION, '2.3.0.0', '<' ) ) {
			$this->response->redirect($this->url->link('module/' . $this->_name, 'token=' . $this->session->data['token'] . ( $this->isOCMod() ? '&refresh_ocmod_cache=1' : '' ), 'SSL'));
		}
	}
	
	private function isVQMod() {
		if( ! class_exists( 'VQMod' ) ) {
			return false;
		}
		
		if( ! file_exists( DIR_SYSTEM . '../vqmod/xml/vqmod_opencart.xml' ) ) {
			return false;
		}
		
		/* @var $files array */
		$files = array(
			'mega_filter.xml',
			'mega_filter_fix.xml',
			'a_mega_filter_fix.xml',
			'z_mega_filter_fix.xml',
			'z_mega_filter.xml',
		);
		
		/* @var $exists array */
		$exists = array();
		
		foreach( $files as $file ) {
			if( file_exists( DIR_SYSTEM . '../vqmod/xml/' . $file ) ) {
				$exists[] = '/vqmod/xml/' . $file;
			}
		}
		
		return $exists;
	}
	
	private function isOCMod() {
		/* @var $files array */
		$files = array(
			'mega_filter.ocmod.xml',
			'mega_filter_fix.ocmod.xml',
			'a_mega_filter_fix.ocmod.xml',
			'z_mega_filter_fix.ocmod.xml',
			'z_mega_filter.ocmod.xml',
		);
		
		/* @var $exists array */
		$exists = array();
		
		foreach( $files as $file ) {
			if( file_exists( DIR_SYSTEM . $file ) ) {
				$exists[] = '/system/' . $file;
			}
		}
		
		return $exists;
	}
	
	/**
	 * Uninstall
	 */
	public function uninstall() {
		/* @var $lang array */
		$lang = $this->language->load('module/' . $this->_name);
		
		$this->data = array_merge($this->data, $lang);
		$this->data['__lang'] = $lang;
			
		/**
		 * Check if extension is on the list
		 */
		$this->load->model('extension/extension');
		$this->load->model('setting/store');
		
		$this->model_module_mega_filter->uninstall();
			
		if( in_array( $this->_name, $this->model_extension_extension->getInstalled('module') ) )
			$this->model_extension_extension->uninstall('module', $this->_name);
		
		if( file_exists( DIR_SYSTEM . 'library/mfilter_plus.php' ) ) {
			require_once DIR_SYSTEM . 'library/mfilter_plus.php';
			Mfilter_Plus::getInstance( $this )->uninstall();
		}
		
		foreach( $this->_mijoshop_update as $file => $changes ) {
			$file = realpath( DIR_SYSTEM . $file );
			
			if( file_exists( $file . '_backup_mf' ) ) {
				if( copy( $file . '_backup_mf', $file ) ) {
					unlink( $file . '_backup_mf' );
				}
			}
		}
		
		if( empty( $this->session->data['success'] ) ) {
			$this->session->data['success'] = $this->language->get('success_uninstall');
		}

		// redirect to list of modules
		if( version_compare( VERSION, '2.3.0.0', '<' ) ) {
			$this->response->redirect( $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL') );
		}
	}
	
	/**
	 * Check permissions
	 * 
	 * @return boolean
	 */
	protected function hasPermission() {
		if( ! $this->user->hasPermission('modify', 'module/' . $this->_name) )
			return false;
		
		return true;
	}
	
	protected function checkPermission() {
		if( ! $this->hasPermission() ) {
			$this->_setErrors(array(
				'warning'	=> $this->language->get( 'error_permission' )
			));
			
			return false;
		}
		
		return true;
	}
}