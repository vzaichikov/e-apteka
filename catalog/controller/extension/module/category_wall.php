<?php
class ControllerExtensionModuleCategoryWall extends Controller {

    public function index() {
        $this->load->language('extension/module/category_wall');
        $this->load->model('catalog/category');

        $data['heading_title'] = $this->language->get('heading_title');

        $data['categories'] = array();

        $categories = $this->model_catalog_category->getCategories(0);

        $this->load->model('tool/image');

        foreach ($categories as $category) {

            $img_w = $this->config->get('category_wall_width');
            $img_h = $this->config->get('category_wall_height');

            if ($category['image']) {
                $image = $this->model_tool_image->resize($category['image'], $img_w, $img_h);
            } else {
                $image = $this->model_tool_image->resize('placeholder.png', $img_w, $img_h);
            }

            $data['categories'][] = array(
                'name' => $category['name'],
                'image' => $image,
                'href' => $this->url->link('product/category', 'path=' . $category['category_id'])
            );
        }

        return $this->load->view('extension/module/category_wall', $data);

    }
}