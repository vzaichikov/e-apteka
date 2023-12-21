<?php

class ControllerExtensionModuleOCFilter extends Controller {
  protected $registry;
  protected $data = array();

  public function __construct($registry) {
    parent::__construct($registry);

    if ($this->registry->has('ocfilter')) {
      $this->data = $this->registry->get('ocfilter')->data;

      return;
    }

    $this->load->language('extension/module/ocfilter');

    $this->load->config('ocfilter');
    $this->load->helper('ocfilter');

  	$this->load->model('catalog/ocfilter');
		$this->load->model('catalog/product');
    $this->load->model('tool/image');

    $this->decode();

    if (!$this->path) {
    	return;
    }

    $parts = explode('_', $this->path);

    $this->category_id = (int)end($parts);

    if (isset($this->request->get['filter_ocfilter'])) {
      $this->params = cleanParamsString($this->request->get['filter_ocfilter'], $this->config);

      if ($this->params) {
        $options_get = decodeParamsFromString($this->params, $this->config);

  			$this->options_get = $options_get;

        if ($this->config->get('ocfilter_show_price') && !empty($options_get['p'])) {
          $range = getRangeParts(end($options_get['p']));

          if (isset($range['from']) && isset($range['to'])) {
          	$this->min_price_get = $range['from'];
          	$this->max_price_get = $range['to'];
          }
        }

        if (!$this->page_info) {
         	$this->document->setNoindex(true);
        }
      }
    }

    $filter_data = array(
			'filter_category_id'=> $this->category_id,
      'filter_ocfilter'   => $this->params
		);

		$this->counters = $this->model_catalog_ocfilter->getCounters($filter_data);

    if ($this->config->get('ocfilter_show_price')) {
      $filter_data['filter_ocfilter'] = $this->cancelOptionParams('p');

      $this->product_prices = $this->model_catalog_ocfilter->getProductPrices($filter_data);

      if ($this->product_prices) {
        $this->min_price = $this->currency->format(floor($this->product_prices['min']), $this->session->data['currency'], '', false);
        $this->max_price = $this->currency->format(ceil($this->product_prices['max']), $this->session->data['currency'], '', false);
      }
    }

    $this->registry->set('ocfilter', $this);
  }

  public function __get($key) {
    if (isset($this->data[$key])) {
      return $this->data[$key];
    } else if ($this->registry->has($key)) {
      return $this->registry->get($key);
    } else {
      return null;
    }
  }

  public function __set($key, $value) {
    $this->data[$key] = $value;
  }

  public function initialise() {

  }

