<?php
	class ControllerExtensionModuleMetaSeoAnyPage extends Controller {
		public function index(&$view, &$data, &$output) {
			if ($this->config->get('metaseo_anypage_status')) {
				$routes = $this->config->get('metaseo_anypage_routes');
				if (is_array($routes)) {
					foreach ($routes as $route) {
						$shop_route = isset($this->request->get['route'])?$this->request->get['route']:'common/home';
						if ($route['route'] == $shop_route) {
							$language_id = $this->config->get('config_language_id');
							if (isset($route['title'][$language_id]) && $route['title'][$language_id]) {
								$this->document->setTitle($this->replace($route['title'][$language_id]));
							}
							if (isset($route['meta_description'][$language_id]) && $route['meta_description'][$language_id]) {
								$this->document->setDescription($this->replace($route['meta_description'][$language_id]));
							}
							break;
						}
					}
				}
			}
		}
		private function replace($haystack) {
			$pattern = '/\[(.+?)\]/';
			preg_match_all($pattern, $haystack, $matches);						
			if ($matches) {
				$array_from = array();
				$array_to = array();
				foreach ($matches[0] as $match) {
					$array_from[] = $match;
					if ($match == '[store_name]') {
						$array_to[] = $this->config->get('config_name');
						} elseif ($match == '[meta_title]') {
						$array_to[] = $this->document->getTitle();
						} elseif ($match == '[meta_description]') {
						$array_to[] = $this->document->getDescription();
						} elseif (preg_match('/^\[page/',$match)) {
						$page_text = explode('=',rtrim($match,']'));
						if (isset($this->request->get['page']) && $this->request->get['page']>1){
							if (!empty($page_text[1])) {
								$array_to[] = str_replace('~page~',$this->request->get['page'],$page_text[1]);
								} else {
								$array_to[] = '';
							}
							} else {
							$array_to[] = '';
						}
						} else {
						$array_to[] = '';
					}
				}
				$haystack = str_replace($array_from,$array_to,$haystack);
			}
			return $haystack;
		}
	}
