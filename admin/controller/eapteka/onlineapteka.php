	<?php
	ini_set('memory_limit', '-1');
	class ControllerEaptekaOnlineApteka extends Controller {
		private $url = 'https://online-apteka.com.ua/rest/products/';


		private function get_data($token, $url, $total) {
			$limit = 100;
			for ($start = 0; $start < $total; $start += $limit) {

				echoLine('[ControllerOnlineApteka::get_data] Getting Data: ' . $start . ' - ' . $limit, 'w');

				$curl = curl_init();
				curl_setopt_array($curl, [
					CURLOPT_URL => "$url?start=$start&limit=$limit",
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_HTTPHEADER => [
						"Authorization: Bearer $token"
					]
				]);

				$response = curl_exec($curl);
				$data = json_decode($response, true);

				if (!empty($data['results'])){
					foreach ($data['results'] as $line){
						echoLine('[ControllerOnlineApteka::get_data] Writing product with code: ' . $line['code'], 's');

						$this->db->query("INSERT INTO oc_onlineapteka SET code = '" . $this->db->escape($line['code']) . "', json = '" . $this->db->escape(json_encode($line)) . "' ON DUPLICATE KEY UPDATE json = '" . $this->db->escape(json_encode($line)) . "'");
					}
				}				

				curl_close($curl); 
			}
		}

		public function hobot(){
			$curl = curl_init(); 
			curl_setopt_array($curl, [
				CURLOPT_URL => "$this->url?limit=1",
				CURLOPT_RETURNTRANSFER => true, 
				CURLOPT_HTTPHEADER => [
					"Authorization: Bearer $this->token"
				]
			]);

			$response = curl_exec($curl);
			$data = json_decode($response, true);
			$total = $data['total'];		

			curl_close($curl);

			$this->db->query("TRUNCATE TABLE oc_onlineapteka");

			$this->get_data(ONLINEAPTEKA_API_KEY, $this->url, $total);
		}

		public function image(){
			$this->hobot();

			$query = $this->db->query("SELECT * FROM oc_product WHERE (image = '' OR ISNULL(image)) AND ms_code <> ''");

			foreach ($query->rows as $row){
				$oquery = $this->db->query("SELECT * FROM oc_onlineapteka WHERE code = '" . $row['model'] . "'");

				if ($oquery->num_rows){
					echoLine('[ControllerOnlineApteka::image] Found OA: ' . $oquery->row['code'], 's');

					$json = json_decode($oquery->row['json'], true);
					if (!empty($json['image'])){
						echoLine('[ControllerOnlineApteka::image] Found image: ' . $json['image'], 's');
						$img_content = file_get_contents('https://online-apteka.com.ua' . $json['image']);				
						$full_path = DIR_IMAGE . 'catalog/source/' . $row['product_id'] . '-' . md5($json['code']) . '.' . pathinfo($json['image'],  PATHINFO_EXTENSION);
						$path      = 'catalog/source/' . $row['product_id'] . '-' . md5($json['code']) . '.' . pathinfo($json['image'],  PATHINFO_EXTENSION);
						echoLine('[ControllerOnlineApteka::image] Downloading to file: ' . $full_path, 'i');

						file_put_contents($full_path, $img_content);

						$this->db->query("UPDATE oc_product SET image = '" . $this->db->escape($path) . "' WHERE product_id = '" . (int)$row['product_id'] . "'");						
					}
				}
			}
		}

		public function double(){
			$this->load->model('catalog/product');

			$query = $this->db->query("SELECT ms_code, GROUP_CONCAT(product_id SEPARATOR ',') as product_ids FROM `oc_product` WHERE ms_code <> '' GROUP BY ms_code HAVING COUNT(product_id) > 1");

			$uuids_to_delete = [];
			foreach ($query->rows as $row){
				echoLine('[ControllerEaptekaOnlineApteka::doubles] Multi code: ' . $row['ms_code'], 'e');
				$exploded = explode(',', $row['product_ids']);

				foreach ($exploded as $product_id){
					$product = $this->model_catalog_product->getProduct($product_id);
					echoLine('[ControllerEaptekaOnlineApteka::doubles] Product ' . $product['name'] . ', added ' . date('Y-m-d', strtotime($product['date_added'])), 'i');

					if (date('Y-m-d', strtotime($product['date_added'])) == '2024-01-11'){
						$uuids_to_delete[] = $product['uuid'];
					}
				}

			}

			echoLine(json_encode($uuids_to_delete), 's');
		}

		public function category(){
			$this->load->model('catalog/category');

			$query = $this->db->query("SELECT oc_product.product_id, ms_code, modx_ms2_products.id as ms_id, oc_product_description.name as name FROM oc_product 
				LEFT JOIN modx_ms2_products ON (oc_product.ms_code = modx_ms2_products.code) 
				LEFT JOIN oc_product_description ON (oc_product.product_id = oc_product_description.product_id AND language_id = 3)
				WHERE oc_product.product_id NOT IN (SELECT product_id FROM oc_product_to_category) AND ms_code <> ''");

			echoLine('[ControllerOnlineApteka::category] TOTAL: ' . $query->num_rows, 'e');
			sleep(3);

			foreach ($query->rows as $row){
				if ($row['ms_id']){
					echoLine('-----------------------------------------------------------', 'w');

					echoLine('[ControllerOnlineApteka::category] Товар АГП: ' . $row['name'] . ', product_id ' . $row['product_id'], 'i');

					echoLine('[ControllerOnlineApteka::category] Працюємо в контексті web з: ' . $row['ms_code'] . ' and ms_product_id ' . $row['ms_id'], 'i');
					$msc_query = $this->db->query("SELECT * FROM modx_site_content WHERE id = '" . (int)$row['ms_id'] . "' AND class_key='msProduct' AND context_key = 'web' LIMIT 1");

					if ($msc_query->row['pagetitle']){
						echoLine('[ControllerOnlineApteka::category] Знайшли товар МС: ' . $msc_query->row['pagetitle'], 'i');

						if ($msc_query->row['parent']){
							$msp_query = $this->db->query("SELECT pagetitle FROM modx_site_content WHERE id = '" . $msc_query->row['parent'] . "' AND context_key = 'web'");
							echoLine('[ControllerOnlineApteka::category] Категорія МС: ' . $msp_query->row['pagetitle'], 'i');

							$eac_query = $this->db->query("SELECT category_id FROM oc_category WHERE onlineapteka_id = '" . (int)$msc_query->row['parent'] . "'");

							if ($eac_query->num_rows){
								foreach ($eac_query->rows as $eac_row){
									$category = $this->model_catalog_category->getCategory($eac_row['category_id']);
									echoLine('[ControllerOnlineApteka::category] Знайшли співставлення: ' . $category['name'] . ' -> ' . $msp_query->row['pagetitle'], 's');

									if ($eac_query->num_rows == 1){
										$this->db->query("INSERT IGNORE INTO oc_product_to_category SET product_id = '" . $row['product_id'] . "', category_id = '" . $category['category_id'] . "', main_category = 1");
									} else {
										$this->db->query("INSERT IGNORE INTO oc_product_to_category SET product_id = '" . $row['product_id'] . "', category_id = '" . $category['category_id'] . "'");
									}									
								}
							}
						}
					}

					echoLine('[ControllerOnlineApteka::category] Працюємо в контексті ua з: ' . $row['ms_code'] . ' and ms_product_id ' . $row['ms_id'], 'i');
					$msc_query = $this->db->query("SELECT * FROM modx_site_content WHERE id = '" . (int)$row['ms_id'] . "' AND class_key='msProduct' AND context_key = 'ua' LIMIT 1");

					if ($msc_query->row['pagetitle']){
						echoLine('[ControllerOnlineApteka::category] Знайшли товар МС: ' . $msc_query->row['pagetitle'], 'i');

						if ($msc_query->row['parent']){
							$msp_query = $this->db->query("SELECT pagetitle FROM modx_site_content WHERE id = '" . $msc_query->row['parent'] . "' AND context_key = 'ua'");
							echoLine('[ControllerOnlineApteka::category] Категорія МС: ' . $msp_query->row['pagetitle'], 'i');

							$eac_query = $this->db->query("SELECT category_id FROM oc_category WHERE onlineapteka_id = '" . (int)$msc_query->row['parent'] . "'");

							if ($eac_query->num_rows){
								foreach ($eac_query->rows as $eac_row){
									$category = $this->model_catalog_category->getCategory($eac_row['category_id']);
									echoLine('[ControllerOnlineApteka::category] Знайшли співставлення: ' . $category['name'] . ' -> ' . $msp_query->row['pagetitle'], 's');

									if ($eac_query->num_rows == 1){
										$this->db->query("INSERT IGNORE INTO oc_product_to_category SET product_id = '" . $row['product_id'] . "', category_id = '" . $category['category_id'] . "', main_category = 1");
									} else {
										$this->db->query("INSERT IGNORE INTO oc_product_to_category SET product_id = '" . $row['product_id'] . "', category_id = '" . $category['category_id'] . "'");
									}	
								}							
							}
						}
					}
				}
			}






		}
	}