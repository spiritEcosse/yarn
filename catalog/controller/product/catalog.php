<?php 
class ControllerProductCatalog extends Controller {
	public function index() {
		$this->language->load('product/category');
		$this->load->model('catalog/category');
		$this->load->model('tool/image');
		$this->load->model('localisation/currency');
		$this->addScriptSample();

		$this->totals($this->request->post);

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_catalog'),
            'href'      => $this->url->link('product/catalog'),
            'separator' => $this->language->get('text_separator')
        );

        $categories = $this->model_catalog_category->getCategories();

        if ($categories) {
			$title = $this->language->get('text_catalog');

//			$this->document->setDescription($category_info['meta_description']);
//			$this->document->setKeywords($category_info['meta_keyword']);
			
//			$this->data['seo_h1'] = $category_info['seo_h1'];
			$this->data['heading_title'] = $title;
			
			$this->getText();

            $this->data['thumb'] = '';
            $this->data['description'] = '';

//			$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $this->data['categories'] = array();

            foreach ($categories as $key => $category) {
                $this->data['categories'][$key] = $category;

                if ($category['image']) {
                    $image = $category['image'];
                } else {
                    $image = 'no_image.jpg';
                }

                $this->data['categories'][$key]['thumb'] = $this->model_tool_image->resize($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
                $this->data['categories'][$key]['href'] = $this->url->link('product/category', 'path=' . $category['category_id']);
            }

			$file = '/template/product/catalog.tpl';
    	} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/category'),
				'separator' => $this->language->get('text_separator')
			);
			
			$title = $this->language->get('text_error');
			
      		$this->data['heading_title'] = $this->language->get('text_error');
      		$this->data['text_error'] = $this->language->get('text_error');
      		$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['continue'] = $this->url->link('common/home');
			
      		$file = '/template/error/not_found.tpl';
		}
		
		$this->document->setTitle($title);
		
		$this->fileRender($file);
  	}
}
?>