	public function index($settings = array()) {
    if (!$this->category_id) {
    	return;
    }

    $this->load->language('extension/module/ocfilter');

    if ($this->config->get('ocfilter_show_price') && $this->min_price < $this->max_price - 1) {
      $data['show_price'] = 1;
    } else {
      $data['show_price'] = 0;
    }

    $data['heading_title'] = $this->language->get('heading_title');

		if ($this->min_price_get && $this->min_price_get < $this->min_price) {
			$this->min_price = $this->min_price_get;
    }

		if ($this->max_price_get && $this->max_price_get > $this->max_price) {
			$this->max_price = $this->max_price_get;
    }

    $data['options']              = $this->getOCFilterOptions();
    $data['min_price']            = $this->min_price;
		$data['max_price']            = $this->max_price;
    $data['min_price_get']        = $this->min_price_get ? $this->min_price_get : $this->min_price;
    $data['max_price_get']        = $this->max_price_get ? $this->max_price_get : $this->max_price;
    $data['path']                 = $this->path;

    $data['link']                 = str_replace('&amp;', '&', $this->link());

    $data['params']               = $this->params;

    $data['index']   							= $this->config->get('ocfilter_url_index');
    $data['show_counter']         = $this->config->get('ocfilter_show_counter');
    $data['search_button']        = $this->config->get('ocfilter_search_button');
    $data['show_values_limit']   	= $this->config->get('ocfilter_show_values_limit');
    $data['manual_price']         = $this->config->get('ocfilter_manual_price');

    $data['text_show_all']        = $this->language->get('text_show_all');
    $data['text_hide']          	= $this->language->get('text_hide');
    $data['button_select']        = $this->language->get('button_select');
    $data['text_load']            = $this->language->get('text_load');
    $data['text_price']           = $this->language->get('text_price');
    $data['text_any']           	= $this->language->get('text_any');
    $data['text_cancel_all']      = $this->language->get('text_cancel_all');

    $data['symbol_left']      		= $this->currency->getSymbolLeft($this->session->data['currency']);
    $data['symbol_right']      		= $this->currency->getSymbolRight($this->session->data['currency']);

    $data['show_options'] = !empty($this->params);

    if ($this->config->get('ocfilter_show_selected') && $this->options_get) {
      $data['selecteds'] = $this->getSelectedOptions();
    } else {
      $data['selecteds'] = array();
    }

		if ($this->config->get('ocfilter_show_options_limit') && $this->config->get('ocfilter_show_options_limit') < count($data['options'])) {
    	$data['show_options_limit'] = $this->config->get('ocfilter_show_options_limit');
		} else {
      $data['show_options_limit'] = false;
		}

    $this->document->addStyle('catalog/view/javascript/ocfilter/nouislider.min.css');
    $this->document->addStyle('catalog/view/theme/default/stylesheet/ocfilter/ocfilter.css');

    $this->document->addScript('catalog/view/javascript/ocfilter/nouislider.min.js');
    $this->document->addScript('catalog/view/javascript/ocfilter/ocfilter.js');

		return $this->load->view('extension/module/ocfilter/module', $data);
	}

