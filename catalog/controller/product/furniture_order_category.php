<?php 
class ControllerProductFurnitureOrderCategory extends Controller {  
	public function index() { 
		$this->language->load('product/furniture_order_category');
		$this->language->load('module/fastorder');
		$this->load->model('catalog/furniture_order_category');
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image'); 
		
		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
       		'separator' => false
   		);	
		
		if (isset($this->request->get['furniture_order_category'])) {
			$path = '';
			
			$parts = explode('_', (string)$this->request->get['furniture_order_category']);
		
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				
				$furniture_order_category_info = $this->model_catalog_furniture_order_category->getCategory($path_id);

				if ($furniture_order_category_info) {
	       			$this->data['breadcrumbs'][] = array(
   	    				'text'      => $furniture_order_category_info['name'],
						'href'      => $this->url->link('product/furniture_order_category', 'furniture_order_category=' . $path),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}
			
			$furniture_order_category_id = array_pop($parts);
		} else {
			$furniture_order_category_id = 0;
		}
		
		$furniture_order_category_info = $this->model_catalog_furniture_order_category->getCategory($furniture_order_category_id);
	
		if ($furniture_order_category_info) {
			if ($furniture_order_category_info['seo_title']) {
		  		$this->document->setTitle($furniture_order_category_info['seo_title']);
			} else {
		  		$this->document->setTitle($furniture_order_category_info['name']);
			}

			$this->document->setDescription($furniture_order_category_info['meta_description']);
			$this->document->setKeywords($furniture_order_category_info['meta_keyword']);
			
			$this->data['seo_h1'] = $furniture_order_category_info['seo_h1'];

			$this->data['heading_title'] = $furniture_order_category_info['name'];
			
			if ($furniture_order_category_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($furniture_order_category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			} else {
				$this->data['thumb'] = '';
			}

			$this->data['images'] = array();
			
			$results = $this->model_catalog_furniture_order_category->getCategoryImages(
				$furniture_order_category_id);
			
			foreach ($results as $result) {
				$this->data['images'][] = array(
					'popup' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_popup_width'), $this->config->get('config_image_popup_height')),
					'thumb' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_additional_width'), $this->config->get('config_image_additional_height'))
				);
			}
			
			$this->data['description'] = html_entity_decode($furniture_order_category_info['description'], ENT_QUOTES, 'UTF-8');
			
			$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/furniture_order_category.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/furniture_order_category.tpl';
			} else {
				$this->template = 'default/template/product/furniture_order_category.tpl';
			}										
    	} else {
			$url = '';
			
			if (isset($this->request->get['furniture_order_category'])) {
				$url .= '&path=' . $this->request->get['furniture_order_category'];
			}
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/furniture_order_category', $url),
				'separator' => $this->language->get('text_separator')
			);
			
			$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');

      		$this->data['continue'] = $this->url->link('common/home');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
			}
		}

		$this->children = array(
			'common/furniture_order_column_left',
			'common/furniture_order_footer',
			'common/furniture_order_header'
		);
				
		$this->response->setOutput($this->render());
  	}
}
?>