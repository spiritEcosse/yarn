<?php
class ControllerModuleFilter extends Controller {
    public function index($setting) {
        $this->language->load('module/filter');
        $this->load->model('catalog/filter');
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        // $this->load->model('tool/seo_url');

        $this->data['text_select_filter'] = $this->language->get('text_select_filter');

        if (isset($this->request->get['route'])) {
            if ($this->request->get['route'] == 'product/search' && !isset($this->request->get['filter_name'])) {
                return false;
            }

            if ($this->request->get['route'] == 'product/manufacturer' && !isset($this->request->get['manufacturer_id'])) {
                return false;
            }
        } else {
            return false;
        }

        $this->data['heading_title'] = $this->language->get('heading_title');

        $route = $this->request->get['route'];

        if (isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') {
            if (isset($this->request->get['product_id']) && !isset($this->request->get['path'])) {
                $category_id = $this->model_catalog_category->getCategroyByProduct($this->request->get['product_id']);

                $path = $this->model_catalog_category->treeCategory($category_id);
                $path = array_reverse($path);
                $path = implode('_', $path);

                $this->request->get['path'] = $path;
            }

            $route = 'product/category';
        }

        $data = $this->getDataOfGetQuery($this->request->get);

        $this->data['filter_values_id'] = array();
        $options_in_get = array();

        if ($data['filter']) {
            $matches = explode(';', $data['filter']);

            foreach ($matches as $key_value) {
                $data_filter = explode('=', $key_value);
                $options_in_get[] = $data_filter[0];

                foreach (explode(',', $data_filter[1]) as $value_id) {
                    $this->data['filter_values_id'][] = $value_id;
                }
            }
        }

        $this->data['category_options'] = array();

        $path_specify = '';

        if ($this->request->get['route'] == 'product/category' && isset($this->request->get['path'])) {
            $path_specify = '&path=' . $this->request->get['path'];
        } else if ($this->request->get['route'] == 'product/manufacturer' && isset($this->request->get['manufacturer_id'])) {
            $path_specify = '&manufacturer_id=' . $this->request->get['manufacturer_id'];
        } else if ($this->request->get['route'] == 'product/search' && isset($this->request->get['filter_name'])) {
            $path_specify = '&filter_name=' . $this->request->get['filter_name'];
        } elseif ($this->request->get['route'] == 'product/product') {
            $path_specify = '&path=' . $this->request->get['path'];
        }

        if (isset($this->request->get['min_price'])) {
            $path_specify .= '&min_price=' . $this->request->get['min_price'];
        }

        if (isset($this->request->get['max_price'])) {
            $path_specify .= '&max_price=' . $this->request->get['max_price'];
        }

        if (isset($this->request->get['filter_tag'])) {
            $path_specify .= '&filter_tag=' . $this->request->get['filter_tag'];
        }

        if (isset($this->request->get['filter_description'])) {
            $path_specify .= '&filter_description=' . $this->request->get['filter_description'];
        }

        if (isset($this->request->get['filter_category_id'])) {
            $path_specify .= '&filter_category_id=' . $this->request->get['filter_category_id'];
        }

        if (isset($this->request->get['filter_sub_category'])) {
            $path_specify .= '&filter_sub_category=' . $this->request->get['filter_sub_category'];
        }

        if (isset($this->request->get['sort'])) {
            $path_specify .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $path_specify .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['limit'])) {
            $path_specify .= '&limit=' . $this->request->get['limit'];
        }

        if (isset($this->request->get['filterpro_special'])) {
            $path_specify .= '&filterpro_special=' . $this->request->get['filterpro_special'];
        }

        $products_total = $this->model_catalog_product->getTotalProducts($data, $data['filter']);
        $results = $this->model_catalog_filter->filterGetOption($data);

        foreach ($results as $option) {
            in_array($option['option_id'], $options_in_get) ? $is_this_opt = true : $is_this_opt = false;

            $values = array();
            $values_results = $this->model_catalog_filter->filterGetOptionValue($data, $option['option_id']);
            $active = false;

            foreach ($values_results as $value) {
                $filter_params = $this->getFilterURLParams($data['filter'], $value['option_id'], $value['value_id'], 'filter');
                $products = $this->model_catalog_product->getTotalProducts($data, str_replace('&filter=', '', $filter_params));
                $products_count = ($is_this_opt ? ($products ? (($products - $products_total) != 0 ? '+' . ($products - $products_total) : 0) : 0) : $products);

                if (isset($this->request->get['route'])) {
                    $filter_option_value = str_replace('&filter=', '', $filter_params);

                    if ($filter_option_value) {
                        $filter_option_value = '&filter=' . $filter_option_value;
                    }

                    $href = $this->url->link($route, $path_specify . $filter_option_value);

                    if (in_array($value['value_id'], $this->data['filter_values_id'])) {
                        $active = true;
                    }

                    $values[] = array(
                        'value_id'      => $value['value_id'],
                        'name'          => $value['name'],
                        'href'          => $href,
                        'products'      => $products_count,
                    );
                }
            }

            if (count($values) > 0) {
                $this->data['category_options'][] = array(
                    'option_id' => $option['option_id'],
                    'name'      => $option['name'],
                    'values'    => $values,
                    'active'    => $active,
                );
            }
        }

        $this->id = 'filter';
        $this->fileRenderModule('/template/module/filter.tpl');
    }
}
?>