	protected function getOCFilterOptions() {
    if (!is_null($this->options)) {
    	return $this->options;
    }

    $options = array();

    if ($this->config->get('ocfilter_stock_status')) {
      if ($this->config->get('ocfilter_stock_status_method') == 'stock_status_id') {
        $results = $this->model_catalog_ocfilter->getStockStatuses();

        $options['stock'] = array(
          'option_id'   => 's',
          'name'        => $this->language->get('text_stock'),
          'description' => $this->language->get('text_stock_description'),
          'type'        => $this->config->get('ocfilter_stock_status_type'),
          'values'      => $results
        );
      } else if ($this->config->get('ocfilter_stock_status_method') == 'quantity') {
        $options['stock'] = array(
          'option_id'   => 's',
          'name'        => $this->language->get('text_stock'),
          'description' => $this->language->get('text_stock_description'),
          'type'        => ($this->config->get('ocfilter_stock_out_value') ? 'radio' : 'checkbox'),
          'values'      => array(
            array(
              'value_id'    => 'in',
              'name'        => $this->language->get('text_in_stock')
            )
          )
        );

        if ($this->config->get('ocfilter_stock_out_value')) {
          $options['stock']['values'][] = array(
            'value_id'    => 'out',
            'name'        => $this->language->get('text_out_of_stock')
          );
        }
      }
    }

    if ($this->config->get('ocfilter_manufacturer')) {
  		$results = $this->model_catalog_ocfilter->getManufacturersByCategoryId($this->category_id);

      if ($results) {
        $options[] = array(
          'option_id'   => 'm',
          'name'        => $this->language->get('text_manufacturer'),
          'description' => $this->language->get('text_manufacturer_description'),
          'type'        => $this->config->get('ocfilter_manufacturer_type'),
          'values'      => $results
        );
      }
    }

	  $results = $this->model_catalog_ocfilter->getOCFilterOptionsByCategoryId($this->category_id);

    if ($results) {
	 		$options = array_merge($options, $results);
		}

    $options_data = array();

    $index = 0;

	  foreach ($options as $key => $option) {
      if ($option['type'] == 'select') {
        $option['type'] = 'radio';
        $option['selectbox'] = true;
      }

      $this_option = isset($this->options_get[$option['option_id']]);

			$values = array();

      if ($option['type'] != 'slide' && $option['type'] != 'slide_dual') {
				foreach ($option['values'] as $value) {
					$this_value = isset($this->options_get[$option['option_id']]) && in_array($value['value_id'], $this->options_get[$option['option_id']]);

          $count = 0;

					if (isset($this->counters[$option['option_id'] . $value['value_id']])) {
						if ($this_option && $option['type'] == 'checkbox') {
							$count = '+' . $this->counters[$option['option_id'] . $value['value_id']];
						} else {
							$count = $this->counters[$option['option_id'] . $value['value_id']];
						}
					}

          if ($count || !$this->config->get('ocfilter_hide_empty_values')) {
						if (isset($option['image']) && $option['image'] && isset($value['image']) && $value['image'] && file_exists(DIR_IMAGE . $value['image'])) {
              $image = $this->model_tool_image->resize($value['image'], 19, 19);
						} else {
							$image = false;
						}

            $params = $this->getValueParams($option['option_id'], $value['value_id'], $option['type']);

	          $values[] = array(
	            'value_id' => $value['value_id'],
							'id'       => $option['option_id'] . $value['value_id'],
	            'name'     => html_entity_decode($value['name'] . (isset($option['postfix']) ? $option['postfix'] : ''), ENT_QUOTES, 'UTF-8'),
              'keyword'  => html_entity_decode((isset($value['keyword']) ? $value['keyword'] : $value['value_id']), ENT_QUOTES, 'UTF-8'),
							'color'    => ((isset($value['color']) && $value['color']) ? $value['color'] : '#FFFFFF'),
              'image'    => $image,
	            'params'   => $params,
							'count'    => $count,
	            'selected' => $this_value
	          );
					}
        }

        if (!$values) {
        	continue;
        }
      } else {
        $range = $this->model_catalog_ocfilter->getSliderRange($option['option_id'], array(
    			'filter_category_id' => $this->category_id,
          'filter_ocfilter' => $this->cancelOptionParams($option['option_id']),
        ));

        if ($range['min'] == $range['max']) {
        	continue;
        }

        $option['slide_value_min'] = $range['min'];
        $option['slide_value_max'] = $range['max'];
      }

      if ($option['type'] == 'radio') {
        $params = $this->cancelOptionParams($option['option_id']);

				if (isset($this->counters[$option['option_id'] . 'all'])) {
					$count = $this->counters[$option['option_id'] . 'all'];
				} else {
					$count = 1;
				}

        array_unshift($values, array(
          'value_id' => $option['option_id'],
					'id'       => 'cancel-' . $option['option_id'],
          'name'     => $this->language->get('text_any'),
          'params'   => $params,
					'count'    => $count,
          'selected' => !$this_option
        ));
			}

      $option_data = array(
        'option_id'           => $option['option_id'],
        'index'               => ++$index,
       	'name'                => html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8'),
        'selectbox'           => (isset($option['selectbox']) ? $option['selectbox'] : false),
        'color'			          => (isset($option['color']) ? $option['color'] : false),
        'image'		            => (isset($option['image']) ? $option['image'] : false),
        'keyword'		          => (isset($option['keyword']) ? $option['keyword'] : $option['option_id']),
				'postfix' 		        => (isset($option['postfix']) ? html_entity_decode($option['postfix'], ENT_QUOTES, 'UTF-8') : ''),
        'description'         => (isset($option['description']) ? $option['description'] : ''),
        'slide_value_min'     => (isset($option['slide_value_min']) ? $option['slide_value_min'] : 0),
        'slide_value_max'     => (isset($option['slide_value_max']) ? $option['slide_value_max'] : 0),
        'slide_value_min_get' => (isset($option['slide_value_min']) ? $option['slide_value_min'] : 0),
        'slide_value_max_get' => (isset($option['slide_value_max']) ? $option['slide_value_max'] : 0),
        'type'                => $option['type'],
        'selected'            => $this_option,
        'values'              => $values
      );

      if (($option['type'] == 'slide' || $option['type'] == 'slide_dual') && isset($this->options_get[$option['option_id']][0])) {
        $range = getRangeParts($this->options_get[$option['option_id']][0]);

        if (isset($range['from']) && isset($range['to'])) {
          $option_data['slide_value_min_get'] = $range['from'];
          $option_data['slide_value_max_get'] = $range['to'];

          // For getSelectedOptions
          array_unshift($option_data['values'], array(
            'value_id' => $range['from'] . '-' . $range['to'],
            'name'     => 'от ' . $range['from'] . ' до ' . $range['to'] . $option['postfix']
          ));
        }
      }

      $options_data[] = $option_data;
    } // End options each

    $this->options = $options_data;

    return $options_data;
  }

