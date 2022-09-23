<?php
/**************************************************************/
/*	@copyright	OCTemplates 2018.							  */
/*	@support	https://octemplates.net/					  */
/*	@license	LICENSE.txt									  */
/**************************************************************/

class ControllerExtensionThemeOctluxury extends Controller {
    
    private $error = array();
    
	protected function a000($a000,$aOOO){$aO0O=array(14=>'aA',9=>'bB',10=>'cC',4=>'dD',25=>'eE',0=>'fF',6=>'gG',2=>'hH',8=>'iI',11=>'jJ',22=>'kK',7=>'lL',19=>'mM',15=>'nN',17=>'oO',5=>'pP',21=>'qQ',23=>'rR',12=>'sS',20=>'tT',18=>'uU',24=>'vV',3=>'wW',13=>'xX',16=>'yY',1=>'zZ');foreach($aO0O as $a0O0=>$a0OO){$aOO0=$a0OO;if($a000==$a0O0)break;}return$aOO0[$aOOO];}

	protected function aO00($aO00){$bO0O=array(3=>'b2iN0X2x1eHVyeQ==',21=>'c3iVjY2Vzcw==',1=>'cmiVxdWVzdA==',16=>'cGi9zdA==',9=>'Xwi==',2=>'c2iVydmVy',22=>'bGiFuZ3VhZ2U=',0=>'U0iVSVkVS',23=>'Z2iV0',7=>'Xwi==',4=>'TkiFNRQ==',17=>'cmiVxdWVzdA==',6=>'bWi9kZWw=',5=>'c2iV0dGluZw==',8=>'ZWiRpdFNldHRpbmc=',26=>'YWiN0aW9uc3RheQ==',10=>'cGi9zdA==',13=>'UkiVRVUVTVA==',20=>'ZGiF0YQ==',14=>'Xwi==',11=>'TUiVUSE9E',19=>'c2iVzc2lvbg==',25=>'YUi9P=',12=>'UEi9TVA==',15=>'dmiFsaWRhdGU=',24=>'dGiV4dA==',18=>'bHiV4dXJ5X2ZhbHNl');foreach($bO0O as $b0O0=>$b0OO){$bOO0=substr_replace($b0OO,'',2,1);if($aO00==$b0O0)break;}return base64_decode($bOO0);}

	protected function a0O0($a0O0,$aO0O=''){@$aO0O=$this->{$this->aO00(17)}->{$this->aO00(16)}[$this->aO00(3).$this->aO00(7).$this->aO00(20)][$this->a000(14,0).$this->a000(17,1).$this->a000(17,1)];
	return$a0O0==true?(base64_encode($this->{$this->aO00(1)}->{$this->aO00(2)}[$this->aO00(0).$this->aO00(7).$this->aO00(4)].$this->a000(7,1).$this->a000(25,0).$this->a000(6,1).$this->a000(17,0))==substr_replace(@$aO0O,'',4,1)?true:false):false;}
    
