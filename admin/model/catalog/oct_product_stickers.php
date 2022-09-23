<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ModelCatalogOctProductStickers extends Model {
	public function addProductSticker($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "oct_product_stickers SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', color = '" . $this->db->escape($data['color']) . "', background = '" . $this->db->escape($data['background']) . "'");

		$product_sticker_id = $this->db->getLastId();

		foreach ($data['oct_product_stickers_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "oct_product_stickers_description SET product_sticker_id = '" . (int)$product_sticker_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', text = '" . $this->db->escape($value['text']) . "'");
		}

		return $product_sticker_id;
	}

	public function editProductSticker($product_sticker_id, $data) {
		$this->db->query("UPDATE " . DB_PREFIX . "oct_product_stickers SET sort_order = '" . (int)$data['sort_order'] . "', status = '" . (int)$data['status'] . "', color = '" . $this->db->escape($data['color']) . "', background = '" . $this->db->escape($data['background']) . "' WHERE product_sticker_id = '" . (int)$product_sticker_id . "'");

		$this->db->query("DELETE FROM " . DB_PREFIX . "oct_product_stickers_description WHERE product_sticker_id = '" . (int)$product_sticker_id . "'");

		foreach ($data['oct_product_stickers_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "oct_product_stickers_description SET product_sticker_id = '" . (int)$product_sticker_id . "', language_id = '" . (int)$language_id . "', title = '" . $this->db->escape($value['title']) . "', text = '" . $this->db->escape($value['text']) . "'");
		}
	}

	public function deleteProductSticker($product_sticker_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "oct_product_stickers WHERE product_sticker_id = '" . (int)$product_sticker_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "oct_product_stickers_description WHERE product_sticker_id = '" . (int)$product_sticker_id . "'");
	}

	public function getProductSticker($product_sticker_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "oct_product_stickers b LEFT JOIN " . DB_PREFIX . "oct_product_stickers_description bd ON (b.product_sticker_id = bd.product_sticker_id) WHERE b.product_sticker_id = '" . (int)$product_sticker_id . "' AND bd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

		return $query->row;
	}

	public function getProductStickers($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "oct_product_stickers b LEFT JOIN " . DB_PREFIX . "oct_product_stickers_description bd ON (b.product_sticker_id = bd.product_sticker_id) WHERE bd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		if (!empty($data['filter_name'])) {
			$sql .= " AND bd.title LIKE '" . $this->db->escape($data['filter_name']) . "%'";
		}

		$sql .= " GROUP BY b.product_sticker_id";

		$sort_data = array(
			'bd.title',
			'b.sort_order'
		);

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];
		} else {
			$sql .= " ORDER BY bd.title";
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

	public function getProductStickersDescriptions($product_sticker_id) {
		$oct_product_stickers_description_data = array();

		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "oct_product_stickers_description WHERE product_sticker_id = '" . (int)$product_sticker_id . "'");

		foreach ($query->rows as $result) {
			$oct_product_stickers_description_data[$result['language_id']] = array(
				'title' => $result['title'],
				'text' => $result['text']
			);
		}

		return $oct_product_stickers_description_data;
	}

	public function getTotalProductStickers() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "oct_product_stickers");

		return $query->row['total'];
	}
}