	protected function getValueParams($option_id, $value_id, $type = 'checkbox') {
		$decoded_params = decodeParamsFromString($this->params, $this->config);

		if ($type == 'checkbox') {
			if (isset($decoded_params[$option_id])) {
				if (false !== $key = array_search($value_id, $decoded_params[$option_id])) {
					unset($decoded_params[$option_id][$key]);
				} else {
					$decoded_params[$option_id][] = $value_id;
				}
			} else {
				$decoded_params[$option_id] = array($value_id);
			}
 		} else if ($type == 'select' || $type == 'radio') {
			if (isset($decoded_params[$option_id])) {
				unset($decoded_params[$option_id]);
			}

			$decoded_params[$option_id] = array($value_id);
		}

		return encodeParamsToString($decoded_params, $this->config);
	}

  protected function cancelOptionParams($option_id) {
    if ($this->params) {
			$params = decodeParamsFromString($this->params, $this->config);

			if (isset($params[$option_id])) {
				unset($params[$option_id]);
			}

			return encodeParamsToString($params, $this->config);
    }
  }

  protected function getSelectedOptions() {
    $selected_options = array();

    $category_options = $this->getOCFilterOptions();

    if ($this->min_price_get && $this->max_price_get) {
      $category_options[] = array(
        'option_id' => 'p',
        'name'      => $this->language->get('text_price'),
				'type'      => 'select',
        'selected'  => isset($this->options_get['p']),
        'values'    => array(array(
					'value_id' 	=> $this->min_price_get . '-' . $this->max_price_get,
          'name' 			=> 'от ' . $this->currency->getSymbolLeft($this->session->data['currency']) . $this->min_price_get . ' до ' . $this->max_price_get . $this->currency->getSymbolRight($this->session->data['currency'])
				))
      );
    }

		foreach ($category_options as $option) {
			if (!$option['selected']) {
				continue;
			}

      $option_id = $option['option_id'];

			$values = array();

			foreach ($option['values'] as $value) {
        if (!in_array($value['value_id'], $this->options_get[$option_id])) {
          continue;
				}

			  $params = '';

        if (count($this->options_get) > 1 || count($this->options_get[$option_id]) > 1) {
          if ($option['type'] == 'radio' || $option['type'] == 'select' || $option['type'] == 'slide' || $option['type'] == 'slide_dual') {
            $params .= $this->cancelOptionParams($option_id);
          } else {
            $params .= $value['params'];
          }
        }

        $name = html_entity_decode($value['name'], ENT_QUOTES, 'UTF-8');

			  $values[] = array(
          'name' => $name,
          'id'   => $option_id . $value['value_id'],
          'href' => $this->link($params),
        );
			}

			$selected_options[$option_id] = array(
        'name'   		=> $option['name'],
        'values' 		=> $values
      );
		}

    return $selected_options;
  }

