<?php  
class ControllerModuleBanner extends Controller {
	protected function index($setting) {
		$this->load->model('design/banner');
		
		$banner = $this->model_design_banner->getBannerName((int)$setting['banner_id']);
		
		if ($banner) {
			static $module = 0;
			$this->data['name_banner'] = $banner['name'];
			
			$this->load->model('tool/image');

			$this->data['setting'] = $setting;
			$this->data['banners'] = array();

			$results = $this->model_design_banner->getBanner((int)$setting['banner_id']);
            $banner_link = array();

			foreach ($results as $result) {
				if (file_exists(DIR_IMAGE . $result['image'])) {
                    $banner_link[] = $result['link'];

					$this->data['banners'][] = array(
						'title' => $result['title'],
						'link'  => $result['link'],
						'image' => $this->model_tool_image->resize($result['image'], $setting['width'], $setting['height'])
					);
				}
			}

            if (in_array($_SERVER['REQUEST_URI'], $banner_link) || $module > 0) {
                return false;
            }

            if (isset($this->request->get['path'])) {
                $this->data['path'] = $this->request->get['path'];
                $path = '';

                $parts = explode('_', (string)$this->request->get['path']);

                foreach ($parts as $path_id) {
                    if (!$path) {
                        $path = $path_id;
                    } else {
                        $path .= '_' . $path_id;
                    }
                }

                $category_id = array_pop($parts);
            } else {
                $category_id = 0;
            }

            if ($category_id) {
                $this->load->model('catalog/category');
                $this->load->model('catalog/product');

                $count_products = $this->model_catalog_product->getTotalProducts(array('filter_category_id' => $category_id, 'innertable' => true));

                if ($count_products == 0) {
                    return false;
                }
            }

			$this->data['module'] = $module++;
			$this->fileRenderModule('/template/module/banner.tpl');
		}
	}
}
?>