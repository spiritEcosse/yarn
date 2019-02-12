<?php
class ControllerModuleFeatured extends Controller {
	protected function index($setting) {
		$this->language->load('module/featured');
		$this->totals($this->request->post, $setting);

      	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->getText();
		$this->data['setting'] = $setting;
		
		if (empty($setting['limit'])) {
			$setting['limit'] = LIMIT;
		}

		$products = array_slice(explode(',', $this->config->get('featured_product')), START, (int)$setting['limit']);

		$data = array(
			'products'	=> $products,
			'setting'	=> $setting
		);

		$this->data['products'] = $this->getDataProducts($data);		
		$this->fileRenderModule('/template/module/featured.tpl');
	}
}
?>