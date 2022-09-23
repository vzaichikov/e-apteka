<?php
class ModelExtensionModuleIMCallMeAskMe extends Model {

	/////////////////////////////////////////
	// Вспомогательные функции
	/////////////////////////////////////////

	// Есть ли столбец в таблице
	public function isHaveTableColumn($table_name, $column_name)
	{
		$result = $this->db->query("SHOW COLUMNS FROM `" . $table_name ."` LIKE '" . $column_name . "'");
		if ($result->num_rows) 
		{
			return true;
		} 
		return false;
	}
	
	/////////////////////////////////////////
	// Установка
	/////////////////////////////////////////
  
	public function install() 
	{
		// Создаем таблицу
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imcallmeaskme_lang_set` (
			  `language_id` int(11) NOT NULL,
			  `params` text NOT NULL,
			  PRIMARY KEY (`language_id`)
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);

		// Создаем таблицу
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "imcallmeaskme_stat` (
			  `stat_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
			  `language_id` int(11) NOT NULL,
			  `date_create` datetime not null,
			  `date_modify` datetime not null,
			  `ip` varchar(50) not null,
			  `comment` text not null,
			  `status` int not null,
			  `url` text not null,
			  `user_name` varchar(255) not null,
			  `email` varchar(255) not null,
			  `phone` varchar(255) not null,
			  `text` text not null,
			  `params` text NOT NULL,
			  `email_message` text not null
			) ENGINE=MyISAM DEFAULT CHARSET=utf8;"
		);

		// Проверяем есть ли колонки под статистику
		if (!$this->isHaveTableColumn(DB_PREFIX . 'imcallmeaskme_stat', 'utm_source'))
		{
			$columnArray = array('utm_term', 'utm_content', 'utm_campaign', 'utm_medium', 'utm_source');
			
			foreach($columnArray as $columnItem)
			{
				$this->db->query(
					'alter table `' . DB_PREFIX . 'imcallmeaskme_stat' . '` '
						. ' add column `' . $columnItem . '` '
							. ' varchar(255) not null default \'\' '
						. ' after `email_message` '
				);
			}
		}

	}

	/////////////////////////////////////////
	// Деинсталляция
	/////////////////////////////////////////

	public function uninstall() 
	{
		// Пока ничего не нужно удалять
	}

	/////////////////////////////////////////
	// Функции с настройками
	/////////////////////////////////////////

	// Дефолтные параметры
	public function getDefaultSet() 
	{
		return array(
			'admin_email' => $this->config->get('config_email'),
			'header' => 'Обратный звонок',
			'header_after' => '',
			'header_after_inc' => 1,
			'name' => 'Введите имя',
			'name_ph' => 'Введите имя',
			'name_req' => 1,
			'name_inc' => 1,
			'name_after' => '',
			'name_after_inc' => 1,
			'email' => 'Введите адрес почты',
			'email_ph' => 'Введите адрес почты',
			'email_req' => 1,
			'email_inc' => 1,
			'email_after' => '',
			'email_after_inc' => 1,
			'tel' => 'Введите телефон',
			'tel_ph' => 'Введите телефон',
			'tel_req' => 1,
			'tel_inc' => 1,
			'tel_after' => '',
			'tel_after_inc' => 1,
			'text' => 'Примечание',
			'text_ph' => 'Примечание',
			'text_req' => 0,
			'text_inc' => 1,
			'text_after' => '',
			'text_after_inc' => 1,
			'btn_ok' => 'Отправить',
			'btn_cancel' => 'Отмена',
			'complete_send' => 'Ваша заявка была удачно отправлена!'
		);	
	}

	// Получения настроек для языков
	public function getSettings()
	{
		// Настройки для языков
		$settings = array();

		$config = $this->config;


		// Настройки по умолчанию
		$settings['default'] = $this->getDefaultSet();
		
		// Подгружаем шабюлон
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "imcallmeaskme_lang_set ");
		
		// Вытаскиваем для всех языков настройки
		foreach ($query->rows as $result) 
		{
			if (!empty($result['params']))
			{
				$params = json_decode($result['params'], true);
				
				if (empty($params)) 
				{
					continue;
				}
				
				foreach($params as $key=>$value)
				{
					$params[$key] = html_entity_decode($value, ENT_QUOTES, 'UTF-8');
				}
				
				if (!empty($params))
				{
					// Сохраняем для языка настройки
					$settings[$result['language_id']]
						= array_merge($this->getDefaultSet(), $params);
				}
			}
			else 
			{
				// Сохраняем для языка настройки
				$settings[$result['language_id']] = $this->getDefaultSet();
			}
		}	
		
		return $settings;	
	}

	// Сохранение настроек для языков
	public function saveSettings($data)
	{
		$saveTemp = array();
		
		// Парсим данные для замены
		foreach ($data['set_langs'] as $language_id => $value) {
			$saveTemp[$language_id] = array();
			$saveTemp[$language_id]['params'] = json_encode($value);
		}
		
		// Сохраняем настройки
		foreach($saveTemp as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "imcallmeaskme_lang_set "
					. "(language_id, params) "
					. " VALUES (" . $language_id . ", '" 
							. $this->db->escape($value['params']) . "' "
					.") " 
				. "ON DUPLICATE KEY UPDATE " 
					. " params='" . $this->db->escape($value['params']) . "' "
			);
		}
	}

	// Получение списка
	public function getStat($settings)
	{
		$wherePart = '';
		
		// Стартовая дата
		if ($wherePart == '' && !empty($settings['filter_date_start'])) {
			$date = date_create_from_format('d.m.Y', $settings['filter_date_start']);
			$wherePart .= " DATE(s.date_create) >= '" . $date->format('Y-m-d') . "' ";
		}
		else if (!empty($settings['filter_date_start'])) {
			$date = date_create_from_format('d.m.Y', $settings['filter_date_start']);
			$wherePart .= " and DATE(s.date_create) >= '" . $date->format('Y-m-d') . "' ";
		}

		// Конечная дата
		if ($wherePart == '' && !empty($settings['filter_date_end'])) {
			$date = date_create_from_format('d.m.Y', $settings['filter_date_end']);
			$wherePart .= " DATE(s.date_create) <= '" . $date->format('Y-m-d') . "' ";
		}
		else if (!empty($settings['filter_date_end'])) {
			$date = date_create_from_format('d.m.Y', $settings['filter_date_end']);
			$wherePart .= " and DATE(s.date_create) <= '" . $date->format('Y-m-d') . "' ";
		}
	
		// Фильтр по категории
		$wherePart .= $this->getWhereFilter($settings, 'status', ' s.status ', $wherePart);

		// Сам запрос
		$query = 
			' select s.*, '
				. ' l.name as lang_name, '
				. ' l.image as lang_image, '
				. ' l.code as lang_code '
			. ' from '
				. ' ' . DB_PREFIX . 'imcallmeaskme_stat s '
				. ' left join ' . DB_PREFIX . 'language l '
					. ' on s.language_id = l.language_id '
			. ($wherePart == '' ? '' : ' where ' . $wherePart)
			. $this->getSortBy($settings, ' order by s.stat_id desc ')
		;
		
		//$query .= ' LIMIT 30';
		
		$queryResult = $this->db->query($query);
		
		//die('+++'.count($queryResult->rows));
		
		return $queryResult->rows;
	}
	
	// Установка статуса
	public function setStatus($settings)
	{
		$date = date_create()->format('Y-m-d H:i:s');
		
		foreach($settings['items'] as $key => $item)
		{
			$query = 'update ' . DB_PREFIX . 'imcallmeaskme_stat '
				. ' set date_modify = \'' . $date . '\', '
					. ' status = ' . $item['status'] . ' '
				. ' where stat_id = ' . $item['stat_id']
			; 
			
			$this->db->query($query);
		}
	}
	
	// Сохранение статистики
	public function saveStat($settings)
	{
		$date = date_create()->format('Y-m-d H:i:s');
		
		foreach($settings['items'] as $key => $item)
		{
			$query = 'update ' . DB_PREFIX . 'imcallmeaskme_stat '
				. ' set date_modify = \'' . $date . '\', '
					. ' comment = \'' . $this->db->escape($item['comment']) . '\' '
				. ' where stat_id = ' . $item['stat_id']
			; 
			
			$this->db->query($query);
		}
	}
	
	// Удаление статистики
	public function deleteStat($settings)
	{
		$wherePart = '';
		
		// Фильтр по категории
		$wherePart .= $this->getWhereFilter($settings, 'items', ' stat_id ', $wherePart);
		
		if ($wherePart != '')
		{
			$query = 'delete from ' . DB_PREFIX . 'imcallmeaskme_stat '
				. ' where ' . $wherePart
			;
				
			$this->db->query($query);
		}
	}
	
	/////////////////////////////////
	// Вспомогательные функции
	/////////////////////////////////

	protected function getWhereFilter($settings, $list_name, $clause, $wherePart)
	{
		$result = '';
		
		if (!isset($settings[$list_name]))
			return $result;
		
		// Если есть , что фильтровать
		if (count($settings[$list_name]) > 0 && (!empty($settings[$list_name][0]) || $settings[$list_name][0] == '0') 
				&& (('' . $settings[$list_name][0] != '-1') || count($settings[$list_name]) > 1)) {
			$result .= (empty($wherePart) ? '' : ' and ');
			
			if (count($settings[$list_name]) == 1) {
				$result .= $clause . ' = ' . $settings[$list_name][0];
			}
			else {
				$result .= $clause . ' in (' . join(', ', $settings[$list_name]) . ') ';
			}
		}
	
		return $result;
	}

	protected function getSortBy($settings, $default = ' ')
	{
		$result = '';
		
		if (count($settings['sort']) > 0 && !empty($settings['sort'][0]) 
				&& (('' . $settings['sort'][0] != '-1') || count($settings['sort']) > 1)) {
			if (count($settings['sort']) > 1) {
				$result .= ' order by ' . join(', ', $settings['sort']);
			}			
			else {
				$result .= ' order by ' . $settings['sort'][0];
			}
		}
			
		return (empty($result) ? $default : $result);
	}
	
	/////////////////////////////////
	// Получение списков
	/////////////////////////////////
	// Получение списка статусов
	public function getStatusList()
	{
		$resultList = array();

		$resultList[] = array('id' => '-1', 'name' => 'Все статусы');
		$resultList[] = array('id' => '0', 'name' => 'В ожидании');
		$resultList[] = array('id' => '1', 'name' => 'Запрос выполнен');
		
		return $resultList;
	}

	// Получение списка сортировки
	public function getSortList()
	{
		$resultList = array();

		$resultList[] = array('id' => '-1', 'name' => 'По умолчанию');
		$resultList[] = array('id' => 's.stat_id asc', 'name' => 'Номер (Возрастание)');
		$resultList[] = array('id' => 's.stat_id desc', 'name' => 'Номер (Убывание)');
		$resultList[] = array('id' => 'l.name asc', 'name' => 'Язык (Возрастание)');
		$resultList[] = array('id' => 'l.name desc', 'name' => 'Язык (Убывание)');
		$resultList[] = array('id' => 's.user_name asc', 'name' => 'Имя (Возрастание)');
		$resultList[] = array('id' => 's.user_name desc', 'name' => 'Имя (Убывание)');
		$resultList[] = array('id' => 's.email asc', 'name' => 'Email (Возрастание)');
		$resultList[] = array('id' => 's.email desc', 'name' => 'Email (Убывание)');
		$resultList[] = array('id' => 's.phone asc', 'name' => 'Телефон (Возрастание)');
		$resultList[] = array('id' => 's.phone desc', 'name' => 'Телефон (Убывание)');
		$resultList[] = array('id' => 's.status asc', 'name' => 'Статус (Возрастание)');
		$resultList[] = array('id' => 's.status desc', 'name' => 'Статус (Убывание)');
		$resultList[] = array('id' => 's.date_create asc', 'name' => 'Создано (Возрастание)');
		$resultList[] = array('id' => 's.date_create desc', 'name' => 'Создано (Убывание)');
		$resultList[] = array('id' => 's.date_modify asc', 'name' => 'Изменено (Возрастание)');
		$resultList[] = array('id' => 's.date_modify desc', 'name' => 'Изменено (Убывание)');
		$resultList[] = array('id' => 's.ip asc', 'name' => 'IP (Возрастание)');
		$resultList[] = array('id' => 's.ip desc', 'name' => 'IP (Убывание)');
		
		return $resultList;
	}

}