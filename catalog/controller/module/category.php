<?php
class ControllerModuleCategory extends Controller {
	protected function index($setting) {
		$this->language->load('module/category');
        $this->load->model('design/topmenu');

    	$this->data['heading_title'] = $this->language->get('heading_title');
        $this->data['categories_active'] = array();

        if (isset($this->request->get['path'])) {
            $this->data['categories_active'] = explode('_', (string)$this->request->get['path']);
		}

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');

		$this->data['categories'] = array();
        $this->data['categories'] = $this->model_design_topmenu->getMenu();
		$this->fileRenderModule('/template/module/category.tpl');
  	}
}
?>