<?php
class ControllerModuleBestSeller extends Controller {
	protected function index($setting) {
		$this->language->load('module/bestseller');
		$this->totals($this->request->post, $setting);
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->getText();
		$this->data['setting'] = $setting;
		
		if (empty($setting['limit'])) {
			$setting['limit'] = LIMIT;
		}
		
		$data = array(
			'sort'  	=> 'o.date_added',
			'order' 	=> 'DESC',
			'start' 	=> START,
			'setting'	=> $setting,
			'limit' 	=> $setting['limit'],
			'bestseller'=> true
		);

		$this->data['products'] = $this->getDataProducts($data);
		$this->fileRenderModule('/template/module/latest.tpl');
	}
}
?>