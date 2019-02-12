<?php
class ControllerModuleLatest extends Controller {
	protected function index($setting) {
		$this->language->load('module/latest');
		$this->totals($this->request->post, $setting);

      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->getText();
        $this->data['setting'] = $setting;

        if (empty($setting['limit'])) {
			$setting['limit'] = LIMIT;
		}
		
		$data = array(
			'sort'  	=> 'p.date_added',
			'order' 	=> 'DESC',
			'start' 	=> START,
			'setting'	=> $setting,
			'limit' 	=> $setting['limit']
		);
		
		$this->data['products'] = $this->getDataProducts($data);
		$this->fileRenderModule('/template/module/latest.tpl');
	}
}
?>