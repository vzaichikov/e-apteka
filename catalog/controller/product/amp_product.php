<?php
class ControllerProductAmpProduct extends Controller {
	private function ampfy($html) {
		$html = str_ireplace(['<img','<video','/video>','<audio','/audio>'],['<div class="image-wrapper"><amp-img layout="responsive" width="600" height="350"','<amp-video','/amp-video>','<amp-audio','/amp-audio>'],$html);

		# Add closing tags to amp-img custom element

		$html = preg_replace('/<amp-img(.*?)>/', '<amp-img$1></amp-img></div>',$html);

		# Whitelist of HTML tags allowed by AMP

		$html = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $html);
		$html = str_replace ('class="img-responsive"', '', $html);
		$html = strip_tags($html,'<h1><h2><h3><h4><h5><h6><a><p><ul><ol><li><blockquote><q><cite><ins><del><strong><em><code><pre><svg><table><thead><tbody><tfoot><th><tr><td><dl><dt><dd><article><section><header><footer><aside><figure><time><abbr><div><span><hr><small><br><amp-img><amp-audio><amp-video><amp-ad><amp-anim><amp-carousel><amp-fit-rext><amp-image-lightbox><amp-instagram><amp-lightbox><amp-twitter><amp-youtube>');


		return $html;
	}
    public function index() {
        
        if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }
        if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
            $data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
            $data['logo'] = '';
        }
        $data['home']      = $this->url->link('common/home');
        $data['base']      = $server;
        $data['canonical'] = $this->url->link('product/product', 'product_id=' . $this->request->get['product_id']);
        $data['current']   = $this->url->link('product/amp_product', 'product_id=' . $this->request->get['product_id']);
        
        $this->load->language('product/product');
        
        $data['breadcrumbs'] = array();
        
        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home')
        );
        
        $this->load->model('catalog/category');
        
        if (isset($this->request->get['path'])) {
            $path = '';
            
            $parts = explode('_', (string) $this->request->get['path']);
            
            $category_id = (int) array_pop($parts);
            
            foreach ($parts as $path_id) {
                if (!$path) {
                    $path = $path_id;
                } else {
                    $path .= '_' . $path_id;
                }
                
                $category_info = $this->model_catalog_category->getCategory($path_id);
                
                if ($category_info) {
                    $data['breadcrumbs'][] = array(
                        'text' => $category_info['name'],
                        'href' => $this->url->link('product/category', 'path=' . $path)
                    );
                }
            }
            
            // Set the last category breadcrumb
            $category_info = $this->model_catalog_category->getCategory($category_id);
            
            if ($category_info) {
                $url = '';
                
                if (isset($this->request->get['sort'])) {
                    $url .= '&sort=' . $this->request->get['sort'];
                }
                
                if (isset($this->request->get['order'])) {
                    $url .= '&order=' . $this->request->get['order'];
                }
                
                if (isset($this->request->get['page'])) {
                    $url .= '&page=' . $this->request->get['page'];
                }
                
                if (isset($this->request->get['limit'])) {
                    $url .= '&limit=' . $this->request->get['limit'];
                }
                
                $data['breadcrumbs'][] = array(
                    'text' => $category_info['name'],
                    'href' => $this->url->link('product/category', 'path=' . $this->request->get['path'] . $url)
                );
            }
        }
        
        $this->load->model('catalog/manufacturer');
        
        if (isset($this->request->get['manufacturer_id'])) {
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_brand'),
                'href' => $this->url->link('product/manufacturer')
            );
            
            $url = '';
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);
            
            if ($manufacturer_info) {
                $data['breadcrumbs'][] = array(
                    'text' => $manufacturer_info['name'],
                    'href' => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id'] . $url)
                );
            }
        }
        
        if (isset($this->request->get['search']) || isset($this->request->get['tag'])) {
            $url = '';
            
            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }
            
            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }
            
            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }
            
            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_search'),
                'href' => $this->url->link('product/search', $url)
            );
        }
        
        if (isset($this->request->get['product_id'])) {
            $product_id = (int) $this->request->get['product_id'];
        } else {
            $product_id = 0;
        }
        
        $this->load->model('catalog/product');
        
        $product_info = $this->model_catalog_product->getProduct($product_id);
        
        if ($product_info) {
            $url = '';
            
            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }
            
            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }
            
            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }
            
            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }
            
            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }
            
            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }
            
            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
                     
            
            
            $data['name']             = $this->config->get('config_name');
            $data['meta_title']       = $product_info['meta_title'];
            $data['meta_description'] = $product_info['meta_description'];
            $data['meta_keyword']     = $product_info['meta_keyword'];
            $data['heading_title']    = $product_info['name'];
            
            $data['quantity_stock'] = $product_info['quantity'];
            $data['text_not_in_stock'] = $this->language->get('text_not_in_stock');
            
            
            if ($this->config->get('amp_product_pro_back_color')) {
                $data['amp_product_pro_back_color'] = $this->config->get('amp_product_pro_back_color');
            } else {
                $data['amp_product_pro_back_color'] = '#ffffff';
            }
            if ($this->config->get('amp_product_pro_link_color')) {
                $data['amp_product_pro_link_color'] = $this->config->get('amp_product_pro_link_color');
            } else {
                $data['amp_product_pro_link_color'] = '#00e';
            }
            if ($this->config->get('amp_product_pro_cart_color')) {
                $data['amp_product_pro_cart_color'] = $this->config->get('amp_product_pro_cart_color');
            } else {
                $data['amp_product_pro_cart_color'] = '#da4f49';
            }
            if ($this->config->get('amp_product_pro_search_color')) {
                $data['amp_product_pro_search_color'] = $this->config->get('amp_product_pro_search_color');
            } else {
                $data['amp_product_pro_search_color'] = '#da4f49';
            }
            if ($this->config->get('amp_product_pro_image_height')) {
                $data['amp_product_pro_image_height'] = $this->config->get('amp_product_pro_image_height');
            } else {
                $data['amp_product_pro_image_height'] = '500';
            }
            if ($this->config->get('amp_product_pro_image_width')) {
                $data['amp_product_pro_image_width'] = $this->config->get('amp_product_pro_image_width');
            } else {
                $data['amp_product_pro_image_width'] = '500';
            }
            if ($this->config->get('amp_product_pro_logo_height')) {
                $data['amp_product_pro_logo_height'] = $this->config->get('amp_product_pro_logo_height');
            } else {
                $data['amp_product_pro_logo_height'] = '42';
            }
            if ($this->config->get('amp_product_pro_logo_width')) {
                $data['amp_product_pro_logo_width'] = $this->config->get('amp_product_pro_logo_width');
            } else {
                $data['amp_product_pro_logo_width'] = '228';
            }
            
            $data['amp_product_pro_enable_rating'] = $this->config->get('amp_product_pro_enable_rating');
            
            $data['amp_product_pro_enable_carousel_rel'] = $this->config->get('amp_product_pro_enable_carousel_rel');
            $data['amp_product_pro_search']              = $this->url->link('product/search');
            
            if (version_compare(VERSION, '2.2.0.0', '>=')) {
                $data['carousel_rel_width']  = $this->config->get($this->config->get('config_theme') . '_image_product_width');
                $data['carousel_rel_height'] = $this->config->get($this->config->get('config_theme') . '_image_product_height');
                
            } else {
                $data['carousel_rel_width']  = $this->config->get('config_image_product_width');
                $data['carousel_rel_height'] = $this->config->get('config_image_product_height');
                
            }
            $data['carousel_rel_conatiner'] = (float) $data['carousel_rel_height'] + 100;
            $data['carousel_rel_element']   = (float) $data['carousel_rel_conatiner'] - 8;
            $data['text_manufacturer']      = $this->language->get('text_manufacturer');
            $data['text_model']             = $this->language->get('text_model');
            $data['text_reward']            = $this->language->get('text_reward');
            $data['text_points']            = $this->language->get('text_points');
            $data['text_stock']             = $this->language->get('text_stock');
            $data['text_discount']          = $this->language->get('text_discount');
            $data['text_tax']               = $this->language->get('text_tax');
            $data['text_option']            = $this->language->get('text_option');
            $data['text_minimum']           = sprintf($this->language->get('text_minimum'), $product_info['minimum']);
            $data['text_note']              = $this->language->get('text_note');
            $data['text_tags']              = $this->language->get('text_tags');
            $data['text_related']           = $this->language->get('text_related');
            
            $data['text_loading'] = $this->language->get('text_loading');
            
            $data['entry_qty'] = $this->language->get('entry_qty');
            
            
            $data['button_cart'] = $this->language->get('button_cart');
            
            
            $this->load->model('catalog/review');
            if (version_compare(VERSION, '2.2.0.0', '>=')) {
                $data['currency_code'] = $this->session->data['currency'];
            } else {
                $data['currency_code'] = $this->currency->getCode();
            }
            $data['product_price']   = $product_info['price'];
            $data['product_special'] = $product_info['special'];
            $data['product_id']      = (int) $this->request->get['product_id'];
            $data['manufacturer']    = $product_info['manufacturer'];
            $data['manufacturers']   = $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $product_info['manufacturer_id']);
            $data['model']           = $product_info['model'];
            $data['reward']          = $product_info['reward'];
            $data['points']          = $product_info['points'];
            $data['description']     = html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8');
            $data['description']     = $this->ampfy($data['description']);
            $data['tab_description'] = $this->language->get('tab_description');
            $data['tab_attribute']   = $this->language->get('tab_attribute');
            if ($product_info['quantity'] <= 0) {
                $data['stock'] = $product_info['stock_status'];
            } elseif ($this->config->get('config_stock_display')) {
                $data['stock'] = $product_info['quantity'];
            } else {
                $data['stock'] = $this->language->get('text_instock');
            }
            
            $this->load->model('tool/image');
            
            if (version_compare(VERSION, '2.2.0.0', '>=')) {
                
                if ($product_info['image']) {
                    $data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get($this->config->get('config_theme') . '_image_thumb_width'), $this->config->get($this->config->get('config_theme') . '_image_thumb_height'));
                } else {
                    $data['thumb'] = false;
                    
                }
            } else {
                
                if ($product_info['image']) {
                    $data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                } else {
                    $data['thumb'] = false;
                }
            }
            
            $data['images'] = array();
            
            $results = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
            
            
            if (version_compare(VERSION, '2.2.0.0', '>=')) {
                foreach ($results as $result) {
                    $data['images'][] = array(
                        'popup' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_popup_width'), $this->config->get($this->config->get('config_theme') . '_image_popup_height')),
                        'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_additional_width'), $this->config->get($this->config->get('config_theme') . '_image_additional_height'))
                    );
                }
            } else {
                foreach ($results as $result) {
                    $data['images'][] = array(
                        'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
                        'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
                    );
                }
            }
            
            
            if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                if (version_compare(VERSION, '2.2.0.0', '>=')) {
                    $data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                    
                    
                } else {
                    $data['price'] = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                }
            } else {
                $data['price'] = false;
            }
            if ((float) $product_info['special']) {
                if (version_compare(VERSION, '2.2.0.0', '>=')) {
                    $data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                } else {
                    $data['special'] = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                }
            } else {
                $data['special'] = false;
            }
            
            if ($this->config->get('config_tax')) {
                if (version_compare(VERSION, '2.2.0.0', '>=')) {
                    $data['tax'] = $this->currency->format((float) $product_info['special'] ? $product_info['special'] : $product_info['price'], $this->session->data['currency']);
                } else {
                    $data['tax'] = $this->currency->format((float) $product_info['special'] ? $product_info['special'] : $product_info['price']);
                }
            } else {
                $data['tax'] = false;
            }
            
            $discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
            
            $data['discounts'] = array();
            
            foreach ($discounts as $discount) {
				if (version_compare(VERSION, '2.2.0.0', '>=')) {
                    $disc_price = $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
					
                } else {
					$disc_price = $this->currency->format($this->tax->calculate($discount['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
                }
                $data['discounts'][] = array(
                    'quantity' => $discount['quantity'],
                    'price' => $disc_price
                );
            }
            if ($product_info['minimum']) {
                $data['minimum'] = $product_info['minimum'];
            } else {
                $data['minimum'] = 1;
            }
            
            // $data['review_status'] = $this->config->get('config_review_status');
            
            //if ($this->config->get('config_review_guest') || $this->customer->isLogged()) {
            //    $data['review_guest'] = true;
            //} else {
            //    $data['review_guest'] = false;
            //}
            
            if ($this->customer->isLogged()) {
                $data['customer_name'] = $this->customer->getFirstName() . '&nbsp;' . $this->customer->getLastName();
            } else {
                $data['customer_name'] = '';
            }
            $data['amp_cart'] = $this->url->link('product/product', 'product_id=' . $this->request->get['product_id']).'&add=true';
            $data['reviews']          = sprintf($this->language->get('text_reviews'), (int) $product_info['reviews']);
			$data['text_comment'] = $this->language->get('text_comment');
			$data['text_no_reviews'] = $this->language->get('text_no_reviews');
            $data['rating']           = (int) $product_info['rating'];
			$data['reviews_data'] = array();
			$reviews = $this->model_catalog_review->getReviewsByProductId($this->request->get['product_id'], 0, 10);

			foreach ($reviews as $result) {
				$data['reviews_data'][] = array(
					'author'     => $result['author'],
					'text'       => nl2br($result['text']),
					'rating'     => (int)$result['rating'],
					'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added']))
				);
			}
            $data['attribute_groups'] = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
            if ($this->config->get('amp_product_pro_enable_related')) {
                $data['enable_rel_products'] = true;
                $data['products']            = array();
                
                $results = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
                
                foreach ($results as $result) {
                    if (version_compare(VERSION, '2.2.0.0', '>=')) {
                        $description = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get($this->config->get('config_theme') . '_product_description_length')) . '..';
                        
                        if ($result['image']) {
                            $image = $this->model_tool_image->resize($result['image'], $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
                        } else {
                            $image = $this->model_tool_image->resize('placeholder.png', $this->config->get($this->config->get('config_theme') . '_image_product_width'), $this->config->get($this->config->get('config_theme') . '_image_product_height'));
                        }
                    } else {
                        $description = utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..';
                        
                        if ($result['image']) {
                            $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
                        } else {
                            $image = false;
                        }
                    }
                    
                    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                        if (version_compare(VERSION, '2.2.0.0', '>=')) {
                            $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                        } else {
                            $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                        }
                    } else {
                        $price = false;
                        
                    }
                    
                    if ((float) $result['special']) {
                        if (version_compare(VERSION, '2.2.0.0', '>=')) {
                            $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']);
                        } else {
                            $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
                        }
                    } else {
                        $special = false;
                    }
                    
                    if ($this->config->get('config_tax')) {
                        if (version_compare(VERSION, '2.2.0.0', '>=')) {
                            $tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price'], $this->session->data['currency']);
                        } else {
                            $tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price']);
                        }
                    } else {
                        $tax = false;
                    }
                    
                    if ($this->config->get('config_review_status')) {
                        $rating = (int) $result['rating'];
                    } else {
                        $rating = false;
                    }
                    
                    $data['products'][] = array(
                        'product_id' => $result['product_id'],
                        'thumb' => $image,
                        'name' => $result['name'],
                        'price' => $price,
                        'special' => $special,
                        'tax' => $tax,
                        'minimum' => $result['minimum'] > 0 ? $result['minimum'] : 1,
                        'rating' => $rating,
                        'href' => $this->url->link('product/amp_product', 'product_id=' . $result['product_id'])
                    );
                }
            } else {
                $data['enable_rel_products'] = false;
            }
            
            $data['tags'] = array();
            
            if ($product_info['tag']) {
                $tags = explode(',', $product_info['tag']);
                
                foreach ($tags as $tag) {
                    $data['tags'][] = array(
                        'tag' => trim($tag),
                        'href' => $this->url->link('product/search', 'tag=' . trim($tag))
                    );
                }
            }
            
            $data['recurrings'] = $this->model_catalog_product->getProfiles($this->request->get['product_id']);
            // Menu
            $this->load->model('catalog/category');
            
            $this->load->model('catalog/product');
            
            $data['categories'] = array();
			$this->load->language('common/header');
            $data['text_home'] = $this->language->get('text_home');
            
            $categories = $this->model_catalog_category->getCategories(0);
            
            foreach ($categories as $category) {
                //if ($category['top']) {
                    // Level 2
                    $children_data = array();
                    
                    $children = $this->model_catalog_category->getCategories($category['category_id']);
                    
                    foreach ($children as $child) {
                        $filter_data = array(
                            'filter_category_id' => $child['category_id'],
                            'filter_sub_category' => true
                        );
                        
                        $children_data[] = array(
                            'name' => $child['name'] . ($this->config->get('config_product_count') ? ' (' . $this->model_catalog_product->getTotalProducts($filter_data) . ')' : ''),
                            'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $child['category_id'])
                        );
                    }
                    
                    // Level 1
                    $data['categories'][] = array(
                        'name' => $category['name'],
                        'children' => $children_data,
                        'column' => $category['column'] ? $category['column'] : 1,
                        'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
                    );
                //}
            }
            $this->model_catalog_product->updateViewed($this->request->get['product_id']);
            
            if (version_compare(VERSION, '2.2.0.0', '>=')) {
                $this->response->setOutput($this->load->view('product/amp_product', $data));
            } else {
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/amp_product.tpl')) {
                    $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/product/amp_product.tpl', $data));
                } else {
                    $this->response->setOutput($this->load->view('default/template/product/amp_product.tpl', $data));
                }
            }
            
        } else {
            $url = '';
            
            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
            }
            
            if (isset($this->request->get['filter'])) {
                $url .= '&filter=' . $this->request->get['filter'];
            }
            
            if (isset($this->request->get['manufacturer_id'])) {
                $url .= '&manufacturer_id=' . $this->request->get['manufacturer_id'];
            }
            
            if (isset($this->request->get['search'])) {
                $url .= '&search=' . $this->request->get['search'];
            }
            
            if (isset($this->request->get['tag'])) {
                $url .= '&tag=' . $this->request->get['tag'];
            }
            
            if (isset($this->request->get['description'])) {
                $url .= '&description=' . $this->request->get['description'];
            }
            
            if (isset($this->request->get['category_id'])) {
                $url .= '&category_id=' . $this->request->get['category_id'];
            }
            
            if (isset($this->request->get['sub_category'])) {
                $url .= '&sub_category=' . $this->request->get['sub_category'];
            }
            
            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }
            
            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }
            
            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }
            
            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }
            
            $data['breadcrumbs'][] = array(
                'text' => $this->language->get('text_error'),
                'href' => $this->url->link('product/product', $url . '&product_id=' . $product_id)
            );
            
            $this->document->setTitle($this->language->get('text_error'));
            
            $data['heading_title'] = $this->language->get('text_error');
            
            $data['text_error'] = $this->language->get('text_error');
            
            $data['button_continue'] = $this->language->get('button_continue');
            
            $data['continue'] = $this->url->link('common/home');
            
            $this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');
            
            $data['column_left']    = $this->load->controller('common/column_left');
            $data['column_right']   = $this->load->controller('common/column_right');
            $data['content_top']    = $this->load->controller('common/content_top');
            $data['content_bottom'] = $this->load->controller('common/content_bottom');
            $data['footer']         = $this->load->controller('common/footer');
            $data['header']         = $this->load->controller('common/header');
            
            if (version_compare(VERSION, '2.2.0.0', '>=')) {
                $this->response->setOutput($this->load->view('error/not_found', $data));
            } else {
                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                    $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found.tpl', $data));
                } else {
                    $this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
                }
            }
        }
    }
    
}