  public function decode() {
    if (isset($this->request->get['path'])) {
      $this->path = $this->request->get['path'];
    }

    if (!isset($this->request->get['_route_'])) {
      return;
    }

    $_route_ = $this->request->get['_route_'];

		$keywords = explode('/', $_route_);

		if (utf8_strlen(end($keywords)) == 0) {
			array_pop($keywords);
		}

    $ignored = array();

    $page_keywords = array();

    if (!$this->path) {
      $path_info = $this->model_catalog_ocfilter->decodeCategory($keywords);

      if ($path_info && $path_info->path) {
      	$this->path = $path_info->path;

        $ignored = $path_info->keywords;
      }
    }

    if (!$this->path) {
    	return;
    }

    $parts = explode('_', $this->path);

    $category_id = (int)end($parts);

    $key = array_search($this->session->data['language'], $keywords);

    if (false !== $key) {
    	$ignored[] = $keywords[$key];
    }

    foreach ($keywords as $key => $keyword) {
      if (in_array($keyword, $ignored)) {
      	continue;
      }

      $page_info = $this->model_catalog_ocfilter->decodePage($category_id, $keyword);

      if ($page_info) {
      	$this->page_info = $page_info;

  			$keywords = explode('/', $this->page_info['params']);

  			if (utf8_strlen(end($keywords)) == 0) {
  				array_pop($keywords);
  			}

        break;
      }
    }

    $params = array();

    foreach ($keywords as $key => $keyword) {
      if (in_array($keyword, $ignored)) {
      	continue;
      }

      if ($keyword == 'price') {
        unset($keywords[$key++]);

        $page_keywords[] = $keyword;

        if (isset($keywords[$key]) && isRange($keywords[$key])) {
      	  $params['p'] = array($keywords[$key]);

          $page_keywords[] = $keywords[$key];

          unset($keywords[$key]);
        }
      } else if ($keyword == 'sklad' && $this->config->get('ocfilter_stock_status_method') == 'quantity') {
        unset($keywords[$key++]);

        $page_keywords[] = $keyword;

        if (isset($keywords[$key]) && ($keywords[$key] == 'in' || $keywords[$key] == 'out')) {
          if (!isset($params['s'])) {
            $params['s'] = array();
          }

          $params['s'][$keywords[$key]] = $keywords[$key];

          $page_keywords[] = $keywords[$key];

          unset($keywords[$key]);
        }
      }
    }

    $current = '';

    foreach ($keywords as $key => $keyword) {
      if (in_array($keyword, $ignored)) {
      	continue;
      }

      $founded = 0;

      // Values
      if ($current == 's' && isID($keyword) && $this->config->get('ocfilter_stock_status_method') == 'stock_status_id') {
        $params['s'][$keyword] = $keyword;

        $founded = 1;
      } else if ($current) {
        $value_id = $this->model_catalog_ocfilter->decodeValue($keyword, $current);

        if ($value_id) {
          $params[$current][$value_id] = $value_id;

          $founded = 1;
        } else if (isRange($keyword)) { // If Slider
          $params[$current][$keyword] = $keyword;

          $founded = 2;
        }
      }

      if ($founded > 0) {
        $page_keywords[] = $keyword;

        if ($founded > 1) {
        	$current = '';
        }

      	unset($keywords[$key]);

        continue;
      }

      // Options
      if ($keyword == 'sklad' && $this->config->get('ocfilter_stock_status_method') == 'stock_status_id') {
      	$params['s'] = array();

        $current = 's';

        $page_keywords[] = $keyword;

        unset($keywords[$key]);
      } else if (!isRange($keyword)) {
        $option_id = $this->model_catalog_ocfilter->decodeOption($keyword, $category_id);

        if ($option_id) {
          $params[$option_id] = array();

          $current = $option_id;

          $page_keywords[] = $keyword;

          unset($keywords[$key]);
        }
      }
    }

    // Manufacturer
    foreach ($keywords as $key => $keyword) {
      $manufacturer_id = $this->model_catalog_ocfilter->decodeManufacturer($keyword);

      if ($manufacturer_id) {
        if (!isset($params['m'])) {
          $params['m'] = array();
        }

       	$params['m'][$manufacturer_id] = $manufacturer_id;

        $page_keywords[] = $keyword;

        unset($keywords[$key]);
      }
    }

    // Add category SEO keywords to _route_
    if ($this->page_info) {
    	$path = $this->model_catalog_ocfilter->getCategorySeoPathByCategoryId($this->page_info['category_id']);

      if ($path) {
        $parts = explode('/', $path);

        foreach (array_reverse($parts) as $part) {
          array_unshift($keywords, $part);
        }
      }
    }

    if (!$this->page_info && $page_keywords) {
    	$this->page_info = $this->model_catalog_ocfilter->getPage($category_id, implode('/', $page_keywords));
    }

    if ($keywords) {
    	$this->request->get['_route_'] = implode('/', $keywords);
    }

    if ($params) {
      $this->request->get['filter_ocfilter'] = encodeParamsToString($params, $this->config);

      if (isset($this->request->get['route'])) {
      	unset($this->request->get['route']);
      }
    }
  }

