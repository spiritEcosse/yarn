<?php  
class ControllerProductCompare extends Controller {
	public function index() { 
		$this->language->load('product/compare');
		
		$this->totals($this->request->post);

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}	

		if (isset($this->request->get['remove'])) {
			$key = array_search($this->request->get['remove'], $this->session->data['compare']);
			
			if ($key !== false) {
				unset($this->session->data['compare'][$key]);
			}
		
			$this->session->data['success'] = $this->language->get('text_remove');
			$this->redirect($this->url->link('product/compare'));
		}
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('product/compare'),			
			'separator' => $this->language->get('text_separator')
		);	
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_product'] = $this->language->get('text_product');
		$this->data['text_name'] = $this->language->get('text_name');
		$this->data['text_image'] = $this->language->get('text_image');
		$this->data['text_availability'] = $this->language->get('text_availability');
        $this->data['text_rating'] = $this->language->get('text_rating');
        $this->data['text_rating'] = $this->language->get('text_rating');

		$this->data['text_summary'] = $this->language->get('text_summary');
		$this->data['text_weight'] = $this->language->get('text_weight');
		$this->data['text_dimension'] = $this->language->get('text_dimension');
        $this->data['text_or'] = $this->language->get('text_or');

		$this->data['button_remove'] = $this->language->get('button_remove');

		$this->getText();

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$setting = array(
			'image_width' 	=> $this->config->get('config_image_compare_width'),
			'image_height'	=> $this->config->get('config_image_compare_height'),
			'weight' 		=> true,
			'length' 		=> true,
			'width' 		=> true,
			'height' 		=> true,
			'route'			=> 'product/compare',
			'class'			=> 'compare'
			);

		$data = array(
			'products'	=> $this->session->data['compare'],
			'setting'	=> $setting
		);

		$this->data['products'] = $this->getDataProducts($data);
        $this->data['filters'] = array();

        foreach ($this->data['products'] as $product) {
            if (isset($product['filters'])) {
                foreach ($product['filters'] as $filter) {
                    if (!in_array($filter['option_name'], $this->data['filters'])) {
                        $this->data['filters'][$filter['option_id']] = $filter['option_name'];
                    }
                }
            }
        }

        $this->data['attribute_groups'] = array();
		$file = '/template/product/compare.tpl';
		$this->fileRender($file);
  	}
	
	public function add() {
		$this->language->load('product/compare');
		$this->language->load('module/fastorder');
		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		$json = array();

		if (!isset($this->session->data['compare'])) {
			$this->session->data['compare'] = array();
		}
				
		if (isset($this->request->post['product_id'])) {
			$product_id = $this->request->post['product_id'];
		} else {
			$product_id = 0;
		}
		
		
		$product_info = $this->model_catalog_product->getProduct($product_id);
		
		if ($product_info) {
			if (!in_array($this->request->post['product_id'], $this->session->data['compare'])) {	
				if (count($this->session->data['compare']) >= 4) {
					array_shift($this->session->data['compare']);
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
                    
                // $this->url->link('product/product', 'product_id=' . $this->request->post['product_id'])
				$this->session->data['compare'][] = $this->request->post['product_id'];
			}
			
            $json['success'] = sprintf($this->language->get('text_success'), $this->url->link('product/product', '&path=' . $category_path . '&product_id=' . $this->request->post['product_id']), $product_info['name'], $this->url->link('product/compare'));
            $json['total'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		}

		$this->response->setOutput(json_encode($json));
	}
}
?>