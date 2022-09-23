<?php

class ControllerExtensionFeedGoogleSitemap extends Controller {
	public function index() {
		if ($this->config->get('google_sitemap_status')) {
			$output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';


			$this->load->model('catalog/product');
			$this->load->model('tool/image');

			$this->load->model('localisation/language');

			if (isset($this->request->post['language'])) {
				$code = $this->model_localisation_language->getLanguage($this->request->post['language']);
				$this->session->data['language'] = $code['code'];
			} else {
				$code['language_id'] = 2;
				$this->session->data['language'] = 'ru-ru';
			}

			$output .= '<url>
                            <loc>' . $this->url->link('common/home') . '</loc>
                            <lastmod>' . date('Y-m-d') . '</lastmod>
                            <changefreq>daily</changefreq>
                            <priority>1.0</priority>
                        </url>';

			$products = $this->model_catalog_product->getProductsForSiteMap($code['language_id']);

			foreach ($products as $product) {
					$output .= '<url>';
					$output .= '<loc>' . $this->url->link('product/product', 'product_id=' . $product['product_id']) . '</loc>';
					$output .= '<changefreq>monthly</changefreq>';
					$product['date_modified'] = $product['date_modified'] != '0000-00-00 00:00:00' ? $product['date_modified'] : $product['date_added'];
					$output .= '<lastmod>' . date('Y-m-d', strtotime($product['date_modified'])) . '</lastmod>';
					$output .= '<priority>0.8</priority>';
					$output .= '</url>' . PHP_EOL;
			}

			$this->load->model('catalog/category');

			$output .= $this->getCategories(0);

			$output .= '</urlset>';

			if (file_exists($this->session->data['language'] . '-' . 'sitemap.xml')){
				unlink($this->session->data['language'] . '-' . 'sitemap.xml');
			}

			file_put_contents($this->session->data['language'] . '-' . 'sitemap.xml', $output);
		}
	}

	protected function getCategories($parent_id, $current_path = '') {
		$output = '';

		$results = $this->model_catalog_category->getCategories($parent_id);

		foreach ($results as $result) {
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}

			$output .= '<url>';
			$output .= '<loc>' . $this->url->link('product/category', 'path=' . $new_path) . '</loc>';
			$output .= '<changefreq>daily</changefreq>';
			$output .= '<priority>0.9</priority>';
			$output .= '</url>' . PHP_EOL;

			$output .= $this->getCategories($result['category_id'], $new_path);
		}

		return $output;
	}
}
