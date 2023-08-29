<?php
	class ModelCatalogProduct extends Model {
		public function updateViewed($product_id) {
			//$this->db->query("UPDATE " . DB_PREFIX . "product SET viewed = (viewed + 1) WHERE product_id = '" . (int)$product_id . "'");
		}				
		
		public function prepareProductArray($results){
			$this->load->model('tool/image');		
			
			$return = array();			
			
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
					} else {
					$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_related_width'), $this->config->get($this->config->get('config_theme') . '_image_related_height'));
				}
				
				if ($this->customer->isLogged() || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
					$price = false;
				}
				
				if (($this->customer->isLogged() || !$this->config->get('config_customer_price')) && $result['count_of_parts'] > 1 && $result['price_of_part'] ) {
					$price_of_part = $this->currency->format($this->tax->calculate($result['price_of_part'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
					$price_of_part = false;
				}
				
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
					$special = false;
				}

				if ((float)$result['price_of_part_special']) {
					$price_of_part_special = $this->currency->format($this->tax->calculate($result['price_of_part_special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
					$price_of_part_special = false;
				}

				if ((float)$result['dl_price']) {
					$dl_price = $this->currency->format($this->tax->calculate($result['dl_price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					} else {
					$dl_price = false;
				}
				
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
					} else {
					$tax = false;
				}
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
					} else {
					$rating = false;
				}						

				$href 				= $this->url->link('product/product', 'product_id=' . $result['product_id']);
				$href_analog 		= $this->url->link('product/product', 'product_id=' . $result['product_id'] . '&product-display=analog');
				$href_instruction 	= $this->url->link('product/product', 'product_id=' . $result['product_id'] . '&product-display=instruction');	

				if ($result['has_analogues']){
					$href = $href_analog;
				}					
				
				$return[$result['product_id']] = array(
				'product_id'  		=> $result['product_id'],
				'seo'		  		=> $result['seo'],
				'ecommerceCurrency' => $this->session->data['currency'],
				'ecommerceData'	   	=> $result['ecommerceData'],
				'thumb'       		=> $image,
				'name'        		=> $result['name'],
				'description' 		=> utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..',
				'price'       		=> $price,
				'manufacturer'    	=> $result['manufacturer'],
				'quantity'    		=> $result['quantity'],
				'count_of_parts' 	=> $result['count_of_parts'],
				'pov_part_id' 		=> $result['pov_part_id'],
				'price_of_part' 			=> $price_of_part,
				'price_of_part_special' 	=> $price_of_part_special,
				'dl_price' 			=> $dl_price,
				'text_full_pack'    => sprintf($this->language->get('text_full_pack'), $result['count_of_parts']),
				'text_part_pack'	=> $this->language->get('text_part_pack'),
				'special'     		=> $special,
				'tax'         		=> $tax,
				'rating'      		=> $rating,
                'reviews'     		=> $result['reviews'],
				'backlight' 		=> $result['backlight'],
				'no_shipping' 		=> $result['no_shipping'],
				'no_payment'  		=> $result['no_payment'],
				'is_receipt'  		=> $result['is_receipt'],
				'is_thermolabel'  	=> $result['is_thermolabel'],
				'has_analogues'		=> $result['has_analogues'],
				'product_xdstickers' => $result['product_xdstickers'],
				'minimum'     		=> $result['minimum'] > 0 ? $result['minimum'] : 1,
				'href'        		=> $href,
				'href_analog'		=> $href_analog,
				'href_instruction'	=> $href_instruction,
				);
			}
			return $return;
		}

		public function getProductInstruction($product_id){
			$query = $this->db->query("SELECT reg_instruction FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

			if (!empty($query->row['reg_instruction']) && file_exists(DIR_INSTRUCTIONS . $query->row['reg_instruction'])){
				$extension 	= pathinfo($query->row['reg_instruction'], PATHINFO_EXTENSION);
				$filename 	= pathinfo($query->row['reg_instruction'], PATHINFO_FILENAME);

				if ($extension == 'pdf'){
					return [
						'from' 			=> 'file',
						'type' 			=> 'pdf',		
						'instruction' 	=> $query->row['reg_instruction']
					];
				}

				if ($extension == 'html'){
					if (file_exists(DIR_INSTRUCTIONS . $query->row['reg_instruction'])){
						return [
							'from' 			=> 'file',
							'type' 			=> 'html', 
							'file' 			=> $query->row['reg_instruction'],
							'instruction' 	=> file_get_contents(DIR_INSTRUCTIONS . $query->row['reg_instruction'])
						];
					}
				}
			}			

			$query = $this->db->query("SELECT instruction FROM " . DB_PREFIX . "product_description WHERE product_id = '" . (int)$product_id . "' AND language_id = '" . (int)$this->config->get('config_language_id') . "'");			

			if ($query->num_rows){
				return [
					'from' 			=> 'db',
					'instruction' 	=> $query->row['instruction']
				];
			}			

			return false;
		}	

		public function getProductLikReestr($product_id){
			$query = $this->db->query("SELECT reg_json FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");

			if ($query->num_rows){
				return $query->row['reg_json'];
			}

			return '';
		}	
				
		public function getProductEcommerceData($product){												
		}
		
		protected function getPath($parent_id, $current_path = '') {
			$this->load->model('catalog/category');	
			$category_info = $this->model_catalog_category->getCategory($parent_id);
			
			if ($category_info) {
				if (!$current_path) {
					$new_path = $category_info['category_id'];
					} else {
					$new_path = $category_info['category_id'] . '_' . $current_path;
				}
				
				$path = $this->getPath($category_info['parent_id'], $new_path);
				
				if ($path) {
					return $path;
					} else {
					return $new_path;
				}
			}
		}

		public function getGoogleCategoryPathForCategory($category_id){
			if (!$string = $this->cache->get('category.google.tree.' . $category_id . '.' . $this->config->get('config_language_id'))){

				$query = $this->db->query("SELECT google_tree FROM " . DB_PREFIX . "category_description WHERE category_id = '" . $category_id . "' AND language_id = '" . $this->config->get('config_language_id') . "' LIMIT 1");
				if (!$query->num_rows || empty($query->row['google_tree']) || !$string = $query->row['google_tree']){
					
					$path = $string = '';
					if (!empty($category_id)){				
						$path = $this->getPath($category_id);
					}
					
					if ($path) {
						$string = '';
						
						foreach (explode('_', $path) as $path_id) {
							$category_info = $this->model_catalog_category->getCategory($path_id);
							
							if ($category_info) {
								if (!$string) {
									$string = $category_info['name'];
								} else {
									$string .= '/' . $category_info['name'];
								}
							}
						}
					}

					$this->db->query("UPDATE " . DB_PREFIX . "category_description SET google_tree = '" . $this->db->escape($string) . "' WHERE category_id = '" . $category_id . "' AND language_id = '" . $this->config->get('config_language_id') . "'");
				}
				$this->cache->set('category.google.tree.' . $category_id . '.' . $this->config->get('config_language_id'), $string);
			}
			
			return $string;
		}
		
		public function getGoogleCategoryPath($product_id){

			if (!$string = $this->cache->get('productfullpath.' . (int)$product_id . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'))){
				$this->load->model('catalog/category');	
				
				$category = $this->db->query("SELECT category_id FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' ORDER BY main_category DESC LIMIT 1")->row;
				
				$path = $this->getPath($category['category_id']);
				
				if ($path) {
					$string = '';
					
					foreach (explode('_', $path) as $path_id) {
						$category_info = $this->model_catalog_category->getCategory($path_id);
						
						if ($category_info) {
							if (!$string) {
								$string = $category_info['name'];
								} else {
								$string .= '/' . $category_info['name'];
							}
						}
					}
				}
				
				$this->cache->set('productfullpath.' . (int)$product_id . '.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id'), $string);
			}
			
			return $string;
		}
		
		public function getProductPrimenenie($product_id) {
			$product_category_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_primenenie WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_category_data[] = $result['primenenie_id'];
			}
			
			return $product_category_data;
		}
				
		public function getProductTags($product_id) {
			$product_category_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_tags WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_category_data[] = $result['tags_id'];
			}
			
			return $product_category_data;
		}	
		
		public function getProductCollection($product_id){
			$query = $this->db->query("SELECT collection_id FROM " . DB_PREFIX . "product_to_collection WHERE product_id = '" . (int)$product_id . "' AND main_collection = 1");
			
			if ($query->num_rows) {
				return $query->row['collection_id'];
				} else {
				return 0;
			}					
		}
		
		public function getProductCollectionLevelZero($product_id){
			$query = $this->db->query("SELECT cp.path_id, cd.name FROM " . DB_PREFIX . "collection_path cp LEFT JOIN " . DB_PREFIX . "collection_description cd ON (cd.collection_id = cp.path_id) WHERE cp.collection_id = (SELECT collection_id FROM " . DB_PREFIX . "product_to_collection WHERE product_id = '" . (int)$product_id . "' AND main_collection = 1 LIMIT 1) AND level = 0 AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' LIMIT 1");
			
			
			if ($query->num_rows) {
				return $query->row;
				} else {
				return 0;
			}
		}
		
		public function getProduct($product_id, $explicit = false) {
			
			$product_info = $this->cache->get('product.info.' . $product_id . '.'.(int)$this->config->get('config_language_id'));
			
			if($product_info){
				return $product_info;
				
				} else {

				$sql = "SELECT DISTINCT *, p.is_preorder, p.no_advert, p.no_payment, p.no_shipping, p.count_of_parts, p.price_of_part, pd.name AS name, p.image, (SELECT md.name FROM " . DB_PREFIX . "manufacturer_description md WHERE md.manufacturer_id = p.manufacturer_id AND md.language_id = '" . (int)$this->config->get('config_language_id') . "') AS manufacturer, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount,
				
				(SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special,

				(SELECT type FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special_type,
				
				(SELECT date_end FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special_date_end,
				
				(SELECT SUM(quantity) FROM " . DB_PREFIX . "stocks s WHERE s.product_id = p.product_id) AS stocks, 
				
				(SELECT points FROM " . DB_PREFIX . "product_reward pr WHERE pr.product_id = p.product_id AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "') AS reward, 
				
				(SELECT ss.name FROM " . DB_PREFIX . "stock_status ss WHERE ss.stock_status_id = p.stock_status_id AND ss.language_id = '" . (int)$this->config->get('config_language_id') . "') AS stock_status, 
				
				(SELECT wcd.unit FROM " . DB_PREFIX . "weight_class_description wcd WHERE p.weight_class_id = wcd.weight_class_id AND wcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS weight_class, 
				
				(SELECT lcd.unit FROM " . DB_PREFIX . "length_class_description lcd WHERE p.length_class_id = lcd.length_class_id AND lcd.language_id = '" . (int)$this->config->get('config_language_id') . "') AS length_class, 
				
				(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, 

				(SELECT category_id FROM " . DB_PREFIX . "product_to_category p2cm WHERE p2cm.product_id = p.product_id ORDER BY main_category DESC LIMIT 1) as main_category_id,
				
				(SELECT COUNT(*) AS total FROM " . DB_PREFIX . "review r2 WHERE r2.product_id = p.product_id AND r2.status = '1' GROUP BY r2.product_id) AS reviews, p.sort_order FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

				if (!$explicit){
					$sql .= " AND p.status = '1' ";
				}
				
				$query = $this->db->query($sql);

				$query->row['price'] 				= (float)$query->row['price'];
				$query->row['price_retail'] 		= (float)$query->row['price_retail'];
				$query->row['price_of_part'] 		= (float)$query->row['price_of_part'];
				$query->row['price_of_part_retail'] = (float)$query->row['price_of_part_retail'];
				$query->row['special'] 				= (float)$query->row['special'];

				if ($query->num_rows){
					$query->row['price_of_part_special'] = false;

					if (!empty($query->row['special'])){
						$query->row['price'] 			= $query->row['price_retail'];
						$query->row['price_of_part'] 	= $query->row['price_of_part_retail'];
					}									

					if (!empty($query->row['special']) && $query->row['special_type'] == '%'){
						if ($query->row['count_of_parts']){
							$query->row['price_of_part_special'] 	= $query->row['price_of_part'] - (($query->row['price_of_part']/100)*$query->row['special']);
						}

						$query->row['special'] 					= $query->row['price'] - (($query->row['price']/100)*$query->row['special']);
					} elseif (!empty($query->row['special']) && $query->row['special_type'] == '=') {
						if ($query->row['count_of_parts']){
							$query->row['price_of_part_special'] = round($query->row['special']/$query->row['count_of_parts'], 2);
						}
					}

					if ($query->row['special'] >= $query->row['price']){
						$query->row['special'] = 0;
					}
				}
				
				if ($query->num_rows){
					if (!$query->row['is_onstock']){
						$query->row['price'] = $query->row['special'] = $query->row['discount'] = 0;
					}
				}
				
				if ($query->num_rows && empty(trim($query->row['name']))){
					$name_query = $this->db->query("SELECT name FROM " . DB_PREFIX . "product_description WHERE language_id = '2' AND product_id = '" . (int)$product_id . "' LIMIT 1");
					
					if ($name_query->num_rows){
						$query->row['name'] = $name_query->row['name'];
					}
				}
				
				//Проверка скидочной модели
				if ($query->num_rows){					
					$general_price = false;
					$has_pricegroup_discount = false;
					
					//Если у нас уже есть скидка, то мы не считаем эту вот самую
					if (!$query->row['special']) {
						if ($query->row['pricegroup_id']){							
							$pricegroup_discount = $this->getPriceGroupDiscountForCustomerGroup($query->row['pricegroup_id']);
							
							if ($pricegroup_discount && is_array($pricegroup_discount) && $pricegroup_discount['percent']){
								$general_price = $query->row['price'];
								$general_price_of_part = $query->row['price_of_part'];
								$has_pricegroup_discount = true;
								
								if ($pricegroup_discount['plus']){
									$query->row['price'] 			= $query->row['price'] + ($query->row['price'] / 100 * $pricegroup_discount['percent'] );
									$query->row['price_of_part'] 	= $query->row['price_of_part'] + ($query->row['price_of_part'] / 100 * $pricegroup_discount['percent'] );
									} else {
									$query->row['price'] 			= $query->row['price'] - ($query->row['price'] / 100 * $pricegroup_discount['percent'] );
									$query->row['price_of_part'] 	= $query->row['price_of_part'] - ($query->row['price_of_part'] / 100 * $pricegroup_discount['percent'] );
								}
							}						
						}
					}
				}				
				
				if ($query->num_rows) {										
						$this->load->model("tool/image");																		
						$ratingCount = $query->row['reviews'];
						
						if ($query->row['image']) {
							$image = $this->model_tool_image->resize($query->row['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
							} else {
							$image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
						}
						$href = $this->url->link('product/product', '&product_id=' . $query->row['product_id'] );
						$in_stok = 'InStock';
						if((int)$query->row['quantity'] < 1){
							$in_stok = 'OutOfStock';
						}
						
						$description = removequotes(strip_tags(html_entity_decode($query->row['description'], ENT_QUOTES, 'UTF-8')));
						if(strlen($description) < 3){
							$description = removequotes($query->row['name']);
						}
						
						$seo_price = $query->row['special']?$query->row['special']:$query->row['price'];
						
						$gtin = false;
						$barcodeValidator = new \Ced\Validator\Barcode();
						$barcodeValidator->setBarcode($query->row['ean']);
						if ($barcodeValidator->isValid()){
							$gtin = $barcodeValidator->getGTIN14();
						}	
						
						$seo = '
						<script type="application/ld+json"> 
						{
						"@context": "http://schema.org/",
						"@type": "Product",
						"name": "'. removequotes($query->row['name']) .'",
						"image": "' . $image . '",
						"brand": {
						"@type": "Brand",
						"name": "'. removequotes($query->row['manufacturer']) . '"
						},
						"mpn": "' . $query->row['product_id'] . '",';
						if ($gtin){
							$seo .= '"gtin": "' . $gtin . '",';	
						}
						$seo .= '"sku": "' . $query->row['product_id'] . '",
						"aggregateRating": {
						"@type": "AggregateRating",
						"name": "'. removequotes($query->row['name']) .'",
						"bestRating": 5,
						"worstRating": 1,
						"ratingCount": '.(($ratingCount) ? $ratingCount : 1).',
						"ratingValue": '.((round($query->row['rating']) > 0) ? round($query->row['rating']) : 1).',
						"reviewCount" : '.((((int)$query->row['reviews']) > 0) ? (int)$query->row['reviews'] : 1).'
						},
						"description": "' . $description . '",
						"offers": {
						"@type": "Offer",
						"url": "' . $href . '",
						"priceCurrency": "UAH",
						"price": "' . $seo_price  . '",
						"priceValidUntil": "'.date('Y-m-d').'",
						"itemCondition": "http://schema.org/NewCondition",
						"availability": "http://schema.org/'.$in_stok.'"
						}
						}
						</script>';				
					
					//Невозможность доставки и оплаты
					/*
						if (!$query->row['no_shipping']){
						$query_ns = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$query->row['product_id']. "' AND category_id IN (SELECT category_id FROM " . DB_PREFIX . "category WHERE no_shipping = 1)");
						
						if ($query_ns->num_rows){
						$query->row['no_shipping'] = true;
						}
						}
						
						if (!$query->row['no_payment']){
						$query_ns = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$query->row['product_id']. "' AND category_id IN (SELECT category_id FROM " . DB_PREFIX . "category WHERE no_payment = 1)");
						
						if ($query_ns->num_rows){
						$query->row['no_payment'] = true;
						}
						}
					*/
					
					if ($query->num_rows) {
						$ecommerceData = array(
						'id'		=> (int)$product_id,
						'name' 		=> prepareEcommString($query->row['name']),
						'gtin' 		=> prepareEcommString($query->row['ean']),			
						'brand' 	=> prepareEcommString($query->row['manufacturer']),		
						'price' 	=> prepareEcommString($query->row['special']?$query->row['special']:$query->row['price']),
						'category' 	=> prepareEcommString($this->getGoogleCategoryPathForCategory($query->row['main_category_id']))
						);
					}
					
										
					$this->load->model('extension/module/xdstickers');
					$xdstickers = $this->config->get('xdstickers');										
					
					$current_language_id = $this->config->get('config_language_id');
					$product_xdstickers = array();
					$data['xdstickers_position'] = ($xdstickers['position'] == '0') ? ' position_upleft' : ' position_upright';
					if ($xdstickers['status']) {
						if ($xdstickers['sale']['status'] == '1' && $special) {
							if ($xdstickers['sale']['discount_status'] == '1') {
								$sale_value = round(((float)$query->row['price'] - (float)$query->row['special']) / ((float)$query->row['price'] * 0.01));
								$sale_text = $xdstickers['sale']['text'][$current_language_id] . ' -' . strval($sale_value) . '%';
								} else {
								$sale_text = $xdstickers['sale']['text'][$current_language_id];
							}								
							$product_xdstickers[] = array(
							'id'			=> 'xdsticker_sale',
							'text'			=> $sale_text
							);
						}
						if ($xdstickers['bestseller']['status'] == '1') {												
							if ($query->row['bestseller']){
								$product_xdstickers[] = array(
								'id'			=> 'xdsticker_bestseller',
								'text'			=> $xdstickers['bestseller']['text'][$current_language_id]
								);
							}					
						}
						if ($xdstickers['novelty']['status'] == '1') {
							if ((strtotime($query->row['date_added']) + intval($xdstickers['novelty']['property']) * 24 * 3600) > time()) {
								$product_xdstickers[] = array(
								'id'			=> 'xdsticker_novelty',
								'text'			=> $xdstickers['novelty']['text'][$current_language_id]
								);
							}
						}
						if ($xdstickers['last']['status'] == '1') {
							if ($query->row['quantity'] <= intval($xdstickers['last']['property']) && $query->row['quantity'] > 0) {
								$product_xdstickers[] = array(
								'id'			=> 'xdsticker_last',
								'text'			=> $xdstickers['last']['text'][$current_language_id]
								);
							}
						}
						if ($xdstickers['freeshipping']['status'] == '1') {
							if ((float)$query->row['special'] >= intval($xdstickers['freeshipping']['property'])) {
								$product_xdstickers[] = array(
								'id'			=> 'xdsticker_freeshipping',
								'text'			=> $xdstickers['freeshipping']['text'][$current_language_id]
								);
								} else if ((float)$query->row['price'] >= intval($xdstickers['freeshipping']['property'])) {
								$product_xdstickers[] = array(
								'id'			=> 'xdsticker_freeshipping',
								'text'			=> $xdstickers['freeshipping']['text'][$current_language_id]
								);
							}
						}
						
						// STOCK stickers
						/*if (isset($xdstickers['stock']) && !empty($xdstickers['stock'])) {
							foreach($xdstickers['stock'] as $key => $value) {
								if (isset($value['status']) && $value['status'] == '1' && $key == $query->row['stock_status_id'] && $query->row['quantity'] <= 0) {
									$product_xdstickers[] = array(
									'id'			=> 'xdsticker_stock_' . $key,
									'text'			=> $query->row['stock_status']
									);
								}
							}
						}

						if (isset($xdstickers['stock']) && !empty($xdstickers['stock'])) {
							foreach($xdstickers['stock'] as $key => $value) {
								if ($key == 7 && $query->row['quantity'] > 0){
									$product_xdstickers[] = array(
										'id'			=> 'xdsticker_stock_7',
										'text'			=> $xdstickers['stock'][7]['text'][$current_language_id]
									);
								}
							}
						}
						*/
						
						// CUSTOM stickers
						$this->load->model('extension/module/xdstickers');
						$custom_xdstickers_id = $this->model_extension_module_xdstickers->getCustomXDStickersProduct($query->row['product_id']);
						if (!empty($custom_xdstickers_id)) {
							foreach ($custom_xdstickers_id as $custom_xdsticker_id) {
								$custom_xdsticker = $this->model_extension_module_xdstickers->getCustomXDSticker($custom_xdsticker_id['xdsticker_id']);
								$custom_xdsticker_text = json_decode($custom_xdsticker['text'], true);
								if ($custom_xdsticker['status'] == '1') {
									$custom_sticker_class = 'xdsticker_' . $custom_xdsticker_id['xdsticker_id'];
									$product_xdstickers[] = array(
									'id'			=> $custom_sticker_class,
									'text'			=> $custom_xdsticker_text[$current_language_id]
									);
								}
							}
						}
					}
					
					if ($query->row['stocks'] > 0){
						$query->row['is_preorder'] = 0;
					}

					$has_analogues = 0;
					if (!$query->row['quantity'] && $query->row['reg_atx_1']){
						$same_results 	= $this->getProductSame($product_id, ['product_id' => $product_id, 'reg_atx_1' => $query->row['reg_atx_1']], 20, true);
						$analog_results = $this->getProductAnalog($product_id, ['product_id' => $product_id, 'reg_atx_1' => $query->row['reg_atx_1']], array_keys($same_results), 20, true);						

						$has_analogues = (count($same_results) + count($analog_results));
					}	
					
					
					$return = array(
                    'product_id'       => $query->row['product_id'],
                    'name'             => removequotes($query->row['name']),
                    'seo'              => $seo,
					'ecommerceData'	   => $ecommerceData,
                    'description'      => $query->row['description'],
                    'special_date_end' => $query->row['special_date_end'],
                    'instruction'      => $query->row['instruction'],
                    'reg_json'         => $query->row['reg_json'],
                    'reg_trade_name'         => $query->row['reg_trade_name'],
                    'reg_unpatented_name'    => $query->row['reg_unpatented_name'],                   
                    'reg_atx_1'    	   => $query->row['reg_atx_1'],
                    'reg_instruction'  => $query->row['reg_instruction'],
					'backlight' 	   => ($query->row['backlight']!='#000000')?$query->row['backlight']:'',
					'no_shipping'      => $query->row['no_shipping'],
					'no_payment'       => $query->row['no_payment'],
					'is_drug'		   => $drugQuery->num_rows,
					'is_receipt'       => $query->row['is_receipt'],
					'is_thermolabel'   => $query->row['is_thermolabel'],
					'no_advert'        => $query->row['no_advert'],
					'is_pko'        	=> $query->row['is_pko'],
					'is_drug'        	=> $query->row['is_drug'],
					'has_analogues'		=> $has_analogues,
                    'meta_title'       => removequotes($query->row['meta_title']),
                    'meta_description' => removequotes($query->row['meta_description']),
                    'meta_keyword'     => removequotes($query->row['meta_keyword']),
                    'tag'              => $query->row['tag'],
                    'model'            => $query->row['model'],
                    'sku'              => $query->row['sku'],
                    'upc'              => $query->row['upc'],
                    'ean'              => $query->row['ean'],
                    'jan'              => $query->row['jan'],
                    'isbn'             => $query->row['isbn'],
                    'mpn'              => $query->row['mpn'],
                    'reg_number'       => $query->row['reg_number'],
                    'morion'	       => $query->row['upc'],
                    'uuid'             => $query->row['uuid'],
                    'location'         => $query->row['location'],					
                    'quantity'         => $query->row['quantity'],
                    'stock_status'     => $query->row['stock_status'],
					'stock_status_id'  => $query->row['stock_status_id'],
                    'is_preorder'      => $query->row['is_preorder'],
                    'image'            => $query->row['image'],
                    'manufacturer_id'  => $query->row['manufacturer_id'],
                    'manufacturer'     => $query->row['manufacturer'],
					'count_of_parts'   => $query->row['count_of_parts'],
					'name_of_part'     => $query->row['name_of_part'],
					'pov_part_id'	   => $this->getProductFastPartOption($query->row['product_id']),
                    'price'            => ($query->row['discount'] ? $query->row['discount'] : $query->row['price']),
					'price_of_part'    		=> $query->row['price_of_part'],
					'price_of_part_special' => $query->row['price_of_part_special'],
					'price_retail'     		=> $query->row['price_retail'],
					'price_of_part_retail' 	=> $query->row['price_of_part_retail'],
					'has_dl_price' 			=> $query->row['has_dl_price'],
					'dl_price' 			=> $query->row['dl_price'],
                    'general_price'    		=> $general_price,
                    'has_pricegroup_discount' => $has_pricegroup_discount,
                    'special'          => $query->row['special'],
                    'reward'           => $query->row['reward'],
                    'points'           => $query->row['points'],
                    'tax_class_id'     => $query->row['tax_class_id'],
                    'date_available'   => $query->row['date_available'],
                    'weight'           => $query->row['weight'],
                    'weight_class_id'  => $query->row['weight_class_id'],
                    'length'           => $query->row['length'],
                    'width'            => $query->row['width'],
                    'height'           => $query->row['height'],
                    'length_class_id'  => $query->row['length_class_id'],
                    'main_category_id' => $query->row['main_category_id'],
                    'subtract'         => $query->row['subtract'],
                    'rating'           => round($query->row['rating']),
                    'reviews'          => $query->row['reviews'] ? $query->row['reviews'] : 0,
                    'minimum'          => $query->row['minimum'],
                    'sort_order'       => $query->row['sort_order'],
                    'status'           => $query->row['status'],
                    'date_added'       => $query->row['date_added'],
                    'date_modified'    => $query->row['date_modified'],
                    'viewed'           => $query->row['viewed'],
                    'sale_quantity'    => $query->row['sale_quantity'],
					'product_xdstickers' => $product_xdstickers
					);
					} else {
					$return = false;
				}
				
				$this->cache->set('product.info.' . $product_id.'.'.(int)$this->config->get('config_language_id'), $return);
				
				return $return;
			}
			
			}
			
		public function getProductUUID($product_id) {
			$query = $this->db->query("SELECT uuid FROM " . DB_PREFIX . "product WHERE product_id = '" . (int)$product_id . "'");
			
			return $query->row['uuid'];
		}
		
		public function setIndexes(){
		}
		
		public function getProducts($data = array(), $prevnext = false, $product_ids = array()) {		
			
			$sql = "SELECT DISTINCT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating_old, (SELECT COUNT(DISTINCT op.order_id) FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (o.order_id = op.order_id) WHERE product_id = p.product_id AND o.order_status_id = 5 AND o.date_added >= '" . date('Y-m-d', strtotime('-30 day')) . "') as rating,
			(SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT IF(type = '%', (p.price - p.price/100*price), price) FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";
			
			if (!empty($data['filter_name'])){
				
				$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));
				$wordquery = false;
				if (count($words) > 1){
					$implode = array();
					
					foreach ($words as $word) {
						if (mb_strlen(trim($word)) >= 2){
							$implode[] = "LOWER(pd.name) LIKE '%" . $this->db->escape(normalizeKeyErrString($word)) . "%'";
						}
					}
					
					if ($implode) {
						$wordquery = "( " . implode(" AND ", $implode) . " ) ";
					}								
				}
				
				$sql .= ", ";
				if (!$wordquery){
					$wordquery = 'FALSE';
				}
				
				$sql .= "IF (
				" . $wordquery . ", 9, 
				IF((pd.normalized_name LIKE ('%" . $this->db->escape(normalizeString($data['filter_name'])) . "%')), 8, 
				IF((p.is_searched = 1 AND pd.soundex_firstword LIKE ('" . $this->db->escape(transSoundex($data['filter_name'])) . "%')), 7, 
				IF((p.is_searched = 1 AND MATCH (pd.normalized_firstword) AGAINST ('" . $this->db->escape(normalizeString($data['filter_name'])) . "' IN BOOLEAN MODE)), 6, 
				IF((MATCH (pd.normalized_name) AGAINST ('" . $this->db->escape(normalizeString($data['filter_name'])) . "' IN BOOLEAN MODE)), 5,
				IF((MATCH (pd.normalized_name) AGAINST ('" . $this->db->escape(normalizeString($data['filter_name'])) . "' IN NATURAL LANGUAGE MODE)), 4, 1
				)))))) AS search_priority";
			}
			
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
					} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
				}
				
				if (!empty($data['filter_filter'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
					} else {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				}
				} elseif (!empty($data['filter_collection_id'])) {
				
				if (!empty($data['filter_sub_collection'])) {
					$sql .= " FROM " . DB_PREFIX . "collection_path cp LEFT JOIN " . DB_PREFIX . "product_to_collection p2c ON (cp.collection_id = p2c.collection_id)";
					} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_collection p2c";
				}
				
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				
				} else {
				$sql .= " FROM " . DB_PREFIX . "product p";
			}
			
			// OCFilter start
			if (!empty($data['filter_ocfilter'])) {
				$this->load->model('catalog/ocfilter');
				
				$ocfilter_product_sql = $this->model_catalog_ocfilter->getSearchSQL($data['filter_ocfilter']);
				} else {
				$ocfilter_product_sql = false;
			}
			
			if ($ocfilter_product_sql && $ocfilter_product_sql->join) {
				$sql .= $ocfilter_product_sql->join;
			}
			// OCFilter end
			
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE 1 AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
					} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}
				
				if (!empty($data['filter_filter'])) {
					$implode = array();
					
					$filters = explode(',', $data['filter_filter']);
					
					foreach ($filters as $filter_id) {
						$implode[] = (int)$filter_id;
					}
					
					$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
				}
				} elseif (!empty($data['filter_collection_id'])){
				if (!empty($data['filter_sub_collection'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_collection_id'] . "'";
					} else {
					$sql .= " AND p2c.collection_id = '" . (int)$data['filter_collection_id'] . "'";
				}
			}
			
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
				
				if (!empty($data['filter_name'])) {
					
					$sql .= " (  pd.normalized_name LIKE ('%" . $this->db->escape(normalizeString($data['filter_name'])) . "%') ) ";
					$sql .= " OR ( p.is_searched = 1 AND pd.soundex_firstword LIKE ('" . $this->db->escape(transSoundex($data['filter_name'])) . "%') ) ";
					$sql .= " OR (MATCH (pd.normalized_name) AGAINST ('" . $this->db->escape(normalizeString($data['filter_name'])) . "' IN NATURAL LANGUAGE MODE)) ";
					
					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));
					
					if (count($words) > 1){
						$implode = array();
						
						foreach ($words as $word) {
							if (mb_strlen(trim($word)) >= 2){
								$implode[] = "LOWER(pd.name) LIKE '%" . $this->db->escape(normalizeKeyErrString($word)) . "%'";
							}
						}
						
						if ($implode) {
							$sql .= " OR ( " . implode(" AND ", $implode) . " ) ";
						}								
					}										
					
					if (!empty($data['filter_description'])) {
						$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
					}
				}
				
				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}
				
				if (!empty($data['filter_tag'])) {
					$implode = array();
					
					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));
					
					foreach ($words as $word) {
						$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
					}
					
					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}
				}
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.model) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
				}
				
				$sql .= ")";
			}
			
			if(isset($data['filter_notnull_price']) && $data['filter_notnull_price']){
				$sql .= " AND p.price > 0";
			}
			
			if(isset($data['filter_in_stock']) && $data['filter_in_stock']){
				$sql .= " AND (p.quantity > 0 OR (p.quantity = 0 AND p.is_preorder = 1))";
			}
			
			if(isset($data['filter_dangerous']) && $data['filter_dangerous']){
				$sql .= " AND (p.no_payment = 0 AND p.is_receipt = 0 AND p.no_advert = 0)";
			}
			
			// OCFilter start
			if (!empty($ocfilter_product_sql) && $ocfilter_product_sql->where) {
				$sql .= $ocfilter_product_sql->where;
			}
			// OCFilter end
			
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
			
			$sort_data = array(
            'pd.name',            
            'p.quantity',
			'p.viewed',
            'p.price',
            'rating',
            'p.sort_order',
            'p.date_added',
			);			
			
			if (!empty($data['filter_name'])){
				
				$sql .= " ORDER BY (p.quantity > 0) DESC, (CASE WHEN search_priority > 6 THEN search_priority ELSE ((MATCH (pd.normalized_name) AGAINST ('" . $this->db->escape(normalizeString($data['filter_name'])) . "' IN NATURAL LANGUAGE MODE)) / 200) END) DESC ";
				
				} else {
				
				if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
					if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
						$sql .= " ORDER BY (p.quantity > 0) DESC, LCASE(" . $data['sort'] . ")";
						} elseif ($data['sort'] == 'p.price') {
						$sql .= " ORDER BY (p.quantity > 0) DESC, (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
						} else {
						$sql .= " ORDER BY (p.quantity > 0) DESC, " . $data['sort'];
					}
					} else {
					$sql .= " ORDER BY (p.quantity > 0) ";
				}
				
				
				if (isset($data['order']) && ($data['order'] == 'DESC')) {
					$sql .= " DESC, LCASE(pd.name) DESC";
					} else {
					$sql .= " ASC, LCASE(pd.name) ASC";
				}
			}
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}
				
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}
				
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
			
			$product_data = array();
			
			if ($_SERVER['REMOTE_ADDR'] == '31.43.104.37'){
				//var_dump($sql);			
			}
			
			$query = $this->db->ecquery($sql);
			
			
			foreach ($query->rows as $result) {			
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			return $product_data;
		}
		
		public function getPriceGroupDiscountForCustomerGroup($pricegroup_id){
			if (!$this->config->get('handling_status')){
				return false;
			}

			$query = $this->db->query("SELECT plus, percent FROM " . DB_PREFIX . "price_group_to_customer_group WHERE pricegroup_id = '" . (int)$pricegroup_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' LIMIT 1");
			
			if ($query->num_rows){
				return array(
                'plus' 	  => $query->row['plus'],
                'percent' => $query->row['percent']
				);
				} else {
				
				return false;			
			}			
		}
		
		public function getProductSpecials($data = array()) {
			$sql = "SELECT DISTINCT ps.product_id, ps.date_end, p.price,
			(SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = ps.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating ";
						
			if (!empty($data['filter_category_id'])) {
				$sql .= " FROM " . DB_PREFIX . "product_to_category p2c			
				LEFT JOIN " . DB_PREFIX . "product_special ps ON (p2c.product_id = ps.product_id)
				LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id)
				LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
				}else{
				$sql .= "FROM " . DB_PREFIX . "product_special ps
				LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id)
				LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)";
			}
			
			$sql .= " WHERE p.status = '1' AND p.date_available <= NOW() AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))";
			
			
			if (!empty($data['filter_category_id'])) {
				$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
			}
			
			$sql .= " GROUP BY ps.product_id";
			
			$sort_data = array(
			'pd.name',
			'p.model',
			'rating',
			'p.sort_order',
			'pd.name',
			'p.model',
			'p.quantity',
			'p.rating',
			'p.order_count',
			'p.is_onstock DESC, date_modified',
			'p.image',
			'p.price',
			'rating',
			'p.sort_order',
			'p.date_added'
			);
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY p.is_onstock DESC, LCASE(" . $data['sort'] . ")";
					} elseif ($data['sort'] == 'ps.price') {
					$sql .= " ORDER BY ps.price";
					} else {
					$sql .= " ORDER BY p.is_onstock DESC, " . $data['sort'];
				}
				} else {
				$sql .= " ORDER BY p.is_onstock DESC, p.order_count";
				
				/*
					if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
					$sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
					} else {
					$sql .= " ORDER BY " . $data['sort'];
					}
					} else {
					$sql .= " ORDER BY p.sort_order";
				*/
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC, LCASE(pd.name) DESC";
				} else {
				$sql .= " ASC, LCASE(pd.name) ASC";
			}
			
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}
				
				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}
				
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
			
			$product_data = array();
			
			$query = $this->db->query($sql);
			
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
				$product_data[$result['product_id']]['date_end'] = $result['date_end'];
			}
									
			return $product_data;
		}
		
		public function getLatestProducts($limit) {
			$this->cache->get('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);
			
			if (!$product_data) {
				$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.date_added DESC LIMIT " . (int)$limit);
				
				foreach ($query->rows as $result) {
					$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
				}
				
				$this->cache->set('product.latest.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
			}
			
			return $product_data;
		}

		public function getProductStock($product_id, $location_id){

			$sql = "SELECT s.*, ld.*, l.gmaps_link, l.can_sell_drugs, p.tax_class_id, p.is_preorder, p.is_pko, p.is_drug FROM " . DB_PREFIX . "stocks s 
			LEFT JOIN " . DB_PREFIX . "location l ON s.location_id = l.location_id 
			LEFT JOIN " . DB_PREFIX . "location_description ld ON l.location_id = ld.location_id 
			LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = s.product_id
			WHERE s.product_id = '" . (int)$product_id . "' 
			AND ld.language_id = '" . $this->config->get('config_language_id') . "' 
			AND s.location_id != 14 
			AND s.location_id IN (". implode(',', $this->cart->getOpenedStores()) .") 
			AND s.location_id = '" . (int)$location_id . "' ORDER BY l.sort_order ASC";
			
			$query = $this->db->ncquery($sql);

			return $query->row;
		}

		public function getProductStockSum($product_id){
			$query_total = $this->db->query("SELECT SUM(quantity) as total FROM " . DB_PREFIX . "stocks WHERE product_id = '" . (int)$product_id . "'");
			$query_drugstores = $this->db->query("SELECT COUNT(DISTINCT location_id) as total FROM " . DB_PREFIX . "stocks WHERE product_id = '" . (int)$product_id . "' AND quantity > 0");

			return [
				'quantity' 	 => $query_total->row['total'],
				'drugstores' => $query_drugstores->row['total'],
			];
		}		
		
		public function getProductStocks($product_id, $cached = false, $in_stock = false){
			$sql = "SELECT s.*, ld.*, l.gmaps_link, l.can_sell_drugs, l.information_id, p.tax_class_id, p.is_preorder, p.is_pko, p.is_drug FROM " . DB_PREFIX . "stocks s
			LEFT JOIN " . DB_PREFIX . "location l ON s.location_id = l.location_id 
			LEFT JOIN " . DB_PREFIX . "location_description ld ON l.location_id = ld.location_id 
			LEFT JOIN " . DB_PREFIX . "product p ON p.product_id = s.product_id
			WHERE s.product_id = '" . (int)$product_id . "'";

			if ($in_stock){
				$sql .= " AND s.quantity > 0 ";
			}

			$sql .= " AND ld.language_id = '" . $this->config->get('config_language_id') . "' AND s.location_id !=14 AND s.location_id IN (". implode(',', $this->cart->getOpenedStores()) .") ORDER BY l.sort_order ASC";
			
			if ($cached){
				$query = $this->db->query($sql);
			} else {
				$query = $this->db->ncquery($sql);
			}
			
			return $query->rows;			
		}
		
		public function getSimilarProductsByName($product_name, $product_id, $limit, $in_stock = false){
			$product_data = array();
			
			$sql = "SELECT DISTINCT pd.product_id FROM " . DB_PREFIX . "product_description pd 
			LEFT JOIN " . DB_PREFIX . "product p ON (pd.product_id = p.product_id) 
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) 
			WHERE pd.language_id = '" . $this->config->get('config_language_id') . "' 
			AND TRIM(LCASE(pd.name)) LIKE ('" . $this->db->escape(trim(mb_strtolower($product_name))) . "%')
			AND pd.product_id <> '" . (int)$product_id . "'
			AND p.status = '1'
			AND p.date_available <= NOW() 
			AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
			if ($in_stock){
				$sql .= " AND p.quantity > 0";
			}
			
			$sql .= " ORDER BY p.quantity DESC, p.image DESC LIMIT " . (int)$limit . "";
			
			
			if ($_SERVER['REMOTE_ADDR'] == '185.41.249.201'){
				//		$this->log->debug($sql);
			}
			
			$query = $this->db->query($sql);
			
			foreach ($query->rows as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			return $product_data;
		}
		
		public function getPopularProducts($limit) {
			$product_data = $this->cache->get('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit);
			
			if (!$product_data) {
				$query = $this->db->query("SELECT p.product_id FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.viewed DESC, p.date_added DESC LIMIT " . (int)$limit);
				
				foreach ($query->rows as $result) {
					$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
				}
				
				$this->cache->set('product.popular.' . (int)$this->config->get('config_language_id') . '.' . (int)$this->config->get('config_store_id') . '.' . $this->config->get('config_customer_group_id') . '.' . (int)$limit, $product_data);
			}
			
			return $product_data;
		}

		public function getLocalStockFeedProducts(){

			$sql = "SELECT p.product_id, p.price, s.location_id, s.quantity, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, s.location_id, s.quantity FROM " . DB_PREFIX . "stocks s LEFT JOIN " . DB_PREFIX . "product p ON (p.product_id = s.product_id) WHERE status = 1 AND p.price > 0";
			
			$query = $this->db->ncquery($sql);
			
			return $query->rows;
		}
		
		public function getSupplementalFeedProducts(){
			
			$sql = "SELECT p.product_id, p.quantity, p.price, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special FROM " . DB_PREFIX . "product p 
			WHERE status = 1 AND p.price > 0";
			
			$query = $this->db->ncquery($sql);
			
			return $query->rows;		
		}

		public function getJustProductAttributeValues($product_id, $attribute_ids = []) {
			$results = [];

			$query = $this->db->query("SELECT text FROM " . DB_PREFIX . "product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id IN (" . implode(',', $attribute_ids) . ")");

			foreach($query->rows as $row){
				if ($row['text']){
					$results[] = $row['text'];
				}
			}

			return array_unique($results);
		}
		
		public function getProductAttributes($product_id) {
			$product_attribute_group_data = array();
			
			$product_attribute_group_query = $this->db->query("SELECT ag.attribute_group_id, agd.name FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_group ag ON (a.attribute_group_id = ag.attribute_group_id) LEFT JOIN " . DB_PREFIX . "attribute_group_description agd ON (ag.attribute_group_id = agd.attribute_group_id) WHERE pa.product_id = '" . (int)$product_id . "' AND agd.language_id = '" . (int)$this->config->get('config_language_id') . "' GROUP BY ag.attribute_group_id ORDER BY ag.sort_order, agd.name");
			
			foreach ($product_attribute_group_query->rows as $product_attribute_group) {
				$product_attribute_data = array();
				
				$product_attribute_query = $this->db->query("SELECT a.attribute_id, ad.name, pa.text FROM " . DB_PREFIX . "product_attribute pa LEFT JOIN " . DB_PREFIX . "attribute a ON (pa.attribute_id = a.attribute_id) LEFT JOIN " . DB_PREFIX . "attribute_description ad ON (a.attribute_id = ad.attribute_id) WHERE pa.product_id = '" . (int)$product_id . "' AND a.attribute_group_id = '" . (int)$product_attribute_group['attribute_group_id'] . "' AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "' AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY a.sort_order, ad.name");
				
				foreach ($product_attribute_query->rows as $product_attribute) {
					$product_attribute_data[] = array(
                    'attribute_id' => $product_attribute['attribute_id'],
                    'name'         => $product_attribute['name'],
                    'text'         => $product_attribute['text']
					);
				}
				
				$product_attribute_group_data[] = array(
                'attribute_group_id' => $product_attribute_group['attribute_group_id'],
                'name'               => $product_attribute_group['name'],
                'attribute'          => $product_attribute_data
				);
			}
			
			return $product_attribute_group_data;
		}
		
		public function getProductFastPartOption($product_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov WHERE product_id = '" . (int)$product_id . "' AND option_id = 2 AND option_value_id = 2 LIMIT 1");
			
			if ($query->num_rows){
				return ['product_option_value_id' => $query->row['product_option_value_id'], 'product_option_id' => $query->row['product_option_id']];
			}
			
			return false;
		}
		
		public function getProductOptions($product_id) {
			$product_option_data = array();
			$product = $this->getProduct($product_id);
			
			$product_option_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY o.sort_order");
			
			foreach ($product_option_query->rows as $product_option) {
				$product_option_value_data = array();
				
				$product_option_value_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY ov.sort_order");
				
				
				foreach ($product_option_value_query->rows as $product_option_value) {					
					$general_price = false;
					$has_pricegroup_discount = false;
					if (!$product['special']){
						if ($product['pricegroup_id']){
							$pricegroup_discount = $this->getPriceGroupDiscountForCustomerGroup($product['pricegroup_id']);
							
							if ($pricegroup_discount && is_array($pricegroup_discount) && $pricegroup_discount['percent']){
								$general_price = $product_option_value['price'];
								$has_pricegroup_discount = true;
								
								if ($pricegroup_discount['plus']){
									$product_option_value['price'] = $product_option_value['price'] + ($product_option_value['price'] / 100 * $pricegroup_discount['percent'] );
									} else {
									$product_option_value['price'] = $product_option_value['price'] - ($product_option_value['price'] / 100 * $pricegroup_discount['percent'] );
								}
							}							
						}
					}

					$option_special = false;
					if (!empty($product['special'])){					
						$option_special =  round($product['special'] / $product['count_of_parts'], 2);
						$product_option_value['price'] = $product_option_value['price_retail'];
					}
					
					$product_option_value_data[] = array(
                    'product_option_value_id' => $product_option_value['product_option_value_id'],
                    'option_value_id'         => $product_option_value['option_value_id'],
                    'name'                    => $product_option_value['name'],
                    'image'                   => $product_option_value['image'],
                    'quantity'                => $product_option_value['quantity'],
                    'subtract'                => $product_option_value['subtract'],
                    'price'                   => $product_option_value['price'],
                    'special'                 => $option_special,
                    'price_retail'            => $product_option_value['price_retail'],
                    'price_prefix'            => $product_option_value['price_prefix'],
                    'weight'                  => $product_option_value['weight'],
                    'weight_prefix'           => $product_option_value['weight_prefix']
					);
				}
				
				$product_option_data[] = array(
                'product_option_id'    => $product_option['product_option_id'],
                'product_option_value' => $product_option_value_data,
                'option_id'            => $product_option['option_id'],
                'name'                 => $product_option['name'],
                'type'                 => $product_option['type'],
                'value'                => $product_option['value'],
                'required'             => $product_option['required']
				);
			}
			
			return $product_option_data;
		}
		
		public function getProductDiscounts($product_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$product_id . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity > 1 AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity ASC, priority ASC, price ASC");
			
			return $query->rows;
		}
		
		public function getProductImages($product_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");
			
			return $query->rows;
		}
		
		public function catchAlsoViewed($product_id)
		{
			
			if (empty($this->session->data['alsoViewed'])) {
				$this->session->data['alsoViewed'] = $product_id;
				} else {
				if (strstr($this->session->data['alsoViewed'], $product_id) == false) {
					$this->session->data['alsoViewed'] .= ',' . $product_id;
				}
			}
			
			$alsoViewed = explode(',', $this->session->data['alsoViewed']);
			
			sort($alsoViewed);
			
			$groupedalsoViewed = array();
			foreach ($alsoViewed as $k => $b) {
				for ($i = 1; $i < count($alsoViewed); $i++) {
					if (!empty($alsoViewed[$k + $i])) {
						$groupedalsoViewed[] = array('low' => $b, 'high' => $alsoViewed[$k + $i]);
					}
				}
			}
			
			if (empty($this->session->data['alsoViewed'])) {
				$this->session->data['alsoViewed'] = $product_id;
			}
			
			$alsoViewed = explode(',', $this->session->data['alsoViewed']);
			
			$groupedalsoViewed = array_slice($groupedalsoViewed, -4);
			
			foreach ($groupedalsoViewed as $p) {
				$this->db->ncquery("INSERT INTO `" . DB_PREFIX . "alsoviewed` (low, high, number, date_added) VALUES ('" . (int)$p['low'] . "', '" . (int)$p['high'] . "', '1', NOW()) ON DUPLICATE KEY UPDATE number = number+1");
			}
		}
		
		public function getProductRelated($product_id) {
			$product_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_related pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.related_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'");
			
			foreach ($query->rows as $result) {
				$product_data[$result['related_id']] = $this->getProduct($result['related_id']);
			}
			
			return $product_data;
		}
		
		public function getProductAlsoBought($product_id){
			$product_data = array();					
			
            $sql = "SELECT op.product_id, COUNT(*) AS total FROM " . DB_PREFIX . "order_product op LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id) LEFT JOIN `" . DB_PREFIX . "product` p ON (op.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE o.order_status_id = 5 AND p.status = '1' AND p.quantity > 0 AND p.date_available <= NOW() AND op.order_id IN (SELECT order_id FROM " . DB_PREFIX . "order_product WHERE product_id = '" . (int)$product_id . "') AND op.product_id != '" . (int)$product_id . "' AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' GROUP BY op.product_id ORDER BY total DESC LIMIT 10";
			
            $query = $this->db->ecquery($sql);

            if ($query->num_rows){
            	foreach ( $query->rows as $result )
            	{
                	$product_data[$result['product_id']] = $this->getProduct($result['product_id'] );
				}
			}
			
			
			return $product_data;
			
		}
		
		public function getProductRelatedSales($product_id, $category_id) {
			$product_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category p2c
			LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)
			WHERE p2c.product_id <> '" . (int)$product_id . "' AND p.status = '1'
			AND p.date_available <= NOW() AND p.quantity > 0 AND p2c.category_id = '" . (int)$category_id . "' ORDER BY RAND() LIMIT 10");
			
			$products = array();
			foreach($query->rows as $product){
				$products[$product['product_id']] = $product;
			}
			
			if(count($products) < 10){
				
				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category p2c
				LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)
				WHERE p2c.product_id <> '" . (int)$product_id . "' AND p.status = '1' AND p.quantity > 0
				AND p.date_available <= NOW()
				AND p.quantity > 0
				AND p2c.category_id IN (SELECT category_id FROM " . DB_PREFIX . "category_path
				WHERE path_id IN (
				SELECT path_id FROM " . DB_PREFIX . "category_path
				WHERE category_id =" . (int)$category_id . "))
				ORDER BY RAND() LIMIT 10");
				
			}
			
			foreach($query->rows as $product){
				$products[$product['product_id']] = $product;
				
				if(count($products) >= 10 ){
					break;
				}
			}
			
			foreach ($products as $result) {
				$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
			}
			
			return $product_data;
		}
		
		public function getProductLights($product_id) {
			$product_data = array();
			
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_light pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.Light_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.quantity > 0 AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' ORDER BY p.price DESC");
			
			foreach ($query->rows as $result) {
				$product_data[$result['light_id']] = $this->getProduct($result['light_id']);
			}
			
			return $product_data;
		}
		
		public function getProductAnalog($product_id, $product_info = [], $same = [], $limit = 20, $count = false) {
			$product_data = array();
			
			$sql = "SELECT * FROM " . DB_PREFIX . "product_analog pr LEFT JOIN " . DB_PREFIX . "product p ON (pr.analog_id = p.product_id) WHERE pr.product_id = '" . (int)$product_id . "' AND p.status = '1' AND p.quantity > 0 AND p.date_available <= NOW() ORDER BY (p.quantity > 0) DESC, p.price DESC";
			
			$query = $this->db->query($sql);
			
			foreach ($query->rows as $result) {
				$product_data[$result['analog_id']] = $this->getProduct($result['analog_id']);
			}

			if (!empty($product_info['reg_atx_1'])){				
				if (mb_strlen($product_info['reg_atx_1']) <= 5){
					$sql = "SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p WHERE 
					p.reg_atx_1 = '" . $this->db->escape($product_info['reg_atx_1']) . "' 
					AND p.status = '1'
					AND p.product_id <> '" . (int)$product_id . "'
					AND p.date_available <= NOW() 
					AND p.quantity > 0				
					ORDER BY (p.quantity > 0) DESC, p.price DESC LIMIT ". (int)$limit;
				} else {
					$sql = "SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p WHERE 
					p.reg_atx_1 LIKE '" . $this->db->escape(mb_substr($product_info['reg_atx_1'], 0, 5)) . "%' 
					AND p.status = '1'
					AND p.product_id <> '" . (int)$product_id . "'
					AND p.date_available <= NOW() 
					AND p.quantity > 0				
					ORDER BY (p.quantity > 0) DESC, p.price DESC LIMIT " . (int)$limit;
				}

				$query = $this->db->query($sql);

				foreach ($query->rows as $result) {
					if (empty($product_data[$result['product_id']]) && !in_array($result['product_id'], $same)){
						if (!$count){
							$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
						} else {
							$product_data[$result['product_id']] = $result['product_id'];
						}						
					}
				}
			}
			
			return $product_data;
		}
		
		public function getProductSame($product_id, $product_info = [], $limit = 20, $count = false) {
			$product_data = array();
			
			//This is set by hands
			$sql = "SELECT DISTINCT pr.same_id FROM " . DB_PREFIX . "product_same pr 
			LEFT JOIN " . DB_PREFIX . "product p ON (pr.same_id = p.product_id)
			WHERE pr.product_id = '" . (int)$product_id . "' 
			AND p.status = '1' 
			AND p.date_available <= NOW() 
			AND p.quantity > 0 
			ORDER BY (p.quantity > 0) DESC, p.price DESC";			

			$query = $this->db->query($sql);
			
			foreach ($query->rows as $result) {
				$product_data[$result['same_id']] = $this->getProduct($result['same_id']);
			}

			if (!empty($product_info['reg_atx_1'])){
				if (mb_strlen($product_info['reg_atx_1']) == 7){
					$sql = "SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p WHERE 
					p.reg_atx_1 = '" . $this->db->escape($product_info['reg_atx_1']) . "' 
					AND p.status = '1'
					AND p.product_id <> '" . (int)$product_id . "'
					AND p.date_available <= NOW() 
					AND p.quantity > 0				
					ORDER BY (p.quantity > 0) DESC, p.price DESC LIMIT " . (int)$limit;						
				} elseif (mb_strlen($product_info['reg_atx_1']) < 7 && $product_info['reg_unpatented_name'] && $product_info['reg_unpatented_name'] <> 'Comb drug'){
					$sql = "SELECT DISTINCT p.product_id FROM " . DB_PREFIX . "product p WHERE 
					p.reg_unpatented_name = '" . $this->db->escape($product_info['reg_unpatented_name']) . "' 
					AND p.status = '1'
					AND p.product_id <> '" . (int)$product_id . "'
					AND p.date_available <= NOW() 	
					AND p.quantity > 0				
					ORDER BY (p.quantity > 0) DESC, p.price DESC LIMIT " . (int)$limit;					
				}


				$query = $this->db->query($sql);

				foreach ($query->rows as $result) {
					if (empty($product_data[$result['product_id']]) && !in_array($result['product_id'], $same)){
						if (!$count){
							$product_data[$result['product_id']] = $this->getProduct($result['product_id']);
						} else {
							$product_data[$result['product_id']] = $result['product_id'];
						}						
					}
				}
			}
			
			return $product_data;
		}

		public function getCountBoughtForMonth($product_id){
			$sql = "SELECT SUM(quantity) as total FROM " . DB_PREFIX . "order_product op 
			WHERE op.product_id = '". (int)$product_id ."' AND op.order_id IN 
			(SELECT o.order_id FROM `" . DB_PREFIX . "order` o WHERE o.order_status_id > 0 AND DATE(o.date_added) >= DATE(DATE_SUB(NOW(),INTERVAL 120 DAY)))";

			$query = $this->db->query($sql);

			return $query->row['total'];
		}
		
		public function getProductLayoutId($product_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_layout WHERE product_id = '" . (int)$product_id . "' AND store_id = '" . (int)$this->config->get('config_store_id') . "'");
			
			if ($query->num_rows) {
				return $query->row['layout_id'];
				} else {
				return 0;
			}
		}
		
		public function getCategories($product_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "'");
			
			return $query->rows;
		}
		
		public function getCategoriesExceptListing($product_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' AND NOT (category_id = 1 OR category_id IN (SELECT category_id FROM " . DB_PREFIX . "category WHERE parent_id = 1))");
			
			return $query->rows;
		}
		
		
		public function getMainCategory($product_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE product_id = '" . (int)$product_id . "' ORDER BY main_category DESC LIMIT 1");
			return $query->row;
		}
		
		public function getMainCategoryName($product_id) {
			$query = $this->db->query("SELECT cd.name FROM " . DB_PREFIX . "product_to_category p2c LEFT JOIN " . DB_PREFIX . "category_description cd ON (cd.category_id = p2c.category_id AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "') WHERE product_id = '" . (int)$product_id . "' ORDER BY main_category DESC LIMIT 1");
			return !empty($query->row['name'])?$query->row['name']:'';
		}
		
		public function getMainCollection($product_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_collection WHERE product_id = '" . (int)$product_id . "' ORDER BY main_collection DESC LIMIT 1");
			
			if ($query->num_rows){
				return $query->row['collection_id'];
				} else {
				return false;
			}
		}
		
		public function getParentCategory($category_id) {
			$query = $this->db->query("SELECT parent_id FROM " . DB_PREFIX . "category WHERE category_id = '" . (int)$category_id . "'");
			return $query->row;
		}
		
		
		public function getTotalProducts($data = array()) {		
			$sql = "SELECT COUNT(DISTINCT p.product_id) AS total";
			
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
					} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
				}
				
				if (!empty($data['filter_filter'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
					} else {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				}
				} elseif (!empty($data['filter_collection_id'])) {
				
				if (!empty($data['filter_sub_collection'])) {
					$sql .= " FROM " . DB_PREFIX . "collection_path cp LEFT JOIN " . DB_PREFIX . "product_to_collection p2c ON (cp.collection_id = p2c.collection_id)";
					} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_collection p2c";
				}
				
				$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				
				} else {
				$sql .= " FROM " . DB_PREFIX . "product p";
			}
			
			// OCFilter start
			if (!empty($data['filter_ocfilter'])) {
				$this->load->model('catalog/ocfilter');
				
				$ocfilter_product_sql = $this->model_catalog_ocfilter->getSearchSQL($data['filter_ocfilter']);
				} else {
				$ocfilter_product_sql = false;
			}
			
			if ($ocfilter_product_sql && $ocfilter_product_sql->join) {
				$sql .= $ocfilter_product_sql->join;
			}
			// OCFilter end
			
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE 1 AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
					} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}
				
				if (!empty($data['filter_filter'])) {
					$implode = array();
					
					$filters = explode(',', $data['filter_filter']);
					
					foreach ($filters as $filter_id) {
						$implode[] = (int)$filter_id;
					}
					
					$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
				}
				} elseif (!empty($data['filter_collection_id'])){
				if (!empty($data['filter_sub_collection'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_collection_id'] . "'";
					} else {
					$sql .= " AND p2c.collection_id = '" . (int)$data['filter_collection_id'] . "'";
				}
			}
			
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
				
				if (!empty($data['filter_name'])) {
					
					$sql .= " (  pd.normalized_name LIKE ('%" . $this->db->escape(normalizeString($data['filter_name'])) . "%') ) ";
					$sql .= " OR ( p.is_searched = 1 AND pd.soundex_firstword LIKE ('" . $this->db->escape(transSoundex($data['filter_name'])) . "%') ) ";
					$sql .= " OR (MATCH (pd.normalized_name) AGAINST ('" . $this->db->escape(normalizeString($data['filter_name'])) . "' IN NATURAL LANGUAGE MODE)) ";
					
					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));
					
					if (count($words) > 1){
						$implode = array();
						
						foreach ($words as $word) {
							if (mb_strlen(trim($word)) >= 2){
								$implode[] = "LOWER(pd.name) LIKE '%" . $this->db->escape(normalizeKeyErrString($word)) . "%'";
							}
						}
						
						if ($implode) {
							$sql .= " OR ( " . implode(" AND ", $implode) . " ) ";
						}								
					}										
					
					if (!empty($data['filter_description'])) {
						$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
					}
				}
				
				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}
				
				if (!empty($data['filter_tag'])) {
					$implode = array();
					
					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));
					
					foreach ($words as $word) {
						$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
					}
					
					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}
				}
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.model) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(normalizeString($data['filter_name'])) . "'";
				}
				
				$sql .= ")";
			}
			
			// OCFilter start
			if (!empty($ocfilter_product_sql) && $ocfilter_product_sql->where) {
				$sql .= $ocfilter_product_sql->where;
			}
			// OCFilter end
			
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
			
			if(isset($data['filter_notnull_price']) && $data['filter_notnull_price']){
				$sql .= " AND p.price > 0";
			}
			
			if(isset($data['filter_in_stock']) && $data['filter_in_stock']){
				$sql .= " AND p.quantity > 0";
			}
			
			if(isset($data['filter_dangerous']) && $data['filter_dangerous']){
				$sql .= " AND (p.no_payment = 0 AND p.is_receipt = 0 AND p.no_advert = 0)";
			}
			
			$query = $this->db->query($sql);
			
			return $query->row['total'];
		}
		
		public function getTotalProductsInfo($data = array()) {
			$sql = "SELECT MAX(p.price) AS max_price, MIN(p.price) AS min_price, COUNT(DISTINCT p.product_id) AS total ";
			
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
					} else {
					$sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
				}
				
				if (!empty($data['filter_filter'])) {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
					} else {
					$sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
				}
				} else {
				$sql .= " FROM " . DB_PREFIX . "product p";
			}
			
			// OCFilter start
			if (!empty($data['filter_ocfilter'])) {
				$this->load->model('catalog/ocfilter');
				
				$ocfilter_product_sql = $this->model_catalog_ocfilter->getSearchSQL($data['filter_ocfilter']);
				} else {
				$ocfilter_product_sql = false;
			}
			
			if ($ocfilter_product_sql && $ocfilter_product_sql->join) {
				$sql .= $ocfilter_product_sql->join;
			}
			// OCFilter end
			
			$sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
					} else {
					$sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
				}
				
				if (!empty($data['filter_filter'])) {
					$implode = array();
					
					$filters = explode(',', $data['filter_filter']);
					
					foreach ($filters as $filter_id) {
						$implode[] = (int)$filter_id;
					}
					
					$sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
				}
			}
			
			if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
				$sql .= " AND (";
				
				if (!empty($data['filter_name'])) {
					$implode = array();
					
					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));
					
					foreach ($words as $word) {
						$implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
					}
					
					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}
					
					if (!empty($data['filter_description'])) {
						$sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
					}
				}
				
				if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
					$sql .= " OR ";
				}
				
				if (!empty($data['filter_tag'])) {
					$implode = array();
					
					$words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_tag'])));
					
					foreach ($words as $word) {
						$implode[] = "pd.tag LIKE '%" . $this->db->escape($word) . "%'";
					}
					
					if ($implode) {
						$sql .= " " . implode(" AND ", $implode) . "";
					}
				}
				
				if (!empty($data['filter_name'])) {
					$sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
					$sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
				}
				
				$sql .= ")";
			}
			
			// OCFilter start
			if (!empty($ocfilter_product_sql) && $ocfilter_product_sql->where) {
				$sql .= $ocfilter_product_sql->where;
			}
			// OCFilter end
			
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
			
			$query = $this->db->query($sql);
			
			return $query->row;
		}
		
		public function getProfile($product_id, $recurring_id) {
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r JOIN " . DB_PREFIX . "product_recurring pr ON (pr.recurring_id = r.recurring_id AND pr.product_id = '" . (int)$product_id . "') WHERE pr.recurring_id = '" . (int)$recurring_id . "' AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");
			
			return $query->row;
		}
		
		public function getProfiles($product_id) {
			$query = $this->db->query("SELECT rd.* FROM " . DB_PREFIX . "product_recurring pr JOIN " . DB_PREFIX . "recurring_description rd ON (rd.language_id = " . (int)$this->config->get('config_language_id') . " AND rd.recurring_id = pr.recurring_id) JOIN " . DB_PREFIX . "recurring r ON r.recurring_id = rd.recurring_id WHERE pr.product_id = " . (int)$product_id . " AND status = '1' AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ORDER BY sort_order ASC");
			
			return $query->rows;
		}
		
		public function getProductByUUID($uuid){
			
			$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE uuid = '" . $this->db->escape($uuid) . "'");
			
			if ($query->num_rows){
				return $this->getProduct($query->row['product_id']);
			}
			
			return false;
			
		}
		
		public function getProductIDByUUID($uuid){
			
			$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE uuid = '" . $this->db->escape($uuid) . "'");
			
			if ($query->num_rows){
				return $query->row['product_id'];
			}
			
			return false;
			
		}
		
		public function getTotalProductSpecials() {
			$query = $this->db->query("SELECT COUNT(DISTINCT ps.product_id) AS total FROM " . DB_PREFIX . "product_special ps LEFT JOIN " . DB_PREFIX . "product p ON (ps.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW()))");
			
			if (isset($query->row['total'])) {
				return $query->row['total'];
				} else {
				return 0;
			}
		}
		
		public function getProductsForSiteMap($language_id, $start)
		{
			$query = $this->db->query("SELECT p.product_id, p.date_modified, p.date_added, p.image, p.manufacturer_id, pd.name FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = p.product_id WHERE  pd.language_id ='". (int)$language_id ."' AND p.product_id >= '". (int)$start ."' ORDER BY p.product_id ASC");
			return $query->rows;
		}
		
		public function getProductsTags($product_id){
			$query = $this->db->query("SELECT pt.product_id, pt.tags_id, a.tags FROM " . DB_PREFIX . "product_to_tags pt 
			LEFT JOIN " . DB_PREFIX . "simple_blog_article_description a ON pt.tags_id = a.simple_blog_article_id 
			WHERE  pt.product_id ='". (int)$product_id ."' AND a.language_id=2");
			$str = '';
			if(!empty($query->rows)){
				foreach ($query->rows as $tag){
					$str .= ' ' . mb_strtolower($tag['tags']);
				}
			}
			return trim($str);
			
		}
		
		public function getProductsForSiteMap2($language_id, $start)
		{
			$query = $this->db->query("SELECT p.product_id, p.date_modified, p.date_added, p.image, p.manufacturer_id, pd.name, pd.description, pd.instruction FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON pd.product_id = p.product_id  WHERE  pd.language_id ='". (int)$language_id ."' AND p.product_id >= '". (int)$start ."' ORDER BY p.product_id ASC");
			
			
			return $query->rows;
		}
		
		
		public function getProductByManufacturer($manufacturerId)
		{
			$query = $this->db->query("SELECT product_id FROM " . DB_PREFIX . "product WHERE manufacturer_id = '". (int)$manufacturerId ."'");
			
			return $query->rows;
		}
		
		public function getProductsByCategory($categoryId)
		{
			$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_category WHERE category_id='" . (int)$categoryId . "'");
			
			return $query->rows;
		}
	}
	
	
