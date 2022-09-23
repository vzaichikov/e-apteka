<?php class ControllerExtensionFeedTurboRSS extends Controller {
	private $from_charset = 'utf-8';
	public function index() {
		if ($this->config->get('turbo_rss_status')) {

			$this->load->model('catalog/product');
			$this->load->model('catalog/category');
			$this->load->model('localisation/currency');
			$this->load->model('tool/image');
			$this->load->language('extension/feed/turbo_rss');

			$total =  $this->model_catalog_product->getTotalProducts();
			$limit = $this->config->get('turbo_rss_limit') ? $this->config->get('turbo_rss_limit') : 500;
			$parts = ceil($total / $limit) - 1;

			$show_price = $this->config->get('turbo_rss_show_price');
			$include_tax = $this->config->get('turbo_rss_include_tax');
			$show_image = $this->config->get('turbo_rss_show_image');


			if ($show_image) {
				$image_width = $this->config->get('turbo_rss_image_width') ? $this->config->get('turbo_rss_image_width') : 100;
				$image_height = $this->config->get('turbo_rss_image_height') ? $this->config->get('turbo_rss_image_height') : 100;
			}

			$filter = array(
				'start' => ($this->request->get['part'] && $parts >= $this->request->get['part'] )? $this->request->get['part'] * $limit : 0,
				'limit' => $limit
			);
			$products = $this->model_catalog_product->getProducts($filter);

			if (isset($this->request->get['currency'])) {
				$currency = $this->request->get['currency'];
			} else {
				$currency = $this->session->data['currency'];
			}

			$author = $this->prepareField($this->config->get('config_owner'));
			$output = '<?xml version="1.0" encoding="windows-1251"?>';
			$output .= '<rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" xmlns:turbo="http://turbo.yandex.ru" version="2.0">';
			$output .= '<channel>';
			
			$output .= '<title>' . $this->prepareField($this->config->get('config_name')) . '</title>';
			$output .= '<link>' . $this->prepareLink(HTTPS_SERVER) . '</link>';
			$output .= '<description>' . $this->prepareField($this->config->get('config_meta_description')) . '</description>';
			
			foreach ($products as $product) {

					$categories_id = $this->model_catalog_product->getCategories($product['product_id']);
					if (!empty($categories_id)) {
						$category_id = $categories_id[0]['category_id'];
						$categories = $this->model_catalog_category->getCategory($category_id);
						if (!empty($categories)) {
							$category = $this->prepareField($categories['name']);
						}
					} else {
						$category = '';
					}

					$title = $this->prepareField($product['name']);

					$link = $this->prepareLink($this->url->link('product/product', 'product_id=' . $product['product_id'], true));

					if ($show_image && $product['image'] != '') {
						$image_url = $this->prepareLink($this->model_tool_image->resize($product['image'], $image_width, $image_height));
					}

					if ($show_price) {
						if ($include_tax) {
							if ((float) $product['special']) {
								$price = $this->currency->format($this->tax->calculate($product['special'], $product['tax_class_id']), $currency, FALSE, TRUE);
							} else {
								$price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id']), $currency, FALSE, TRUE);
							}
						} else {
							if ((float) $product['special']) {
								$price = $this->currency->format($product['special'], $currency, FALSE, TRUE);
							} else {
								$price = $this->currency->format($product['price'], $currency, FALSE, TRUE);
							}
						}
						
					}

					$description = "";
					$description .= '<header>';
					if (isset($image_url)) {
                        $description .= '<figure><img src="' . $image_url . '"></figure>';
                    }
                    $description .= '<h1>'. $title .'</h1>';
                    $description .= '</header>';
					if ($show_price) { $description .= '<p>' . $this->prepareField($this->language->get('text_price')) . ' ' . $this->prepareField($price) . '</p>'; };
					if ($product['description']) {
						$description .= $this->prepareField($product['description']);
					}

					$output .= '<item turbo="true">';
						$output .= '<title>' . $title . '</title>';
						$output .= '<link>' . $link . '</link>';
						$output .= '<author>' . $author . '</author>';
						if ($category) {
		            		$output .= '<category>' . $category . '</category>';
		            	}
						$output .= '<pubDate>' . date(DATE_RSS, strtotime($product['date_added'])) . '</pubDate>';
						$output .= '<turbo:content><![CDATA[' . $description . ']]></turbo:content>';
					$output .= '</item>';
			
			}

			$output .= '</channel>';
			$output .= '</rss>';

			$this->response->addHeader('Content-Type: application/rss+xml');
			$this->response->setOutput($output);
		}
	}

	private function prepareField($field) {
		if (!is_array($field)){
			$field = htmlspecialchars_decode($field);
			/*
			$field = strip_tags($field);
			$from = array('"', '&', '>', '<', '\'');
			$to = array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;');
			$field = str_replace($from, $to, $field);
			*/
			$field = str_replace('&', '&amp;', $field);
			if ($this->from_charset != 'windows-1251') {
				$field = $this->utf8_to_cp1251($field);	
			}
			$field = preg_replace('#[\x00-\x08\x0B-\x0C\x0E-\x1F]+#is', ' ', $field);

			return trim($field);
		} else {
			return $field;
		}
	}

	private function prepareLink($field) {
		if (!is_array($field)){
			$field = htmlspecialchars_decode($field);
			$field = strip_tags($field);
			$from = array('"', '&', '>', '<', '\'');
			$to = array('&quot;', '&amp;', '&gt;', '&lt;', '&apos;');
			$field = str_replace($from, $to, $field);
			if ($this->from_charset != 'windows-1251') {
				$field = $this->utf8_to_cp1251($field);	
			}
			$field = preg_replace('#[\x00-\x08\x0B-\x0C\x0E-\x1F]+#is', ' ', $field);

			return trim($field);
		} else {
			return $field;
		}
	}

	private function utf8_to_cp1251($s) {

		$tbl = array(
			0x0402 => "\x80",
			0x0403 => "\x81",
			0x201A => "\x82",
			0x0453 => "\x83",
			0x201E => "\x84",
			0x2026 => "\x85",
			0x2020 => "\x86",
			0x2021 => "\x87",
			0x20AC => "\x88",
			0x2030 => "\x89",
			0x0409 => "\x8A",
			0x2039 => "\x8B",
			0x040A => "\x8C",
			0x040C => "\x8D",
			0x040B => "\x8E",
			0x040F => "\x8F",
			0x0452 => "\x90",
			0x2018 => "\x91",
			0x2019 => "\x92",
			0x201C => "\x93",
			0x201D => "\x94",
			0x2022 => "\x95",
			0x2013 => "\x96",
			0x2014 => "\x97",
			0x2122 => "\x99",
			0x0459 => "\x9A",
			0x203A => "\x9B",
			0x045A => "\x9C",
			0x045C => "\x9D",
			0x045B => "\x9E",
			0x045F => "\x9F",
			0x00A0 => "\xA0",
			0x040E => "\xA1",
			0x045E => "\xA2",
			0x0408 => "\xA3",
			0x00A4 => "\xA4",
			0x0490 => "\xA5",
			0x00A6 => "\xA6",
			0x00A7 => "\xA7",
			0x0401 => "\xA8",
			0x00A9 => "\xA9",
			0x0404 => "\xAA",
			0x00AB => "\xAB",
			0x00AC => "\xAC",
			0x00AD => "\xAD",
			0x00AE => "\xAE",
			0x0407 => "\xAF",
			0x00B0 => "\xB0",
			0x00B1 => "\xB1",
			0x0406 => "\xB2",
			0x0456 => "\xB3",
			0x0491 => "\xB4",
			0x00B5 => "\xB5",
			0x00B6 => "\xB6",
			0x00B7 => "\xB7",
			0x0451 => "\xB8",
			0x2116 => "\xB9",
			0x0454 => "\xBA",
			0x00BB => "\xBB",
			0x0458 => "\xBC",
			0x0405 => "\xBD",
			0x0455 => "\xBE",
			0x0457 => "\xBF",
			0x0410 => "\xC0",
			0x0411 => "\xC1",
			0x0412 => "\xC2",
			0x0413 => "\xC3",
			0x0414 => "\xC4",
			0x0415 => "\xC5",
			0x0416 => "\xC6",
			0x0417 => "\xC7",
			0x0418 => "\xC8",
			0x0419 => "\xC9",
			0x041A => "\xCA",
			0x041B => "\xCB",
			0x041C => "\xCC",
			0x041D => "\xCD",
			0x041E => "\xCE",
			0x041F => "\xCF",
			0x0420 => "\xD0",
			0x0421 => "\xD1",
			0x0422 => "\xD2",
			0x0423 => "\xD3",
			0x0424 => "\xD4",
			0x0425 => "\xD5",
			0x0426 => "\xD6",
			0x0427 => "\xD7",
			0x0428 => "\xD8",
			0x0429 => "\xD9",
			0x042A => "\xDA",
			0x042B => "\xDB",
			0x042C => "\xDC",
			0x042D => "\xDD",
			0x042E => "\xDE",
			0x042F => "\xDF",
			0x0430 => "\xE0",
			0x0431 => "\xE1",
			0x0432 => "\xE2",
			0x0433 => "\xE3",
			0x0434 => "\xE4",
			0x0435 => "\xE5",
			0x0436 => "\xE6",
			0x0437 => "\xE7",
			0x0438 => "\xE8",
			0x0439 => "\xE9",
			0x043A => "\xEA",
			0x043B => "\xEB",
			0x043C => "\xEC",
			0x043D => "\xED",
			0x043E => "\xEE",
			0x043F => "\xEF",
			0x0440 => "\xF0",
			0x0441 => "\xF1",
			0x0442 => "\xF2",
			0x0443 => "\xF3",
			0x0444 => "\xF4",
			0x0445 => "\xF5",
			0x0446 => "\xF6",
			0x0447 => "\xF7",
			0x0448 => "\xF8",
			0x0449 => "\xF9",
			0x044A => "\xFA",
			0x044B => "\xFB",
			0x044C => "\xFC",
			0x044D => "\xFD",
			0x044E => "\xFE",
			0x044F => "\xFF",
		);
				$uc = 0;
				$bits = 0;
				$r = "";
				$l = strlen($s);
				for($i = 0;  $i < $l; $i++) {
				$c = $s{$i};
				$b = ord($c);
				if($b & 0x80) {
				if($b & 0x40) {
				if($b & 0x20) {
				$uc = ($b & 0x0F) << 12;
				$bits = 12;
				}
				else {
				$uc = ($b & 0x1F) << 6;
				$bits = 6;
				}
				}
				else {
				$bits -= 6;
				if($bits) {
				$uc |= ($b & 0x3F) << $bits;
				}
				else {
				$uc |= $b & 0x3F;
				if($cc = @$tbl[$uc]) {
				$r .= $cc;
				}
				else {
				$r .= '?';
				}
				}
				}
				}
				else {
				$r .= $c;
				}
				}
				return $r;
	}
}