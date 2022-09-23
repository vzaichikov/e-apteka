<?php
//==============================================================================
// Redirect Manager v210.1
// 
// Author: Clear Thinking, LLC
// E-mail: johnathan@getclearthinking.com
// Website: http://www.getclearthinking.com
// 
// All code within this file is copyright Clear Thinking, LLC.
// You may not copy or reuse code within this file without written permission.
//==============================================================================

class ControllerModuleRedirectManager extends Controller { 
	private $type = 'module';
	private $name = 'redirect_manager';
	
	public function index() {
		$data = array(
			'type'				=> $this->type,
			'name'				=> $this->name,
			'autobackup'		=> true,
			'save_type'			=> 'keepediting',
			'token'				=> $this->session->data['token'],
			'permission'		=> $this->user->hasPermission('modify', $this->type . '/' . $this->name),
			'exit'				=> $this->url->link('extension/' . $this->type . '&token=' . $this->session->data['token'], '', 'SSL'),
		);
		
		// extension-specific
		$table_query = $this->db->query("SHOW TABLES LIKE '" . DB_PREFIX . "redirect'");
		if ($table_query->num_rows) {
			$this->db->query("ALTER TABLE `" . DB_PREFIX . "redirect` CHANGE redirect_id " . $this->name . "_id INT");
			$this->db->query("RENAME TABLE `" . DB_PREFIX . "redirect` TO `" . $this->name . "`");
		} else {
			$this->db->query("
				CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . $this->name . "` (
				`" . $this->name . "_id` int(11) NOT NULL AUTO_INCREMENT,
				`active` tinyint(1) NOT NULL DEFAULT '0',
				`from_url` text COLLATE utf8_bin NOT NULL,
				`to_url` text COLLATE utf8_bin NOT NULL,
				`response_code` int(3) NOT NULL DEFAULT '301',
				`date_start` date NOT NULL DEFAULT '0000-00-00',
				`date_end` date NOT NULL DEFAULT '0000-00-00',
				`times_used` int(5) NOT NULL DEFAULT '0',
				PRIMARY KEY (`" . $this->name . "_id`)
				) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_bin
			");
		}
		
		if (isset($this->request->get['action'])) {
			if ($this->request->get['action'] == 'reset') {
				$this->db->query("UPDATE `" . DB_PREFIX . $this->name . "` SET times_used = 0");
			} elseif ($this->request->get['action'] == 'delete') {
				//$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . $this->name . "`");
			}
			$this->response->redirect(str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $this->url->link($this->type . '/' . $this->name, 'token=' . $this->session->data['token'], 'SSL')));
		}
		
		$data['page'] = (isset($this->request->get['page'])) ? (int)$this->request->get['page'] : 1;
		$data['limit'] = (version_compare(VERSION, '2.0', '<')) ? $this->config->get('config_admin_limit') : $this->config->get('config_limit_admin');
		// end
		
		$this->loadSettings($data);
		
		//------------------------------------------------------------------------------
		// Settings
		//------------------------------------------------------------------------------
		$data['settings'] = array();
		
		$data['settings'][] = array(
			'key'		=> 'status',
			'type'		=> 'select',
			'options'	=> array('0' => $data['text_disabled'], '1' => $data['text_enabled']),
		);
		$data['settings'][] = array(
			'key'		=> 'sorting',
			'type'		=> 'select',
			'options'	=> array(
				'active'		=> $data['column_active'],
				'from_url'		=> $data['column_from_url'],
				'to_url'		=> $data['column_to_url'],
				'response_code'	=> $data['column_response_code'],
				'date_start'	=> $data['column_date_start'],
				'date_end'		=> $data['column_date_end'],
				'times_used'	=> $data['column_times_used'],
			),
			'default'	=> 'from_url'
		);
		$data['settings'][] = array(
			'key'		=> 'filter_from_url',
			'type'		=> 'text',
			'attributes'=> array('style' => 'width: 400px !important'),
		);
		$data['settings'][] = array(
			'key'		=> 'filter_to_url',
			'type'		=> 'text',
			'attributes'=> array('style' => 'width: 400px !important'),
		);
		$data['settings'][] = array(
			'key'		=> 'sort_and_filter',
			'type'		=> 'html',
			'content'	=> '<a class="btn btn-primary" onclick="saveSettings($(this)); location = \'index.php?route=' . $this->type . '/' . $this->name . '&token=' . $data['token'] . '\'">' . $data['button_sort_and_filter'] . '</a>',
		);
		
		//------------------------------------------------------------------------------
		// Redirects
		//------------------------------------------------------------------------------
		$data['settings'][] = array(
			'key'		=> 'redirects',
			'type'		=> 'heading',
			'buttons'	=> '
				<a class="btn btn-danger" onclick="if (confirm(\'' . $data['standard_confirm'] . '\')) location = location + \'&action=reset\'">' . $data['button_reset_all'] . '</a>				
			',
		);
		
