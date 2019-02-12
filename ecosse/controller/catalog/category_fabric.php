<?php

class ControllerCatalogCategoryFabric extends Controller {
    private $error = array();  
    
    public function index() {
        $this->load->language('catalog/category_fabric');
        
        $this->document->setTitle($this->language->get('heading_title'));
        
        $this->load->model('catalog/category_fabric');
        
        $this->getData();
    }
    
    public function getData() {
        $this->load->model('catalog/category_fabric');
        $this->load->language('catalog/category_fabric');
        
        $this->data['text_category'] = $this->language->get('text_category');
        $this->data['text_insert'] = $this->language->get('text_insert');
        $this->data['text_delete'] = $this->language->get('text_delete');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_update'] = $this->language->get('text_update');
        
        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_save'] = $this->language->get('button_save');

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/category_fabric', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        if (isset($this->error['category_fabric'])) {
		$this->data['error_category_fabric'] = $this->error['category_fabric'];
        } else {
		$this->data['error_category_fabric'] = array();
	}
        
        if (isset($this->request->post['category_fabric'])) {
		$this->data['categories_fabric'] = $this->request->post['category_fabric'];
	} else {
		$this->data['categories_fabric'] = $this->model_catalog_category_fabric->getCategoryFabric();
	}
        
	$this->data['action'] = $this->url->link('catalog/category_fabric/update', 'token=' . $this->session->data['token'], 'SSL');
	
        $this->template = 'catalog/category_fabric.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    function update() {
        $this->load->model('catalog/category_fabric');
        
        $this->load->language('catalog/category_fabric');
        
    	$this->document->setTitle($this->language->get('heading_title'));
        
        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_category_fabric->editCategoryFabric($this->request->post);
            $this->redirect($this->url->link('catalog/category_fabric', 'token=' . $this->session->data['token'], 'SSL'));
        }
        
        $this->getData();
    }
    
    private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/category_fabric')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
        
        if (isset($this->request->post['category_fabric'])) {
            foreach ($this->request->post['category_fabric'] as $numb => $fabric) {
                    if ((utf8_strlen($fabric['name']) < 1) || (utf8_strlen($fabric['name']) > 100)) {
                        $this->error['category_fabric'][$numb] = $this->language->get('error_category_fabric');
                    }
            }
        }
	
    	if (!$this->error) {
		return true;
    	} else {
      		return false;
    	}
    }

    public function delete() {
        $this->load->model('catalog/category_fabric');
        
        $fabric_id = $this->request->get['fabric_id'];
        
        $this->model_catalog_category_fabric->delete($fabric_id);
        
        $message = "Категория удалена!";
        
        print json_encode($message);
        return;
    }
}

?>