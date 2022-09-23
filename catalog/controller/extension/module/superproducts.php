<?php
class ControllerExtensionModuleSuperproducts extends Controller {
	public function index($setting) {
		static $module = 0;
		$data['module'] = $module++;
		$this->load->language('extension/module/latest');

		$data['heading_title'] = 'SuperProducts';

		$langVars = $this->config->get('superproductsadmin_langvars');

		if (!$setting['module_type'] && isset($setting['fname'][$this->config->get('config_language_id')]) && $setting['fname'][$this->config->get('config_language_id')]) { 
			//custom name for singles module
			$data['heading_title'] = html_entity_decode($setting['fname'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8');
		}

		if ($setting['viewall_link_t'] && !$setting['module_type'] && $setting['product_group'] == 'bytag' && $setting['tag']) {
			$data['heading_title'] .= ' <a href="'.$this->url->link('product/search', 'tag=' . (string)$setting['tag']).'">'.(isset($langVars[$this->config->get('config_language_id')]['tag_view_link']) && $langVars[$this->config->get('config_language_id')]['tag_view_link'] ? $langVars[$this->config->get('config_language_id')]['tag_view_link'] : 'View All').'</a>';
		}

		$data['smp_applied'] = true; 
		$this->language->load('module/supertheme');
		$pds = $this->config->get('supertheme_pds_settings');
		if ($pds['pdlength'] == 1 || $pds['pdlength'] == 3) {
			$metric = $this->db->query("SELECT unit FROM " . DB_PREFIX . "length_class mc LEFT JOIN " . DB_PREFIX . "length_class_description mcd ON (mc.length_class_id = mcd.length_class_id) WHERE mcd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND mc.length_class_id= '" . (int)$this->config->get('config_length_class_id') . "'");
			$metric = $metric->row['unit'];
   		}

		$tab_data['text_tax'] = $data['text_tax'] = $this->language->get('text_tax');

		$tab_data['button_cart'] = $data['button_cart'] = $this->language->get('button_cart');
		$tab_data['button_wishlist'] = $data['button_wishlist'] = $this->language->get('button_wishlist');
		$tab_data['button_compare'] = $data['button_compare'] = $this->language->get('button_compare');

		$this->load->model('extension/module/superproducts');

		$this->load->model('tool/image');

		if (isset($this->request->get['path'])) {
			$parts = explode('_', (string)$this->request->get['path']);
		} else {
			$parts = array();
		}

		if (isset($parts[0])) {
			$category_id = $parts[0];
		} else {
			$category_id = 9999999999999;
		}

		if ($setting['viewall_link_c'] && !$setting['module_type'] && $setting['product_group'] == 'bycat' && !$setting['active_cat']) {
			$data['heading_title'] .= ' <a href="'.$this->url->link('product/category', 'path=' . ($setting['active_cat'] ? $category_id : (isset($setting['category']) ? (int)$setting['category'] : 0))).'">'.(isset($langVars[$this->config->get('config_language_id')]['cat_view_link']) && $langVars[$this->config->get('config_language_id')]['cat_view_link'] ? $langVars[$this->config->get('config_language_id')]['cat_view_link'] : 'View Category Page').'</a>';
		}

		if (isset($this->request->get['manufacturer_id'])) {
			$brand_id = (int)$this->request->get['manufacturer_id'];
		} else {
			$brand_id = 9999999999999;
		}

		if ($setting['viewall_link_m'] && !$setting['module_type'] && $setting['product_group'] == 'byman' && !$setting['active_brand']) {
			$data['heading_title'] .= ' <a href="'.$this->url->link('product/manufacturer/info', 'manufacturer_id=' . ($setting['active_brand'] ? $brand_id : (isset($setting['brand']) ? (int)$setting['brand'] : 0))) .'">' . (isset($langVars[$this->config->get('config_language_id')]['man_view_link']) && $langVars[$this->config->get('config_language_id')]['man_view_link'] ? $langVars[$this->config->get('config_language_id')]['man_view_link'] : 'View Brand Page').'</a>';
		}
		
		//build latest viewed cache
		if (isset($this->request->get['product_id'])) {
        	$lastviewedProducts = isset($this->request->cookie['last_visited']) ? explode(',', $this->request->cookie['last_visited']) : array();
            $pidv = (int)$this->request->get['product_id'];
            $lastviewedProducts = array_diff($lastviewedProducts, array($pidv)); array_unshift($lastviewedProducts,$pidv);
            setcookie('last_visited', implode(',',$lastviewedProducts), time() + 60 * 60 * 24 * 15, '/', $this->request->server['HTTP_HOST']);
        }

        //start module
		if (!$setting['module_type']) {

			//single_module

			$data['products'] = array();

			if ($setting['product_group'] == 'bought') {

				$pid = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : 0;
				$fromcart = !$pid ? true : false;
				if ($fromcart) {
					$pid = array();
					$productsfromcart = $this->cart->getProducts();
					foreach ($productsfromcart as $pc) $pid[] = $pc['product_id'];
				} 
				$results = $this->model_extension_module_superproducts->getABProducts($pid, $fromcart, $setting['limit']);

			} elseif ($setting['product_group'] == 'related') {

				$this->load->model('catalog/product');
				$pid = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : 0;
				$results = $this->model_catalog_product->getProductRelated($pid);

			} elseif ($setting['product_group'] == 'last') {

				$this->load->model('catalog/product');
				$lastviewedProducts = isset($this->request->cookie['last_visited']) ? explode(',', $this->request->cookie['last_visited']) : array();
				$results = array();
				foreach (array_slice($lastviewedProducts, 0, (int)$setting['limit']) as $lastviewed_id) {
					$results[] = $this->model_catalog_product->getProduct($lastviewed_id);
				}

			} else {

				$filter_data = array(
					'product_group' => $setting['product_group'],
					'product_group_b' => $setting['product_group_b'],
					'category' => $setting['active_cat'] ? $category_id : (isset($setting['category']) ? (int)$setting['category'] : 0),
					'brand' => $setting['active_brand'] ? $brand_id : (isset($setting['brand']) ? (int)$setting['brand'] : 0),
					'tag' => (string)$setting['tag'],
					'start' => 0,
					'mid' => $data['module'],
					'limit' => $setting['limit']
				);

				$results = $this->model_extension_module_superproducts->getProducts($filter_data);

			}

			if ($results) {
				foreach ($results as $result) {
					if ($result['image']) {
						$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
					} else {
						$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
					}

					if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
						$price =  (version_compare(VERSION, '2.2.0.0') >= 0) ? $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : 
									$this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$price = false;
					}
	
					if ((float)$result['special']) {
						$special = (version_compare(VERSION, '2.2.0.0') >= 0) ? $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : 
									$this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
					} else {
						$special = false;
					}

					if ($this->config->get('config_tax')) {
						$tax = (version_compare(VERSION, '2.2.0.0') >= 0) ? $this->currency->format(((float)$result['special'] ? $result['special'] : $result['price']), $this->session->data['currency']) : 
								$this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
					} else {
						$tax = false;
					}

					if ($this->config->get('config_review_status')) {
						$rating = $result['rating'];
					} else {
						$rating = false;
					}
					$smp_info = $result;
					$data['products'][] = array(
						'smp_model' => ($pds['pdmodel'] && $smp_info['model']) ? $this->language->get('text_pdmodel') . $smp_info['model'] : '',
						'smp_stock' => $smp_info['quantity'],
						'smp_sstat' => $smp_info['stock_status'],
						'smp_brand' => ($pds['pdbrand'] && $smp_info['manufacturer']) ? $this->language->get('text_pdbrand') . $smp_info['manufacturer'] : '',
						'smp_pdstock' => $pds['pdstock'] ? $this->language->get('text_pdstock') . $smp_info['stock_status'] : '',
						'smp_nostock' => ($pds['pdnostock'] == 1 || $pds['pdnostock'] == 3) ? $smp_info['stock_status'] : '',
						'smp_sku' => (($pds['pdsku'] == 1 || $pds['pdsku'] == 3) && $smp_info['sku']) ? $this->language->get('text_pdsku') . $smp_info['sku'] : '',
						'smp_upc' => (($pds['pdupc'] == 1 || $pds['pdupc'] == 3) && $smp_info['upc']) ? $this->language->get('text_pdupc') . $smp_info['upc'] : '',
						'smp_location' => (($pds['pdlocation'] == 1 || $pds['pdlocation'] == 3) && $smp_info['location']) ? $this->language->get('text_pdloc') . $smp_info['location'] : '',
						'smp_mpn' => (($pds['pdmpn'] == 1 || $pds['pdmpn'] == 3) && $smp_info['mpn']) ? $this->language->get('text_pdmpn') . $smp_info['mpn'] : '',
						'smp_ean' => (($pds['pdean'] == 1 || $pds['pdean'] == 3) && $smp_info['ean']) ? $this->language->get('text_pdean') . $smp_info['ean'] : '',
						'smp_isbn' => (($pds['pdisbn'] == 1 || $pds['pdisbn'] == 3) && $smp_info['isbn']) ? $this->language->get('text_pdisbn') . $smp_info['isbn'] : '',
						'smp_weight' => (($pds['pdweight'] == 1 || $pds['pdweight'] == 3) && $smp_info['weight'] > 0.01) ? $this->language->get('text_pdweight') . $this->weight->format($smp_info['weight'], $smp_info['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point')) : '',
						'smp_length' => (($pds['pdlength'] == 1 || $pds['pdlength'] == 3) && $smp_info['length'] > 0.01) ? $this->language->get('text_pdlength') . round($smp_info['length'], 2) . ' x ' . round($smp_info['width'], 2) . ' x ' . round($smp_info['height'], 2) . ' ' . $metric : '',
						'product_id'  => $result['product_id'],
						'thumb'       => $image,
						'name'        => $result['name'],
						'description' => (version_compare(VERSION, '2.2.0.0') >= 0)  ? (utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..') : (utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..'),
						'price'       => $price,
						'special'     => $special,
						'tax'         => $tax,
						'rating'      => $rating,
						'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
					);
				}

				$singlemod_tpl = $this->config->get('superproductsadmin_singlemod_tpl') ? $this->config->get('superproductsadmin_singlemod_tpl') : 'superproducts.tpl';

				return $this->load->view('extension/module/'.substr($singlemod_tpl, 0, -4), $data);
			}
		} else {
			//tabs module
			if ($setting['supertabs']) {

				$tab_sort = array();

				foreach ($setting['supertabs'] as $sort_tab) { 
					$tab_sort[] = $sort_tab['order'];
				}
				array_multisort($tab_sort,SORT_NUMERIC,$setting['supertabs']);

				$data['tabs'] = array();

				$data['viewlink_pos'] =  $this->config->get('superproductsadmin_viewlink_pos');

				$tab_no = 0;

				$tabmod_tpl = $this->config->get('superproductsadmin_tabsmodmod_tpl') ? $this->config->get('superproductsadmin_tabsmodmod_tpl') : 'superproducts.tpl';

				foreach ($setting['supertabs'] as $tab) { $tab_no++;

					$tab_data['products'] = array();

					if ($tab['product_group'] == 'bought') {

						$pid = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : 0;
						$fromcart = !$pid ? true : false;
						if ($fromcart) {
							$pid = array();
							$productsfromcart = $this->cart->getProducts();
							foreach ($productsfromcart as $pc) $pid[] = $pc['product_id'];
						} 
						$results = $this->model_extension_module_superproducts->getABProducts($pid, $fromcart, $setting['limit']);

					} elseif ($tab['product_group'] == 'related') {

						$this->load->model('catalog/product');
						$pid = isset($this->request->get['product_id']) ? (int)$this->request->get['product_id'] : 0;
						$results = $this->model_catalog_product->getProductRelated($pid);

					} elseif ($tab['product_group'] == 'last') {

						$this->load->model('catalog/product');
						$lastviewedProducts = isset($this->request->cookie['last_visited']) ? explode(',', $this->request->cookie['last_visited']) : array();
						$results = array();
						foreach (array_slice($lastviewedProducts, 0, (int)$setting['limit']) as $lastviewed_id) {
							$results[] = $this->model_catalog_product->getProduct($lastviewed_id);
						}

					} else {

						$filter_data = array(
							'product_group' => $tab['product_group'],
							'product_group_b' => $tab['product_group_b'],
							'category' => $tab['active_cat'] ? $category_id : (isset($tab['category']) ? (int)$tab['category'] : 0),
							'brand' => $tab['active_brand'] ? $brand_id : (isset($tab['brand']) ? (int)$tab['brand'] : 0),
							'tag' => (string)$tab['tag'],
							'start' => 0,
							'mid' => $data['module'],
							'limit' => $setting['limit']
						);

						$results = $this->model_extension_module_superproducts->getProducts($filter_data);

					}

					if ($results) {

						$data['tabs'][$tab_no]['head'] = (isset($tab['fname'][$this->config->get('config_language_id')]) && $tab['fname'][$this->config->get('config_language_id')]) ? html_entity_decode($tab['fname'][$this->config->get('config_language_id')], ENT_QUOTES, 'UTF-8') : 'Unnamed Tab ' . $tab_no;

						$data['tabs'][$tab_no]['link'] = '';

						$data['tabs'][$tab_no]['id'] = 'spt_'.$data['module'].'_'.$tab_no;

						if ($tab['viewall_link_t'] && $tab['product_group'] == 'bytag' && $tab['tag']) {

							$data['tabs'][$tab_no]['link'] = ' <a class="btn btn-default" href="'.$this->url->link('product/search', 'tag=' . (string)$tab['tag']).'">'.(isset($langVars[$this->config->get('config_language_id')]['tag_view_link']) && $langVars[$this->config->get('config_language_id')]['tag_view_link'] ? $langVars[$this->config->get('config_language_id')]['tag_view_link'] : 'View All').'</a>';
						}

						if ($tab['viewall_link_c'] && $tab['product_group'] == 'bycat' && !$tab['active_cat']) {

							$data['tabs'][$tab_no]['link'] = ' <a class="btn btn-default" href="'.$this->url->link('product/category', 'path=' . ($tab['active_cat'] ? $category_id : (isset($tab['category']) ? (int)$tab['category'] : 0))).'">'.(isset($langVars[$this->config->get('config_language_id')]['cat_view_link']) && $langVars[$this->config->get('config_language_id')]['cat_view_link'] ? $langVars[$this->config->get('config_language_id')]['cat_view_link'] : 'View Category Page').'</a>';

						}

						if ($tab['viewall_link_m'] && $tab['product_group'] == 'byman' && !$tab['active_brand']) {
			
							$data['tabs'][$tab_no]['link'] = ' <a class="btn btn-default" href="'.$this->url->link('product/manufacturer/info', 'manufacturer_id=' . ($tab['active_brand'] ? $brand_id : (isset($tab['brand']) ? (int)$tab['brand'] : 0))) .'">' . (isset($langVars[$this->config->get('config_language_id')]['man_view_link']) && $langVars[$this->config->get('config_language_id')]['man_view_link'] ? $langVars[$this->config->get('config_language_id')]['man_view_link'] : 'View Brand Page').'</a>';
						
						}

						foreach ($results as $result) {
							if ($result['image']) {
								$image = $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
							} else {
								$image = $this->model_tool_image->resize('placeholder.png', $setting['width'], $setting['height']);
							}

							if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
								$price = (version_compare(VERSION, '2.2.0.0') >= 0) ? $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : 
											$this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$price = false;
							}
	
							if ((float)$result['special']) {
								$special = (version_compare(VERSION, '2.2.0.0') >= 0) ? $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']) : 
											$this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
							} else {
								$special = false;
							}

							if ($this->config->get('config_tax')) {
								$tax = (version_compare(VERSION, '2.2.0.0') >= 0) ? $this->currency->format(((float)$result['special'] ? $result['special'] : $result['price']), $this->session->data['currency']) : 
										$this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
							} else {
								$tax = false;
							}

							if ($this->config->get('config_review_status')) {
								$rating = $result['rating'];
							} else {
								$rating = false;
							}
							$smp_info = $result;
							$tab_data['products'][] = array(
								'smp_model' => ($pds['pdmodel'] && $smp_info['model']) ? $this->language->get('text_pdmodel') . $smp_info['model'] : '',
								'smp_stock' => $smp_info['quantity'],
								'smp_sstat' => $smp_info['stock_status'],
								'smp_brand' => ($pds['pdbrand'] && $smp_info['manufacturer']) ? $this->language->get('text_pdbrand') . $smp_info['manufacturer'] : '',
								'smp_pdstock' => $pds['pdstock'] ? $this->language->get('text_pdstock') . $smp_info['stock_status'] : '',
								'smp_nostock' => ($pds['pdnostock'] == 1 || $pds['pdnostock'] == 3) ? $smp_info['stock_status'] : '',
								'smp_sku' => (($pds['pdsku'] == 1 || $pds['pdsku'] == 3) && $smp_info['sku']) ? $this->language->get('text_pdsku') . $smp_info['sku'] : '',
								'smp_upc' => (($pds['pdupc'] == 1 || $pds['pdupc'] == 3) && $smp_info['upc']) ? $this->language->get('text_pdupc') . $smp_info['upc'] : '',
								'smp_location' => (($pds['pdlocation'] == 1 || $pds['pdlocation'] == 3) && $smp_info['location']) ? $this->language->get('text_pdloc') . $smp_info['location'] : '',
								'smp_mpn' => (($pds['pdmpn'] == 1 || $pds['pdmpn'] == 3) && $smp_info['mpn']) ? $this->language->get('text_pdmpn') . $smp_info['mpn'] : '',
								'smp_ean' => (($pds['pdean'] == 1 || $pds['pdean'] == 3) && $smp_info['ean']) ? $this->language->get('text_pdean') . $smp_info['ean'] : '',
								'smp_isbn' => (($pds['pdisbn'] == 1 || $pds['pdisbn'] == 3) && $smp_info['isbn']) ? $this->language->get('text_pdisbn') . $smp_info['isbn'] : '',
								'smp_weight' => (($pds['pdweight'] == 1 || $pds['pdweight'] == 3) && $smp_info['weight'] > 0.01) ? $this->language->get('text_pdweight') . $this->weight->format($smp_info['weight'], $smp_info['weight_class_id'], $this->language->get('decimal_point'), $this->language->get('thousand_point')) : '',
								'smp_length' => (($pds['pdlength'] == 1 || $pds['pdlength'] == 3) && $smp_info['length'] > 0.01) ? $this->language->get('text_pdlength') . round($smp_info['length'], 2) . ' x ' . round($smp_info['width'], 2) . ' x ' . round($smp_info['height'], 2) . ' ' . $metric : '',
								'product_id'  => $result['product_id'],
								'thumb'       => $image,
								'name'        => $result['name'],
								'description' => (version_compare(VERSION, '2.2.0.0') >= 0)  ? (utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..') : (utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..'),
								'price'       => $price,
								'special'     => $special,
								'tax'         => $tax,
								'rating'      => $rating,
								'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id']),
							);
						}

						$tab_data['heading_title'] = $data['tabs'][$tab_no]['head'];

						
						$data['tabs'][$tab_no]['body'] = $this->load->view('extension/module/'.substr($tabmod_tpl, 0, -4), $tab_data);
						$title_regex = $this->config->get('superproductsadmin_title_regex') ? html_entity_decode($this->config->get('superproductsadmin_title_regex')) : '/<h3>(.*?)<\/h3>/';
						
						$data['tabs'][$tab_no]['body'] = preg_replace($title_regex, '', $data['tabs'][$tab_no]['body'], 1);
					}
				}

				return $this->load->view('extension/module/superproducts_tabs', $data);

			}
		}
	}
}