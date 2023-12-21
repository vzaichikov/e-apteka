<?php
	class ModelCatalogProduct extends Model {
		public function addProduct($data) {
			$this->db->query("INSERT INTO oc_product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', price_retail = '" . (float)$data['price_retail'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', pricegroup_id = '" . (int)$data['pricegroup_id'] . "', no_payment = '" . (int)$data['no_payment'] . "', no_shipping = '" . (int)$data['no_shipping'] . "', no_advert = '" . (int)$data['no_advert'] . "', is_receipt = '" . (int)$data['is_receipt'] . "', is_preorder = '" . (int)$data['is_preorder'] . "', is_thermolabel = '" . (int)$data['is_thermolabel'] . "', is_pko = '" . (int)$data['is_pko'] . "', is_drug = '" . (int)$data['is_drug'] . "', dnup = '" . (int)$data['dnup'] . "', social_program = '" . $this->db->escape($data['social_program']) . "', social_parent_id = '" . (int)$data['social_parent_id'] . "', social_parent_uuid = '" . $this->db->escape($data['social_parent_uuid']) . "', has_dl_price = '" . (int)$data['has_dl_price'] . "', dl_price = '" . (float)$data['dl_price'] . "', uuid = '" . $this->db->escape($data['uuid']) . "', ehealth_id = '" . $this->db->escape($data['ehealth_id']) . "', ehealth_id_1 = '" . $this->db->escape($data['ehealth_id_1']) . "', ehealth_id_2 = '" . $this->db->escape($data['ehealth_id_2']) . "', ehealth_id_3 = '" . $this->db->escape($data['ehealth_id_3']) . "', program_id = '" . $this->db->escape($data['program_id']) . "', program_id_1 = '" . $this->db->escape($data['program_id_1']) . "', program_id_2 = '" . $this->db->escape($data['program_id_2']) . "', program_id_3 = '" . $this->db->escape($data['program_id_3']) . "', reg_number = '" . $this->db->escape($data['reg_number']) . "', backlight = '" . $this->db->escape($data['backlight']) . "', name_of_part = '" . $this->db->escape($data['name_of_part']) . "', uuid_of_part = '" . $this->db->escape($data['uuid_of_part']) . "', count_of_parts = '" . (int)$data['count_of_parts'] . "', bestseller = '" . (int)$data['bestseller'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_added = NOW()");
			
			$product_id = $this->db->getLastId();
			
			if (isset($data['image'])) {
				$this->db->query("UPDATE oc_product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}
			
			foreach ($data['product_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO oc_product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', original_name = '" . $this->db->escape($value['original_name']) . "',  normalized_firstword = '" . $this->db->escape(normalizeString(firstWord($value['name']))) . "', soundex_firstword = '" . $this->db->escape(transSoundex(firstWord($value['name']))) . "', normalized_name = '" . $this->db->escape(normalizeString($value['name'])) . "', soundex_name = '" . $this->db->escape(transSoundex($value['name'])) . "', description = '" . $this->db->escape($value['description']) . "', instruction = '" . $this->db->escape($value['instruction']) . "', tag = '" . $this->db->escape($value['tag']) . "', faq_name = '" . $this->db->escape($value['faq_name']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
			}
			
			
			$this->db->query("DELETE FROM oc_product_faq WHERE product_id = '" . (int)$product_id . "'");
			if (isset($data['product_faq'])) {
				foreach ($data['product_faq'] as $product_faq) {
					$this->db->query("INSERT INTO oc_product_faq SET product_id = '" . (int)$product_id . "', `question` = '" . $this->db->escape(serialize($product_faq['question'])) . "', `faq` = '" . $this->db->escape(serialize($product_faq['faq'])) . "', `icon` = '" . $this->db->escape($product_faq['icon']) . "', `sort_order` = '" . (int)$product_faq['sort_order'] . "'");
				}
			} 
			
			if (isset($data['product_store'])) {
				foreach ($data['product_store'] as $store_id) {
					$this->db->query("INSERT INTO oc_product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			
			if (isset($data['product_attribute'])) {
				foreach ($data['product_attribute'] as $product_attribute) {
					if ($product_attribute['attribute_id']) {
						// Removes duplicates
						$this->db->query("DELETE FROM oc_product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
						
						foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
							$this->db->query("DELETE FROM oc_product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "' AND language_id = '" . (int)$language_id . "'");
							
							$this->db->query("INSERT INTO oc_product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
						}
					}
				}
			}
			
			if (isset($data['product_option'])) {
				foreach ($data['product_option'] as $product_option) {
					if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
						if (isset($product_option['product_option_value'])) {
							$this->db->query("INSERT INTO oc_product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
							
							$product_option_id = $this->db->getLastId();
							
							foreach ($product_option['product_option_value'] as $product_option_value) {
								$this->db->query("INSERT INTO oc_product_option_value SET product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
							}
						}
						} else {
						$this->db->query("INSERT INTO oc_product_option SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
					}
				}
			}
			
			if (isset($data['product_discount'])) {
				foreach ($data['product_discount'] as $product_discount) {
					$this->db->query("INSERT INTO oc_product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
				}
			}
			
			if (isset($data['product_special'])) {
				foreach ($data['product_special'] as $product_special) {				
					$this->db->query("INSERT INTO oc_product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', type = '" . $this->db->escape($product_special['type']) . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
				}
			}
			
			if (isset($data['product_image'])) {
				foreach ($data['product_image'] as $product_image) {
					$this->db->query("INSERT INTO oc_product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
				}
			}
			
			if (isset($data['product_download'])) {
				foreach ($data['product_download'] as $download_id) {
					$this->db->query("INSERT INTO oc_product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
				}
			}
			
			
			$this->db->query("DELETE FROM oc_product_to_primenenie WHERE product_id = '" . (int)$product_id . "'");
			if (isset($data['primenenie'])) {
				foreach ($data['primenenie'] as $category_id) {
					$this->db->query("INSERT INTO oc_product_to_primenenie SET product_id = '" . (int)$product_id . "', primenenie_id = '" . (int)$category_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_to_tags WHERE product_id = '" . (int)$product_id . "'");
			if (isset($data['tags'])) {
				foreach ($data['tags'] as $category_id) {
					$this->db->query("INSERT INTO oc_product_to_tags SET product_id = '" . (int)$product_id . "', tags_id = '" . (int)$category_id . "'");
				}
				}
			
			if (isset($data['product_category'])) {
				foreach ($data['product_category'] as $category_id) {
					$this->db->query("INSERT INTO oc_product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
				}
			}
			
			if (isset($data['product_collection'])) {
				foreach ($data['product_collection'] as $collection_id) {
					$this->db->query("INSERT INTO oc_product_to_collection SET product_id = '" . (int)$product_id . "', collection_id = '" . (int)$collection_id . "'");
				}
			}
			
			if(isset($data['main_collection_id']) && $data['main_collection_id'] > 0) {
				$this->db->query("DELETE FROM oc_product_to_collection WHERE product_id = '" . (int)$product_id . "' AND collection_id = '" . (int)$data['main_collection_id'] . "'");
				$this->db->query("INSERT INTO oc_product_to_collection SET product_id = '" . (int)$product_id . "', collection_id = '" . (int)$data['main_collection_id'] . "', main_collection = 1");
				} elseif(isset($data['product_collection'][0])) {
				$this->db->query("UPDATE oc_product_to_collection SET main_collection = 1 WHERE product_id = '" . (int)$product_id . "' AND collection_id = '" . (int)$data['product_collection'][0] . "'");
			}
			
			if (isset($data['product_socialprogram'])) {
				foreach ($data['product_socialprogram'] as $socialprogram_id) {
					$this->db->query("INSERT INTO oc_product_to_socialprogram SET product_id = '" . (int)$product_id . "', socialprogram_id = '" . (int)$socialprogram_id . "'");
				}
			}
			
			if(isset($data['main_socialprogram_id']) && $data['main_socialprogram_id'] > 0) {
				$this->db->query("DELETE FROM oc_product_to_socialprogram WHERE product_id = '" . (int)$product_id . "' AND socialprogram_id = '" . (int)$data['main_socialprogram_id'] . "'");
				$this->db->query("INSERT INTO oc_product_to_socialprogram SET product_id = '" . (int)$product_id . "', socialprogram_id = '" . (int)$data['main_socialprogram_id'] . "', main_socialprogram = 1");
				} elseif(isset($data['product_socialprogram'][0])) {
				$this->db->query("UPDATE oc_product_to_socialprogram SET main_socialprogram = 1 WHERE product_id = '" . (int)$product_id . "' AND socialprogram_id = '" . (int)$data['product_socialprogram'][0] . "'");
			}
			
			if (isset($data['product_filter'])) {
				foreach ($data['product_filter'] as $filter_id) {
					$this->db->query("INSERT INTO oc_product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
				}
			}
			
			if(isset($data['main_category_id']) && $data['main_category_id'] > 0) {
				$this->db->query("DELETE FROM oc_product_to_category WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['main_category_id'] . "'");
				$this->db->query("INSERT INTO oc_product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
				} elseif(isset($data['product_category'][0])) {
				$this->db->query("UPDATE oc_product_to_category SET main_category = 1 WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['product_category'][0] . "'");
			}
			
			if (isset($data['product_related'])) {
				foreach ($data['product_related'] as $related_id) {
					$this->db->query("DELETE FROM oc_product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
					$this->db->query("INSERT INTO oc_product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
					$this->db->query("DELETE FROM oc_product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
					$this->db->query("INSERT INTO oc_product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
				}
			}
			
			if (isset($data['product_same'])) {
				foreach ($data['product_same'] as $same_id) {
					$this->db->query("DELETE FROM oc_product_same WHERE product_id = '" . (int)$product_id . "' AND same_id = '" . (int)$same_id . "'");
					$this->db->query("INSERT INTO oc_product_same SET product_id = '" . (int)$product_id . "', same_id = '" . (int)$same_id . "'");
					$this->db->query("DELETE FROM oc_product_same WHERE product_id = '" . (int)$same_id . "' AND same_id = '" . (int)$product_id . "'");
					$this->db->query("INSERT INTO oc_product_same SET product_id = '" . (int)$same_id . "', same_id = '" . (int)$product_id . "'");
				}
			}
			
			if (isset($data['product_analog'])) {
				foreach ($data['product_analog'] as $analog_id) {
					$this->db->query("DELETE FROM oc_product_analog WHERE product_id = '" . (int)$product_id . "' AND analog_id = '" . (int)$analog_id . "'");
					$this->db->query("INSERT INTO oc_product_analog SET product_id = '" . (int)$product_id . "', analog_id = '" . (int)$analog_id . "'");
					$this->db->query("DELETE FROM oc_product_analog WHERE product_id = '" . (int)$analog_id . "' AND analog_id = '" . (int)$product_id . "'");
					$this->db->query("INSERT INTO oc_product_analog SET product_id = '" . (int)$analog_id . "', analog_id = '" . (int)$product_id . "'");
				}
			}
			
			if (isset($data['product_light'])) {
				foreach ($data['product_light'] as $light_id) {
					$this->db->query("DELETE FROM oc_product_light WHERE product_id = '" . (int)$product_id . "' AND light_id = '" . (int)$light_id . "'");
					$this->db->query("INSERT INTO oc_product_light SET product_id = '" . (int)$product_id . "', light_id = '" . (int)$light_id . "'");					
				}
			}
			
			if (isset($data['product_reward'])) {
				foreach ($data['product_reward'] as $customer_group_id => $product_reward) {
					if ((int)$product_reward['points'] > 0) {
						$this->db->query("INSERT INTO oc_product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$product_reward['points'] . "'");
					}
				}
			}
			
			if (isset($data['product_layout'])) {
				foreach ($data['product_layout'] as $store_id => $layout_id) {
					$this->db->query("INSERT INTO oc_product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
				}
			}

			$this->db->query("DELETE FROM oc_ocfilter_option_value_to_product WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['ocfilter_product_option'])) {
				foreach ($data['ocfilter_product_option'] as $option_id => $values) {
					foreach ($values['values'] as $value_id => $value) {
						if (isset($value['selected'])) {
							$this->db->query("INSERT IGNORE INTO oc_ocfilter_option_value_to_product SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', value_id = '" . (string)$value_id . "', slide_value_min = '" . (isset($value['slide_value_min']) ? (float)$value['slide_value_min'] : 0) . "', slide_value_max = '" . (isset($value['slide_value_max']) ? (float)$value['slide_value_max'] : 0) . "'");
						}
					}
				}
			}
			
			if ($data['keyword']) {
				$this->db->query("INSERT INTO oc_url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}
			
			if (isset($data['product_recurring'])) {
				foreach ($data['product_recurring'] as $recurring) {
					$this->db->query("INSERT INTO `oc_product_recurring` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$recurring['customer_group_id'] . ", `recurring_id` = " . (int)$recurring['recurring_id']);
				}
			}
			
			$this->db->query("DELETE FROM oc_xdstickers_product WHERE product_id = " . (int)$product_id);
			if (isset($data['xdstickers'])) {
				foreach ($data['xdstickers'] as $xdsticker) {
					$this->db->query("INSERT INTO oc_xdstickers_product SET product_id = " . (int)$product_id . ", xdsticker_id = ".(int)$xdsticker['xdsticker_id']);
				}
			}
			
			$this->cache->delete('product');
			
			return $product_id;
		}
		
		public function editProduct($product_id, $data) {
			$this->db->query("UPDATE oc_product SET model = '" . $this->db->escape($data['model']) . "', sku = '" . $this->db->escape($data['sku']) . "', upc = '" . $this->db->escape($data['upc']) . "', ean = '" . $this->db->escape($data['ean']) . "', jan = '" . $this->db->escape($data['jan']) . "', isbn = '" . $this->db->escape($data['isbn']) . "', mpn = '" . $this->db->escape($data['mpn']) . "', location = '" . $this->db->escape($data['location']) . "', quantity = '" . (int)$data['quantity'] . "', minimum = '" . (int)$data['minimum'] . "', subtract = '" . (int)$data['subtract'] . "', stock_status_id = '" . (int)$data['stock_status_id'] . "', date_available = '" . $this->db->escape($data['date_available']) . "', manufacturer_id = '" . (int)$data['manufacturer_id'] . "', shipping = '" . (int)$data['shipping'] . "', price = '" . (float)$data['price'] . "', price_retail = '" . (float)$data['price_retail'] . "', points = '" . (int)$data['points'] . "', weight = '" . (float)$data['weight'] . "', weight_class_id = '" . (int)$data['weight_class_id'] . "', length = '" . (float)$data['length'] . "', width = '" . (float)$data['width'] . "', height = '" . (float)$data['height'] . "', length_class_id = '" . (int)$data['length_class_id'] . "', status = '" . (int)$data['status'] . "', tax_class_id = '" . (int)$data['tax_class_id'] . "', pricegroup_id = '" . (int)$data['pricegroup_id'] . "', no_payment = '" . (int)$data['no_payment'] . "', no_shipping = '" . (int)$data['no_shipping'] . "', no_advert = '" . (int)$data['no_advert'] . "', is_receipt = '" . (int)$data['is_receipt'] . "', is_preorder = '" . (int)$data['is_preorder'] . "', is_thermolabel = '" . (int)$data['is_thermolabel'] . "', is_pko = '" . (int)$data['is_pko'] . "', is_drug = '" . (int)$data['is_drug'] . "', dnup = '" . (int)$data['dnup'] . "', uuid = '" . $this->db->escape($data['uuid']) . "', ehealth_id = '" . $this->db->escape($data['ehealth_id']) . "', ehealth_id_1 = '" . $this->db->escape($data['ehealth_id_1']) . "', ehealth_id_2 = '" . $this->db->escape($data['ehealth_id_2']) . "', ehealth_id_3 = '" . $this->db->escape($data['ehealth_id_3']) . "', program_id = '" . $this->db->escape($data['program_id']) . "', program_id_1 = '" . $this->db->escape($data['program_id_1']) . "', program_id_2 = '" . $this->db->escape($data['program_id_2']) . "', program_id_3 = '" . $this->db->escape($data['program_id_3']) . "', reg_number = '" . $this->db->escape($data['reg_number']) . "', social_program = '" . $this->db->escape($data['social_program']) . "', social_parent_id = '" . (int)$data['social_parent_id'] . "', social_parent_uuid = '" . $this->db->escape($data['social_parent_uuid']) . "', has_dl_price = '" . (int)$data['has_dl_price'] . "', dl_price = '" . (float)$data['dl_price'] . "', backlight = '" . $this->db->escape($data['backlight']) . "', name_of_part = '" . $this->db->escape($data['name_of_part']) . "', uuid_of_part = '" . $this->db->escape($data['uuid_of_part']) . "', count_of_parts = '" . (int)$data['count_of_parts'] . "', bestseller = '" . (int)$data['bestseller'] . "', sort_order = '" . (int)$data['sort_order'] . "', date_modified = NOW() WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['image'])) {
				$this->db->query("UPDATE oc_product SET image = '" . $this->db->escape($data['image']) . "' WHERE product_id = '" . (int)$product_id . "'");
			}

			if (!empty($data['ehealth_id'])) {
				$this->db->query("UPDATE oc_ehealth SET product_id = '" . (int)$product_id . "' WHERE ehealth_id = '" . $this->db->escape($ehealth_id) . "'");
			}
			
			$this->db->query("DELETE FROM oc_product_description WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($data['product_description'] as $language_id => $value) {
				$this->db->query("INSERT INTO oc_product_description SET product_id = '" . (int)$product_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', original_name = '" . $this->db->escape($value['original_name']) . "', normalized_firstword = '" . $this->db->escape(normalizeString(firstWord($value['name']))) . "', soundex_firstword = '" . $this->db->escape(transSoundex(firstWord($value['name']))) . "', normalized_name = '" . $this->db->escape(normalizeString($value['name'])) . "', soundex_name = '" . $this->db->escape(transSoundex($value['name'])) . "', description = '" . $this->db->escape($value['description']) . "', instruction = '" . $this->db->escape($value['instruction']) . "', tag = '" . $this->db->escape($value['tag']) . "', faq_name = '" . $this->db->escape($value['faq_name']) . "', meta_title = '" . $this->db->escape($value['meta_title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keyword = '" . $this->db->escape($value['meta_keyword']) . "'");
			}
			
			
			$this->db->query("DELETE FROM oc_product_faq WHERE product_id = '" . (int)$product_id . "'");
			if (isset($data['product_faq'])) {
				foreach ($data['product_faq'] as $product_faq) {
					$this->db->query("INSERT INTO oc_product_faq SET product_id = '" . (int)$product_id . "', `question` = '" . $this->db->escape(serialize($product_faq['question'])) . "', `faq` = '" . $this->db->escape(serialize($product_faq['faq'])) . "', `icon` = '" . $this->db->escape($product_faq['icon']) . "', `sort_order` = '" . (int)$product_faq['sort_order'] . "'");
				}
			} 
			
			$this->db->query("DELETE FROM oc_product_to_store WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_store'])) {
				foreach ($data['product_store'] as $store_id) {
					$this->db->query("INSERT INTO oc_product_to_store SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_attribute WHERE product_id = '" . (int)$product_id . "'");
			
			if (!empty($data['product_attribute'])) {
				foreach ($data['product_attribute'] as $product_attribute) {
					if ($product_attribute['attribute_id']) {
						// Removes duplicates
						$this->db->query("DELETE FROM oc_product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
						
						foreach ($product_attribute['product_attribute_description'] as $language_id => $product_attribute_description) {
							$this->db->query("INSERT INTO oc_product_attribute SET product_id = '" . (int)$product_id . "', attribute_id = '" . (int)$product_attribute['attribute_id'] . "', language_id = '" . (int)$language_id . "', text = '" .  $this->db->escape($product_attribute_description['text']) . "'");
						}
					}
				}
			}
			
			$this->db->query("DELETE FROM oc_product_option WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_option_value WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_option'])) {
				foreach ($data['product_option'] as $product_option) {
					if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
						if (isset($product_option['product_option_value'])) {
							$this->db->query("INSERT INTO oc_product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', required = '" . (int)$product_option['required'] . "'");
							
							$product_option_id = $this->db->getLastId();
							
							foreach ($product_option['product_option_value'] as $product_option_value) {
								$this->db->query("INSERT INTO oc_product_option_value SET product_option_value_id = '" . (int)$product_option_value['product_option_value_id'] . "', product_option_id = '" . (int)$product_option_id . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', option_value_id = '" . (int)$product_option_value['option_value_id'] . "', quantity = '" . (int)$product_option_value['quantity'] . "', subtract = '" . (int)$product_option_value['subtract'] . "', price = '" . (float)$product_option_value['price'] . "', price_prefix = '" . $this->db->escape($product_option_value['price_prefix']) . "', points = '" . (int)$product_option_value['points'] . "', points_prefix = '" . $this->db->escape($product_option_value['points_prefix']) . "', weight = '" . (float)$product_option_value['weight'] . "', weight_prefix = '" . $this->db->escape($product_option_value['weight_prefix']) . "'");
							}
						}
						} else {
						$this->db->query("INSERT INTO oc_product_option SET product_option_id = '" . (int)$product_option['product_option_id'] . "', product_id = '" . (int)$product_id . "', option_id = '" . (int)$product_option['option_id'] . "', value = '" . $this->db->escape($product_option['value']) . "', required = '" . (int)$product_option['required'] . "'");
					}
				}
			}
			
			$this->db->query("DELETE FROM oc_product_discount WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_discount'])) {
				foreach ($data['product_discount'] as $product_discount) {
					$this->db->query("INSERT INTO oc_product_discount SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_discount['customer_group_id'] . "', quantity = '" . (int)$product_discount['quantity'] . "', priority = '" . (int)$product_discount['priority'] . "', price = '" . (float)$product_discount['price'] . "', date_start = '" . $this->db->escape($product_discount['date_start']) . "', date_end = '" . $this->db->escape($product_discount['date_end']) . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_special WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_special'])) {
				foreach ($data['product_special'] as $product_special) {						
					$this->db->query("INSERT INTO oc_product_special SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$product_special['customer_group_id'] . "', priority = '" . (int)$product_special['priority'] . "', price = '" . (float)$product_special['price'] . "', type = '" . $this->db->escape($product_special['type']) . "', date_start = '" . $this->db->escape($product_special['date_start']) . "', date_end = '" . $this->db->escape($product_special['date_end']) . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_image WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_image'])) {
				foreach ($data['product_image'] as $product_image) {
					$this->db->query("INSERT INTO oc_product_image SET product_id = '" . (int)$product_id . "', image = '" . $this->db->escape($product_image['image']) . "', sort_order = '" . (int)$product_image['sort_order'] . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_to_download WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_download'])) {
				foreach ($data['product_download'] as $download_id) {
					$this->db->query("INSERT INTO oc_product_to_download SET product_id = '" . (int)$product_id . "', download_id = '" . (int)$download_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_to_category WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_category'])) {
				foreach ($data['product_category'] as $category_id) {
					$this->db->query("INSERT INTO oc_product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$category_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_to_collection WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_collection'])) {
				foreach ($data['product_collection'] as $collection_id) {
					$this->db->query("INSERT INTO oc_product_to_collection SET product_id = '" . (int)$product_id . "', collection_id = '" . (int)$collection_id . "'");
				}
			}
			
			if(isset($data['main_collection_id']) && $data['main_collection_id'] > 0) {
				$this->db->query("DELETE FROM oc_product_to_collection WHERE product_id = '" . (int)$product_id . "' AND collection_id = '" . (int)$data['main_collection_id'] . "'");
				$this->db->query("INSERT INTO oc_product_to_collection SET product_id = '" . (int)$product_id . "', collection_id = '" . (int)$data['main_collection_id'] . "', main_collection = 1");
				} elseif(isset($data['product_collection'][0])) {
				$this->db->query("UPDATE oc_product_to_collection SET main_collection = 1 WHERE product_id = '" . (int)$product_id . "' AND collection_id = '" . (int)$data['product_collection'][0] . "'");
			}
			
			$this->db->query("DELETE FROM oc_product_to_socialprogram WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_socialprogram'])) {
				foreach ($data['product_socialprogram'] as $socialprogram_id) {
					$this->db->query("INSERT INTO oc_product_to_socialprogram SET product_id = '" . (int)$product_id . "', socialprogram_id = '" . (int)$socialprogram_id . "'");
				}
			}
			
			if(isset($data['main_socialprogram_id']) && $data['main_socialprogram_id'] > 0) {
				$this->db->query("DELETE FROM oc_product_to_socialprogram WHERE product_id = '" . (int)$product_id . "' AND socialprogram_id = '" . (int)$data['main_socialprogram_id'] . "'");
				$this->db->query("INSERT INTO oc_product_to_socialprogram SET product_id = '" . (int)$product_id . "', socialprogram_id = '" . (int)$data['main_socialprogram_id'] . "', main_socialprogram = 1");
				} elseif(isset($data['product_socialprogram'][0])) {
				$this->db->query("UPDATE oc_product_to_socialprogram SET main_socialprogram = 1 WHERE product_id = '" . (int)$product_id . "' AND socialprogram_id = '" . (int)$data['product_socialprogram'][0] . "'");
			}
			
			$this->db->query("DELETE FROM oc_product_to_primenenie WHERE product_id = '" . (int)$product_id . "'");
			if (isset($data['primenenie'])) {
				foreach ($data['primenenie'] as $category_id) {
					$this->db->query("INSERT INTO oc_product_to_primenenie SET product_id = '" . (int)$product_id . "', primenenie_id = '" . (int)$category_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_to_tags WHERE product_id = '" . (int)$product_id . "'");
			if (isset($data['tags'])) {
				foreach ($data['tags'] as $category_id) {
					$this->db->query("INSERT INTO oc_product_to_tags SET product_id = '" . (int)$product_id . "', tags_id = '" . (int)$category_id . "'");
				}
			}
			
			if(isset($data['main_category_id']) && $data['main_category_id'] > 0) {
				$this->db->query("DELETE FROM oc_product_to_category WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['main_category_id'] . "'");
				$this->db->query("INSERT INTO oc_product_to_category SET product_id = '" . (int)$product_id . "', category_id = '" . (int)$data['main_category_id'] . "', main_category = 1");
				} elseif(isset($data['product_category'][0])) {
				$this->db->query("UPDATE oc_product_to_category SET main_category = 1 WHERE product_id = '" . (int)$product_id . "' AND category_id = '" . (int)$data['product_category'][0] . "'");
			}
			
			$this->db->query("DELETE FROM oc_product_filter WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_filter'])) {
				foreach ($data['product_filter'] as $filter_id) {
					$this->db->query("INSERT INTO oc_product_filter SET product_id = '" . (int)$product_id . "', filter_id = '" . (int)$filter_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_related WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_related WHERE related_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_related'])) {
				foreach ($data['product_related'] as $related_id) {
					$this->db->query("DELETE FROM oc_product_related WHERE product_id = '" . (int)$product_id . "' AND related_id = '" . (int)$related_id . "'");
					$this->db->query("INSERT INTO oc_product_related SET product_id = '" . (int)$product_id . "', related_id = '" . (int)$related_id . "'");
					$this->db->query("DELETE FROM oc_product_related WHERE product_id = '" . (int)$related_id . "' AND related_id = '" . (int)$product_id . "'");
					$this->db->query("INSERT INTO oc_product_related SET product_id = '" . (int)$related_id . "', related_id = '" . (int)$product_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_same WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_same WHERE same_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_same'])) {
				foreach ($data['product_same'] as $same_id) {
					$this->db->query("DELETE FROM oc_product_same WHERE product_id = '" . (int)$product_id . "' AND same_id = '" . (int)$same_id . "'");
					$this->db->query("INSERT INTO oc_product_same SET product_id = '" . (int)$product_id . "', same_id = '" . (int)$same_id . "'");
					$this->db->query("DELETE FROM oc_product_same WHERE product_id = '" . (int)$same_id . "' AND same_id = '" . (int)$product_id . "'");
					$this->db->query("INSERT INTO oc_product_same SET product_id = '" . (int)$same_id . "', same_id = '" . (int)$product_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_analog WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_analog WHERE analog_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_analog'])) {
				foreach ($data['product_analog'] as $analog_id) {
					$this->db->query("DELETE FROM oc_product_analog WHERE product_id = '" . (int)$product_id . "' AND analog_id = '" . (int)$analog_id . "'");
					$this->db->query("INSERT INTO oc_product_analog SET product_id = '" . (int)$product_id . "', analog_id = '" . (int)$analog_id . "'");
					$this->db->query("DELETE FROM oc_product_analog WHERE product_id = '" . (int)$analog_id . "' AND analog_id = '" . (int)$product_id . "'");
					$this->db->query("INSERT INTO oc_product_analog SET product_id = '" . (int)$analog_id . "', analog_id = '" . (int)$product_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_light WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_light'])) {
				foreach ($data['product_light'] as $light_id) {
					$this->db->query("DELETE FROM oc_product_light WHERE product_id = '" . (int)$product_id . "' AND light_id = '" . (int)$light_id . "'");
					$this->db->query("INSERT INTO oc_product_light SET product_id = '" . (int)$product_id . "', light_id = '" . (int)$light_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_product_reward WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_reward'])) {
				foreach ($data['product_reward'] as $customer_group_id => $value) {
					if ((int)$value['points'] > 0) {
						$this->db->query("INSERT INTO oc_product_reward SET product_id = '" . (int)$product_id . "', customer_group_id = '" . (int)$customer_group_id . "', points = '" . (int)$value['points'] . "'");
					}
				}
			}
			
			$this->db->query("DELETE FROM oc_product_to_layout WHERE product_id = '" . (int)$product_id . "'");
			
			if (isset($data['product_layout'])) {
				foreach ($data['product_layout'] as $store_id => $layout_id) {
					$this->db->query("INSERT INTO oc_product_to_layout SET product_id = '" . (int)$product_id . "', store_id = '" . (int)$store_id . "', layout_id = '" . (int)$layout_id . "'");
				}
			}
			
			$this->db->query("DELETE FROM oc_url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
			
			if ($data['keyword']) {
				$this->db->query("INSERT INTO oc_url_alias SET query = 'product_id=" . (int)$product_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
			}

			$this->db->query("DELETE FROM oc_ocfilter_option_value_to_product WHERE product_id = '" . (int)$product_id . "'");

			if (isset($data['ocfilter_product_option'])) {
				foreach ($data['ocfilter_product_option'] as $option_id => $values) {
					foreach ($values['values'] as $value_id => $value) {
						if (isset($value['selected'])) {
							$this->db->query("INSERT IGNORE INTO oc_ocfilter_option_value_to_product SET product_id = '" . (int)$product_id . "', option_id = '" . (int)$option_id . "', value_id = '" . (string)$value_id . "', slide_value_min = '" . (isset($value['slide_value_min']) ? (float)$value['slide_value_min'] : 0) . "', slide_value_max = '" . (isset($value['slide_value_max']) ? (float)$value['slide_value_max'] : 0) . "'");
						}
					}
				}
			}
			
			$this->db->query("DELETE FROM `oc_product_recurring` WHERE product_id = " . (int)$product_id);
			
			if (isset($data['product_recurring'])) {
				foreach ($data['product_recurring'] as $product_recurring) {
					$this->db->query("INSERT INTO `oc_product_recurring` SET `product_id` = " . (int)$product_id . ", customer_group_id = " . (int)$product_recurring['customer_group_id'] . ", `recurring_id` = " . (int)$product_recurring['recurring_id']);
				}
			}
			
			$this->db->query("DELETE FROM oc_xdstickers_product WHERE product_id = " . (int)$product_id);
			if (isset($data['xdstickers'])) {
				foreach ($data['xdstickers'] as $xdsticker) {
					$this->db->query("INSERT INTO oc_xdstickers_product SET product_id = " . (int)$product_id . ", xdsticker_id = ".(int)$xdsticker['xdsticker_id']);
				}
			}
			
			$this->cache->delete('product');
		}
		
		public function copyProduct($product_id) {							
			$this->load->model('catalog/ocfilter');

			$query = $this->db->query("SELECT DISTINCT * FROM oc_product p WHERE p.product_id = '" . (int)$product_id . "'");
			
			if ($query->num_rows) {
				$data = $query->row;
				
				$data['sku'] = '';
				$data['upc'] = '';
				$data['viewed'] = '0';
				$data['keyword'] = '';
				$data['status'] = '0';
				
				$data['ocfilter_product_option'] = $this->model_catalog_ocfilter->getProductOCFilterValues($product_id);
				$data['product_attribute'] = $this->getProductAttributes($product_id);
				$data['product_description'] = $this->getProductDescriptions($product_id);
				$data['product_discount'] = $this->getProductDiscounts($product_id);
				$data['product_filter'] = $this->getProductFilters($product_id);
				$data['product_image'] = $this->getProductImages($product_id);
				$data['product_option'] = $this->getProductOptions($product_id);
				$data['product_related'] = $this->getProductRelated($product_id);
				$data['product_analog'] = $this->getProductAnalog($product_id);
				$data['product_light'] = $this->getProductLight($product_id);
				$data['product_collection'] = $this->getProductCollections($product_id);
				$data['product_socialprogram'] = $this->getProductSocialPrograms($product_id);
				$data['product_same'] = $this->getProductSame($product_id);
				$data['product_reward'] = $this->getProductRewards($product_id);
				$data['product_special'] = $this->getProductSpecials($product_id);
				$data['product_category'] = $this->getProductCategories($product_id);
				$data['product_download'] = $this->getProductDownloads($product_id);
				$data['product_layout'] = $this->getProductLayouts($product_id);
				$data['product_store'] = $this->getProductStores($product_id);
				$data['product_recurrings'] = $this->getRecurrings($product_id);
				
				$data['main_category_id'] = $this->getProductMainCategoryId($product_id);
				$data['main_collection_id'] = $this->getProductMainCollectionId($product_id);
				$data['main_socialprogram_id'] = $this->getProductMainSocialProgramId($product_id);
				
				$this->addProduct($data);
			}
		}
		
		public function deleteProduct($product_id) {
			$this->db->query("DELETE FROM oc_product WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_attribute WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_ocfilter_option_value_to_product WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_description WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_discount WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_filter WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_image WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_option WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_option_value WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_related WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_related WHERE related_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_analog WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_analog WHERE analog_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_light WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_light WHERE light_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_same WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_same WHERE same_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_to_collection WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_to_socialprogram WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_reward WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_special WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_to_category WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_to_download WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_to_layout WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_to_store WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_product_recurring WHERE product_id = " . (int)$product_id);
			$this->db->query("DELETE FROM oc_review WHERE product_id = '" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_url_alias WHERE query = 'product_id=" . (int)$product_id . "'");
			$this->db->query("DELETE FROM oc_coupon_product WHERE product_id = '" . (int)$product_id . "'");
			
			$this->cache->delete('product');
		}
		
		public function getProduct($product_id) {
			$query = $this->db->query("SELECT DISTINCT *, 
				(SELECT IF(type = '%', (p.price - p.price/100*price), price) FROM oc_product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special, 
					(SELECT name FROM oc_manufacturer_description md WHERE md.manufacturer_id = p.manufacturer_id AND md.language_id =  '" . (int)$this->config->get('config_language_id') . "') AS manufacturer, 
					(SELECT keyword FROM oc_url_alias WHERE query = 'product_id=" . (int)$product_id . "') AS keyword FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) WHERE p.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			return $query->row;
		}

		public function insertDataToLikReestr($drug_id, $json, $product_id = null) {			
			$query = $this->db->query("INSERT INTO oc_likreestr SET 
				`json_old` 		= `json`,
				`json` 			= '" . $this->db->escape(json_encode($json)) . "',
				`product_id` 	= '" . (int)$product_id . "',			
				`drug_id` 		= '" . $this->db->escape($drug_id) . "'
				ON DUPLICATE KEY UPDATE
				`json_old` 		= `json`,
				`json` 			= '" . $this->db->escape(json_encode($json)) . "',
				`product_id` 	= '" . (int)$product_id . "'");
		}

		public function getAllDataFromLikReestr(){
			$query = $this->db->query("SELECT * FROM oc_likreestr WHERE 1");

			return $query->rows;
		}

		private function saveProductInstructionFromLikReestr($product_id, $data){
			if (!empty($data['URL інструкції'])){

				$filestring = md5($data['Номер Реєстраційного посвідчення'] . '-eapteka.com.ua');
				$extension 	=  pathinfo($data['URL інструкції'], PATHINFO_EXTENSION);
				$filename 	=  $filestring . '.' . $extension;
				$filename_html 	= $filestring . '.html';
				$filename_pdf 	= $filestring . '.pdf';

				$instructionDir = DIR_INSTRUCTIONS;
				$cachePath 		= 	$filestring[0] . $filestring[1] . '/';  
				$cachePath 		.= 	$filestring[2] . $filestring[3] . '/';
				$instructionDir .= $cachePath;

				$file = ($instructionDir . $filename);

				if (file_exists($file) && (time() - filemtime($file) <= 345600)) {
					if ($extension == 'pdf'){
						echoLine('Инструкция в PDF, не старше двух дней, файл ' . ($cachePath . $filename), 's');
						return $cachePath . $filename;
					}

					if ($extension == 'mht'){
						if (file_exists($instructionDir . $filename_html) && file_exists($instructionDir . $filename_pdf)){
							echoLine('HTML + PDF существуют, не старше двух дней, файл ' . ($cachePath . $filename_html), 's');							
							return $cachePath . $filename_html;
						}
					}
				}

				if ($content = file_get_contents($data['URL інструкції'])){									
					if (!is_dir($instructionDir)){
						mkdir($instructionDir, 0775, true);
						echoLine('Создаем директорию ' . $cachePath, 'i');
					}		
					
					echoLine($data['Торгівельне найменування'] . ', скачали инструкцию ' . $filename, 's');					
					file_put_contents($file, $content);

					if ($extension == 'pdf'){
						echoLine('Инструкция в PDF, не преобразовываем, файл ' . ($cachePath . $filename), 'w');
						return $cachePath . $filename;
					}

					if ($extension == 'mht'){
						echoLine('Инструкция в MHT, преобразовываем, файл ' . ($cachePath . $filename), 'w');						
						$MHTParser = new \hobotix\MHTParser($instructionDir . $filename);
						$MHTParser->parse();
						if ($html = $MHTParser->get_html()){
							echoLine('Преобразовали в HTML ' . ($cachePath . $filename_html), 'w');
							file_put_contents(($instructionDir . $filename_html), $html);

							try {
								$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8']);
								$mpdf->WriteHTML($html);
								$mpdf->Output(($instructionDir . $filename_pdf), \Mpdf\Output\Destination::FILE);
								echoLine('Преобразовали в PDF ' . ($cachePath . $filename_pdf), 'w');
							} catch (\Mpdf\MpdfException $e){
								echoLine('Ошибка преобразования в PDF ' . $e->getMessage(), 'e');
							}
						}

						return $cachePath . $filename_html;
					}
				}
			}

			echoLine($data['Торгівельне найменування'] . ', нет инструкции', 'e');
			return false;
		}
		
		public function updateProductByRegistryNumber($product_id, $data) {			
			$query = $this->db->query("UPDATE oc_product SET reg_json = '" . $this->db->escape(json_encode($data)) . "' WHERE product_id = '" . (int)$product_id . "'");	

			$this->db->query("UPDATE oc_product SET 
				reg_trade_name 			= '" . $this->db->escape($data['Торгівельне найменування']) . "',
				reg_unpatented_name 	= '" . $this->db->escape($data['Міжнародне непатентоване найменування']) . "',
				reg_save_terms 			= '" . $this->db->escape($data['Термін придатності']) . "',
				reg_atx_1 				= '" . $this->db->escape($data['Код АТС 1']) . "',
				reg_atx_2 				= '" . $this->db->escape($data['Код АТС 2']) . "',
				reg_atx_3 				= '" . $this->db->escape($data['Код АТС 3']) . "',
				reg_instruction			= '" . $this->db->escape($this->saveProductInstructionFromLikReestr($product_id, $data)) . "'				
				WHERE product_id 		= '" . (int)$product_id . "'");
		}
		
		public function getProductByRegistryNumber($reg_number) {			
			$query = $this->db->query("SELECT DISTINCT * FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.reg_number LIKE '" . $this->db->escape($reg_number) . "'");

			return $query->row;
		}
		
		public function getSocialChildProduct($product_id){
			$query = $this->db->query("SELECT product_id FROM oc_product p WHERE social_parent_id = '" . (int)$product_id . "' LIMIT 1");
			
			if ($query->num_rows){
				return $this->getProduct($query->row['product_id']);			
				} else {
				return false;			
			}
		}
		
		public function getProducts($data = array()) {
			$sql = "SELECT * FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(pd.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_name'])) . "%'";
			}
			
			if (!empty($data['filter_model'])) {
				$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
			}
			
			if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
				$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
			}
			
			if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
				$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
			}
			
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}
			
			if (isset($data['filter_image']) && !is_null($data['filter_image'])) {
				if ($data['filter_image'] == 1) {
					$sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";
					} else {
					$sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";
				}
			}
			
			$sql .= " GROUP BY p.product_id";
			
			$sort_data = array(
			'pd.name',
			'p.model',
			'p.price',
			'p.quantity',
			'p.status',
			'p.sort_order'
			);
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];
				} else {
				$sql .= " ORDER BY pd.name";
			}
			
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
				} else {
				$sql .= " ASC";
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
			
			$query = $this->db->query($sql);
			
			return $query->rows;
		}
		
		public function getProductsByCategoryId($category_id) {
			$query = $this->db->query("SELECT * FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) LEFT JOIN oc_product_to_category p2c ON (p.product_id = p2c.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p2c.category_id = '" . (int)$category_id . "' ORDER BY pd.name ASC");
			
			return $query->rows;
		}
		
		public function getProductDescriptions($product_id) {
			$product_description_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_description WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_description_data[$result['language_id']] = array(
				'name'             => $result['name'],
				'original_name'    => $result['original_name'],
				'description'      => $result['description'],
				'faq_name'     	   => $result['faq_name'],
				'instruction'      => $result['instruction'],
				'meta_title'       => $result['meta_title'],
				'meta_description' => $result['meta_description'],
				'meta_keyword'     => $result['meta_keyword'],
				'tag'              => $result['tag']
				);
			}
			
			return $product_description_data;
		}
		
		public function getProductCategories($product_id) {
			$product_category_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_to_category WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_category_data[] = $result['category_id'];
			}
			
			return $product_category_data;
		}
		
		public function getProductCollections($product_id) {
			$product_collection_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_to_collection WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_collection_data[] = $result['collection_id'];
			}
			
			return $product_collection_data;
		}
		
		public function getProductSocialprograms($product_id) {
			$product_socialprogram_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_to_socialprogram WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_socialprogram_data[] = $result['socialprogram_id'];
			}
			
			return $product_socialprogram_data;
		}
		
		public function getProductPrimenenie($product_id) {
			$product_category_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_to_primenenie WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_category_data[] = $result['primenenie_id'];
			}
			
			return $product_category_data;
		}
		
		public function getProductTags($product_id) {
			$product_category_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_to_tags WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_category_data[] = $result['tags_id'];
			}
			
			return $product_category_data;
		}
		
		public function getProductFilters($product_id) {
			$product_filter_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_filter WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_filter_data[] = $result['filter_id'];
			}
			
			return $product_filter_data;
		}

		public function getJustProductAttributeValues($product_id, $attribute_ids = []) {
			$results = [];

			$query = $this->db->query("SELECT text FROM oc_product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id IN (" . implode(',', $attribute_ids) . ")");

			foreach($query->rows as $row){
				if ($row['text']){
					$results[] = $row['text'];
				}
			}

			return array_unique($results);
		}
		
		public function getProductAttributes($product_id) {
			$product_attribute_data = array();
			
			$product_attribute_query = $this->db->query("SELECT attribute_id FROM oc_product_attribute WHERE product_id = '" . (int)$product_id . "' GROUP BY attribute_id");
			
			foreach ($product_attribute_query->rows as $product_attribute) {
				$product_attribute_description_data = array();
				
				$product_attribute_description_query = $this->db->query("SELECT * FROM oc_product_attribute WHERE product_id = '" . (int)$product_id . "' AND attribute_id = '" . (int)$product_attribute['attribute_id'] . "'");
				
				foreach ($product_attribute_description_query->rows as $product_attribute_description) {
					$product_attribute_description_data[$product_attribute_description['language_id']] = array('text' => $product_attribute_description['text']);
				}
				
				$product_attribute_data[] = array(
				'attribute_id'                  => $product_attribute['attribute_id'],
				'product_attribute_description' => $product_attribute_description_data
				);
			}
			
			return $product_attribute_data;
		}
		
		public function getProductOptions($product_id) {
			$product_option_data = array();
			
			$product_option_query = $this->db->query("SELECT * FROM `oc_product_option` po LEFT JOIN `oc_option` o ON (po.option_id = o.option_id) LEFT JOIN `oc_option_description` od ON (o.option_id = od.option_id) WHERE po.product_id = '" . (int)$product_id . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			foreach ($product_option_query->rows as $product_option) {
				$product_option_value_data = array();
				
				$product_option_value_query = $this->db->query("SELECT * FROM oc_product_option_value pov LEFT JOIN oc_option_value ov ON(pov.option_value_id = ov.option_value_id) WHERE pov.product_option_id = '" . (int)$product_option['product_option_id'] . "' ORDER BY ov.sort_order ASC");
				
				foreach ($product_option_value_query->rows as $product_option_value) {
					$product_option_value_data[] = array(
					'product_option_value_id' => $product_option_value['product_option_value_id'],
					'option_value_id'         => $product_option_value['option_value_id'],
					'quantity'                => $product_option_value['quantity'],
					'subtract'                => $product_option_value['subtract'],
					'price'                   => $product_option_value['price'],
					'price_prefix'            => $product_option_value['price_prefix'],
					'points'                  => $product_option_value['points'],
					'points_prefix'           => $product_option_value['points_prefix'],
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
			
		//	print('<pre>');
		//	print_r($product_option_data);
		//	print('</pre>');
			
			return $product_option_data;
		}
		
		
		public function getProductOptionValue($product_id, $product_option_value_id) {
			$query = $this->db->query("SELECT pov.option_value_id, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM oc_product_option_value pov LEFT JOIN oc_option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN oc_option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_id = '" . (int)$product_id . "' AND pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
			
			return $query->row;
		}
		
		public function getProductImages($product_id) {
			$query = $this->db->query("SELECT * FROM oc_product_image WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");
			
			return $query->rows;
		}
		
		public function getProductDiscounts($product_id) {
			$query = $this->db->query("SELECT * FROM oc_product_discount WHERE product_id = '" . (int)$product_id . "' ORDER BY quantity, priority, price");
			
			return $query->rows;
		}
		
		public function getProductSpecials($product_id) {
			$query = $this->db->query("SELECT * FROM oc_product_special WHERE product_id = '" . (int)$product_id . "' ORDER BY priority, price");
			
			return $query->rows;
		}
		
		public function getProductRewards($product_id) {
			$product_reward_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_reward WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_reward_data[$result['customer_group_id']] = array('points' => $result['points']);
			}
			
			return $product_reward_data;
		}
		
		public function getProductDownloads($product_id) {
			$product_download_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_to_download WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_download_data[] = $result['download_id'];
			}
			
			return $product_download_data;
		}
		
		public function getProductStores($product_id) {
			$product_store_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_to_store WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_store_data[] = $result['store_id'];
			}
			
			return $product_store_data;
		}
		
		public function getProductLayouts($product_id) {
			$product_layout_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_to_layout WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_layout_data[$result['store_id']] = $result['layout_id'];
			}
			
			return $product_layout_data;
		}
		
		public function getProductMainCategoryId($product_id) {
			$query = $this->db->query("SELECT category_id FROM oc_product_to_category WHERE product_id = '" . (int)$product_id . "' AND main_category = '1' LIMIT 1");
			
			return ($query->num_rows ? (int)$query->row['category_id'] : 0);
		}
		
		public function getProductMainCollectionId($product_id) {
			$query = $this->db->query("SELECT collection_id FROM oc_product_to_collection WHERE product_id = '" . (int)$product_id . "' AND main_collection = '1' LIMIT 1");
			
			return ($query->num_rows ? (int)$query->row['collection_id'] : 0);
		}
		
		public function getProductMainSocialProgramId($product_id) {
			$query = $this->db->query("SELECT socialprogram_id FROM oc_product_to_socialprogram WHERE product_id = '" . (int)$product_id . "' AND main_socialprogram = '1' LIMIT 1");
			
			return ($query->num_rows ? (int)$query->row['socialprogram_id'] : 0);
		}
		
		public function getProductRelated($product_id) {
			$product_related_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_related WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_related_data[] = $result['related_id'];
			}
			
			return $product_related_data;
		}
		
		public function getProductFaq($product_id) {
			$query = $this->db->query("SELECT * FROM oc_product_faq WHERE product_id = '" . (int)$product_id . "' ORDER BY sort_order ASC");
			return $query->rows;
		}
		
		public function getProductSame($product_id) {
			$product_same_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_same WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_same_data[] = $result['same_id'];
			}
			
			return $product_same_data;
		}
		
		public function getProductAnalog($product_id) {
			$product_analog_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_analog WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_analog_data[] = $result['analog_id'];
			}
			
			return $product_analog_data;
		}
		
		public function getProductLight($product_id) {
			$product_light_data = array();
			
			$query = $this->db->query("SELECT * FROM oc_product_light WHERE product_id = '" . (int)$product_id . "'");
			
			foreach ($query->rows as $result) {
				$product_light_data[] = $result['light_id'];
			}
			
			return $product_light_data;
		}
		
		public function getRecurrings($product_id) {
			$query = $this->db->query("SELECT * FROM `oc_product_recurring` WHERE product_id = '" . (int)$product_id . "'");
			
			return $query->rows;
		}
		
		public function getTotalProductsExtended($data = array()) {
			$sql = "SELECT COUNT(DISTINCT p.product_id) AS total";
			
			if (!empty($data['filter_category_id'])) {
				if (!empty($data['filter_sub_category'])) {
					$sql .= " FROM oc_category_path cp LEFT JOIN oc_product_to_category p2c ON (cp.category_id = p2c.category_id)";
					} else {
					$sql .= " FROM oc_product_to_category p2c";
				}
				
				if (!empty($data['filter_filter'])) {
					$sql .= " LEFT JOIN oc_product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN oc_product p ON (pf.product_id = p.product_id)";
					} else {
					$sql .= " LEFT JOIN oc_product p ON (p2c.product_id = p.product_id)";
				}
				} else {
				$sql .= " FROM oc_product p";
			}
			
			$sql .= " LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id) LEFT JOIN oc_product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";
			
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
			
			if (!empty($data['filter_manufacturer_id'])) {
				$sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
			}
			
			$query = $this->db->query($sql);
			
			return $query->row['total'];
		}
		
		public function getTotalProducts($data = array()) {
			$sql = "SELECT COUNT(DISTINCT p.product_id) AS total FROM oc_product p LEFT JOIN oc_product_description pd ON (p.product_id = pd.product_id)";
			
			$sql .= " WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
			if (!empty($data['filter_name'])) {
				$sql .= " AND LCASE(pd.name) LIKE '%" . $this->db->escape(mb_strtolower($data['filter_name'])) . "%'";
			}
			
			if (!empty($data['filter_model'])) {
				$sql .= " AND p.model LIKE '" . $this->db->escape($data['filter_model']) . "%'";
			}
			
			if (isset($data['filter_price']) && !is_null($data['filter_price'])) {
				$sql .= " AND p.price LIKE '" . $this->db->escape($data['filter_price']) . "%'";
			}
			
			if (isset($data['filter_quantity']) && !is_null($data['filter_quantity'])) {
				$sql .= " AND p.quantity = '" . (int)$data['filter_quantity'] . "'";
			}

			if (isset($data['filter_instock']) && !is_null($data['filter_instock'])) {
				$sql .= " AND p.quantity > 0";
			}
			
			if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
				$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
			}
			
			if (isset($data['filter_image']) && !is_null($data['filter_image'])) {
				if ($data['filter_image'] == 1) {
					$sql .= " AND (p.image IS NOT NULL AND p.image <> '' AND p.image <> 'no_image.png')";
					} else {
					$sql .= " AND (p.image IS NULL OR p.image = '' OR p.image = 'no_image.png')";
				}
			}
			
			$query = $this->db->query($sql);
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByTaxClassId($tax_class_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product WHERE tax_class_id = '" . (int)$tax_class_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByStockStatusId($stock_status_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product WHERE stock_status_id = '" . (int)$stock_status_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByWeightClassId($weight_class_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product WHERE weight_class_id = '" . (int)$weight_class_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByLengthClassId($length_class_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product WHERE length_class_id = '" . (int)$length_class_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByDownloadId($download_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product_to_download WHERE download_id = '" . (int)$download_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByManufacturerId($manufacturer_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product WHERE manufacturer_id = '" . (int)$manufacturer_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByAttributeId($attribute_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product_attribute WHERE attribute_id = '" . (int)$attribute_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByOptionId($option_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product_option WHERE option_id = '" . (int)$option_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByProfileId($recurring_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product_recurring WHERE recurring_id = '" . (int)$recurring_id . "'");
			
			return $query->row['total'];
		}
		
		public function getTotalProductsByLayoutId($layout_id) {
			$query = $this->db->query("SELECT COUNT(*) AS total FROM oc_product_to_layout WHERE layout_id = '" . (int)$layout_id . "'");
			
			return $query->row['total'];
		}
		
		public function initProductStocks($data){
			
			$this->db->query("INSERT IGNORE INTO oc_stocks SET
			product_id = '" . (int)$data['product_id'] . "',
			location_id = '" . (int)$data['location_id'] . "',
			quantity = 0,
			price = 0,
			quantity_of_parts = 0,
			price_of_part = 0,
			count = 0,
			reserve = 0"
			);
			
		}
		
		public function getProductStocks($product_id){			
			$query = $this->db->query("SELECT s.*, l.name
			FROM oc_stocks s
			LEFT JOIN oc_location l ON l.location_id = s.location_id
			WHERE product_id = '" . (int)$product_id . " ORDER BY location_id ASC'
			
			");
			
			return $query->rows;
		}
		
		public function updateProductStocks($data){			
			$this->db->query("INSERT IGNORE INTO oc_stocks SET
			product_id 			= '" . (int)$data['product_id'] . "',
			location_id 		= '" . (int)$data['location_id'] . "',
			quantity 			= '" . (int)$data['quantity'] . "',
			quantity_of_parts 	= '" . (int)$data['quantity_of_parts'] . "',
			price 				= '" . (float)$data['price'] . "',
			price_retail 		= '" . (float)$data['price_retail'] . "',
			price_of_part 		= '" . (float)$data['price_of_part'] . "',
			count 				= '" . (int)$data['count'] . "',
			reserve 			= '" . (int)$data['reserve'] . "',
			ocfilter_value_id 	= '" . (int)$data['ocfilter_value_id'] . "'
			ON DUPLICATE KEY UPDATE
			quantity 			= '" . (int)$data['quantity'] . "',
			quantity_of_parts 	= '" . (int)$data['quantity_of_parts'] . "',
			price 				= '" . (float)$data['price'] . "',
			price_retail 		= '" . (float)$data['price_retail'] . "',
			price_of_part 		= '" . (float)$data['price_of_part'] . "',
			count 				= '" . (int)$data['count'] . "',
			reserve 			= '" . (int)$data['reserve'] . "',
			ocfilter_value_id 	= '" . (int)$data['ocfilter_value_id'] . "'");
		}
	}										