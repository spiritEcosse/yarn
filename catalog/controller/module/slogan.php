<?php  
class ControllerModuleSlogan extends Controller {
	protected function index($setting) {
		$path = explode('_', (string)$this->request->get['path']);

		if (in_array(end($path), $setting['category_id'])) {
			$this->data['setting'] = $setting;
			$this->fileRenderModule('/template/module/slogan.tpl');
		}
	}
}
?>