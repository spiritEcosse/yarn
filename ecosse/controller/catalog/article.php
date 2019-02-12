<?php 
class ControllerCatalogArticle extends Controller {
	private $error = array();
   
  	public function index() {
		$this->load->language('catalog/article');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/article');

    	$this->getList();
  	}

  	public function insert() {
		$this->load->language('catalog/article');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/article');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
      		$this->model_catalog_article->addarticle($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

      		$this->redirect($this->url->link('catalog/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function update() {
		$this->load->language('catalog/article');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/article');

    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
	  		$this->model_catalog_article->editarticle($this->request->get['article_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
    	}

    	$this->getForm();
  	}

  	public function delete() {
		$this->load->language('catalog/article');

    	$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/article');

    	if (isset($this->request->post['selected'])) {
			foreach ($this->request->post['selected'] as $article_id) {
				$this->model_catalog_article->deletearticle($article_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->redirect($this->url->link('catalog/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
   		}

    	$this->getList();
  	}

  	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'article_date_added';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'desc';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['insert'] = $this->url->link('catalog/article/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/article/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['copy'] = $this->url->link('catalog/article/copy', 'token=' . $this->session->data['token'] . $url, 'SSL');

		$this->data['articles'] = array();

        $data = array();
        $data['sort'] = $sort;
        $data['order'] = $order;

		$article_total = $this->model_catalog_article->getTotalarticles();
		$results = $this->model_catalog_article->getarticles($data);

    	foreach ($results as $result) {
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/article/update', 'token=' . $this->session->data['token'] . '&article_id=' . $result['article_id'] . $url, 'SSL')
			);

			$this->data['articles'][] = array(
				'article_id'    => $result['article_id'],
				'name'            => $result['name'],
				'sort_order'      => $result['sort_order'],
                'article_date_added' => $result['article_date_added'],
                'article_status' => $result['article_status'],
                'selected'        => isset($this->request->post['selected']) && in_array($result['article_id'], $this->request->post['selected']),
                'action'          => $action
			);
		}

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_article_group'] = $this->language->get('column_article_group');
        $this->data['column_sort_order'] = $this->language->get('column_sort_order');
        $this->data['column_article_date_added'] = $this->language->get('column_article_date_added');
        $this->data['column_action'] = $this->language->get('column_action');
        $this->data['column_sort_article_status'] = $this->language->get('column_sort_article_status');

		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
        $this->data['button_copy'] = $this->language->get('button_copy');

        if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

        $this->data['sort_article_date_added'] = $this->url->link('catalog/article', 'token=' . $this->session->data['token'] . '&sort=article_date_added' . $url, 'SSL');
        $this->data['sort_name'] = $this->url->link('catalog/article', 'token=' . $this->session->data['token'] . '&sort=name' . $url, 'SSL');
        $this->data['sort_sort_order'] = $this->url->link('catalog/article', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, 'SSL');
        $this->data['sort_article_status'] = $this->url->link('catalog/article', 'token=' . $this->session->data['token'] . '&sort=article_status' . $url, 'SSL');

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/article_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
  	}

  	private function getForm() {
        $this->load->model('catalog/category_article');

        $this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['entry_name'] = $this->language->get('entry_name');
		$this->data['entry_article_group'] = $this->language->get('entry_article_group');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_category'] = $this->language->get('entry_category');
        $this->data['text_select_all'] = $this->language->get('text_select');
        $this->data['text_unselect_all'] = $this->language->get('text_unselect');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_no'] = $this->language->get('text_no');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_description'] = $this->language->get('entry_description');

        $this->data['entry_main_category'] = $this->language->get('entry_main_category');

    	$this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['categories'] = $this->model_catalog_category_article->getCategories(0);

        if (isset($this->request->post['article_category'])) {
            $this->data['article_category'] = $this->request->post['article_category'];
        } elseif (isset($this->request->get['article_id'])) {
            $this->data['article_category'] = $this->model_catalog_article->getarticleCategories($this->request->get['article_id']);
        } else {
            $this->data['article_category'] = array();
        }

        if (isset($this->request->post['main_category_article_id'])) {
            $this->data['main_category_article_id'] = $this->request->post['main_category_article_id'];
        } elseif (isset($this->request->get['article_id'])) {
            $this->data['main_category_article_id'] = $this->model_catalog_article->getarticleMainCategoryId($this->request->get['article_id']);
        } else {
            $this->data['main_category_article_id'] = 0;
        }

        if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = '';
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/article', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		if (!isset($this->request->get['article_id'])) {
			$this->data['action'] = $this->url->link('catalog/article/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/article/update', 'token=' . $this->session->data['token'] . '&article_id=' . $this->request->get['article_id'] . $url, 'SSL');
		}

        $this->data['cancel'] = $this->url->link('catalog/article', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['article_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$article_info = $this->model_catalog_article->getarticle($this->request->get['article_id']);
		}

		$this->load->model('localisation/language');

        if (isset($this->request->post['description'])) {
            $this->data['article_description'] = $this->request->post['article_description'];
        } elseif (!empty($article_info)) {
            $this->data['article_description'] = $article_info['article_description'];
        } else {
            $this->data['article_description'] = '';
        }

        if (isset($this->request->post['name'])) {
            $this->data['name'] = $this->request->post['name'];
        } elseif (!empty($article_info)) {
            $this->data['name'] = $article_info['name'];
        } else {
            $this->data['name'] = '';
        }

        if (isset($this->request->post['article_status'])) {
            $this->data['article_status'] = $this->request->post['article_status'];
        } elseif (!empty($article_info)) {
            $this->data['article_status'] = $article_info['article_status'];
        } else {
            $this->data['article_status'] = 1;
        }

		if (isset($this->request->post['sort_order'])) {
			$this->data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($article_info)) {
			$this->data['sort_order'] = $article_info['sort_order'];
		} else {
			$this->data['sort_order'] = '';
		}

		$this->template = 'catalog/article_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
  	}

    public function copy() {
        $this->load->language('catalog/article');
        $this->document->setTitle($this->language->get('heading_title'));
        $this->load->model('catalog/article');

        if (isset($this->request->post['selected']) && $this->validateTotal()) {
            foreach ($this->request->post['selected'] as $article_id) {
                $this->model_catalog_article->copyarticle($article_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');
            $url = '';

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->redirect($this->url->link('catalog/article', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

//        $this->getList();
    }

    private function validateTotal() {
        if (!$this->user->hasPermission('modify', 'catalog/article')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        }

        return false;
    }

	private function validateForm() {
    	if (!$this->user->hasPermission('modify', 'catalog/article')) {
      		$this->error['warning'] = $this->language->get('error_permission');
    	}

        if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 100)) {
            $this->error['name'] = $this->language->get('error_name');
        }

        if ($this->error && !isset($this->error['warning'])) {
            $this->error['warning'] = $this->language->get('error_warning');
        }

        if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
}
?>