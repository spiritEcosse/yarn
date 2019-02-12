<?php 
class ControllerAccountWishList extends Controller {
	public function index() {
    	if (!$this->customer->isLogged()) {
	  		$this->session->data['redirect'] = $this->url->link('account/wishlist', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL')); 
    	}    	
		
		$this->language->load('account/wishlist');
		$this->load->model('catalog/product');
		$this->load->model('tool/image');
		
		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}
		
		if (isset($this->request->get['remove'])) {
			$key = array_search($this->request->get['remove'], $this->session->data['wishlist']);
			
			if ($key !== false) {
				unset($this->session->data['wishlist'][$key]);
			}
		
			$this->session->data['success'] = $this->language->get('text_remove');
			$this->redirect($this->url->link('account/wishlist'));
		}
						
		$this->document->setTitle($this->language->get('heading_title'));	
      	
		$this->breadcrumbs();

      	$this->data['breadcrumbs'][] = array(       	
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);

      	$this->data['breadcrumbs'][] = array(       	
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/wishlist'),
        	'separator' => $this->language->get('text_separator')
      	);
      	
		$this->data['heading_title'] = $this->language->get('heading_title');	
		
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_stock'] = $this->language->get('column_stock');
		$this->data['column_price'] = $this->language->get('column_price');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['button_remove'] = $this->language->get('button_remove');
		$this->getText();

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$setting = array(
			'image_width' 	=> $this->config->get('config_image_wishlist_width'),
			'image_height'	=> $this->config->get('config_image_wishlist_height'),
			'route'			=> 'account/wishlist',
			'class'			=> 'wishlist'
			);

		$data = array(
			'products'	=> $this->session->data['wishlist'],
			'setting'	=> $setting
		);

		$this->data['products'] = $this->getDataProducts($data);
		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		
		$this->fileRender('/template/account/wishlist.tpl');
	}
	
	public function add() {
		$this->language->load('account/wishlist');
		$this->load->model('catalog/product');
        $this->load->model('catalog/category');
		
		$json = array();

		if (!isset($this->session->data['wishlist'])) {
			$this->session->data['wishlist'] = array();
		}
				
		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {
			if (!in_array($this->request->post['product_id'], $this->session->data['wishlist'])) {	
				$this->session->data['wishlist'][] = $this->request->post['product_id'];
			}
			
            if ( $this->request->post['product_id'] ) {
                $category_id = $this->model_catalog_category->getCategroyByProduct($this->request->post['product_id']);
            } else {
                $category_id = false;
            }

            if ( $category_id ) {
                $category_path = $this->model_catalog_category->treeCategory($category_id);
            } else {
                $category_path = false;
            }

            if ( $category_path ) {
                $category_path = array_reverse($category_path);
                $category_path = implode('_', $category_path);
            }

			if ($this->customer->isLogged()) {
				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', '&path=' . $category_path . '&product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));	
				$json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', 'product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));	
			} else {
				$json['success'] = sprintf($this->language->get('text_login'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'), $this->url->link('product/product', '&path=' . $category_path . '&product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('account/wishlist'));				
			}
			
			$json['total'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}	
		
		$this->response->setOutput(json_encode($json));
	}	
}
?>