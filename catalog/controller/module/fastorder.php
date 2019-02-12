<?php
class ControllerModuleFastorder extends Controller {
	
	public function index() { 
		$this->load->language("module/fastorder");
		$this->load->model('setting/setting');
		
		$this->data["heading_title"] = $this->language->get("heading_title");
		$this->data["email"] = $this->config->get('config_email');
		
		$this->fileRender("/template/module/fastorder.tpl");
	}
}
?>