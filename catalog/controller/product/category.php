<?php 
class ControllerProductCategory extends Controller {
	public function index() {
		$this->language->load('product/category');
		$this->load->model('catalog/category');
		$this->load->model('tool/image');
		$this->load->model('localisation/currency');
		$this->addScriptSample();
		
		$this->totals($this->request->post);

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_catalog'),
            'href'      => $this->url->link('product/catalog'),
            'separator' => $this->language->get('text_separator')
        );

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['limit'])) {
            $url .= '&limit=' . $this->request->get['limit'];
        }

        if (isset($this->request->get['filterpro_special'])) {
            $url .= '&filterpro_special=' . $this->request->get['filterpro_special'];
        }

        if (isset($this->request->get['path'])) {
			$this->data['path'] = $this->request->get['path'];
			$path = '';
			
			$parts = explode('_', (string)$this->request->get['path']);
			
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				
				$category_info = $this->model_catalog_category->getCategory($path_id);
				
				if ($category_info) {
	       			$this->data['breadcrumbs'][] = array(
   	    				'text'      => $category_info['name'],
						'href'      => $this->url->link('product/category', 'path=' . $path. $url),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$category_id = array_pop($parts);
		} else {
			$category_id = 0;
		}

		$this->data['category_id'] = $category_id;
		
		$category_info = $this->model_catalog_category->getCategory($category_id);
		
		if ($category_info) {
			$title = $category_info['name'];

			if ($category_info['seo_title']) {
				$title = $category_info['seo_title'];
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			
			$this->data['seo_h1'] = $category_info['seo_h1'];
			$this->data['heading_title'] = $category_info['name'];
			
			$this->getText();
			
			$this->data['thumb'] = '';

			if ($category_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			}

			$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
			$this->data['config_image_category_width'] = $this->config->get('config_image_category_width');
			$this->data['config_image_category_height'] = $this->config->get('config_image_category_height') + PLUS_HEIGHT_IMAGE_CATEGORY;

            $this->sample($this->request->get);
			$file = '/template/product/category.tpl';
    	} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/category'),
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
        if (isset($data_get['path'])) {
            $data_get['path_specify'] = '&path=' . $data_get['path'];
            $this->parentSample($data_get);
        }
  	}
}
?>