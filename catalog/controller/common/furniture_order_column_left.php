<?php  
class ControllerCommonFurnitureOrderColumnLeft extends Controller {
	public function index() {
		if (isset($this->request->get['route'])) {
			$route = (string)$this->request->get['route'];
		} else {
			$route = 'common/home';
		}
		
        $this->load->model('design/furniture_order_topmenu');
        $this->data['categories'] = $this->model_design_furniture_order_topmenu->getMenu();
        
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . 'template/common/furniture_order_column_left.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/furniture_order_column_left.tpl';
		} else {
			$this->template = 'default/template/common/furniture_order_column_left.tpl';
		}
		
		$this->render();
	}
}
?>