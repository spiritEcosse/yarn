<?php 
class ControllerCatalogFurnitureOrderCategory extends Controller { 
	private $error = array();
	private $furniture_order_category_id = 0;
	private $path = array();
 
	public function index() {
		$this->load->language('catalog/furniture_order_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/furniture_order_category');
		 
		$this->getList();
	}

	public function insert() {
		$this->load->language('catalog/furniture_order_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/furniture_order_category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_furniture_order_category->addCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('catalog/furniture_order_category', 'token=' . $this->session->data['token'], 'SSL')); 
		}

		$this->getForm();
	}

	public function update() {
		$this->load->language('catalog/furniture_order_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/furniture_order_category');
		
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_furniture_order_category->editCategory($this->request->get['furniture_order_category_id'], $this->request->post);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$this->redirect($this->url->link('catalog/furniture_order_category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/furniture_order_category');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('catalog/furniture_order_category');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $furniture_order_category_id) {
				$this->model_catalog_furniture_order_category->deleteCategory($furniture_order_category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$this->redirect($this->url->link('catalog/furniture_order_category', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->getList();
	}

	private function getList() {
   		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/furniture_order_category', 'token=' . $this->session->data['token'] . '&path=', 'SSL'),
      		'separator' => ' :: '
   		);
									
		$this->data['insert'] = $this->url->link('catalog/furniture_order_category/insert', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['delete'] = $this->url->link('catalog/furniture_order_category/delete', 'token=' . $this->session->data['token'], 'SSL');
		
		if (isset($this->request->get['path'])) {
			if ($this->request->get['path'] != '') {
				$this->path = explode('_', $this->request->get['path']);
				$this->furniture_order_category_id = end($this->path);
				$this->session->data['path'] = $this->request->get['path'];
			} else {
				unset($this->session->data['path']);
			}
		} elseif (isset($this->session->data['path'])) {
			$this->path = explode('_', $this->session->data['path']);
			$this->furniture_order_category_id = end($this->path);
		}

		$this->data['categories'] = $this->getCategories(0);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_sort_order'] = $this->language->get('column_sort_order');
		$this->data['column_action'] = $this->language->get('column_action');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$this->template = 'catalog/furniture_order_category_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
    	$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_percent'] = $this->language->get('text_percent');
		$this->data['text_amount'] = $this->language->get('text_amount');
				
		$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['entry_store'] = $this->language->get('entry_store');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['entry_parent'] = $this->language->get('entry_parent');
		$this->data['entry_image'] = $this->language->get('entry_image');
		$this->data['entry_top'] = $this->language->get('entry_top');
		$this->data['entry_column'] = $this->language->get('entry_column');		
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_layout'] = $this->language->get('entry_layout');
		$this->data['entry_seo_title'] = $this->language->get('entry_seo_title');
		$this->data['entry_seo_h1'] = $this->language->get('entry_seo_h1');
		
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_add_image'] = $this->language->get('button_add_image');
		$this->data['button_remove'] = $this->language->get('button_remove');

    	$this->data['tab_general'] = $this->language->get('tab_general');
    	$this->data['tab_data'] = $this->language->get('tab_data');
		$this->data['tab_design'] = $this->language->get('tab_design');
		$this->data['tab_image'] = $this->language->get('tab_image');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
	
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/furniture_order_category', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		if (!isset($this->request->get['furniture_order_category_id'])) {
			$this->data['action'] = $this->url->link('catalog/furniture_order_category/insert', 'token=' . $this->session->data['token'], 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/furniture_order_category/update', 'token=' . $this->session->data['token'] . '&furniture_order_category_id=' . $this->request->get['furniture_order_category_id'], 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('catalog/furniture_order_category', 'token=' . $this->session->data['token'], 'SSL');

		if (isset($this->request->get['furniture_order_category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$furniture_order_category_info = $this->model_catalog_furniture_order_category->getCategory($this->request->get['furniture_order_category_id']);
    	}
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['furniture_order_category_description'])) {
			$this->data['furniture_order_category_description'] = $this->request->post['furniture_order_category_description'];
		} elseif (isset($this->request->get['furniture_order_category_id'])) {
			$this->data['furniture_order_category_description'] = $this->model_catalog_furniture_order_category->getCategoryDescriptions($this->request->get['furniture_order_category_id']);
		} else {
			$this->data['furniture_order_category_description'] = array();
		}

		$categories = $this->model_catalog_furniture_order_category->getAllCategories();

		$this->data['categories'] = $this->getAllCategories($categories);

		if (isset($furniture_order_category_info)) {
			unset($this->data['categories'][$furniture_order_category_info['furniture_order_category_id']]);
		}

		if (isset($this->request->post['parent_id'])) {
			$this->data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($furniture_order_category_info)) {
			$this->data['parent_id'] = $furniture_order_category_info['parent_id'];
		} else {
			$this->data['parent_id'] = 0;
		}
						
		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['furniture_order_category_store'])) {
			$this->data['furniture_order_category_store'] = $this->request->post['furniture_order_category_store'];
		} elseif (isset($this->request->get['furniture_order_category_id'])) {
			$this->data['furniture_order_category_store'] = $this->model_catalog_furniture_order_category->getCategoryStores($this->request->get['furniture_order_category_id']);
		} else {
			$this->data['furniture_order_category_store'] = array(0);
		}			
		
		if (isset($this->request->post['keyword'])) {
			$this->data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($furniture_order_category_info)) {
			$this->data['keyword'] = $furniture_order_category_info['keyword'];
		} else {
			$this->data['keyword'] = '';
		}

		if (isset($this->request->post['image'])) {
			$this->data['image'] = $this->request->post['image'];
		} elseif (!empty($furniture_order_category_info)) {
			$this->data['image'] = $furniture_order_category_info['image'];
		} else {
			$this->data['image'] = '';
		}
		
		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($furniture_order_category_info) && $furniture_order_category_info['image'] && file_exists(DIR_IMAGE . $furniture_order_category_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($furniture_order_category_info['image'], 100, 100);
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->post['top'])) {
			$this->data['top'] = $this->request->post['top'];
		} elseif (!empty($furniture_order_category_info)) {
			$this->data['top'] = $furniture_order_category_info['top'];
		} else {
			$this->data['top'] = 0;
		}
		
		if (isset($this->request->post['column'])) {
			$this->data['column'] = $this->request->post['column'];
		} elseif (!empty($furniture_order_category_info)) {
			$this->data['column'] = $furniture_order_category_info['column'];
		} else {
			$this->data['column'] = 1;
		}
				
		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($furniture_order_category_info)) {
			$this->data['sort_order'] = $furniture_order_category_info['sort_order'];
		} else {
			$this->data['sort_order'] = 0;
		}
		
		if (isset($this->request->post['status'])) {
			$this->data['status'] = $this->request->post['status'];
		} elseif (!empty($furniture_order_category_info)) {
			$this->data['status'] = $furniture_order_category_info['status'];
		} else {
			$this->data['status'] = 1;
		}
				
		if (isset($this->request->post['furniture_order_category_layout'])) {
			$this->data['furniture_order_category_layout'] = $this->request->post['furniture_order_category_layout'];
		} elseif (isset($this->request->get['furniture_order_category_id'])) {
			$this->data['furniture_order_category_layout'] = $this->model_catalog_furniture_order_category->getCategoryLayouts($this->request->get['furniture_order_category_id']);
		} else {
			$this->data['furniture_order_category_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();

		if (isset($this->request->post['furniture_order_category_image'])) {
			$furniture_order_category_images = $this->request->post['furniture_order_category_image'];
		} elseif (isset($this->request->get['furniture_order_category_id'])) {
			$furniture_order_category_images = $this->model_catalog_furniture_order_category->getCategoryImages($this->request->get['furniture_order_category_id']);
		} else {
			$furniture_order_category_images = array();
		}
		
		$this->data['furniture_order_category_images'] = array();

		foreach ($furniture_order_category_images as $furniture_order_category_image) {
			if ($furniture_order_category_image['image'] && file_exists(DIR_IMAGE . $furniture_order_category_image['image'])) {
				$image = $furniture_order_category_image['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			$this->data['furniture_order_category_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($image, 100, 100),
				'sort_order' => $furniture_order_category_image['sort_order']
			);
		}
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		$this->template = 'catalog/furniture_order_category_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}

	private function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/furniture_order_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['furniture_order_category_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
					
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/furniture_order_category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
 
		if (!$this->error) {
			return true; 
		} else {
			return false;
		}
	}

	private function getCategories($parent_id, $parent_path = '', $indent = '') {
		$furniture_order_category_id = array_shift($this->path);

		$output = array();

		static $href_furniture_order_category = null;
		static $href_action = null;

		if ($href_furniture_order_category === null) {
			$href_furniture_order_category = $this->url->link('catalog/furniture_order_category', 'token=' . $this->session->data['token'] . '&path=', 'SSL');
			$href_action = $this->url->link('catalog/furniture_order_category/update', 'token=' . $this->session->data['token'] . '&furniture_order_category_id=', 'SSL');
		}

		$results = $this->model_catalog_furniture_order_category->getCategoriesByParentId($parent_id);

		foreach ($results as $result) {
			$path = $parent_path . $result['furniture_order_category_id'];

			$href = ($result['children']) ? $href_furniture_order_category . $path : '';

			$name = $result['name'];

			if ($furniture_order_category_id == $result['furniture_order_category_id']) {
				$name = '<b>' . $name . '</b>';

				$this->data['breadcrumbs'][] = array(
					'text'      => $result['name'],
					'href'      => $href,
					'separator' => ' :: '
				);

				$href = '';
			}

			$selected = isset($this->request->post['selected']) && in_array($result['furniture_order_category_id'], $this->request->post['selected']);

			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $href_action . $result['furniture_order_category_id']
			);

			$output[$result['furniture_order_category_id']] = array(
				'furniture_order_category_id' => $result['furniture_order_category_id'],
				'name'        => $name,
				'sort_order'  => $result['sort_order'],
				'selected'    => $selected,
				'action'      => $action,
				'href'        => $href,
				'indent'      => $indent
			);

			if ($furniture_order_category_id == $result['furniture_order_category_id']) {
				$output += $this->getCategories($result['furniture_order_category_id'], $path . '_', $indent . str_repeat('&nbsp;', 8));
			}
		}

		return $output;
	}

	private function getAllCategories($categories, $parent_id = 0, $parent_name = '') {
		$output = array();

		if (array_key_exists($parent_id, $categories)) {
			if ($parent_name != '') {
				$parent_name .= $this->language->get('text_separator');
			}

			foreach ($categories[$parent_id] as $furniture_order_category) {
				$output[$furniture_order_category['furniture_order_category_id']] = array(
					'furniture_order_category_id' => $furniture_order_category['furniture_order_category_id'],
					'name'        => $parent_name . $furniture_order_category['name']
				);

				$output += $this->getAllCategories($categories, $furniture_order_category['furniture_order_category_id'], $parent_name . $furniture_order_category['name']);
			}
		}

		return $output;
	}
}
?>