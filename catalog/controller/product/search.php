<?php 
class ControllerProductSearch extends Controller {
	public function index() {
    	$this->language->load('product/search');
		$this->load->model('design/topmenu');
		$this->addScriptSample();
		
		$this->totals($this->request->post);
		$this->getText();
		
		$title = $this->language->get('heading_title');
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->document->setTitle($title);
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('product/search'),
      		'separator' => $this->language->get('text_separator')
   		);
   		
		$this->data['categories'] = $this->model_design_topmenu->getMenu();
		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

        $this->sample($this->request->get);

        if (isset($this->request->get['filter_name'])) {
            $filter_name = $this->request->get['filter_name'];
        } else {
            $filter_name = '';
        }

        if (isset($this->request->get['filter_description'])) {
            $filter_description = $this->request->get['filter_description'];
        } else {
            $filter_description = '';
        }

        if (isset($this->request->get['filter_category_id'])) {
            $filter_category_id = $this->request->get['filter_category_id'];
        } else {
            $filter_category_id = 0;
        }

        if (isset($this->request->get['filter_sub_category'])) {
            $filter_sub_category = $this->request->get['filter_sub_category'];
        } else {
            $filter_sub_category = '';
        }

        $this->data['filter_name'] = $filter_name;
        $this->data['filter_description'] = $filter_description;
        $this->data['filter_category_id'] = $filter_category_id;
        $this->data['filter_sub_category'] = $filter_sub_category;

        $file = '/template/product/search.tpl';
		$this->fileRender($file);
  	}
  	
  	public function ajax() {
		$products = array();

		$this->load->model('catalog/category');
		$this->load->model('catalog/product');
		
		if ( isset($this->request->get['keyword']) ) {
			$keywords = mb_strtolower( $this->request->get['keyword'], 'UTF-8' );
			
			if ( strlen($keywords) >= 1 ) {
				$parts = explode( ' ', $keywords );
				$products = $this->model_catalog_product->ajaxSearch($parts);
				
				if ( $products ) {
					$basehref = 'product/product&path=';
					$keyword = '&keyword=' . $this->request->get['keyword'];

					foreach ( $products as $key => $values ) {
						$category_id = false;
						$category_path = false;

						if ( $values['product_id'] ) {
							$category_id = $this->model_catalog_category->getCategroyByProduct($values['product_id']);
						}
						
						if ( $category_id ) {
							$category_path = $this->model_catalog_category->treeCategory($category_id);
						}
						
						if ( $category_path ) {
							$category_path = array_reverse($category_path);
							$category_path = implode('_', $category_path);
						}
						
						$products[$key] = array(
							'name' => html_entity_decode($values['name'] . ' (' . $values['product_id'] . ')', ENT_QUOTES, 'UTF-8'),
							'href' => $this->url->link($basehref . $category_path . $keyword . '&product_id=' . $values['product_id'])
						);
					}
				}
			}
		}

		echo json_encode( $products );
	}
	
	public function sample($data_get) {
		if (isset($data_get['filter_name']) && !empty($data_get['filter_name'])) {
			$this->load->model('catalog/record');
			$this->load->model('catalog/blog');
			$this->getChild('common/seoblog');
			
			$filter_name = mb_strtolower($data_get['filter_name'], 'UTF-8');

            if (isset($data_get['filter_tag'])) {
                $filter_tag = $data_get['filter_tag'];
            } else {
                $filter_tag = $filter_name;
            }

			$filter_description = null;
			
			if (isset($data_post['filter_description'])) {
	          	$filter_description = $data_post['filter_description'];
	        }
	        
			$data_blog = array(
				'filter_name' 			=> $filter_name,
				'filter_tag' 			=> $filter_tag,
				'filter_description' 	=> $filter_description,
			);
	        
			$records = $this->model_catalog_record->searchBlog($data_blog);
	        $records_total = array();

	        foreach ($records as $record) {
	        	$rating_img = false;

	        	if ($record['rating']) {
	                $rating_img = 'catalog/view/theme/' . $this->config->get('config_template') . '/image/blogstars-' . $record['rating'] . '.png';
	            }

				$blog_href = $this->model_catalog_blog->getPathByrecord($record['record_id']);

	        	$records_total[] = array(
					'href' 		=> $this->url->link('record/record', 'record_id=' . $record['record_id'] . '&blog_id=' . $blog_href['path']),
	        		'name' 		=> $record['name'],
	        		'rating_img'=> $rating_img
	        	);
	        }

            $data_get['path_specify'] = '&filter_name=' . $data_get['filter_name'];
            $data_get['filter_name'] = $filter_name;
            $data_get['filter_tag'] = $filter_name;
            $data_get['records_total'] = $records_total;
			$this->parentSample($data_get);
		}
  	}
}
?>