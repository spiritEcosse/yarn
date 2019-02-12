<?php
class ControllerModuleTagCloud extends Controller {
	protected function index($setting) {
		$this->data = array_merge($this->data, $this->language->load('module/tagcloud'));

      	$this->load->model('module/tagcloud');

		$this->data['tagcloud'] = $this->model_module_tagcloud->getRandomTags(
			(int)$setting['limit'],
			(int)$setting['min_font_size'],
			(int)$setting['max_font_size']
		);
		
		$this->fileRenderModule('/template/module/tagcloud.tpl');
	}
}
?>