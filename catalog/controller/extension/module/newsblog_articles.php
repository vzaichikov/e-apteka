<?php
class ControllerExtensionModuleNewsBlogArticles extends Controller {

	public function index($setting) {

		$this->load->language('module/newsblog_articles');

		$this->load->model('newsblog/article');

		if (isset($setting['module_description'][$this->config->get('config_language_id')])) {
			$data['heading_title'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['title'], ENT_QUOTES, 'UTF-8');
			$data['html'] = html_entity_decode($setting['module_description'][$this->config->get('config_language_id')]['description'], ENT_QUOTES, 'UTF-8');
		} else {
			$data['heading_title'] = false;
			$data['html'] = false;
		}

		$data['text_more'] = $this->language->get('text_more');

		$data['text_date_added'] = $this->language->get('text_date_added');

		$data['articles'] = array();

		$show_categories= $setting['show_categories'];
		$sort			= $setting['sort_by'];
		$order			= $setting['sort_direction'];
		$date_format	= $setting['date_format'];

		$filter_data = array(
					'filter_categories'  => $show_categories,
					'sort'               => $sort,
					'order'              => $order,
					'start'              => 0,
					'limit'              => $setting['limit']
		);

		$data['link_to_category']=false;
		if (count($show_categories)==1) $data['link_to_category']=$this->url->link('newsblog/category', 'newsblog_path=' . $show_categories[0]);

		$results = $this->model_newsblog_article->getArticles($filter_data);

		$this->load->model('tool/image');

		foreach ($results as $result) {
			if ($result['image']) {
				$original	= HTTP_SERVER.'image/'.$result['image'];
 				$thumb 		= $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height']);
 			} else {
 				$original 	= false;
 				$thumb 		= false;
 			}

 			$mainCategoryId =  $this->model_newsblog_article->getArticleMainCategoryId($result['article_id']);

			$data['articles'][] = array(
				'article_id'  		=> $result['article_id'],
				'original' 			=> $original,
				'thumb' 			=> $thumb,
				'name'        		=> $result['name'],
				'preview'  			=> utf8_substr(strip_tags(html_entity_decode($result['preview'], ENT_QUOTES, 'UTF-8')), 0, $setting['desc_limit']),
				'attributes'  		=> $result['attributes'],
				'href'         		=> $this->url->link('newsblog/article', 'newsblog_path=' . $mainCategoryId . '&newsblog_article_id=' . $result['article_id']),
				'date'   			=> ($date_format ? date($date_format, strtotime($result['date_available'])) : false),
				'date_modified'   	=> ($date_format ? date($date_format, strtotime($result['date_modified'])) : false),
				'viewed' 			=> sprintf($this->language->get('text_viewed'), $result['viewed']),
			);
		}

		$template='newsblog_articles.tpl';
		if ($setting['template']) $template=$setting['template'];

		return $this->load->view('extension/module/'.$template, $data);

	}
}
