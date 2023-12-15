<?php
class ControllerCommonHome extends Controller {
	public function index() {
		$code = $this->session->data['language'];

		if ($this->config->get('tltmultilang_meta_title_' . $code)){
			$this->document->setTitle($this->config->get('tltmultilang_meta_title_' . $code));
		} else {
			$this->document->setTitle($this->config->get('config_meta_title'));
		}
		
		if ($this->config->get('tltmultilang_meta_description_' . $code)){
			$this->document->setDescription($this->config->get('tltmultilang_meta_description_' . $code));
		} else {
			$this->document->setDescription($this->config->get('config_meta_description'));
		}

		if ($this->config->get('tltmultilang_meta_keyword_' . $code)){
			$this->document->setKeywords($this->config->get('tltmultilang_meta_keyword_' . $code));
		} else {
			$this->document->setKeywords($this->config->get('config_meta_keyword'));

			if ($this->config->get('hb_snippets_og_enable') == '1'){
				$this->document->setOpengraph('og:title', $this->config->get('config_meta_title'));
				$this->document->setOpengraph('og:type', 'website');
				$this->document->setOpengraph('og:site_name', $this->config->get('config_name'));
				$this->document->setOpengraph('og:image', HTTP_SERVER . 'image/' . $this->config->get('config_logo'));
				$this->document->setOpengraph('og:url', $this->config->get('config_url'));
				$this->document->setOpengraph('og:description', $this->config->get('config_meta_description'));
			}
			
		}
		
		if (property_exists('Document', 'tlt_metatags')) {
			$image = $this->config->get('tltmultilang_image');
			
			if (is_file(DIR_IMAGE . $image)) {
				if ($this->request->server['HTTPS']) {
					$image_tw = $image_fb = $this->config->get('config_ssl') . 'image/' . $image;
				} else {
					$image_tw = $image_fb = $this->config->get('config_url') . 'image/' . $image;
				} 
			} else {
				$image_tw = $image_fb = '';
			}
			
			if ($this->config->get('tltmultilang_twitter_status')) {
				if ($this->config->get('tltmultilang_twitter_card')) {
					$this->document->addTLTMetaTag('twitter:card', 'summary_large_image');
				} else {
					$this->document->addTLTMetaTag('twitter:card', 'summary');
				}
				
				$this->document->addTLTMetaTag('twitter:site', $this->config->get('tltmultilang_twitter_name'));	
				$this->document->addTLTMetaTag('twitter:title', $meta_title);	
				$this->document->addTLTMetaTag('twitter:text:description', $meta_description);	
				
				if ($image_tw) {
					$this->document->addTLTMetaTag('twitter:image', $image_tw);
					$this->document->addTLTMetaTag('twitter:image:alt', $meta_title);
				}
			}
			
			if ($this->config->get('tltmultilang_facebook_status')) {
				$this->document->addTLTMetaTag('og:type', 'website', 'property');
				$this->document->addTLTMetaTag('og:site_name', $this->config->get('tltmultilang_facebook_name'), 'property');
				
				if ($this->request->server['HTTPS']) {
					$this->document->addTLTMetaTag('og:url', $this->config->get('config_ssl'), 'property');
				} else {
					$this->document->addTLTMetaTag('og:url', $this->config->get('config_url'), 'property');
				} 
				
				$this->document->addTLTMetaTag('og:title', $meta_title, 'property');
				$this->document->addTLTMetaTag('og:description', $meta_description, 'property');
				
				if ($this->config->get('tltmultilang_facebook_appid')) {
					$this->document->addTLTMetaTag('fb:app_id', $this->config->get('tltmultilang_facebook_appid'), 'property');
				}
				
				if ($image_fb) {
					list($image_width, $image_height) = getimagesize(DIR_IMAGE . $image);
					$this->document->addTLTMetaTag('og:image', $image_fb, 'property');
					$this->document->addTLTMetaTag('og:image:width', $image_width, 'property');
					$this->document->addTLTMetaTag('og:image:height', $image_height, 'property');
				}
			}
		}				

		$this->document->addLink($this->url->link('common/home'), 'canonical');
		
		
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['column_right'] = $this->load->controller('common/column_right');
		$data['content_top'] = $this->load->controller('common/content_top');
		$data['content_bottom'] = $this->load->controller('common/content_bottom');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('common/home', $data));
	}
}