		$pagination = new Pagination();
		$pagination->total = $data['table_total'];
		$pagination->page = $data['page'];
		$pagination->limit = $data['limit'];
		$pagination->text = $data['text_pagination'];
		$pagination->url = $this->url->link($this->type . '/' . $this->name, 'token=' . $data['token'] . '&page={page}', 'SSL');
		
		$data['settings'][] = array(
			'type'		=> 'html',
			'content'	=> '<div class="pagination" style="border: none; margin: -10px 0 15px;">' . $pagination->render() . '</div>',
		);
		
		$data['settings'][] = array(
			'key'		=> 'table',
			'type'		=> 'table_start',
			'columns'	=> array('action', 'active', 'from_url', 'to_url', 'response_code', 'date_start', 'date_end', 'times_used'),
			'attributes'=> array('data-autoincrement' => $data['table_autoincrement']),
			'buttons'	=> 'add_row',
		);
		
		foreach ($data['table_ids'] as $id) {
			$prefix = 'table_' . $id . '_';
			$data['settings'][] = array(
				'type'		=> 'row_start',
			);
			$data['settings'][] = array(
				'type'		=> 'html',
				'content'	=> '<a class="btn btn-danger" onclick="if (!confirm(\'' . $data['standard_confirm'] . '\')) return; element = $(this); $.get(\'index.php?route=' . $this->type . '/' . $this->name . '/deleteRow&id=' . $id . '&token=' . $data['token'] . '\', function(data) { if (data) { alert(data); } else { element.parent().parent().parent().remove(); }});" data-help="' . $data['button_delete'] . '"><i class="fa fa-trash-o fa-lg fa-fw"></i></a>',
			);
			$data['settings'][] = array(
				'type'		=> 'column',
			);
			$data['settings'][] = array(
				'key'		=> $prefix . 'active',
				'type'		=> 'checkboxes',
				'options'	=> array(1 => ''),
				'default'	=> 1,
			);
			$data['settings'][] = array(
				'type'		=> 'column',
			);
			$data['settings'][] = array(
				'key'		=> $prefix . 'from_url',
				'type'		=> 'textarea',
				'attributes'=> array('style' => 'width: 200px !important'),
			);
			$data['settings'][] = array(
				'type'		=> 'column',
			);
			$data['settings'][] = array(
				'key'		=> $prefix . 'to_url',
				'type'		=> 'textarea',
				'attributes'=> array('style' => 'width: 200px !important'),
			);
			$data['settings'][] = array(
				'type'		=> 'column',
			);
			$data['settings'][] = array(
				'key'		=> $prefix . 'response_code',
				'type'		=> 'select',
				'options'	=> array(
					'301'	=> $data['text_moved_permanently'],
					'302'	=> $data['text_found'],
					'307'	=> $data['text_temporary_redirect'],
				),
			);
			$data['settings'][] = array(
				'type'		=> 'column',
			);
			$data['settings'][] = array(
				'key'		=> $prefix . 'date_start',
				'type'		=> 'date',
				'attributes'=> array('placeholder' => $data['placeholder_date_format'], 'style' => 'width: 140px !important'),
			);
			$data['settings'][] = array(
				'type'		=> 'column',
			);
			$data['settings'][] = array(
				'key'		=> $prefix . 'date_end',
				'type'		=> 'date',
				'attributes'=> array('placeholder' => $data['placeholder_date_format'], 'style' => 'width: 140px !important'),
			);
			$data['settings'][] = array(
				'type'		=> 'column',
			);
			$data['settings'][] = array(
				'key'		=> $prefix . 'times_used',
				'type'		=> 'text',
				'attributes'=> array('style' => 'width: 50px !important'),
			);
			$data['settings'][] = array(
				'type'		=> 'row_end',
			);
		}
		
		$data['settings'][] = array(
			'type'		=> 'table_end',
		);
		$data['settings'][] = array(
			'type'		=> 'html',
			'content'	=> '<div class="pagination" style="border: none;">' . $pagination->render() . '</div>',
		);
		
		//------------------------------------------------------------------------------
		// end settings
		//------------------------------------------------------------------------------
		
		$this->document->setTitle($data['heading_title']);
		
