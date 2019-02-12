<?php 
class ControllerInformationCategoryArticle extends Controller {
	public function index() {
		$this->language->load('information/category_article');
        $this->load->model('catalog/category_article');
        $this->load->model('catalog/article');
		$this->load->model('tool/image');

		$this->totals($this->request->post);
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['continue'] = $this->url->link('common/home');
        $this->data['text_limit'] = $this->language->get('text_limit');
        $this->data['text_sort'] = $this->language->get('text_sort');

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_catalog'),
            'href'      => $this->url->link('information/list_category_article'),
            'separator' => $this->language->get('text_separator')
        );

        if (isset($this->request->get['category_article_id'])) {
			$path = '';
			$parts = explode('_', (string)$this->request->get['category_article_id']);
			
			foreach ($parts as $path_id) {
				if (!$path) {
					$path = $path_id;
				} else {
					$path .= '_' . $path_id;
				}
				
				$category_info = $this->model_catalog_category_article->getCategory($path_id);
				
				if ($category_info) {
	       			$this->data['breadcrumbs'][] = array(
   	    				'text'      => $category_info['name'],
						'href'      => $this->url->link('information/category_article', 'category_article_id=' . $path),
        				'separator' => $this->language->get('text_separator')
        			);
				}
			}		
		
			$category_id = array_pop($parts);
		} else {
			$category_id = 0;
		}

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        if (isset($this->request->get['limit'])) {
            $limit = $this->request->get['limit'];
        } else {
            $limit = $this->config->get('config_category_article_limit');
        }

        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'v_sort_order';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        $this->data['category_id'] = $category_id;
        $this->data['articles'] = array();

		$category_info = $this->model_catalog_category_article->getCategory($category_id);
		
		if ($category_info) {
			$title = $category_info['name'];

			if ($category_info['seo_title']) {
				$title = $category_info['seo_title'];
			}

			$this->document->setDescription($category_info['meta_description']);
			$this->document->setKeywords($category_info['meta_keyword']);
			
			$this->data['seo_h1'] = $category_info['seo_h1'];
			$this->data['heading_title'] = $category_info['name'];
            $this->data['text_empty'] = $this->language->get('text_empty');

			$this->data['thumb'] = '';

			if ($category_info['image']) {
				$this->data['thumb'] = $this->model_tool_image->resize($category_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			}

            $data = array(
                'category_article_id' => $category_id,
                'sort'               => $sort,
                'order'              => $order,
                'start'              => ($page - 1) * $limit,
                'limit'              => $limit
            );

			$this->data['description'] = html_entity_decode($category_info['description'], ENT_QUOTES, 'UTF-8');
            $this->data['articles'] = $this->model_catalog_article->getarticlesByCategory($data);

            $url = '';

            $data = array(
                'category_article_id' => $category_id
            );

            $pagination = new Pagination();
            $pagination->total = $this->model_catalog_article->getTotalarticles($data);
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $this->url->link('information/category_article', 'category_article_id=' . $this->request->get['category_article_id'] . $url . '&page={page}');

            $this->data['pagination'] = $pagination->render();

            $url = '';
            $data_for_limit = array();

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            $data_for_limit['url'] = $url;

            if (isset($this->request->get['category_article_id'])) {
                $data_for_limit['category_article_id'] = '&category_article_id=' . $this->request->get['category_article_id'];
            }

            $data_for_limit['route'] = 'information/category_article';
            $this->buildLimitVideo($data_for_limit);

            $url = '';
            $data_for_limit = array();

            if (isset($this->request->get['limit'])) {
                $url .= '&limit=' . $this->request->get['limit'];
            }

            $data_for_limit['url'] = $url;

            if (isset($this->request->get['category_article_id'])) {
                $data_for_limit['category_article_id'] = '&category_article_id=' . $this->request->get['category_article_id'];
            }

            $data_for_limit['route'] = 'information/categroy_article';
            $this->buildSortVideo($data_for_limit);

			$file = '/template/information/category_article.tpl';
    	} else {
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('information/category'),
				'separator' => $this->language->get('text_separator')
			);
			
			$title = $this->language->get('text_error');
			
      		$this->data['heading_title'] = $this->language->get('text_error');
      		$this->data['text_error'] = $this->language->get('text_error');
			$this->data['continue'] = $this->url->link('common/home');
			
      		$file = '/template/error/not_found.tpl';
		}

        $this->data['limit_select'] = $limit;
        $this->data['order_select'] = $order;
        $this->data['sort_select'] = $sort;

		$this->document->setTitle($title);
		
		$this->fileRender($file);
  	}
}
?>