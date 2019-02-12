<?php  
class ControllerModuleCarousel extends Controller {
	protected function index($setting) {
		static $module = 0;
		
		$this->load->model('design/banner');
		$this->load->model('tool/image');

		$this->data['limit'] = $setting['limit'];
		$this->data['scroll'] = $setting['scroll'];
				
		$this->data['banners'] = array();
		
		$results = $this->model_design_banner->getBanner($setting['banner_id']);

		foreach ($results as $result) {
			if (file_exists(DIR_IMAGE . $result['image'])) {
				$this->data['banners'][] = array(
					'title' => $result['title'],
					'link'  => $result['link'],
					'image' => 'http://' . $_SERVER['SERVER_NAME'] . '/image/' . $result['image']
				);
			}
		}
		
		$this->data['module'] = $module++; 
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/carousel.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/carousel.tpl';
		} else {
			$this->template = 'default/template/module/carousel.tpl';
		}
		
		$this->render(); 
	}
}
?>