		if (version_compare(VERSION, '2.0', '<')) {
			$this->data = $data;
			$this->template = $this->type . '/' . $this->name . '.tpl';
			$this->children = array(
				'common/header',	
				'common/footer',
			);
			$this->response->setOutput($this->render());
		} else {
			$data['header'] = $this->load->controller('common/header');
			$data['column_left'] = $this->load->controller('common/column_left');
			$data['footer'] = $this->load->controller('common/footer');
			$this->response->setOutput($this->load->view($this->type . '/' . $this->name . '.tpl', $data));
		}
	}
	
	//==============================================================================
	// Setting functions (custom)
	//==============================================================================
	private $encryption_key = '';
	
	private function loadSettings(&$data) {
		$backup_type = (empty($data)) ? 'manual' : 'auto';
		if ($backup_type == 'manual' && !$this->user->hasPermission('modify', $this->type . '/' . $this->name)) {
			return;
		}
		
		// Load saved settings
		$data['saved'] = array();
		$settings_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "setting WHERE `" . (version_compare(VERSION, '2.0.1', '<') ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "' ORDER BY `key` ASC");
		
		foreach ($settings_query->rows as $setting) {
			$key = str_replace($this->name . '_', '', $setting['key']);
			$value = $setting['value'];
			if ($setting['serialized']) {
				$value = (version_compare(VERSION, '2.1', '<')) ? unserialize($setting['value']) : json_decode($setting['value'], true);
			}
			$data['saved'][$key] = $value;
		}
		
		$where = '';
		foreach ($data['saved'] as $key => $value) {
			$parts = explode('_', $key, 2);
			if ($parts[0] == 'filter') {
				$where .= (empty($where) ? " WHERE " : " AND ") . $parts[1] . " LIKE '%" . $this->db->escape($value) . "%'";
			}
		}
		$sorting = (isset($data['saved']['sorting'])) ? " ORDER BY " . $data['saved']['sorting'] : '';
		$limit = (isset($data['page']) && isset($data['limit'])) ? " LIMIT " . (($data['page']-1) * $data['limit']) . "," . $data['limit'] : '';
		
		$table_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . $this->name . "`" . $where . $sorting . $limit);
		
		$data['table_autoincrement'] = $this->db->query("SELECT MAX(" . $this->name . "_id) AS autoincrement FROM `" . DB_PREFIX . $this->name . "`")->row['autoincrement'] + 1;
		$data['table_total'] = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . $this->name . "`" . $where)->row['total'];
		$data['table_ids'] = array();
		
		foreach ($table_query->rows as $row) {
			$data['table_ids'][] = $row[$this->name . '_id'];
			foreach ($row as $key => $value) {
				$data['saved']['table_' . $row[$this->name . '_id'] . '_' . $key] = $value;
			}
		}
		
		if (empty($data['table_ids'])) {
			foreach ($this->db->query("DESCRIBE `" . DB_PREFIX . $this->name . "`")->rows as $column) {
				$data['saved']['table_1_' . $column['Field']] = '';
			}
			$data['table_ids'][] = 1;
			$data['table_autoincrement'] = 2;
		}
		
		$data = array_merge($data, $this->load->language($this->type . '/' . $this->name));
		asort($data['saved']);
		
		// Create settings auto-backup file
		$table_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . $this->name . "`");
		
		$manual_filepath = DIR_LOGS . $this->name . '_backup' . $this->encryption_key . '.txt';
		$auto_filepath = DIR_LOGS . $this->name . '_autobackup' . $this->encryption_key . '.txt';
		$filepath = ($backup_type == 'auto') ? $auto_filepath : $manual_filepath;
		if (file_exists($filepath)) unlink($filepath);
		
		file_put_contents($filepath, strtoupper(implode(',', array_keys($table_query->row))) . "\n", FILE_APPEND|LOCK_EX);
		
		foreach ($table_query->rows as $row) {
			file_put_contents($filepath, implode(',', array_values(str_replace(',', ';;', $row))) . "\n", FILE_APPEND|LOCK_EX);
		}
		
		$data['autobackup_time'] = date('Y-M-d @ g:i a');
		$data['backup_time'] = (file_exists($manual_filepath)) ? date('Y-M-d @ g:i a', filemtime($manual_filepath)) : '';
		
		if ($backup_type == 'manual') {
			echo $data['autobackup_time'];
		}
	}
	
	public function backupSettings() {
		$data = array();
		$this->loadSettings($data);
	}
	
	public function viewBackup() {
		if (!$this->user->hasPermission('access', $this->type . '/' . $this->name)) {
			echo 'You do not have permission to view this file.';
			return;
		}
		if (!file_exists(DIR_LOGS . $this->name . '_backup' . $this->encryption_key . '.txt')) {
			echo 'Backup file "' . DIR_LOGS . $this->name . '_backup' . $this->encryption_key . '.txt" does not exist';
			return;
		}
		
		$contents = trim(file_get_contents(DIR_LOGS . $this->name . '_backup' . $this->encryption_key . '.txt'));
		$lines = explode("\n", $contents);
		
		$html = '<table border="1" style="font-family: monospace" cellspacing="0" cellpadding="5">';
		foreach ($lines as $line) {
			$html .= '<tr><td>' . implode('</td><td>', explode(",", $line)) . '</td></tr>';
		}
		echo $html;
	}
	
	public function downloadBackup() {
		if (!$this->user->hasPermission('access', $this->type . '/' . $this->name) || !file_exists(DIR_LOGS . $this->name . '_backup' . $this->encryption_key . '.txt')) {
			return;
		}
		
		header('Pragma: public');
		header('Expires: 0');
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename=' . $this->name . '_backup.' . date('Y-n-d') . '.txt');
		header('Content-Transfer-Encoding: binary');
		
		echo file_get_contents(DIR_LOGS . $this->name . '_backup' . $this->encryption_key . '.txt');
	}
	
	public function restoreSettings() {
		$data = $this->load->language($this->type . '/' . $this->name);
		
		if (!$this->user->hasPermission('modify', $this->type . '/' . $this->name)) {
			$this->session->data['error'] = $data['standard_error'];
			$this->response->redirect(str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $this->url->link($this->type . '/' . $this->name, 'token=' . $this->session->data['token'], 'SSL')));
		}
		
		if ($this->request->post['from'] == 'auto') {
			$filepath = DIR_LOGS . $this->name . '_autobackup' . $this->encryption_key . '.txt';
		} elseif ($this->request->post['from'] == 'manual') {
			$filepath = DIR_LOGS . $this->name . '_backup' . $this->encryption_key . '.txt';
		} elseif ($this->request->post['from'] == 'file') {
			$filepath = $this->request->files['backup_file']['tmp_name'];
			if (empty($filepath)) {
				$this->session->data['error'] = 'File is empty or not present';
				$this->response->redirect(str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $this->url->link($this->type . '/' . $this->name, 'token=' . $this->session->data['token'], 'SSL')));
			}
		}
		
		$this->db->query("TRUNCATE TABLE `" . DB_PREFIX . $this->name . "`");
		$contents = str_replace("\r\n", "\n", trim(file_get_contents($filepath)));
		
		foreach (explode("\n", str_replace('"', '', $contents)) as $num => $row) {
			if (empty($row)) continue;
			
			if (!$num) {
				$columns = explode(',', strtolower($row));
				continue;
			}
			
			$sql = array();
			foreach (explode(',', $row) as $index => $col) {
				if (!$col) continue;
				$sql[] = $columns[$index] . " = '" . $this->db->escape(str_replace(';;', ',', $col)) . "'";
			}
			
			$this->db->query("INSERT INTO `" . DB_PREFIX . $this->name . "` SET " . implode(', ', $sql));
		}
		
		$this->session->data['success'] = $data['text_settings_restored'];
		$this->response->redirect(str_replace(array('&amp;', "\n", "\r"), array('&', '', ''), $this->url->link($this->type . '/' . $this->name, 'token=' . $this->session->data['token'], 'SSL')));
	}
	
	public function saveSettings() {
		if (!$this->user->hasPermission('modify', $this->type . '/' . $this->name)) {
			echo 'PermissionError';
			return;
		}
		
		foreach ($this->request->post as $key => $value) {
			if (strpos($key, 'table_') === 0) {
				$parts = explode('_', $key, 3);
				$sql = $this->db->escape($parts[2]) . " = '" . $this->db->escape(stripslashes(is_array($value) ? implode(';', $value) : $value)) . "'";
				$this->db->query("INSERT INTO `" . DB_PREFIX . $this->name . "` SET " . $this->name . "_id = " . (int)$parts[1] . ", " . $sql . " ON DUPLICATE KEY UPDATE " . $sql);
			} else {
				$this->db->query("DELETE FROM " . DB_PREFIX . "setting WHERE `" . (version_compare(VERSION, '2.0.1', '<') ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "'AND `key` = '" . $this->db->escape($this->name . '_' . $key) . "'");
				$this->db->query("
					INSERT INTO " . DB_PREFIX . "setting SET
					`store_id` = 0,
					`" . (version_compare(VERSION, '2.0.1', '<') ? 'group' : 'code') . "` = '" . $this->db->escape($this->name) . "',
					`key` = '" . $this->db->escape($this->name . '_' . $key) . "',
					`value` = '" . $this->db->escape(stripslashes(is_array($value) ? implode(';', $value) : $value)) . "'
					" . (version_compare(VERSION, '1.5.1', '>=') ? ", `serialized` = 0" : "") . "
				");
			}
		}
	}
	
	public function deleteRow() {
		$this->db->query("DELETE FROM `" . DB_PREFIX . $this->name . "` WHERE " . $this->name . "_id = " . (int)$this->request->get['id']);
	}
}
?>