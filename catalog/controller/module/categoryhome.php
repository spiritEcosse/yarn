<?php
class ControllerModulecategoryhome extends Controller {
	protected $category_id = 0;
	protected $path = array();

	protected function index() {
		$this->language->load('module/categoryhome');
    	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->load->model('catalog/category');
		$this->load->model('tool/image');

		if (isset($this->request->get['path'])) {
			$this->path = explode('_', $this->request->get['path']);
			$this->category_id = end($this->path);
		}

		$this->data['categoryhome'] = $this->getCategories($this->config->get('categoryhome_category'));
		$this->id = 'categoryhome';
		$this->data['config_image_category_width'] = $this->config->get('config_image_category_width');
		$this->data['config_image_category_height'] = $this->config->get('config_image_category_height') + PLUS_HEIGHT_IMAGE_CATEGORY;
		$this->fileRenderModule('/template/module/categoryhome.tpl');
  	}

	protected function getCategories($parent_id, $current_path = '') {
		$categoryhome = array();
		$category_id = array_shift($this->path);

		$results = $this->model_catalog_category->getCategories($parent_id);

		$i = 0;

		foreach ($results as $result) {
			if (!$current_path) {
				$new_path = $result['category_id'];
			} else {
				$new_path = $current_path . '_' . $result['category_id'];
			}

			if ($this->category_id == $result['category_id']) {
				$categoryhome[$i]['href'] = $this->url->link('product/category', 'path=' . $new_path);
			} else {
				$categoryhome[$i]['href'] =  $this->url->link('product/category', 'path=' . $new_path);
			}

			if ($result['image']) {
				$image = $result['image'];
			} else {
				$image = 'no_image.jpg';
			}

			$categoryhome[$i]['thumb'] = $this->model_tool_image->resize($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			$categoryhome[$i]['name'] = $result['name'];
        	$i++;
		}

		return $categoryhome;
	}
}
?>