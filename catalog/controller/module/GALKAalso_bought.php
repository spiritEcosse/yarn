<?php

class ControllerModuleGalkaAlsoBought extends Controller {
    private  static $count = 1;

	protected function index($setting) {
		$this->load->model('module/GALKAalso_bought');
		
		$this->totals($this->request->post, $setting);
		
      	$this->data['heading_title'] = $this->config->get('GALKAalso_bought_heading_title_' . $this->config->get('config_language_id'));
        $this->data['button_cart'] = $this->language->get('button_cart');
        $this->data['text_users_selected'] = $this->language->get('text_users_selected');

		$this->data['setting'] = $setting;
		$this->data['show_add_to_cart_button'] = $setting['button_cart'];
		$this->getText();
		$this->data['products'] = array();

		if (isset($this->request->get['product_id'])) {
			$data = array(
				'dc_period'            => $this->config->get('GALKAalso_bought_dc_period') * 60 * 60,
				'filter_product_id'    => $this->request->get['product_id'],
				'order_status_operand' => htmlspecialchars_decode($setting['order_status_operand']),
				'order_status_id'      => $setting['order_status_id'],
				'sort'  			   => $setting['sort'],
				'order' 			   => $setting['sort_type'],
				'start' 			   => 0,
				'limit' 			   => $setting['limit']
			);

			$product_data = $this->model_module_GALKAalso_bought->getAlsoBoughtProducts($data);
			$products = array();

			if ($product_data) {
				foreach ($product_data as $product) {
					$products[] = $product['product_id'];
				}
			}

			$this->data['products'] = $this->getDataProducts(array('products' => $products, 'setting' => $setting));
            $this->data['count'] = self::$count;
            self::$count++;
		}

		$this->fileRenderModule('/template/module/GALKAalso_bought.tpl');
	}
}
?>