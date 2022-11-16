<?php
	
	class ControllerFeedGoogleSitemapCli extends Controller {
		private $limit = 2000;
		private $sitemaps = array();
		
		public function index() {
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}						
		}
		
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

		//VERY FAST AND DIRTY FIX
		private function linkUA($uri){
			if ($this->config->get('config_language_id') == 3){
				return str_ireplace(HTTPS_SERVER, HTTPS_SERVER . 'ua/', $uri);
			} else {
				return $uri;
			}
		}
		
		private function writeSitemap($sitemap, $output){
			
			$file = DIR_SITEMAPS . $sitemap;
			$link = HTTPS_SERVER . 'feeds/sitemaps/' . $sitemap;
			$this->echoLine('[i] Добавлен сайтмап: ' . $link);
			
			$this->sitemaps[] = $link;
			
			$handle = fopen($file, 'w+');
			flock($handle, LOCK_EX);
			fwrite($handle, $output);
			flock($handle, LOCK_UN);
			fclose($handle);
			
		}
		
		private function writeSitemapIndex($code){
			
			$output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= ' <sitemapindex xmlns:xsi="https://www.w3.org/2001/XMLSchema-instance"
			
			xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/siteindex.xsd"
			
			xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';	
			
			foreach ($this->sitemaps as $sitemap){
				$output .= '<sitemap>';			
				$output .= '<loc><![CDATA['.$sitemap.']]></loc>';			
				$output .= '</sitemap>';				
			}
			
			$output .= '  </sitemapindex>';				
			
			$file = DIR_FEEDS . 'sitemap.'. $code .'.xml';
			
			file_put_contents($file, $output);
			$this->echoLine('');
			$this->echoLine('[SG] Записали файл индекса ' . $file);
			$this->echoLine('[SG] Сайтмап-индекс создан, доступен по адресу ' . HTTPS_SERVER . '/feeds/sitemap.'. $code .'.xml');
			
		}
		
		public function cron(){
		
			ini_set('memory_limit', '2G');
			
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}
			
			$this->cache->delete('seo_pro');
			$this->cache->delete('seo_url');
			
			
			if ($this->config->get('google_sitemap_status')) {							
				$this->load->model('catalog/product');
				$this->load->model('tool/image');
				
				$this->load->model('catalog/category');
				$this->load->model('catalog/manufacturer');
				$this->load->model('catalog/information');
				$this->load->model('catalog/collection');
				
				$this->load->model('catalog/ocfilter');				
				$this->load->model('simple_blog/article');
				
				$this->load->model('localisation/language');
				$languages = $this->model_localisation_language->getLanguages();
				
				foreach ($languages as $language){	
								
					$this->config->set('config_language_id', $language['language_id']);
					$this->config->set('config_language', $language['code']);
					$this->config->set('config_language_code_explicit', $language['code']);										
					
					$this->echoLine('[i] Язык ' . $language['code']);
									
				
					//START PRODUCTS
					$this->echoLine('');
					$this->echoLine('[SG] Начали товары');
					$total_products = $this->model_catalog_product->getTotalProducts();
					$index = (int)($total_products / $this->limit);		
					
					for ($i=0; $i<=$index; $i++){
						
						$this->echoLine('[SG] Сайтмап товаров ' . $i);
						
						$output  = '<?xml version="1.0" encoding="UTF-8"?>';
						$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
						
						$start = $i * $this->limit;	
						
						$data = array(
						'start' => $start,
						'limit' => $this->limit
						);
						
						$products = $this->model_catalog_product->getProducts($data);
						
						unset($product);
						foreach ($products as $product) {									
							$output .= '<url>';
							$output .= '<loc><![CDATA[' . $this->linkUA($this->url->link('product/product', 'product_id=' . $product['product_id'])) . ']]></loc>';
							$output .= '<changefreq>weekly</changefreq>';
							
							$date_modified = $product['date_modified'] != '0000-00-00 00:00:00' ? $product['date_modified'] : $product['date_added'];
							if ($product['date_modified'] == '0000-00-00 00:00:00' || date('Y-m-d\TH:i:sP', strtotime($product['date_modified'])) == '-0001-11-30T00:00:00+00:00' || date('Y-m-d\TH:i:sP', strtotime($product['date_modified'])) == '0001-01-01T00:00:00+00:00'){
								$date_modified = date('Y-m-d\TH:i:sP');
							}
							
							$output .= '<lastmod>' . date('Y-m-d\TH:i:sP', strtotime($date_modified)) . '</lastmod>';
							$output .= '<priority>1.0</priority>';
							if ($product['image']) {
								$output .= '<image:image>';
								$output .= '<image:loc>' . $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height')) . '</image:loc>';
								$output .= '<image:caption><![CDATA[' . $product['name'] . ']]></image:caption>';
								$output .= '<image:title><![CDATA[' . $product['name'] . ']]></image:title>';
								$output .= '</image:image>';						
								$output .= '<image:image>';
								$output .= '<image:loc>' . $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')) . '</image:loc>';
								$output .= '<image:caption><![CDATA[' . $product['name'] . ']]></image:caption>';
								$output .= '<image:title><![CDATA[' . $product['name'] . ']]></image:title>';
								$output .= '</image:image>';						
							}
							
							$images = $this->model_catalog_product->getProductImages($product['product_id']);
							
							if ($images){
								foreach ($images as $image){
									$output .= '<image:image>';
									$output .= '<image:loc>' . $this->model_tool_image->resize($image['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height')) . '</image:loc>';
									$output .= '<image:caption><![CDATA[' . $product['name'] . ']]></image:caption>';
									$output .= '<image:title><![CDATA[' . $product['name'] . ']]></image:title>';
									$output .= '</image:image>';							
									$output .= '<image:image>';
									$output .= '<image:loc>' . $this->model_tool_image->resize($image['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')) . '</image:loc>';
									$output .= '<image:caption><![CDATA[' . $product['name'] . ']]></image:caption>';
									$output .= '<image:title><![CDATA[' . $product['name'] . ']]></image:title>';
									$output .= '</image:image>';
								}							
							}
							
							$output .= '</url>';						
						}
						$output .= '</urlset>';
						
						$this->writeSitemap('products.sitemap.'.$i.'.'.$language['code'].'.xml', $output);		
					}
					//END PRODUCTS
					
					//START MANUFACTURERS
					$this->echoLine('');
					$this->echoLine('[SG] Начали бренды');
					$manufacturers = $this->model_catalog_manufacturer->getManufacturers();
					
					$output  = '<?xml version="1.0" encoding="UTF-8"?>';
					$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
					
					foreach ($manufacturers as $manufacturer) {
						$output .= '<url>';
						$output .= '<loc><![CDATA[' . $this->linkUA($this->url->link('product/manufacturer/info', 'manufacturer_id=' . $manufacturer['manufacturer_id'])) . ']]></loc>';
						$output .= '<changefreq>weekly</changefreq>';
						$output .= '<priority>0.7</priority>';
						$output .= '</url>';
					}
					
					$output .= '</urlset>';
					
					$this->writeSitemap('manufacturer.sitemap.'.$language['code'].'.xml', $output);				
					//END MANUFACTURERS
					
					
					//START INFO
					$this->echoLine('');
					$this->echoLine('[SG] Начали информационные статьи');
					$informations = $this->model_catalog_information->getInformations();
					$output  = '<?xml version="1.0" encoding="UTF-8"?>';
					$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
					
					foreach ($informations as $information) {
						$output .= '<url>';
						$output .= '<loc><![CDATA[' . $this->linkUA($this->url->link('information/information', 'information_id=' . $information['information_id'])) . ']]></loc>';
						$output .= '<changefreq>weekly</changefreq>';
						$output .= '<priority>0.5</priority>';
						$output .= '</url>';
					}
					$output .= '</urlset>';
					
					$this->writeSitemap('information.sitemap.'.$language['code'].'.xml', $output);							
					//END INFO
					
					//OCFILTER PAGES
					if ($this->config->get('ocfilter_sitemap_status')) {
						
						$output  = '<?xml version="1.0" encoding="UTF-8"?>';
						$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
						
						$this->echoLine('');
						$this->echoLine('[SG] Начали страницы OCFILTER');
						$ocfilter_pages = $this->model_catalog_ocfilter->getPages();
						
						foreach ($ocfilter_pages as $page) {
							$link = rtrim($this->url->link('product/category', 'path=' . $page['category_id']), '/');
							
							if ($page['keyword']) {
								$link .= '/' . $page['keyword'];
								} else {
								$link .= '/' . $page['params'];
							}
							
							if ($this->config->get('config_seo_url_type') == 'seo_pro') {
								$link .= '/';
							}
							
							$output .= '<url>';
							$output .= '<loc><![CDATA[' . $this->linkUA($link) . ']]></loc>';
							$output .= '<changefreq>weekly</changefreq>';
							$output .= '<priority>0.7</priority>';
							$output .= '</url>';
							
						}
						$output .= '</urlset>';
						
						$this->writeSitemap('ocfilter.page.sitemap.'.$language['code'].'.xml', $output);							
					}
					
					//START CATEGORIES
					$this->echoLine('');
					$this->echoLine('[SG] Начали категории товаров');
					$output  = '<?xml version="1.0" encoding="UTF-8"?>';
					$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
					$output .= $this->getCategories(0);
					$output .= '</urlset>';
					
					$this->writeSitemap('category.sitemap.'.$language['code'].'.xml', $output);				
					//END CATEGORIES
					
					//START COLLECTIONS
					$this->echoLine('');
					$this->echoLine('[SG] Начали коллекции товаров');
					$output  = '<?xml version="1.0" encoding="UTF-8"?>';
					$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
					$output .= $this->getCollections(0);
					$output .= '</urlset>';
					
					$this->writeSitemap('collections.sitemap.'.$language['code'].'.xml', $output);				
					//END COLLECTIONS
					
					//START OCT_BLOG 
					$this->echoLine('');
					$this->echoLine('[SG] Начали блог');
				
					
					$output  = '<?xml version="1.0" encoding="UTF-8"?>';
					$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';
					$articles = $this->model_simple_blog_article->getArticles();
					foreach ($articles as $article){
						$output .= '<url>';
						$output .= '<loc><![CDATA[' . $this->linkUA($this->url->link('simple_blog_article/article', 'simple_blog_article_id=' . $article['simple_blog_article_id'])) . ']]></loc>';
						$output .= '<changefreq>weekly</changefreq>';
						$output .= '<priority>0.7</priority>';
						$output .= '</url>';
					}				
					$output .= '</urlset>';
					$this->writeSitemap('blog.articles.sitemap.'.$language['code'].'.xml', $output);
					
					//END OCT_BLOG 
														
					$this->writeSitemapIndex($language['code']);
					$this->sitemaps = array();
				}
			}
		}
		

		//СТРУКТУРА КАТЕГОРИЙ
		protected function getCategories($parent_id, $current_path = '') {
			$output = '';
			
			$results = $this->model_catalog_category->getCategories($parent_id);
			
			foreach ($results as $result) {
				if (!$current_path) {
					$new_path = $result['category_id'];
					} else {
					$new_path = $current_path . '_' . $result['category_id'];
				}
				
				//	$this->echoLine('[c] Категория ' . $result['name']);
				
				$output .= '<url>';
				$output .= '<loc><![CDATA[' . $this->linkUA($this->url->link('product/category', 'path=' . $new_path)) . ']]></loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.7</priority>';
				$output .= '</url>';
				
				//Производители, совместимость OCFILTER
				/*
				if ($this->config->get('ocfilter_manufacturer')) {
					$manufacturers = $this->model_catalog_ocfilter->getManufacturersByCategoryId($result['category_id']);
					
					if ($manufacturers) {
						foreach ($manufacturers as $manufacturer){
							//	$this->echoLine('[OCF] Бренд ' . $manufacturer['name'] . ', URL: ' . $this->url->link('product/category', 'path=' . $new_path . '&manufacturer_id=' . $manufacturer['value_id']) . '/');
							
							$output .= '<url>';
							$output .= '<loc><![CDATA[' .  $this->url->link('product/category', 'path=' . $new_path . '&manufacturer_id=' . $manufacturer['value_id']) . '/' . ']]></loc>';
							$output .= '<changefreq>weekly</changefreq>';
							$output .= '<priority>0.7</priority>';
							$output .= '</url>';
						}
					}
				}
				*/
				
				
				$output .= $this->getCategories($result['category_id'], $new_path);
			}
			
			return $output;
		}
		
		//СТРУКТУРА Коллекций
		protected function getCollections($parent_id, $current_path = '') {
			$output = '';
			
			$results = $this->model_catalog_collection->getCollections($parent_id);
			
			foreach ($results as $result) {
				if (!$current_path) {
					$new_path = $result['collection_id'];
					} else {
					$new_path = $current_path . '_' . $result['collection_id'];
				}
				
				//	$this->echoLine('[c] Коллекция ' . $result['name']);
				
				$output .= '<url>';
				$output .= '<loc><![CDATA[' . $this->linkUA($this->url->link('product/collection', 'colpath=' . $new_path)) . ']]></loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.7</priority>';
				$output .= '</url>';			
				
				
				$output .= $this->getCollections($result['collection_id'], $new_path);
			}
			
			return $output;
		}
		
		
	}	