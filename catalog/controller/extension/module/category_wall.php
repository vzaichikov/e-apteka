<?php
class ControllerExtensionModuleCategoryWall extends Controller {

    public function index() {
        $return = $this->cache->get('ControllerExtensionModuleCategoryWall' . '.' . (int)$this->config->get('config_language_id'));
        if ($return){
             return $return;
        }


        $data = $this->load->language('extension/module/category_wall');
        $data += $this->load->language('product/category');
        
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');

        $data['categories'] = [];         

        if ($this->config->get('category_wall_type') == 'viewed'){
            $categories = $this->model_catalog_category->getMostViewedCategories((int)$this->config->get('category_wall_category_limit'));
        } elseif ($this->config->get('category_wall_type') == 'bought'){
            $categories = $this->model_catalog_category->getMostBoughtCategories((int)$this->config->get('category_wall_category_limit'));
        }               ;

        foreach ($categories as $category){
            $filter_data = [                                
                'sort'                => 'p.viewed',
                'filter_only_viewed'  => (int)$this->config->get('category_wall_product_threshold'), 
                'filter_category_id'  => $category['category_id'],
                'filter_sub_category' => true,
                'filter_notnull_price'=> true,
                'filter_in_stock'     => true,
                'order'               => 'DESC',
                'start'               => 0,
                'limit'               => (int)$this->config->get('category_wall_product_limit')
            ];

            $products = $this->model_catalog_product->getProducts($filter_data);

            if (count($products) < $setting['product_amount']){
                $filter_data = [                                
                    'sort'                =>    'p.viewed',
                    'filter_only_viewed'  =>    (int)$this->config->get('category_wall_product_threshold'), 
                    'filter_category_id'  =>    $category['category_id'],
                    'filter_sub_category' =>    true,
                    'filter_notnull_price'=>    true,
                    'order'               =>    'DESC',
                    'start'               =>    count($products),
                    'limit'               =>    (int)$this->config->get('category_wall_product_limit') - count($products)
                ];

                $products2 = $this->model_catalog_product->getProducts($filter_data);
                foreach ($products2 as $key => $product){
                    $products[$key] = $product;
                }
            }

            $data['categories'][] = [
                'href'      => $this->url->link('product/category', 'path=' . $category['category_id']),
                'name'      => $category['name'],
                'products'  => $this->model_catalog_product->prepareProductArray($products)
            ];
        }

        $return = $this->load->view('extension/module/category_wall', $data);
        $this->cache->set('ControllerExtensionModuleCategoryWall' . '.' . (int)$this->config->get('config_language_id'), $return);
            
        return $return;

    }
}