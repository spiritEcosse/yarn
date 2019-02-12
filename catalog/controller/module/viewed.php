<?php
class ControllerModuleViewed extends Controller {
	protected function index($setting) {
        $this->language->load('module/viewed');
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->getText();
        $this->data['setting'] = $setting;
        $this->totals($this->request->post, $setting);
        $this->data['products'] = array();

        $viewed_products = array();
        
        if (isset($this->request->cookie['viewed'])) {
            $viewed_products = explode(',', $this->request->cookie['viewed']);
        } else if (isset($this->session->data['viewed'])) {
      		$viewed_products = $this->session->data['viewed'];
    	}
        
        if (isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') {
            $product_id = $this->request->get['product_id'];
            $viewed_products = array_diff($viewed_products, array($product_id));
            array_unshift($viewed_products, $product_id);
            setcookie('viewed', implode(',',$viewed_products), time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
        
            if (!isset($this->session->data['viewed']) || $this->session->data['viewed'] != $viewed_products) {
          		$this->session->data['viewed'] = $viewed_products;
        	}
        } 
        
        $show_on_product = $this->config->get('show_on_product');
        
        if (isset($this->request->get['route']) && $this->request->get['route'] == 'product/product' && (!isset($show_on_product) || !$show_on_product)) {
            return;
        }

        $viewed_count = $this->config->get('viewed_count');
        $products = array();
            
        if (isset($viewed_count) && $viewed_count > 0) {
            for ($i = 0; $i < $viewed_count; $i++) {
                $key = isset($product_id) ? $i + 1 : $i;
                
                if (isset($viewed_products[$key])) {
                    $products[] = $viewed_products[$key];
                }
            }
        }

        $data = array(
            'products'	=> $products,
            'setting'	=> $setting
        );

        $this->data['products'] = $this->getDataProducts($data);
        $this->fileRenderModule('/template/module/viewed.tpl');
	}
}
?>