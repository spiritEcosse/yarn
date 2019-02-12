<?php 
class ControllerProductManufacturer extends Controller {  
	public function index() {
		if (isset($this->request->get['manufacturer_id'])) {
			$this->product();
		} else {
			$this->language->load('product/manufacturer');
			$this->load->model('catalog/manufacturer');
			$this->load->model('tool/image');		
			
			$this->document->setTitle($this->language->get('heading_title'));
			
			$this->data['heading_title'] = $this->language->get('heading_title');
			$this->data['text_index'] = $this->language->get('text_index');
			$this->data['text_empty'] = $this->language->get('text_empty');
			$this->data['button_continue'] = $this->language->get('button_continue');
			
			$this->breadcrumbs();
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_brand'),
				'href'      => $this->url->link('product/manufacturer'),
				'separator' => $this->language->get('text_separator')
			);
			
			$this->data['categories'] = array();
										
			$results = $this->model_catalog_manufacturer->getManufacturers();
		
			foreach ($results as $result) {
				if (is_numeric(utf8_substr($result['name'], 0, 1))) {
					$key = '0 - 9';
				} else {
					$key = utf8_substr(utf8_strtoupper($result['name']), 0, 1);
				}
				
				if (!isset($this->data['manufacturers'][$key])) {
					$this->data['categories'][$key]['name'] = $key;
				}
				
				$this->data['categories'][$key]['manufacturer'][] = array(
					'name' => $result['name'],
					'image' => $this->model_tool_image->resize($result['image'], $this->config->get('config_image_manufacturer_width'), $this->config->get('config_image_manufacturer_height')),
					'href' => $this->url->link('product/manufacturer', 'manufacturer_id=' . $result['manufacturer_id'])
				);
			}
			
			$this->data['continue'] = $this->url->link('common/home');
			$this->fileRender('/template/product/manufacturer_list.tpl');
		}
  	}
	
	public function product() {
		$this->language->load('product/manufacturer');
		$this->load->model('catalog/manufacturer');
		$this->load->model('tool/image'); 
		$this->addScriptSample();
		
		$this->totals($this->request->post);
		
		$this->data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_brand'),
			'href'      => $this->url->link('product/manufacturer'),
      		'separator' => $this->language->get('text_separator')
   		);
		
		$manufacturer_id = 0;
		
		if (isset($this->request->get['manufacturer_id'])) {
			$manufacturer_id = $this->request->get['manufacturer_id'];
		}
		
		$this->data['manufacturer_id'] = $manufacturer_id;
		
		$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($manufacturer_id);
		
		if ($manufacturer_info) {
			$title = $manufacturer_info['name'];
			
			if ($manufacturer_info['seo_title']) {
				$title = $manufacturer_info['seo_title'];
			}
			
			$this->document->setDescription($manufacturer_info['meta_description']);
			$this->document->setKeywords($manufacturer_info['meta_keyword']);
		   	
		   	$this->data['href_item'] = $this->url->link('product/manufacturer', 'manufacturer_id=' . $this->request->get['manufacturer_id']);
		   	
			$this->data['breadcrumbs'][] = array(
       			'text'      => $manufacturer_info['name'],
				'href'      => $this->url->link('product/manufacturer', 'manufacturer_id=' . $this->request->get['manufacturer_id']),
      			'separator' => $this->language->get('text_separator')
   			);
			
			$this->data['seo_h1'] = $manufacturer_info['seo_h1'];
			
			$this->data['description'] = html_entity_decode($manufacturer_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['thumb'] = $this->model_tool_image->resize($manufacturer_info['image'], $this->config->get('config_image_manufacturer_width_main'), $this->config->get('config_image_manufacturer_height_main'));
			
			$this->getText();
			$this->data['heading_title'] = $manufacturer_info['name'];

            $this->sample($this->request->get);
			$file = '/template/product/manufacturer_info.tpl';
		} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/manufacturer'),
				'separator' => $this->language->get('text_separator')
			);
			
			$title = $this->language->get('text_error');

      		$this->data['heading_title'] = $this->language->get('text_error');
      		$this->data['text_error'] = $this->language->get('text_error');
      		$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['continue'] = $this->url->link('common/home');
			
      		$file = '/template/error/not_found.tpl';
		}

		$this->document->setTitle($title);
		
		$this->fileRender($file);
  	}

  	public function sample($data_get) {
		if (isset($data_get['manufacturer_id'])) {
            $data_get['path_specify'] = 'manufacturer_id=' . $data_get['manufacturer_id'];
  			$this->parentSample($data_get);
		}
  	}
}
?>