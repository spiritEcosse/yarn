<?php 
class ControllerAccountInfoCart extends Controller {
	public function index($setting) {
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->load->model('tool/image');
        $this->language->load('account/infocart');

        $this->data['text_link'] = $this->language->get('text_new_link');
        $this->data['text_date_added'] = $this->language->get('text_new_date_added');
        $this->data['text_email'] = $this->language->get('text_new_email');
        $this->data['text_model'] = $this->language->get('text_model');
        $this->data['text_telephone'] = $this->language->get('text_new_telephone');
        $this->data['text_ip'] = $this->language->get('text_new_ip');
        $this->data['text_product'] = $this->language->get('text_new_product');
        $this->data['text_quantity'] = $this->language->get('text_new_quantity');
        $this->data['text_price'] = $this->language->get('text_new_price');
        $this->data['text_total'] = $this->language->get('text_new_total');
        $this->data['text_footer'] = $this->language->get('text_new_footer');
        $this->data['text_powered'] = $this->language->get('text_new_powered');
        $this->data['store_name'] = $this->config->get('config_name');

        $this->data['text_info_cart'] = sprintf($this->language->get('text_info_cart'), $setting['date_add_cart']);

        if ($this->config->get('text_info_cart')) {
            $this->data['text_info_cart'] .= $this->config->get('text_info_cart');
        }

        $this->data['text_info_cart'] = html_entity_decode($this->data['text_info_cart'], ENT_QUOTES, 'UTF-8');

        $this->data['logo'] = HTTP_IMAGE . $this->config->get('config_logo');
        $this->data['store_url'] = HTTP_SERVER;
        $this->data['link'] = HTTP_SERVER . '/index.php?route=checkout/cart';

        if ($setting['valid_date_add_cart'] == true) {
            $this->data['first_name'] = $setting['first_name'];
            $this->data['last_name'] = $setting['last_name'];
            $sql = "UPDATE " . DB_PREFIX . "customer SET date_add_cart = '%s' WHERE customer_id = '%d' ";
            $this->db->query(sprintf($sql, date('Y-m-d H:i:s'), $setting['customer_id']));
        } else {
            return false;
        }

        $this->session->data['cart'] = array();

        foreach ($setting['cart'] as $key => $value) {
            $this->session->data['cart'][$key] = $value;
        }

        $this->data['products'] = array();

        foreach ($this->cart->getProducts() as $product) {
            $option_data = array();
            $image = false;
            $category_id = false;
            $category_path = false;

            foreach ($product['option'] as $option) {
                if ($option['type'] != 'file') {
                    $value = $option['option_value'];
                } else {
                    $value = $this->encryption->decrypt($option['option_value']);
                }

                $option_data[] = array(
                    'name' => $option['name'],
                    'value' => $value
                );
            }

            if ($product['image']) {
                $image = $this->model_tool_image->resize($product['image'], $this->config->get('config_image_cart_width'), $this->config->get('config_image_cart_height'));
            }

            if ( $product['product_id'] ) {
                $this->load->model('catalog/category');
                $category_id = $this->model_catalog_category->getCategroyByProduct($product['product_id']);
            }

            if ( $category_id ) {
                $category_path = $this->model_catalog_category->treeCategory($category_id);
            }

            if ( $category_path ) {
                $category_path = array_reverse($category_path);
                $category_path = implode('_', $category_path);
            }

            $old_price = $this->currency->format($product['old_price'], $product['code'], 1);
            $old_price_total = $this->currency->format($product['old_price_total'], $product['code'], 1);

            $this->data['products'][] = array(
                'product_id' => $product['product_id'],
                'href'     => $this->url->link('product/product', '&path=' . $category_path . '&product_id=' . $product['product_id']),
                'name'       => $product['name'],
                'image'      => $image,
                'option'     => $option_data,
                'old_price' => $old_price,
                'diff_price' => $product['diff_price'],
                'gift'     => $product['gift'],
                'old_price_total' => $old_price_total,
                'sale'      => $product['sale'],
                'download'   => $product['download'],
                'prefix_name' => $product['prefix_name'],
                'product_price'	=> $product['product_price'],
                'quantity'   => $product['quantity'],
                'subtract'   => $product['subtract'],
                'code'		 => $product['code'],
                'value'		 => sprintf($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax'))),
                'total_value'=> sprintf($this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('config_tax'))),
                'price'      => $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $product['code'], 1),
                'total'      => $this->currency->format($this->tax->calculate($product['total'], $product['tax_class_id'], $this->config->get('config_tax')), $product['code'], 1),
                'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
                'reward'     => $product['reward']
            );
        }

        if (empty($this->data['products'])) {
            return false;
        }

        $this->load->model('setting/extension');

        ////////totals data
        $total_data = array();
        $total = 0;
        $taxes = $this->cart->getTaxes();
        $sort_order = array();

        $results = $this->model_setting_extension->getExtensions('total');

        foreach($results as $key => $value) {
            $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
        }

        array_multisort($sort_order, SORT_ASC, $results);

        foreach($results as $result) {
            if($this->config->get($result['code'] . '_status')) {
                $this->load->model('total/' . $result['code']);

                $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
            }
        }

        $sort_order = array();
        foreach($total_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $total_data);

        $this->data['totals'] = $total_data;
        $this->cart->clear();
        $this->fileRenderModule('/template/account/infocart.tpl');
  	}
}

?>