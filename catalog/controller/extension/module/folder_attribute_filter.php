<?php
class ControllerExtensionModuleFolderAttributeFilter extends Controller {
	public function index() {
		
		/*
		if(isset( $this->request->get['path']) AND strpos($this->request->get['path'], '_') === false){
			$category_id = $this->request->get['path'];
			if($category_id == 143 OR $category_id == 141 OR $category_id == 144){
				return '';
			}
		}
		*/
        $data = array();
        $data['filter_manufactures'] = array();
        $data['filter_attributes'] = array();
        $data['filter_attribute_groups'] = array();
        $data['ffilter'] = array();
		$data['fprices'] = array();
		$data['ofilter'] = array();
		$data['ffilter_manufacturer'] = array();
		$data['filter_options'] = array();
        
		if(isset($this->request->get['path'])){
			$data['action'] = str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $this->request->get['path']));
		}elseif(isset($this->request->get['manufacturer_id'])){
			$data['action'] = str_replace('&amp;', '&', $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id']));
		}
      
	  //echo "<pre>";print_r(var_dump($this->request->get));echo "</pre>";
	  //die();
	  
        if(isset($this->session->data['prices'])){
            $data['prices'] = $this->session->data['prices'];
			
			$data['prices']['min_price'] = (int)$data['prices']['min_price'];
			$data['prices']['max_price'] = (int)$data['prices']['max_price'];
			
		}
        if(isset($this->session->data['filter_manufactures']))
            $data['filter_manufactures'] = $this->session->data['filter_manufactures'];
            
        if(isset($this->session->data['filter_attributes']))
            $data['filter_attributes'] = $this->session->data['filter_attributes'];
           
		if(isset($this->session->data['filter_options']))
            $data['filter_options'] = $this->session->data['filter_options'];
    	    
        if(isset($this->session->data['filter_attribute_groups']))
            $data['filter_attribute_groups'] = $this->session->data['filter_attribute_groups'];
		
        if(isset($this->request->get['min_price']) AND isset($this->request->get['max_price'])){
            $data['fprices']['min_price'] = (int)$this->request->get['min_price'];
            $data['fprices']['max_price'] = (int)$this->request->get['max_price'];
        }else{
			$data['fprices'] = $data['prices'];
		}
	   
		if(isset($this->request->get['ofilter']))
            $data['ofilter'] = $this->request->get['ofilter'];
	
        if(isset($this->request->get['ffilter']))
            $data['ffilter'] = $this->request->get['ffilter'];
		
		if(isset($this->request->get['manufacturer_id']))
            $data['ffilter_manufacturer'] = $this->request->get['manufacturer_id'];
		
        
        $this->load->language('extension/module/folder_attribute_filter');
        
		$find = array(
					  'амбиент',
					  'брикс',
					  'вестерн',
					  'драконий зуб',
					  'континент',
					  'плитка',
					  'полукруг',
					  'прямоугольник / щепа',
					  'ромб',
					  'шестигранник',
					  );
		
		$replace = array(
						'<img title="амбиент" alt="амбиент" src="/image/filter/амбиент.png">',
						'<img title="брикс" alt="брикс" src="/image/filter/брикс.png">',
						'<img title="вестерн" alt="вестерн" src="/image/filter/вестерн.png">',
						'<img title="драконий зуб" alt="драконий зуб" src="/image/filter/драконийзуб.png">',
						'<img title="континент" alt="континент" src="/image/filter/континент.png">',
						'<img title="плитка" alt="плитка" src="/image/filter/плитка.png">',
						'<img title="полукруг" alt="полукруг" src="/image/filter/полукруг.png">',
						'<img title="прямоугольник щепа" alt="прямоугольник щепа" src="/image/filter/прямоугольникщепа.png">',
						'<img title="ромб" alt="ромб" src="/image/filter/ромб.png">',
						'<img title="шестигранник" alt="шестигранник" src="/image/filter/шестигранник.png">',
						 );
		
		if(isset($data['filter_attributes'][16])){
			foreach($data['filter_attributes'][16] as $index => $row){
				
				$data['filter_attributes'][16][$index] = str_replace($find, $replace, $row);
				
			}
		}
	
		
		if (count($data['filter_attributes']) > 0 OR count($data['filter_manufactures']) > 0) {
		
			$data['heading_title'] = $this->language->get('heading_title');

			$data['button_filter'] = $this->language->get('button_filter');
			$data['manufacture_title'] = $this->language->get('manufacture_title');
		
			return $this->load->view('extension/module/folder_attribute_filter', $data);
			
		}
        
        return '';
	}
}
