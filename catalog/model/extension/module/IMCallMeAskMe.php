<?php
class ModelExtensionModuleIMCallMeAskMe extends Model {

	
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
			'complete_send' => 'Ваша заявка удачно отправлена!'
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
	
	// Получение эффективных настроек
	public function getEffSettings($lang_id)
	{
		$settings = $this->getSettings();
		
		if (isset($settings[$lang_id]))
			return $settings[$lang_id];
		return $settings['default'];
	}
	
	public function insertStat($lang_id, $post, $message)
	{
	
	
		$ip = $this->request->server['REMOTE_ADDR'];
		$date = date_create()->format('Y-m-d H:i:s');
		
		$post['name'] = strip_tags($post['name']);
		
		if(!is_string($post['name'])){
		//	return false;
		}
		if(strlen($post['name']) < 3){
		//	return false;
		}
		if(strlen($post['url']) < 3){
			return false;
		}
		
			$query = 'insert into ' . DB_PREFIX . 'imcallmeaskme_stat '
			. '(
			  `language_id`, `date_create`, `date_modify`, `ip`,
			  `comment`, `status`, `url`, 
			  `user_name`, 
			  `email`, 
			  `phone`, 
			  `text`, 
			  `params`, 
			  `utm_source`, `utm_medium`, `utm_campaign`, `utm_content`, `utm_term`,
			  `email_message`
			)'
			. ' values( '
				. $lang_id . ', \'' . $date . '\', \'' . $date . '\', \'' . $ip . '\', \''
				. '\', ' . '0' . ', \'' . urldecode(empty($post['url']) ? '' : $post['url']) . '\', \''
				. $this->db->escape(strip_tags(empty($post['name']) ? '' : $post['name'])) . '\', \'' 
				. $this->db->escape(strip_tags(empty($post['email']) ? '' : $post['email'])) . '\', \''
				. $this->db->escape(strip_tags(empty($post['tel']) ? '' : $post['tel'])) . '\', \''
				. $this->db->escape(strip_tags(empty($post['text']) ? '' : $post['text'])) . '\', \''
				. '\', \'' // params
				. $this->db->escape(strip_tags(empty($post['utm_source']) ? '' : $post['utm_source'])) . '\', \''
				. $this->db->escape(strip_tags(empty($post['utm_medium']) ? '' : $post['utm_medium'])) . '\', \''
				. $this->db->escape(strip_tags(empty($post['utm_campaign']) ? '' : $post['utm_campaign'])) . '\', \''
				. $this->db->escape(strip_tags(empty($post['utm_content']) ? '' : $post['utm_content'])) . '\', \''
				. $this->db->escape(strip_tags(empty($post['utm_term']) ? '' : $post['utm_term'])) . '\', \''
				 . $this->db->escape($message) . '\' '
			. ');'
		;
		
		$this->db->query($query);
	}
}