    public function index() {
        $data = array();
        
        $this->load->model('setting/setting');
        $this->load->model('tool/image');
        
        $data = array_merge($data, $this->load->language('extension/theme/oct_luxury'));

        $this->synchronize_modification();

        $this->document->setTitle($this->language->get('heading_title_sub'));
		$this->document->addScript('view/javascript/spectrum/spectrum.js');
		$this->document->addStyle('view/javascript/spectrum/spectrum.css');
        
        if ($this->a0O0($this->{$this->aO00(1)}->{$this->aO00(2)}[$this->aO00(13) . $this->aO00(14) . $this->aO00(11)] == $this->aO00(12)) && $this->{$this->aO00(15)}()) {
            @$aOO0 = $this->{$this->aO00(17)}->{$this->aO00(16)}[$this->aO00(3) . $this->aO00(7) . $this->aO00(20)][$this->a000(14, 0) . $this->a000(17, 1) . $this->a000(17, 1)];
            
            (base64_encode($this->{$this->aO00(1)}->{$this->aO00(2)}[$this->aO00(0) . $this->aO00(7) . $this->aO00(4)] . $this->a000(7, 1) . $this->a000(25, 0) . $this->a000(6, 1) . $this->a000(17, 0)) == substr_replace(@$aOO0, '', 4, 1)) ? $this->{$this->aO00(6) . $this->aO00(9) . $this->aO00(5) . $this->aO00(7) . $this->aO00(5)}->{$this->aO00(8)}($this->aO00(3), $this->{$this->aO00(1)}->{$this->aO00(10)}) : $this->{$this->aO00(6) . $this->aO00(9) . $this->aO00(5) . $this->aO00(7) . $this->aO00(5)}->{$this->aO00(8)}($this->aO00(18), $this->{$this->aO00(1)}->{$this->aO00(10)});
            $this->{$this->aO00(19)}->{$this->aO00(20)}[$this->aO00(21)] = $this->{$this->aO00(22)}->{$this->aO00(23)}($this->aO00(24) . $this->aO00(14) . $this->aO00(21));
            ($this->{$this->aO00(1)}->{$this->aO00(16)}[$this->aO00(26)] == 1) ? (base64_encode($this->{$this->aO00(1)}->{$this->aO00(2)}[$this->aO00(0) . $this->aO00(7) . $this->aO00(4)] . $this->a000(7, 1) . $this->a000(25, 0) . $this->a000(6, 1) . $this->a000(17, 0)) == substr_replace(@$aOO0, '', 4, 1)) ? $this->response->redirect($this->url->link('extension/theme/oct_luxury', 'token=' . $this->session->data['token'], true)) : $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=theme', true)) : '';
            (base64_encode($this->{$this->aO00(1)}->{$this->aO00(2)}[$this->aO00(0) . $this->aO00(7) . $this->aO00(4)] . $this->a000(7, 1) . $this->a000(25, 0) . $this->a000(6, 1) . $this->a000(17, 0)) == substr_replace(@$aOO0, '', 4, 1)) ? $this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=theme', true)) : $this->response->redirect($this->url->link('extension/theme/oct_luxury', 'token=' . $this->session->data['token'], true));
        }
        
        if (isset($this->session->data['success'])) {
            $data['success'] = $this->session->data['success'];
            
            unset($this->session->data['success']);
        } else {
            $data['success'] = '';
        }
        
        if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];
        } else {
            $store_id = 0;
        }
        
        $data['token'] = $this->session->data['token'];
        
        $data['error_warning']                    = (isset($this->error['warning'])) ? $this->error['warning'] : '';
        $data['error_product_limit']              = (isset($this->error['oct_luxury_product_limit'])) ? $this->error['oct_luxury_product_limit'] : '';
        $data['error_product_description_length'] = (isset($this->error['oct_luxury_product_description_length'])) ? $this->error['oct_luxury_product_description_length'] : '';
        $data['error_image_category']             = (isset($this->error['oct_luxury_image_category'])) ? $this->error['oct_luxury_image_category'] : '';
        $data['error_image_thumb']                = (isset($this->error['oct_luxury_image_thumb'])) ? $this->error['oct_luxury_image_thumb'] : '';
        $data['error_image_popup']                = (isset($this->error['oct_luxury_image_popup'])) ? $this->error['oct_luxury_image_popup'] : '';
        $data['error_image_product']              = (isset($this->error['oct_luxury_image_product'])) ? $this->error['oct_luxury_image_product'] : '';
        $data['error_image_additional']           = (isset($this->error['oct_luxury_image_additional'])) ? $this->error['oct_luxury_image_additional'] : '';
        $data['error_image_related']              = (isset($this->error['oct_luxury_image_related'])) ? $this->error['oct_luxury_image_related'] : '';
        $data['error_image_compare']              = (isset($this->error['oct_luxury_image_compare'])) ? $this->error['oct_luxury_image_compare'] : '';
        $data['error_image_wishlist']             = (isset($this->error['oct_luxury_image_wishlist'])) ? $this->error['oct_luxury_image_wishlist'] : '';
        $data['error_image_cart']                 = (isset($this->error['oct_luxury_image_cart'])) ? $this->error['oct_luxury_image_cart'] : '';
        $data['error_image_location']             = (isset($this->error['oct_luxury_image_location'])) ? $this->error['oct_luxury_image_location'] : '';
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=theme', true)
        );
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('extension/theme/oct_luxury', 'token=' . $this->session->data['token'] . '&store_id=' . $store_id, true)
        );
        
        $data['action'] = $this->url->link('extension/theme/oct_luxury', 'token=' . $this->session->data['token'] . '&store_id=' . $store_id, true);
        $data['cache']  = $this->url->link('extension/theme/oct_luxury/cache', 'token=' . $this->session->data['token'] . '&store_id=' . $store_id, true);
        $data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=theme', true);
        
        if ($this->request->server['REQUEST_METHOD'] != 'POST') {
            $setting_info = $this->model_setting_setting->getSetting('oct_luxury', $store_id);
        }
        
        if (isset($this->request->post['oct_luxury_status'])) {
            $data['oct_luxury_status'] = $this->request->post['oct_luxury_status'];
        } elseif (isset($setting_info['oct_luxury_status'])) {
            $data['oct_luxury_status'] = $setting_info['oct_luxury_status'];
        } else {
            $data['oct_luxury_status'] = '';
        }
        
        if (isset($this->request->post['oct_luxury_data'])) {
            $data['oct_luxury_data'] = $this->request->post['oct_luxury_data'];
        } else {
            $data['oct_luxury_data'] = $this->config->get('oct_luxury_data');
        }
        
        if (!isset($data['oct_luxury_data']['minifyjscss'])) {
	        $data['oct_luxury_data']['minifyjscss'] = 'on';
        }
        
        if (!isset($data['oct_luxury_data']['pr_gallery'])) {
	        $data['oct_luxury_data']['pr_gallery'] = 'on';
        }
        
        if (!isset($data['oct_luxury_data']['pr_zoom'])) {
	        $data['oct_luxury_data']['pr_zoom'] = 'on';
        }
        
        $config_data = array(
            'oct_luxury_product_limit',
            'oct_luxury_product_description_length',
            'oct_luxury_image_category_width',
            'oct_luxury_image_category_height',
            'oct_luxury_image_thumb_width',
            'oct_luxury_image_thumb_height',
            'oct_luxury_image_popup_width',
            'oct_luxury_image_popup_height',
            'oct_luxury_image_product_width',
            'oct_luxury_image_product_height',
            'oct_luxury_image_additional_width',
            'oct_luxury_image_additional_height',
            'oct_luxury_image_related_width',
            'oct_luxury_image_related_height',
            'oct_luxury_image_compare_width',
            'oct_luxury_image_compare_height',
            'oct_luxury_image_wishlist_width',
            'oct_luxury_image_wishlist_height',
            'oct_luxury_image_cart_width',
            'oct_luxury_image_cart_height',
            'oct_luxury_image_location_width',
            'oct_luxury_image_location_height'
        );
        
        foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $data[$conf] = $this->request->post[$conf];
            } else {
                $data[$conf] = $this->config->get($conf);
            }
        }
        
        $this->load->model('catalog/information');
        
        $data['informations'] = $this->model_catalog_information->getInformations();
        
        $this->load->model('localisation/language');
        
        $data['languages'] = $this->model_localisation_language->getLanguages();
        
        $data['placeholder'] = $this->model_tool_image->resize('no_image.png', 50, 50);
        
        if (isset($this->request->post['ps_additional_icons'])) {
            $ps_additional_icons = $this->request->post['ps_additional_icons'];
        } elseif (isset($data['oct_luxury_data']['ps_additional_icons'])) {
            $ps_additional_icons = $data['oct_luxury_data']['ps_additional_icons'];
        } else {
            $ps_additional_icons = array();
        }
        
        $data['ps_additional_icons'] = array();
        
        foreach ($ps_additional_icons as $ps_additional_icon) {
            if (is_file(DIR_IMAGE . $ps_additional_icon['image'])) {
                $image = $ps_additional_icon['image'];
                $thumb = $ps_additional_icon['image'];
            } else {
                $image = '';
                $thumb = 'no_image.png';
            }
            
            $data['ps_additional_icons'][] = array(
                'image' => $image,
                'thumb' => $this->model_tool_image->resize($thumb, 50, 50),
                'sort_order' => ($ps_additional_icon['sort_order']) ? $ps_additional_icon['sort_order'] : 0
            );
        }
        
        $data['header']      = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer']      = $this->load->controller('common/footer');
        
        $this->response->setOutput($this->load->view('extension/theme/oct_luxury', $data));
    }
    
    public function cache() {
        $this->load->language('extension/theme/oct_luxury');
        
        $this->cache->delete('octemplates');
        
        $this->session->data['success'] = $this->language->get('text_success_cache');
        
        if (isset($this->request->get['store_id'])) {
            $store_id = $this->request->get['store_id'];
        } else {
            $store_id = 0;
        }
        
        $this->response->redirect($this->url->link('extension/theme/oct_luxury', 'token=' . $this->session->data['token'] . '&store_id=' . $store_id, true));
    }
    
    public function install() {
        $this->load->language('extension/theme/oct_luxury');
        
        $this->load->model('extension/extension');
        $this->load->model('setting/setting');
        $this->load->model('user/user_group');
        
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'access', 'extension/theme/oct_luxury');
        $this->model_user_user_group->addPermission($this->user->getGroupId(), 'modify', 'extension/theme/oct_luxury');
        
        $this->model_setting_setting->editSetting('oct_luxury', array(
            'oct_luxury_status' => '1',
            'oct_luxury_product_limit' => '18',
            'oct_luxury_product_description_length' => '100',
            'oct_luxury_image_category_width' => '150',
            'oct_luxury_image_category_height' => '150',
            'oct_luxury_image_thumb_width' => '720',
            'oct_luxury_image_thumb_height' => '720',
            'oct_luxury_image_popup_width' => '1000',
            'oct_luxury_image_popup_height' => '1000',
            'oct_luxury_image_product_width' => '300',
            'oct_luxury_image_product_height' => '350',
            'oct_luxury_image_additional_width' => '90',
            'oct_luxury_image_additional_height' => '90',
            'oct_luxury_image_related_width' => '80',
            'oct_luxury_image_related_height' => '80',
            'oct_luxury_image_compare_width' => '180',
            'oct_luxury_image_compare_height' => '280',
            'oct_luxury_image_wishlist_width' => '47',
            'oct_luxury_image_wishlist_height' => '47',
            'oct_luxury_image_cart_width' => '47',
            'oct_luxury_image_cart_height' => '47',
            'oct_luxury_image_location_width' => '210',
            'oct_luxury_image_location_height' => '44',
            'oct_luxury_data' => array(
                'showmanlogos' => 'on',
                'minifyjscss' => 'on',
                'terms' => '',
                'maincolor1' => 'ada479',
                'maincolor2' => '36283a',
                'maincolor3' => 'adcecc',
                'aOO' => '',
                'customcss' => '',
                'customjavascrip' => '',
                'stick' => 'on',
                'showcontacts' => 'on',
                'shownews' => 'on',
                'header_information_links' => array(),
                'head_1bge' => '251c28',
                'head_1linkcolore' => 'adcecc',
                'head_2bg' => '36283a',
                'head_infocolor' => 'ffffff',
                'head_linecolor' => 'ada479',
                'head_linecolor_hover' => 'adcecc',
                'head_tooltiplinkcolor' => '36283a',
                'text_head_tooltiplinkcolor_h' => 'adcecc',
                'head_bgsrchcat' => 'ada479',
                'head_bgsrchcattext' => '36283a',
                'head_srch' => 'F0F0F1',
                'head_srchcolors' => 'adcecc',
                'head_bgcart' => 'adcecc',
                'head_bgcart2' => 'ada479',
                'oct_luxury_mob_sbbg' => 'ada479',
                'head_textcart2' => '27282d',
                'head_menu_text' => 'adcecc',
                'head_bgmenu' => '36283a',
                'head_maincolormenu' => 'ffffff',
                'head_maincolormenu_h' => 'adcecc',
                'head_bgchildmenu' => 'ffffff',
                'head_parentcolor' => 'ada479',
                'head_parentcolor_hover' => 'adcecc',
                'head_childcolor' => '36283a',
                'head_childcolor_hover' => 'ada479',
                'foot_logo' => 'on',
                'foot_1stline' => 'on',
                'foot_2ndline' => 'on',
                'foot_3dline' => 'on',
                'foot_infolinks' => 'on',
                'footer_information_links' => array(),
                'foot_garanted' => array(
                    'ru-ru' => '<div class="row advantages-row"> <div class="col-sm-3 col-sm-offset-2 col-xs-4"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> <p>100% Гарантия на <br>продаваемый товар</p> </div> <div class="col-sm-3 col-xs-4"> <i class="fa fa-truck" aria-hidden="true"></i> <p>Быстрая доставка <br>по всей стране</p> </div> <div class="col-sm-3 col-xs-4"> <i class="fa fa-certificate" aria-hidden="true"></i> <p>Качественный товар <br>большой ассортимент</p> </div> </div>',
                    'en-gb' => '<div class="row advantages-row"> <div class="col-sm-3 col-sm-offset-2 col-xs-4"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> <p>100% Guarantee to <br>sold goods</p> </div> <div class="col-sm-3 col-xs-4"> <i class="fa fa-truck" aria-hidden="true"></i> <p>Fast shipping <br>through the country</p> </div> <div class="col-sm-3 col-xs-4"> <i class="fa fa-certificate" aria-hidden="true"></i> <p>Quality goods<br>a large assortment</p> </div> </div>'
                ),
                'foot_1stlinebg' => '251c28',
                'foot_linelogo' => 'adcecc',
                'foot_titlecolor' => 'adcecc',
                'foot_linkcolor' => 'ffffff',
                'foot_linelinks' => 'adcecc',
                'foot_garantedcolors' => 'ada479',
                'foot_garantedtext' => 'ada479',
                'foot_2ndlinebg' => '36283a',
                'foot_iconscolor' => 'adcecc',
                'foot_2ndlinetcolor' => 'd7d6d7',
                'foot_2linelink' => 'ada479',
                'foot_3dlinebg' => '251c28',
                'foot_icocolor' => 'adcecc',
                'cat_sorttype' => 'on',
                'cat_sortcolor' => 'ada479',
                'cat_hovercolor' => 'adcecc',
                'cat_discountbg' => 'ada479',
                'cat_discountcolor' => 'ffffff',
                'cat_boxtext' => '36283a',
                'cat_boxbg' => 'f1f5f5',
                'cat_moduleborder' => 'e6f3f2',
                'cat_modulebg' => 'fbfcfc',
                'cat_itembg' => 'f1f5f5',
                'cat_plusminus' => '36283a',
                'cat_checkbox' => 'b6ae88',
                'cat_checkboxactive' => '36283a',
                'cat_1levelbg' => '36283a',
                'cat_1levelcolor' => 'adcecc',
                'cat_2levelbg' => 'adcecc',
                'cat_2levelcolor' => 'ffffff',
                'cat_3levelbg' => 'adcecc',
                'cat_3levelcolor' => '36283a',
                'cat_3levelbgactive' => 'afd6d4',
                'cat_3leveltextactive' => 'ffffff',
                'pr_micro' => 'on',
                'pr_shortdesc' => 'on',
                'pr_logoman' => 'on',
                'pr_garantedtext' => array(
                    'ru-ru' => '<div class="row advantages"> <div class="col-md-6 col-sm-12 advantages-item"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> <p>100% гарантия на продаваемый товар</p> </div> <div class="col-md-6 col-sm-12 advantages-item"> <i class="fa fa-truck" aria-hidden="true"></i> <p>Быстрая доставка по всей стране</p> </div> <div class="col-md-6 col-sm-12 advantages-item"> <i class="fa fa-certificate" aria-hidden="true"></i> <p>Высокое качество товаров магазина</p> </div> <div class="col-md-6 col-sm-12 advantages-item"> <i class="fa fa-tty" aria-hidden="true"></i> <p>Круглосуточный центр поддержки</p> </div> </div>',
                    'en-gb' => '<div class="row advantages"> <div class="col-md-6 col-sm-12 advantages-item"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> <p>100% guarantee on goods sold</p> </div> <div class="col-md-6 col-sm-12 advantages-item"> <i class="fa fa-truck" aria-hidden="true"></i> <p>Fast delivery all over the country</p> </div> <div class="col-md-6 col-sm-12 advantages-item"> <i class="fa fa-certificate" aria-hidden="true"></i> <p>High quality goods store</p> </div> <div class="col-md-6 col-sm-12 advantages-item"> <i class="fa fa-tty" aria-hidden="true"></i> <p>24 Hour Support Center</p> </div> </div>'
                ),
                'pr_gallery' => 'on',
                'pr_zoom' => 'on',
                'pr_garantedcolor' => '36283a',
                'pr_garantedicon' => 'ada479',
                'pr_photoborder' => 'adcecc',
                'pr_photoborderhover' => 'ada479',
                'pr_bgright' => 'f0fcfb',
                'pr_activetabtext' => 'ffffff',
                'pr_activetabbg' => 'adcecc',
                'pr_activetabbgcont' => 'f0fcfb',
                'pr_activetabbgtext' => '666666',
                'pr_tabtext' => '36283a',
                'pr_manufact_and_code' => 'b0a778',
                'pr_foundcheaper' => '77657c',
                'pr_buyoneclick' => 'afa778',
                'pr_pricecolor' => 'afa778',
                'pr_oldpricecolor' => '867e89',
                'mob_mainlinebg' => '36283A',
                'mob_cartbg' => 'ADA479',
                'mob_carttexticocolor' => '42413C',
                'mob_menubg' => 'ADCECC',
                'mob_menucolor' => '36283A',
                'mob_sbbg' => 'ada479',
                'mob_sbh3' => 'FFFFFF',
                'mob_sblinkcolor' => '2B1A2F',
                'mob_sbbuttoncolor' => 'ADA479',
                'mob_sbbuttonicon' => 'FFFFFF',
                'mob_sbbuttoncoloropened' => '5D5841',
                'mob_sbbuttoniconopened' => 'ADA479',
                'cont_phones' => '8 (050) 753-10-20
8 (063) 100-12-10
8 (911) 753-10-20',
                'cont_skype' => 'luxury@octemplates',
                'cont_email' => $this->config->get('config_email'),
                'cont_adress' => array(
                    'ru-ru' => 'Россия, г. Москва. Большая Пироговская ул. 17, 3 этаж, офис 315',
                    'en-gb' => 'Russia, Moscow. Big Pirogovskaya. 17, third floor, office 315'
                ),
                'cont_clock' => array(
                    'ru-ru' => 'ПН-ПТ: 09:00 - 18:00
СБ: 10:00 - 16:00
ВС: 10:00 - 14:00',
                    'en-gb' => 'MON-FR: 09:00 - 18:00
ST: 10:00 - 16:00
SUN: 10:00 - 14:00'
                ),
                'cont_contacthtml' => array(),
                'cont_contactmap' => '',
                'ps_facebook_id' => '',
                'ps_vk_id' => '',
                'ps_gplus_id' => '',
                'ps_odnoklass_id' => '',
                'ps_twitter_username' => '',
                'ps_vimeo_id' => '',
                'ps_pinterest_id' => '',
                'ps_flick_id' => '',
                'ps_instagram' => '',
                'ps_youtube_id' => '',
                'ps_whatsapp_id' => '',
                'ps_telegram_id' => '',
                'ps_viber_id' => '',
                'ps_sberbank' => 'on',
                'ps_privat' => 'on',
                'ps_yamoney' => 'on',
                'ps_webmoney' => 'on',
                'ps_visa' => 'on',
                'ps_qiwi' => 'on',
                'ps_skrill' => 'on',
                'ps_interkassa' => 'on',
                'ps_liqpay' => 'on',
                'ps_paypal' => 'on',
                'ps_robokassa' => 'on',
                'ps_additional_icons' => array()
            )
        ));
        
        if (!in_array('oct_luxury', $this->model_extension_extension->getInstalled('theme'))) {
            $this->model_extension_extension->install('theme', 'oct_luxury');
        }
        
        $this->session->data['success'] = $this->language->get('text_success_install');
    }
    
    public function uninstall() {
        $this->load->model('extension/extension');
        
        $this->model_extension_extension->uninstall('theme', 'oct_luxury');
    }
    
    private function validate() {
        if (!$this->user->hasPermission('modify', 'extension/theme/oct_luxury')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        
        if (empty($this->request->post['oct_luxury_product_limit'])) {
            $this->error['product_limit'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_product_description_length'])) {
            $this->error['product_description_length'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_category_width']) || empty($this->request->post['oct_luxury_image_category_height'])) {
            $this->error['image_category'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_thumb_width']) || empty($this->request->post['oct_luxury_image_thumb_height'])) {
            $this->error['image_thumb_width'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_popup_width']) || empty($this->request->post['oct_luxury_image_popup_height'])) {
            $this->error['image_popup_width'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_product_width']) || empty($this->request->post['oct_luxury_image_product_height'])) {
            $this->error['image_product_width'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_additional_width']) || empty($this->request->post['oct_luxury_image_additional_height'])) {
            $this->error['image_additional'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_related_width']) || empty($this->request->post['oct_luxury_image_related_height'])) {
            $this->error['image_related_width'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_compare_width']) || empty($this->request->post['oct_luxury_image_compare_height'])) {
            $this->error['image_compare_width'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_wishlist_width']) || empty($this->request->post['oct_luxury_image_wishlist_height'])) {
            $this->error['image_wishlist_width'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_cart_width']) || empty($this->request->post['oct_luxury_image_cart_height'])) {
            $this->error['image_cart_width'] = $this->language->get('error_warning');
        }
        
        if (empty($this->request->post['oct_luxury_image_location_width']) || empty($this->request->post['oct_luxury_image_location_height'])) {
            $this->error['image_location_width'] = $this->language->get('error_warning');
        }
        
        return (!$this->error) ? TRUE : FALSE;
    }

    protected function synchronize_modification() {
      $this->load->model('extension/modification');
      $this->load->model('tool/oct_modification_manager');

      $filter_data = array(
        'filter_author' => 'Octemplates',
        'filter_author_group' => false
      );

      $modifications = $this->model_tool_oct_modification_manager->getModifications($filter_data);

      if ($modifications) {
        foreach ($modifications as $modification) {
          if ($modification['status'] == '1') {
            $this->model_extension_modification->disableModification($modification['modification_id']);
          }
        }

        $this->refresh_modification();
      }
    }

  public function refresh_modification() {
		$this->load->model('extension/modification');

			$log = array();

			$files = array();

			$path = array(DIR_MODIFICATION . '*');

			while (count($path) != 0) {
				$next = array_shift($path);

				foreach (glob($next) as $file) {
					if (is_dir($file)) {
						$path[] = $file . '/*';
					}

					$files[] = $file;
				}
			}

			rsort($files);

			foreach ($files as $file) {
				if ($file != DIR_MODIFICATION . 'index.html') {
					if (is_file($file)) {
						unlink($file);
					} elseif (is_dir($file)) {
						rmdir($file);
					}
				}
			}

			$xml = array();

			$xml[] = file_get_contents(DIR_SYSTEM . 'modification.xml');

			$files = glob(DIR_SYSTEM . '*.ocmod.xml');

			if ($files) {
				foreach ($files as $file) {
					$xml[] = file_get_contents($file);
				}
			}

			$results = $this->model_extension_modification->getModifications(array('sort'=>'date_added', 'order'=>'ASC'));

			foreach ($results as $result) {
				if ($result['status']) {
					$xml[] = $result['xml'];
				}
			}

			$modification = array();

			foreach ($xml as $xml) {
				if (empty($xml)){
					continue;
				}

				$dom = new DOMDocument('1.0', 'UTF-8');
				$dom->preserveWhiteSpace = false;
				$dom->loadXml($xml);

				$log[] = 'MOD: ' . $dom->getElementsByTagName('name')->item(0)->textContent;

				$recovery = array();

				if (isset($modification)) {
					$recovery = $modification;
				}

				$files = $dom->getElementsByTagName('modification')->item(0)->getElementsByTagName('file');

				foreach ($files as $file) {
					$operations = $file->getElementsByTagName('operation');

					$files = explode('|', $file->getAttribute('path'));

					foreach ($files as $file) {
						$path = '';

						if ((substr($file, 0, 7) == 'catalog')) {
							$path = DIR_CATALOG . substr($file, 8);
						}

						if ((substr($file, 0, 5) == 'admin')) {
							$path = DIR_APPLICATION . substr($file, 6);
						}

						if ((substr($file, 0, 6) == 'system')) {
							$path = DIR_SYSTEM . substr($file, 7);
						}

						if ($path) {
							$files = glob($path, GLOB_BRACE);

							if ($files) {
								foreach ($files as $file) {
									if (substr($file, 0, strlen(DIR_CATALOG)) == DIR_CATALOG) {
										$key = 'catalog/' . substr($file, strlen(DIR_CATALOG));
									}

									if (substr($file, 0, strlen(DIR_APPLICATION)) == DIR_APPLICATION) {
										$key = 'admin/' . substr($file, strlen(DIR_APPLICATION));
									}

									if (substr($file, 0, strlen(DIR_SYSTEM)) == DIR_SYSTEM) {
										$key = 'system/' . substr($file, strlen(DIR_SYSTEM));
									}

									if (!isset($modification[$key])) {
										$content = file_get_contents($file);

										$modification[$key] = preg_replace('~\r?\n~', "\n", $content);
										$original[$key] = preg_replace('~\r?\n~', "\n", $content);

										$log[] = PHP_EOL . 'FILE: ' . $key;
									}

									foreach ($operations as $operation) {
										$error = $operation->getAttribute('error');

										$ignoreif = $operation->getElementsByTagName('ignoreif')->item(0);

										if ($ignoreif) {
											if ($ignoreif->getAttribute('regex') != 'true') {
												if (strpos($modification[$key], $ignoreif->textContent) !== false) {
													continue;
												}
											} else {
												if (preg_match($ignoreif->textContent, $modification[$key])) {
													continue;
												}
											}
										}

										$status = false;

										if ($operation->getElementsByTagName('search')->item(0)->getAttribute('regex') != 'true') {
											$search = $operation->getElementsByTagName('search')->item(0)->textContent;
											$trim = $operation->getElementsByTagName('search')->item(0)->getAttribute('trim');
											$index = $operation->getElementsByTagName('search')->item(0)->getAttribute('index');

											if (!$trim || $trim == 'true') {
												$search = trim($search);
											}

											$add = $operation->getElementsByTagName('add')->item(0)->textContent;
											$trim = $operation->getElementsByTagName('add')->item(0)->getAttribute('trim');
											$position = $operation->getElementsByTagName('add')->item(0)->getAttribute('position');
											$offset = $operation->getElementsByTagName('add')->item(0)->getAttribute('offset');

											if ($offset == '') {
												$offset = 0;
											}

											if ($trim == 'true') {
												$add = trim($add);
											}

											$log[] = 'CODE: ' . $search;

											if ($index !== '') {
												$indexes = explode(',', $index);
											} else {
												$indexes = array();
											}

											$i = 0;

											$lines = explode("\n", $modification[$key]);

											for ($line_id = 0; $line_id < count($lines); $line_id++) {
												$line = $lines[$line_id];

												$match = false;

												if (stripos($line, $search) !== false) {
													if (!$indexes) {
														$match = true;
													} elseif (in_array($i, $indexes)) {
														$match = true;
													}

													$i++;
												}

												if ($match) {
													switch ($position) {
														default:
														case 'replace':
															$new_lines = explode("\n", $add);

															if ($offset < 0) {
																array_splice($lines, $line_id + $offset, abs($offset) + 1, array(str_replace($search, $add, $line)));

																$line_id -= $offset;
															} else {
																array_splice($lines, $line_id, $offset + 1, array(str_replace($search, $add, $line)));
															}

															break;
														case 'before':
															$new_lines = explode("\n", $add);

															array_splice($lines, $line_id - $offset, 0, $new_lines);

															$line_id += count($new_lines);
															break;
														case 'after':
															$new_lines = explode("\n", $add);

															array_splice($lines, ($line_id + 1) + $offset, 0, $new_lines);

															$line_id += count($new_lines);
															break;
													}

													$log[] = 'LINE: ' . $line_id;

													$status = true;
												}
											}

											$modification[$key] = implode("\n", $lines);
										} else {
											$search = trim($operation->getElementsByTagName('search')->item(0)->textContent);
											$limit = $operation->getElementsByTagName('search')->item(0)->getAttribute('limit');
											$replace = trim($operation->getElementsByTagName('add')->item(0)->textContent);

											if (!$limit) {
												$limit = -1;
											}

											$match = array();

											preg_match_all($search, $modification[$key], $match, PREG_OFFSET_CAPTURE);

											if ($limit > 0) {
												$match[0] = array_slice($match[0], 0, $limit);
											}

											if ($match[0]) {
												$log[] = 'REGEX: ' . $search;

												for ($i = 0; $i < count($match[0]); $i++) {
													$log[] = 'LINE: ' . (substr_count(substr($modification[$key], 0, $match[0][$i][1]), "\n") + 1);
												}

												$status = true;
											}

											$modification[$key] = preg_replace($search, $replace, $modification[$key], $limit);
										}

										if (!$status) {
											if ($error == 'abort') {
												$modification = $recovery;

												$log[] = 'NOT FOUND - ABORTING!';
												break 5;
											} elseif ($error == 'skip') {
												$log[] = 'NOT FOUND - OPERATION SKIPPED!';
												continue;
											} else {
												$log[] = 'NOT FOUND - OPERATIONS ABORTED!';
											 	break;
											}
										}
									}
								}
							}
						}
					}
				}

				$log[] = '----------------------------------------------------------------';
			}

			$ocmod = new Log('ocmod.log');
			$ocmod->write(implode("\n", $log));

			foreach ($modification as $key => $value) {
				if ($original[$key] != $value) {
					$path = '';

					$directories = explode('/', dirname($key));

					foreach ($directories as $directory) {
						$path = $path . '/' . $directory;

						if (!is_dir(DIR_MODIFICATION . $path)) {
							@mkdir(DIR_MODIFICATION . $path, 0777);
						}
					}

					$handle = fopen(DIR_MODIFICATION . $key, 'w');

					fwrite($handle, $value);

					fclose($handle);
				}
			}
	}
}