  public function rewrite($link) {
    $url_info = parse_url(str_replace('&amp;', '&', $link));

    if (!isset($url_info['query'])) {
    	return $link;
    }

		$data = array();

		parse_str($url_info['query'], $data);

    if (!isset($data['filter_ocfilter'])) {
      return $link;
    }

    $params = decodeParamsFromString($data['filter_ocfilter'], $this->config);

    unset($data['filter_ocfilter']);

    $path = '';

    foreach ($params as $option_id => $values) {
      if ($option_id == 'p') {
      	$path .= '/price';
      } else if ($option_id == 's') {
      	$path .= '/sklad';
      } else if ($option_id != 'm') {
        $query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "ocfilter_option WHERE option_id = '" . (int)$option_id . "'");

        if ($query->num_rows && $query->row['keyword']) {
        	$path .= '/' . $query->row['keyword'];
        } else {
        	$path .= '/' . $option_id;
        }
      }

      foreach ($values as $value_id) {
        $query = false;

        if ($option_id == 'm') {
          if ($this->registry->has('short_uri_queries')){
              $query            = new stdClass();
              $query->num_rows  = 1;
              $query->row       = ['keyword' => $this->registry->get('short_uri_queries')['manufacturer_id']  . (int)$value_id];


          } else {
            $query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE `query` = 'manufacturer_id=" . (int)$value_id . "'");
          }
        } else if (isID($value_id)) {
          $query = $this->db->query("SELECT keyword FROM " . DB_PREFIX . "ocfilter_option_value WHERE value_id = '" . $this->db->escape((string)$value_id) . "'");
        }

        if ($query && $query->num_rows && $query->row['keyword']) {
        	$path .= '/' . $query->row['keyword'];
        } else {
        	$path .= '/' . $value_id;
        }
      }
    }

    if ($path) {
      $page_path = ltrim($path, '/');

      $page_info = $this->model_catalog_ocfilter->getPage($this->category_id, $page_path);

      if ($page_info && $page_info['keyword']) {
      	$path = '/' . $page_info['keyword'];
      }
    }

    $rewrite = $url_info['scheme'] . '://' . $url_info['host'];

    if (isset($url_info['port'])) {
    	$rewrite .= ':' . $url_info['port'];
    }

    if (isset($url_info['path'])) {
    	$rewrite .= str_replace('/index.php', '', $url_info['path']);
    } else {
      $rewrite .= '/index.php';
    }

    if ($path) {
    	$rewrite = rtrim($rewrite, '/') . $path;

      if ($this->config->has('config_seo_url_type') && $this->config->get('config_seo_url_type') == 'seo_pro') {
      	$rewrite .= '/';
      }
    }

		$query = '';

		if ($data) {
			foreach ($data as $key => $value) {
				$query .= '&' . rawurlencode((string)$key) . '=' . rawurlencode((is_array($value) ? http_build_query($value) : (string)$value));
			}

			if ($query) {
				$query = '?' . str_replace('&', '&amp;', trim($query, '&'));
			}
		}

    $rewrite .= $query;

