<?php
class ModelSoconfigGeneral extends Model {
	public function getCurrentLayout() {
        if ($this->config->get('config_maintenance')) {
            $route = '';

            if (isset($this->request->get['route'])) {
                $part = explode('/', $this->request->get['route']);

                if (isset($part[0])) {
                    $route .= $part[0];
                }
            }

            // Show site if logged in as admin
           // $this->load->library('user');

            $this->user = new User($this->registry);

            if (($route != 'payment') && !$this->user->isLogged()) {
                $layout_id = '';
            } else {
                if (isset($this->request->get['route'])) {
                    $route = $this->request->get['route'];
                } else {
                    $route = 'common/home';
                }
                $layout_id = 0;
                if (substr($route, 0, 16) == 'product/category' && isset($this->request->get['path'])) {
                    $path = explode('_', (string)$this->request->get['path']);
                    $layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
                }
                if (substr($route, 0, 16) == 'product/product' && isset($this->request->get['product_id'])) {
                    $layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
                }
                if (substr($route, 0, 16) == 'product/information' && isset($this->request->get['information_id'])) {
                    $layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
                }
                if (!$layout_id) { $layout_id = $this->model_design_layout->getLayout($route); }
                if (!$layout_id) { $layout_id = $this->config->get('config_layout_id'); }


            }

        } else {
            if (isset($this->request->get['route'])) {
                $route = $this->request->get['route'];
            } else {
                $route = 'common/home';
            }
            $layout_id = 0;
            if (substr($route, 0, 16) == 'product/category' && isset($this->request->get['path'])) {
                $path = explode('_', (string)$this->request->get['path']);
                $layout_id = $this->model_catalog_category->getCategoryLayoutId(end($path));
            }
            if (substr($route, 0, 16) == 'product/product' && isset($this->request->get['product_id'])) {
                $layout_id = $this->model_catalog_product->getProductLayoutId($this->request->get['product_id']);
            }
            if (substr($route, 0, 16) == 'product/information' && isset($this->request->get['information_id'])) {
                $layout_id = $this->model_catalog_information->getInformationLayoutId($this->request->get['information_id']);
            }
            if (!$layout_id) { $layout_id = $this->model_design_layout->getLayout($route); }
            if (!$layout_id) { $layout_id = $this->config->get('config_layout_id'); }


        }


        $query = $this->db->query("SELECT route FROM " . DB_PREFIX . "layout_route WHERE layout_id='".$layout_id."' AND store_id = '" . (int)$this->config->get('config_store_id') . "' ");

        if ($query->num_rows) {
            $layout_route = $query->row["route"];

            if ($layout_route == 'common/home'){
                $layout_id = 1;
            } elseif ($layout_route == 'product/product') {
                $layout_id = 2;
            } elseif ($layout_route == 'product/category') {
                $layout_id = 3;
            }





            return $layout_id;
        } else {
            return 0;
        }
    }
	 public function getBreadcrumbs($breadcrumbs) {
        $breadcrumbs_block = '';
        $breadcrumbs_block.= '
        <div class="breadcrumbs">
    <div class="container">
        <ol class="breadcrumb breadcrumb--ys pull-left">';

        foreach ($breadcrumbs as $k => $breadcrumb) {
            $breadcrumbs_block.= '<li class="'.($k == 0 ? 'home-link' : ($k == (count($breadcrumbs) - 1) ? 'active' : '')).'">';
            if ($k == (count($breadcrumbs) - 1)) {
                $breadcrumbs_block.= $breadcrumb['text'];
            } else {
                $breadcrumbs_block.= '<a class="'.(count($breadcrumbs)-1).'" href="'.$breadcrumb['href'].'">'.$breadcrumb['text'].'</a>';
            }
            $breadcrumbs_block.= '</li>';

        }
        $breadcrumbs_block.= '
                </ol>
            </div>
        </div>
        ';

        return $breadcrumbs_block;
    }

    public function getDateEnd($product_id) {
        $query = $this->db->query("SELECT date_end FROM ".DB_PREFIX."product_special WHERE product_id='".filter_var($product_id, FILTER_SANITIZE_NUMBER_INT)."' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' ");

        if ($query->num_rows) {
            $special_date = $query->row['date_end'];
        } else {
            $special_date = false;
        }
        return $special_date;
    }
    public function getCategoryId($category_href) {
        if (isset($category_href)) {
            $parts = explode('=', (string)$category_href);
        } else {
            $parts = array();
        }
        $category_id = end($parts);

        if (is_numeric($category_id)) {
            $category_id = $category_id;
        } else {
            $parts = explode('/', (string)$category_id);
            $query = $this->db->query("SELECT query as query FROM ".DB_PREFIX."url_alias WHERE keyword='".$this->db->escape($parts)."'");

            if ($query->num_rows) {
                //$parts = explode('=', (string)$query->row['query']);
                $parts = explode('=', $query->row['query']);
                $category_id = end($parts);
            }

        }
        return $category_id;
    }

    public function getCategoryOption($category_id, $option) {
        $column_exists_option = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "category_description LIKE '".$option."' ");
        if ($column_exists_option->num_rows) {
            $query = $this->db->query("SELECT DISTINCT `".$option."` FROM " . DB_PREFIX . "category_description cd WHERE cd.category_id = '" . (int)$category_id . "' ");
            if ($query->rows) {
                $category_option = $query->row["$option"];
            } else {
                $category_option = '';
            }
        } else {
            $category_option = '';
        }
        return $category_option;
    }

    public function getProductOption($product_id, $option) {
        $column_exists_option = $this->db->query("SHOW COLUMNS FROM " . DB_PREFIX . "product_description LIKE '".$option."' ");
        if ($column_exists_option->num_rows) {
            $query = $this->db->query("SELECT DISTINCT `".$option."` FROM " . DB_PREFIX . "product_description pd WHERE pd.product_id = '" . (int)$product_id . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' ");
            if ($query->rows) {
                $custom1 = $query->row[$option];
                if ($option == 'html_product_right' || $option == 'html_product_tab'){
                    $custom = html_entity_decode($custom1, ENT_QUOTES, 'UTF-8');
                } else {
                    $custom = $custom1;
                }
            } else {
                $custom = '';
            }
        } else {
            $custom = '';
        }

        return $custom;
    }

    public function getCategoryName($category_id) {
        $query = $this->db->query("SELECT DISTINCT `name` FROM " . DB_PREFIX . "category_description cd WHERE cd.category_id = '" . (int)$category_id . "' AND cd.language_id = '" . (int)$this->config->get('config_language_id') . "' ");

        if ($query->rows) {
            $category_name = $query->row["name"];
        } else {
            $category_name = '';
        }
        return $category_name;

    }

    public function getModuleSettings($module_code) {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "module WHERE code = '" . $module_code . "'");

        if ($query->row) {
            return unserialize($query->row['setting']);
        } else {
            return array();
        }
    }

    public function getSeoUrl($product_id) {

        $query = $this->db->query("SELECT keyword as keyword FROM ".DB_PREFIX."url_alias WHERE query='product_id=".$product_id."' ");

        if ($query->num_rows) {
            $product_link = '/'.$query->row['keyword'];
        } else {
            $product_link = 'index.php?route=product/product&product_id='.$product_id;
        }
        return $product_link;
    }


}