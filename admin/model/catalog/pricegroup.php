<?php
class ModelCatalogPriceGroup extends Model {
	
	public function addPriceGroup($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "price_group SET name = '" . $this->db->escape($data['name']) . "', uuid = '" . $this->db->escape($data['uuid']) . "'");

		$pricegroup_id = $this->db->getLastId();
		
		return $pricegroup_id;
	}

	public function editPriceGroup($pricegroup_id, $data) {
	
		$this->db->query("UPDATE " . DB_PREFIX . "price_group SET name = '" . $this->db->escape($data['name']) . "', uuid = '" . $this->db->escape($data['uuid']) . "' WHERE 	pricegroup_id  = '" . (int)$pricegroup_id  . "'");
		
	}
	
	public function getPriceGroups() {
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "price_group WHERE 1");
		
		return $query->rows;
	}
	
	public function getPriceGroupsForCustomerGroup($customer_group_id) {
		
		$query = $this->db->query("SELECT *, pg.name as pg_name, pg.uuid as pg_uuid FROM " . DB_PREFIX . "price_group_to_customer_group pg2cg LEFT JOIN " . DB_PREFIX . "price_group pg ON pg2cg.pricegroup_id = pg.pricegroup_id WHERE customer_group_id = '" . (int)$customer_group_id . "' ORDER BY pg.name ASC");
		
		return $query->rows;
		
	}
}