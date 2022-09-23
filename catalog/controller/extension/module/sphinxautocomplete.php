<?php
	//*******************************************************************************
	// Sphinx Search v1.2.3
	// Author: Iverest EOOD
	// E-mail: sales@iverest.com
	// Website: http://www.iverest.com
	//*******************************************************************************
	
	class  ControllerExtensionModuleSphinxautocomplete extends Controller {
		
		public function sphinx_autocomplete_js()
		{
			if(!$this->config->get('sphinx_search_module') || !$this->config->get('sphinx_search_autocomple')) {
				return '';
			}
			
			$this->load->language('extension/module/sphinx');
			
			$data['sphinx_autocomple_selector'] = $this->config->get('sphinx_autocomple_selector');
			$data['label_categories'] = $this->language->get('label_categories');
			$data['label_products'] = $this->language->get('label_products');
			$data['label_view_all'] = $this->language->get('label_view_all');
			$data['text_no_results'] = $this->language->get('text_no_results');
			
			$ssl = false;
			
			if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
				$ssl = true;
			}
			
			$query_string = 'search';
			$version = (!defined('VERSION')) ? 140 : (int)substr(str_replace('.', '', VERSION), 0, 3);
			if ($version < 150) { $query_string = 'keyword'; }
			if ($version < 155) { $query_string = 'filter_name'; }
			
			$data['search_url'] = $this->url->link('product/search', 'wildcard=true&' . $query_string .'=', $ssl);
			$data['autocomplete_url'] = $this->url->link('extension/module/sphinxautocomplete', 'search=', $ssl);
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/sphinxautocomplete')) {
				$this->template = $this->config->get('config_template') . '/template/extension/module/sphinxautocomplete';
				} else {
				$this->template = 'default/template/extension/module/sphinxautocomplete';
			}
			
			return $this->load->view('extension/module/sphinxautocomplete', $data);
			
		}
		
		public function index() {
			
			$categories = array();
			$products = array();
			
			if (!isset($this->request->get['search']) || trim($this->request->get['search']) == '') {
				$this->response->setOutput(json_encode(array('products' => $products, 'categories' => $categories)));
				return;
			}
			
			$this->load->model('catalog/sphinx');
			
			$autoCompleteLimit = (int)$this->config->get('sphinx_autocomple_limit');
			if (!$autoCompleteLimit) {
				$autoCompleteLimit = 5;
			}
			
			$searchData = array(
			'filter_name' 	=> $this->request->get['search'],
			'sort' 			=> 'default',
			'filter_category_id' => 0,
			'start' 		=> 0,
			'limit' 		=> $autoCompleteLimit
			);
			
			$resultsProducts = $this->model_catalog_sphinx->search($searchData, 'products', true);
			extract($resultsProducts);		
			
			if ($resultsProducts['product_total'] == 0){
				$this->load->library('hobotix/Morphology');
				$Morphology = new hobotix\Morphology;
				
				$searchData['filter_name'] = $Morphology->orfFilter($searchData['filter_name']);												
				
				$resultsProducts = $this->model_catalog_sphinx->search($searchData, 'products', true);
				extract($resultsProducts);		
			}
			
			if ($resultsProducts['product_total'] == 0){
				
				$data['search_suggestion'] = $this->model_catalog_sphinx->buildSuggestion($searchData['filter_name'], $lastQueryKeywords); 	
				
				if (!empty($data['search_suggestion']) && $data['search_suggestion']){
					unset($product_total);
					unset($results);
					
					$searchData['filter_name'] = $data['search_suggestion'];
					
					$resultsProducts = $this->model_catalog_sphinx->search($searchData, 'products', true);	
				}
			}
			
			$this->load->model('tool/image');
			$this->load->model('catalog/product');
			
			foreach ($resultsProducts['results'] as $product) {
				$image = $this->model_tool_image->resize(($product['image']) ? $product['image'] : 'placeholder.png', 40, 40);
				
				$products[] = array(
				'name'			=> $product['name'],
				'href'			=> $this->url->link('product/product', 'product_id=' . $product['product_id']),
				'image'			=> $image,
				);
			}
			
			if (!(int)$this->config->get('sphinx_search_autocomplete_categories') || !(int)$this->config->get('sphinx_autocomplete_cat_limit')) {
				$this->response->setOutput(json_encode(array('products' => $products, 'categories' => $categories)));
				return;
			}
			
			$autoCompleteCatLimit = (int)$this->config->get('sphinx_autocomplete_cat_limit');
			
			if (!$autoCompleteCatLimit) {
				$autoCompleteCatLimit = 5;
			}
			
			$searchData['limit'] = $autoCompleteCatLimit;
			
			$resultsCategories = $this->model_catalog_sphinx->search($searchData, 'categories', true);
			
			if (count($resultsCategories['results']) == 0){
				$data['search_suggestion'] = $this->model_catalog_sphinx->buildSuggestion($this->request->get['search'], $lastQueryKeywords); 								
				
				if (!empty($data['search_suggestion']) && $data['search_suggestion']){										
					$searchData['filter_name'] = $data['search_suggestion'];
					
					$resultsProducts = $this->model_catalog_sphinx->search($searchData, 'categories', true);	
				}
			}
			
			foreach ($resultsCategories['results'] as $category) {
				if($category['image']) {
					$image = $this->model_tool_image->resize($category['image'], 40, 40);
					} else {
					$image = '';
				}
				
				$categories[] = array(
				'name' => $category['name'],
				'href' => $this->url->link('product/category', 'path='.$category['category_id']),
				'image' => $image
				);
			}
			
			$this->response->setOutput(json_encode(array('products' => $products, 'categories' => $categories)));
		}
		
	}
?>