<?php
	class ControllerHobotixHoboDB extends Controller {
	
		public function index(){
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}
		}
	
		public function cron(){		
			if (!defined('OPENCART_CLI_MODE')){
				die('CLI ONLY');
			}
			
			echoLine('[ControllerHobotixHoboDB::cron] Cleaning carts', 'i');
			$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE (api_id > '0' OR customer_id = '0') AND date_added < DATE_SUB(NOW(), INTERVAL 30 DAY)");
			
			echoLine('[ControllerHobotixHoboDB::cron] Normalising stocks', 'i');		
			$this->db->query("INSERT INTO oc_stocks (product_id, product_uuid, location_id)	SELECT p.product_id, p.uuid, l.location_id FROM oc_product p CROSS JOIN oc_location l
				WHERE l.temprorary_closed = 0 AND p.status = 1 ON DUPLICATE KEY UPDATE product_uuid = p.uuid");

			echoLine('[ControllerHobotixHoboDB::cron] Нормализация рейтинга товаров', 'i');
			$this->db->query("UPDATE oc_product SET xrating = (SELECT AVG(rating) as xrating FROM oc_review WHERE status = 1 AND product_id = oc_product.product_id GROUP BY product_id)");
			$this->db->query("UPDATE oc_product SET xreviews = (SELECT COUNT(*) as xrating FROM oc_review WHERE status = 1 AND product_id = oc_product.product_id GROUP BY product_id)");
			
			echoLine('[ControllerHobotixHoboDB::cron] Подсчёт продаж по категориям', 'i');	
			$this->db->query("UPDATE oc_category SET bought_for_month = (SELECT SUM(quantity) FROM oc_order_product op WHERE op.product_id IN (SELECT product_id FROM oc_product_to_category WHERE category_id = oc_category.category_id) AND op.order_id IN (SELECT o.order_id FROM `oc_order` o WHERE o.order_status_id > 0 AND DATE(o.date_added) >= DATE(DATE_SUB(NOW(),INTERVAL 30 DAY))))");

			echoLine('[ControllerHobotixHoboDB::cron] Финальные категории', 'i');	
			$this->db->query("UPDATE oc_category SET final = 0 WHERE 1");
			$this->db->query("UPDATE oc_category SET final = 1 WHERE category_id NOT IN ( SELECT parent_id FROM ( SELECT parent_id FROM oc_category ) AS subquery )");
		}
	}	