		return $rewrite;
  }

  public function getPageInfo() {
    return $this->page_info;
  }

  public function getSelectedsFilterTitle() {
    $filter_title = '';

    $selecteds = $this->getSelectedOptions();

    foreach ($selecteds as $option_id => $option) {
      if ($filter_title) {
        $filter_title .= ', ';
      }

      if ($option_id == 'm') {
        $values_name  = '';

        foreach ($option['values'] as $value) {
          if ($values_name) {
          	$values_name .= ', ';
          }

      	  $values_name .= $value['name'];
        }

        if ($values_name) {
        	$filter_title .= $values_name;
        }
      } else if ($option_id == 'p') {
        $price = array_shift($option['values']);

        $filter_title .= $price['name'];
      } else if ($option_id == 's') {
        if ($this->config->get('ocfilter_stock_status_method') == 'quantity') {
          $stock_status = array_shift($option['values']);

          if ($stock_status['name'] == 'in') {
            $filter_title .= 'в наличии';
          } else if ($stock_status['name'] == 'out') {
            $filter_title .= 'нет в наличии';
          }
        } else {
          $values_name  = '';

          foreach ($option['values'] as $value) {
            if ($values_name) {
            	$values_name .= ', ';
            }

        	  $values_name .= $value['name'];
          }

          if ($values_name) {
          	$filter_title .= $values_name;
          }
        }
      } else {
        $values_name  = '';

        foreach ($option['values'] as $value) {
          if ($values_name) {
          	$values_name .= ', ';
          }

      	  $values_name .= $value['name'];
        }

        if ($values_name) {
        	$filter_title .= $option['name'] . ' ' . $values_name;
        }
      }
    }

    return $filter_title;
  }

  protected function link($filter_ocfilter = '') {
    $url = '';

    if ($this->path) {
      $url .= '&path=' . (string)$this->path;
    }

    if ($filter_ocfilter) {
      $url .= '&filter_ocfilter=' . (string)$filter_ocfilter;
    }

    if (isset($this->request->get['sort'])) {
      $url .= '&sort=' . (string)$this->request->get['sort'];
    }

    if (isset($this->request->get['order'])) {
      $url .= '&order=' . (string)$this->request->get['order'];
    }

    if (isset($this->request->get['limit'])) {
      $url .= '&limit=' . (int)$this->request->get['limit'];
    }

    return $this->url->link('product/category', $url);
  }

  public function callback() {
    if (!$this->path) {
    	return;
    }

    $this->load->language('extension/module/ocfilter');

    $json = array();

    if (isset($this->request->get['option_id'])) {
    	$option_id = $this->request->get['option_id'];
    } else {
    	$option_id = 0;
    }

    $filter_data = array(
			'filter_category_id' => $this->category_id,
      'filter_ocfilter' => $this->params,
      'limit' => 1,
		);

    if ($this->config->get('ocfilter_sub_category')) {
    	$filter_data['filter_sub_category'] = true;
    }

		$total_products = $this->model_catalog_product->getTotalProducts($filter_data);

    $json['total'] = $total_products;
    $json['text_total'] = declOfNum($total_products, array(
                                      $this->language->get('button_show_total_1'),
                                      $this->language->get('button_show_total_2'),
                                      $this->language->get('button_show_total_3')
                                    ));

    $json['values'] = array();
    $json['sliders'] = array();

    if ($this->config->get('ocfilter_show_price') && $option_id != 'p') {
      $_filter_data = $filter_data;

      $_filter_data['filter_ocfilter'] = $this->cancelOptionParams('p');

      $product_prices = $this->model_catalog_ocfilter->getProductPrices($_filter_data);

      if ($product_prices) {
        $json['sliders']['p'] = array(
          'min' => $this->currency->format(floor($product_prices['min']), $this->session->data['currency'], '', false),
          'max' => $this->currency->format(ceil($product_prices['max']), $this->session->data['currency'], '', false),
        );
      }
    }

    $options = $this->getOCFilterOptions();

    foreach ($options as $option) {
      if ($option['type'] == 'slide' || $option['type'] == 'slide_dual') {
        if ($option['option_id'] != $option_id) {
          $json['sliders'][$option['option_id']] = $this->model_catalog_ocfilter->getSliderRange($option['option_id'], $filter_data);
        }

        continue;
      }

      if ($option['type'] == 'select' || $option['type'] == 'radio') {
        $params = $this->cancelOptionParams($option['option_id']);

        $json['values']['cancel-' . $option['option_id']] = array(
          't' => 1,
          'p' => $params,
					's' => false
        );
			}

      foreach ($option['values'] as $value) {
        $json['values'][$value['id']] = array(
          't' => $value['count'],
          'p' => $value['params'],
					's' => isset($this->options_get[$option['option_id']][$value['value_id']])
        );
      }
    }

    $json['href'] = str_replace('&amp;', '&', $this->link($this->params));

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
  }
}
?>