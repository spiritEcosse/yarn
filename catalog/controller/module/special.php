<?php
class ControllerModuleSpecial extends Controller {
	protected function index($setting) {
		$this->language->load('module/special');
		$this->totals($this->request->post, $setting);

      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->getText();
		$this->data['setting'] = $setting;
		
		if (empty($setting['limit'])) {
			$setting['limit'] = LIMIT;
		}
		
		$data = array(
			'sort'  	=> 'pd.name',
			'order' 	=> 'ASC',
			'start' 	=> START,
			'limit' 	=> $setting['limit'],
			'setting'	=> $setting,
			'special'	=> true,
		);

		$this->data['products'] = $this->getDataProducts($data);
        $informations = $this->model_catalog_information->getInformations();
        
        $this->data['description'] = FALSE;
        
        foreach ($informations as $information) {
            if ($information['special'] != 0) {
                $this->data['description'] = html_entity_decode($information['description'], ENT_QUOTES, 'UTF-8');
            }
        }
        
		$this->fileRenderModule('/template/module/special.tpl');
	}
}
?>