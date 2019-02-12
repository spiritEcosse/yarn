<?php
class ControllerFeedGoogleSitemap extends Controller {
	public function index() {
		if ($this->config->get('google_sitemap_status')) {
            $this->load->model('catalog/filter');
            $this->load->model('catalog/category');
            $this->load->model('catalog/product');
            $this->load->model('catalog/filter');

            $output  = '<?xml version="1.0" encoding="UTF-8"?>';
			$output .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

			$this->load->model('catalog/product');

			$products = $this->model_catalog_product->getProducts();

			foreach ($products as $product) {
				$output .= '<url>';
				$output .= '<loc>' . str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('product/product', 'product_id=' . $product['product_id']))) . '</loc>';
				$output .= '<lastmod>' . substr(max($product['date_added'], $product['date_modified']), 0, 10) . '</lastmod>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>1.0</priority>';
				$output .= '</url>';
			}

			$output .= $this->getCategories(0);

			$this->load->model('catalog/manufacturer');
            $this->load->model('catalog/filter');

			$manufacturers = $this->model_catalog_manufacturer->getManufacturers();

			foreach ($manufacturers as $manufacturer) {
				$output .= '<url>';
				$output .= '<loc>' . str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('product/manufacturer', 'manufacturer_id=' . $manufacturer['manufacturer_id']))) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.7</priority>';
				$output .= '</url>';

                $setting = array();
                $setting['filter_manufacturer_id'] = $manufacturer['manufacturer_id'];
                $setting['filter'] = 0;
                $setting['special'] = 0;
                $setting['innertable'] = true;
                $results = $this->model_catalog_filter->filterGetOption($setting);

                $options_in_get = array();
                $products_total = $this->model_catalog_product->getTotalProducts($setting, $setting['filter']);

                foreach ($results as $option) {
                    in_array($option['option_id'], $options_in_get) ? $is_this_opt = true : $is_this_opt = false;

                    $values_results = $this->model_catalog_filter->filterGetOptionValue($setting, $option['option_id']);

                    foreach ($values_results as $value) {
                        $filter_params = $this->getFilterURLParams($setting['filter'], $value['option_id'], $value['value_id'], 'filter');
                        $products = $this->model_catalog_product->getTotalProducts($setting, str_replace('&filter=', '', $filter_params));
                        $products_count = ($is_this_opt ? ($products ? (($products - $products_total) != 0 ? '+' . ($products - $products_total) : 0) : 0) : $products);

                        if (($products_count > 0 && $is_this_opt == false) || $is_this_opt == true) {
                            $filter_option_value = str_replace('&filter=', '', $filter_params);

                            if ($filter_option_value) {
                                $filter_option_value = '&filter=' . $filter_option_value;
                            }

                            $output .= '<url>';
                            $output .= '<loc>' . str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('product/manufacturer', 'manufacturer_id=' . $manufacturer['manufacturer_id'] . $filter_option_value))) . '</loc>';

                            if (isset($manufacturer['date_added']) && isset($manufacturer['date_modified'])) {
                                $output .= '<lastmod>' . substr(max($manufacturer['date_added'], $manufacturer['date_modified']), 0, 10) . '</lastmod>';
                            }

                            $output .= '<changefreq>weekly</changefreq>';
                            $output .= '<priority>0.7</priority>';
                            $output .= '</url>';
                        }
                    }
                }
			}

			$this->load->model('catalog/information');

			$informations = $this->model_catalog_information->getInformations();

			foreach ($informations as $information) {
				$output .= '<url>';
				$output .= '<loc>' . str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('information/information', 'information_id=' . $information['information_id']))) . '</loc>';
				$output .= '<changefreq>weekly</changefreq>';
				$output .= '<priority>0.5</priority>';
				$output .= '</url>';
			}

			$output .= '</urlset>';

			$this->response->addHeader('Content-Type: application/xml');
			$this->response->setOutput($output);
		}
	}

	protected function getCategories($parent_id, $current_path = '') {
        $this->load->model('catalog/filter');
        $output = '';

		$results = $this->model_catalog_category->getCategories($parent_id);

		foreach ($results as $result) {
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}

			$output .= '<url>';
			$output .= '<loc>' . str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $new_path))) . '</loc>';
			$output .= '<lastmod>' . substr(max($result['date_added'], $result['date_modified']), 0, 10) . '</lastmod>';
			$output .= '<changefreq>weekly</changefreq>';
			$output .= '<priority>0.7</priority>';
			$output .= '</url>';

            $setting = array();
            $setting['filter_category_id'] = $result['category_id'];
            $setting['filter'] = 0;
            $setting['special'] = 0;
            $setting['innertable'] = true;
            $results = $this->model_catalog_filter->filterGetOption($setting);

            $options_in_get = array();
            $products_total = $this->model_catalog_product->getTotalProducts($setting, $setting['filter']);

            foreach ($results as $option) {
                in_array($option['option_id'], $options_in_get) ? $is_this_opt = true : $is_this_opt = false;

                $values_results = $this->model_catalog_filter->filterGetOptionValue($setting, $option['option_id']);

                foreach ($values_results as $value) {
                    $filter_params = $this->getFilterURLParams($setting['filter'], $value['option_id'], $value['value_id'], 'filter');
                    $products = $this->model_catalog_product->getTotalProducts($setting, str_replace('&filter=', '', $filter_params));
                    $products_count = ($is_this_opt ? ($products ? (($products - $products_total) != 0 ? '+' . ($products - $products_total) : 0) : 0) : $products);

                    if (($products_count > 0 && $is_this_opt == false) || $is_this_opt == true) {
                        $filter_option_value = str_replace('&filter=', '', $filter_params);

                        if ($filter_option_value) {
                            $filter_option_value = '&filter=' . $filter_option_value;
                        }

                        $output .= '<url>';
                        $output .= '<loc>' . str_replace('&', '&amp;', str_replace('&amp;', '&', $this->url->link('product/category', 'path=' . $new_path . $filter_option_value))) . '</loc>';
                        $output .= '<lastmod>' . substr(max($result['date_added'], $result['date_modified']), 0, 10) . '</lastmod>';
                        $output .= '<changefreq>weekly</changefreq>';
                        $output .= '<priority>0.7</priority>';
                        $output .= '</url>';
                    }
                }
            }

            $output .= $this->getCategories($result['category_id'], $new_path);

        }

		return $output;
	}
}
?>