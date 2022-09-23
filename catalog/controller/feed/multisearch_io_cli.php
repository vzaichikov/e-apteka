<?php
	class ControllerFeedMultiSearchIoCli extends Controller {
		
		private function echoLine($line){
			$line = str_replace('<![CDATA[', '', $line);
			$line = str_replace(']]>', '', $line);
			echo $line . PHP_EOL;			
		}
		
		private function echoSimple($line){
			echo $line;			
		}
		
		private function memoryUnits($size)
		{
			$unit=array('b','kb','mb','gb','tb','pb');
			return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
		}
		
		private function getProductsFast(){
			
			$query = $this->db->ncquery("SELECT
			p.product_id, GROUP_CONCAT(p2c.category_id SEPARATOR ',') as category_ids FROM " . DB_PREFIX . "product p
			LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id)
			LEFT JOIN " . DB_PREFIX . "product_to_category AS p2c ON (p.product_id = p2c.product_id)
			LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id)
			WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'
			AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "'
			AND p.date_available <= NOW()
			AND p.price > 0
			AND p.status = '1'			
			GROUP BY p.product_id ORDER BY product_id");
			
			$i = 0;
			$total = count($query->rows);
			$this->echoLine('[MS]' . $total . ' товаров');
			
			$result = array();
			foreach ($query->rows as $row){			
				
				if ($i % 1000 == 0){
					$this->echoSimple($i.'...');
				}
				
				$result[$row['product_id']] = $this->model_catalog_product->getProduct($row['product_id']);
				$result[$row['product_id']]['categories'] = $row['category_ids'];
				$result[$row['product_id']]['attributes'] = $this->getProductAttributes($row['product_id']);
				$i++;
			}
			
			return $result;
		}
		
		public function getProductAttributes($product_id) {
			$query = $this->db->query("SELECT pa.attribute_id, pa.text, ad.name
			FROM product_attribute pa
			LEFT JOIN attribute_description ad ON (pa.attribute_id = ad.attribute_id)
			WHERE pa.product_id = '" . (int)$product_id . "'
			AND pa.language_id = '" . (int)$this->config->get('config_language_id') . "'
			AND ad.language_id = '" . (int)$this->config->get('config_language_id') . "'
			ORDER BY pa.attribute_id");
			
			return $query->rows;
		}
		
		
		private function getCategories() {
			$query = $this->db->ncquery("SELECT cd.name, c.category_id, c.parent_id, c.sort_order FROM 
			" . DB_PREFIX . "category c 
			LEFT JOIN " . DB_PREFIX . "category_description cd ON (c.category_id = cd.category_id) 
			LEFT JOIN " . DB_PREFIX . "category_to_store c2s ON (c.category_id = c2s.category_id) 
			WHERE cd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
			AND c2s.store_id = '" . (int)$this->config->get('config_store_id') . "' 
			AND c.status = '1'
			AND c.sort_order <> '-1'");
			
			return $query->rows;
		}
		
		
		public function cron() {		
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}
			
			error_reporting(E_ALL);		
			ini_set('display_errors', 'On');
			ini_set('memory_limit', '1024M');
			
			$this->echoLine('[MSRCH TIME] Начали в ' . date('H:i:s'));
			
			$this->load->model('extension/feed/google_base');
			$this->load->model('catalog/category');
			$this->load->model('catalog/product');
			$this->load->model('tool/image');
			
			$this->load->model('localisation/language');
			$languages = $this->model_localisation_language->getLanguages();
			
			foreach ($languages as $language){	
				
				$this->config->set('config_language_id', $language['language_id']);
				$this->config->set('config_language', $language['code']);
				$this->config->set('config_language_code_explicit', $language['code']);	
				
				//FULL
				$file = DIR_FEEDS . 'multisearch-io-feed-' . $language['code'] . '.xml';
				$this->echoLine('Файл ' . $file);	
				
				$this->echoLine('[MSRCH] Язык ' . $language['code']);
				
				$multisearch = fopen($file, 'w+');
				flock($multisearch, LOCK_EX);
				fwrite($multisearch, '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL);
				fwrite($multisearch, '<!DOCTYPE yml_catalog SYSTEM "shops.dtd">' . PHP_EOL);
				fwrite($multisearch, '<yml_catalog date="' . date('Y-m-d H:i') . '">' . PHP_EOL);
				fwrite($multisearch, '<shop>' . PHP_EOL);
				
				fwrite($multisearch, '<categories>' . PHP_EOL);
				
				fwrite($multisearch, '<categories>' . PHP_EOL);
				
				foreach ($this->getCategories() as $category) {			
					fwrite($multisearch, "<category id='" . (int)$category['category_id'] . "' ordering='" .  $category['sort_order'] . "' parentID = '" . (int)$category['parent_id'] . "' url='" . $this->url->link('product/category', 'category_id='. (int)$category['category_id']) . "'>" . $category['name'] . "</category>" . PHP_EOL);
				}
				
				fwrite($multisearch, '</categories>' . PHP_EOL);
				
				
				fwrite($multisearch, '<currencies>' . PHP_EOL);
				fwrite($multisearch, "<currency id='UAH' rate='1' />" . PHP_EOL);
				fwrite($multisearch, '</currencies>' . PHP_EOL);
				
				fwrite($multisearch, '</offers>' . PHP_EOL);
				fwrite($multisearch, '</shop>' . PHP_EOL);
				fwrite($multisearch, '</yml_catalog>' . PHP_EOL);
				
				
				flock($multisearch, LOCK_UN);
				fclose($multisearch);
				
				gc_collect_cycles();
				
				$this->echoLine('[MSRCH TIME] Закончили в ' . date('H:i:s'));
				
			}
		}	
	}																	