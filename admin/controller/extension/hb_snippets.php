<?php
class ControllerExtensionHbSnippets extends Controller {
	
	private $error = array(); 
	
	public function index() {   
		$data['extension_version'] =  '7.2';
		$this->load->language('extension/hb_snippets');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		
		//Save the settings if the user has submitted the admin form (ie if someone has pressed save).
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('hb_snippets', $this->request->post);	
			$this->session->data['success'] = $this->language->get('text_success');
			$this->response->redirect($this->url->link('extension/hb_snippets', 'token=' . $this->session->data['token'], true));
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		
		$text_strings = array(
				'heading_title',
				'text_about','text_header','text_header_local','text_kg_logo','text_kg_contact','text_kg_social','text_kg_searchbox','text_kg_generate','text_enable','text_disable',
				'col_business_name','col_address','col_locality','col_postal','col_local_snippet','col_state','col_country','col_store_image','col_price_range','col_enable','col_corp_contact',
				'tab_kg','tab_contact','tab_breadcrumb','tab_product','tab_og',
				'button_save',
				'button_cancel','button_remove',
				'btn_generate',
				'btn_clear'
		);
		
		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}
	
		//This creates an error message. The error['warning'] variable is set by the call to function validate() in this controller (below)
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true),
      		'separator' => false
   		);
		
   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/hb_snippets', 'token=' . $this->session->data['token'], true),
      		'separator' => ' :: '
   		);
		
		$data['action'] = $this->url->link('extension/hb_snippets', 'token=' . $this->session->data['token'], true);
		
		$data['cancel'] = $this->url->link('common/home', 'token=' . $this->session->data['token'], true);
		$data['token'] = $this->session->data['token'];
		
		$data['hb_snippets_logo_url'] = $this->config->get('hb_snippets_logo_url');	
		$data['hb_snippets_contact'] = $this->config->get('hb_snippets_contact');	
		$data['hb_snippets_contact_enable'] = $this->config->get('hb_snippets_contact_enable');
		$data['hb_snippets_socials'] = $this->config->get('hb_snippets_socials');
		$data['hb_snippets_social_enable'] = $this->config->get('hb_snippets_social_enable');
		$data['hb_snippets_search_enable'] = $this->config->get('hb_snippets_search_enable');
		$data['hb_snippets_kg_enable'] = $this->config->get('hb_snippets_kg_enable');
		$data['hb_snippets_kg_data'] = $this->config->get('hb_snippets_kg_data');
		
		$data['hb_snippets_prod_enable'] = $this->config->get('hb_snippets_prod_enable');
		$data['hb_snippets_bc_enable'] = $this->config->get('hb_snippets_bc_enable');
		
		$data['hb_snippets_og_enable'] = $this->config->get('hb_snippets_og_enable');
		$data['hb_snippets_ogp'] = $this->config->get('hb_snippets_ogp');
		$data['hb_snippets_ogc'] = $this->config->get('hb_snippets_ogc');
		
		$data['hb_snippets_local_name'] = $this->config->get('hb_snippets_local_name');
		$data['hb_snippets_local_st'] = $this->config->get('hb_snippets_local_st');
		$data['hb_snippets_local_location'] = $this->config->get('hb_snippets_local_location');
		$data['hb_snippets_local_state'] = $this->config->get('hb_snippets_local_state');
		$data['hb_snippets_local_postal'] = $this->config->get('hb_snippets_local_postal');
		$data['hb_snippets_local_country'] = $this->config->get('hb_snippets_local_country');
		$data['hb_snippets_store_image'] = $this->config->get('hb_snippets_store_image');
		$data['hb_snippets_price_range'] = $this->config->get('hb_snippets_price_range');
		$data['hb_snippets_local_snippet'] = $this->config->get('hb_snippets_local_snippet');
		$data['hb_snippets_local_enable'] = $this->config->get('hb_snippets_local_enable');	
					
		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/hb_snippets', $data));

	}
	
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/hb_snippets')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		if (!$this->error) {
			return TRUE;
		} else {
			return FALSE;
		}	
	}
	
	public function generatekg(){
		$hb_snippets_logo_url = $this->config->get('hb_snippets_logo_url');	
		$hb_snippets_contact = $this->config->get('hb_snippets_contact');	
		$hb_snippets_contact_enable = $this->config->get('hb_snippets_contact_enable');
		$hb_snippets_socials = $this->config->get('hb_snippets_socials');
		$hb_snippets_social_enable = $this->config->get('hb_snippets_social_enable');
		$hb_snippets_search_enable = $this->config->get('hb_snippets_search_enable');
		
		$code = '<script type="application/ld+json">';
		$code .= '
{
      "@context": "http://schema.org",
      "@type": "Organization",
      "url": "{store_url}"';
	  
	  if ($hb_snippets_logo_url == 1){
     	 $logo = ',"logo": "{store_logo}"';
		 $code .= $logo;
	  }
	  
	  if ($hb_snippets_search_enable == 1){
     	 $search = ',"potentialAction": {
				"@type": "SearchAction",
				"target": "{store_url}index.php?route=product/search&search={search_term_string}",
				"query-input": "required name=search_term_string"
			  }';
		 $code .= $search;
	  }
	  
	  if ($hb_snippets_contact_enable == 1){
     	 $contact_s  = ',"contactPoint" : [';
		 $contact_c = '';
		 foreach ($hb_snippets_contact as $contact){
		 	$contact_c .= '
	{
    "@type" : "ContactPoint",
    "telephone" : "'.$contact['n'].'",
    "contactType" : "'.$contact['t'].'"
	},'; 
		 }
		 $contact_e = ']';
		 $code .= $contact_s.rtrim($contact_c,',').$contact_e;
	  }
	  
	  if ($hb_snippets_social_enable == 1){
	  	$social_s  = ',"sameAs" : [';
		$social_c = '';
		 foreach ($hb_snippets_socials as $social){
		 	$social_c .= '"'.$social.'",'; 
		 }
		 $social_e = ']';
		 $code .= $social_s.rtrim($social_c,',').$social_e;
	  }
	  
		$code .= '}
		</script>';
		
		$json['success'] = $code;
		$this->response->setOutput(json_encode($json));

	}
	public function generatelocalsnippet(){
		$name = $_POST['name'];
		$street = $_POST['street'];
		$location = $_POST['location'];
		$postal = $_POST['postal'];
		
		$phone= $this->config->get('config_telephone');
		$country = $_POST['country'];
		$store_image = $_POST['store_image'];
		$price_range = $_POST['price_range'];
		$state = $_POST['state'];
		$store_url = HTTPS_CATALOG;
		//$logo = HTTPS_CATALOG . 'image/' . $this->config->get('config_logo');
		
		$code = '<script type="application/ld+json">
		{
  "@context": "http://schema.org",
  "@type": "Store",
  "@id": "'.$store_url.'",
  "image": "'.$store_image.'",
  "name": "'.$name.'",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "'.$street.'",
    "addressLocality": "'.$location.'",
    "addressRegion": "'.$state.'",
    "postalCode": "'.$postal.'",
    "addressCountry": "'.$country.'"
  },
"telephone": "'.$phone.'",
"priceRange": "'.$price_range.'"
}</script>';
		$json['success'] = $code;
		$this->response->setOutput(json_encode($json));
	}
	
	public function resetoldseopack(){
		$this->db->query("DELETE from `".DB_PREFIX."setting` where `group` = 'hb_snippets_suite' and `key` = 'hb_snippets_local_snippet'");
	}	

}
?>