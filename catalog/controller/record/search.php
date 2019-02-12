<?php
class ControllerRecordSearch extends Controller {
	public function index() {
		$this->language->load('record/search');
		$this->getChild('common/seoblog');
		$this->load->model('catalog/blog');
		$this->load->model('catalog/record');
		$this->load->model('tool/image');
		$this->data['theme'] = $this->config->get('config_template');

		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = '';
		}

		if (isset($this->request->get['filter_tag'])) {
			$filter_tag = $this->request->get['filter_tag'];
		} elseif (isset($this->request->get['filter_name'])) {
			$filter_tag = $this->request->get['filter_name'];
		} else {
			$filter_tag = '';
		}

		if (isset($this->request->get['filter_description'])) {
			$filter_description = $this->request->get['filter_description'];
		} else {
			$filter_description = '';
		}
		if (isset($this->request->get['filter_blog_id'])) {
			$filter_blog_id = $this->request->get['filter_blog_id'];
		} else {
			$filter_blog_id = 0;
		}
		if (isset($this->request->get['filter_sub_blog'])) {
			$filter_sub_blog = $this->request->get['filter_sub_blog'];
		} else {
			$filter_sub_blog = '';
		}
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
		}
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
		if (isset($this->request->get['keyword'])) {
			$this->document->setTitle($this->language->get('heading_title') . ' - ' . $this->request->get['keyword']);
		} else {
			$this->document->setTitle($this->language->get('heading_title'));
		}
		$this->data['breadcrumbs']   = array();
		$this->data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home'),
			'separator' => false
		);
		$url                         = '';
		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . $this->request->get['filter_name'];
		}
		if (isset($this->request->get['filter_tag'])) {
			$url .= '&filter_tag=' . $this->request->get['filter_tag'];
		}
		if (isset($this->request->get['filter_description'])) {
			$url .= '&filter_description=' . $this->request->get['filter_description'];
		}
		if (isset($this->request->get['filter_blog_id'])) {
			$url .= '&filter_blog_id=' . $this->request->get['filter_blog_id'];
		}
		if (isset($this->request->get['filter_sub_blog'])) {
			$url .= '&filter_sub_blog=' . $this->request->get['filter_sub_blog'];
		}
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
		$this->data['breadcrumbs'][]     = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('record/search', $url),
			'separator' => $this->language->get('text_separator')
		);
		$this->data['heading_title']     = $this->language->get('heading_title');
		$this->data['text_comments']     = $this->language->get('text_comments');
		$this->data['text_viewed']       = $this->language->get('text_viewed');
		$this->data['text_empty']        = $this->language->get('text_empty');
		$this->data['text_critea']       = $this->language->get('text_critea');
		$this->data['text_search']       = $this->language->get('text_search');
		$this->data['text_keyword']      = $this->language->get('text_keyword');
		$this->data['text_blog']         = $this->language->get('text_blog');
		$this->data['text_sub_blog']     = $this->language->get('text_sub_blog');
		$this->data['text_quantity']     = $this->language->get('text_quantity');
		$this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
		$this->data['text_model']        = $this->language->get('text_model');
		$this->data['text_price']        = $this->language->get('text_price');
		$this->data['text_tax']          = $this->language->get('text_tax');
		$this->data['text_points']       = $this->language->get('text_points');
		$this->data['text_compare']      = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
		$this->data['text_display']      = $this->language->get('text_display');
		$this->data['text_list']         = $this->language->get('text_list');
		$this->data['text_grid']         = $this->language->get('text_grid');
		$this->data['text_sort']         = $this->language->get('text_sort');
		$this->data['text_limit']        = $this->language->get('text_limit');
		$this->data['entry_search']      = $this->language->get('entry_search');
		$this->data['entry_description'] = $this->language->get('entry_description');
		$this->data['button_search']     = $this->language->get('button_search');
		$this->data['button_cart']       = $this->language->get('button_cart');
		$this->data['button_wishlist']   = $this->language->get('button_wishlist');
		$this->data['button_compare']    = $this->language->get('button_compare');
		$this->data['compare']           = $this->url->link('record/compare');
		$this->load->model('catalog/blog');
		$this->data['blogies'] = array();
		$blogies_1             = $this->model_catalog_blog->getBlogies(0);
		foreach ($blogies_1 as $blog_1) {
			$level_2_data = array();
			$blogies_2    = $this->model_catalog_blog->getBlogies($blog_1['blog_id']);
			foreach ($blogies_2 as $blog_2) {
				$level_3_data = array();
				$blogies_3    = $this->model_catalog_blog->getBlogies($blog_2['blog_id']);
				foreach ($blogies_3 as $blog_3) {
					$level_3_data[] = array(
						'blog_id' => $blog_3['blog_id'],
						'name' => $blog_3['name']
					);
				}
				$level_2_data[] = array(
					'blog_id' => $blog_2['blog_id'],
					'name' => $blog_2['name'],
					'children' => $level_3_data
				);
			}
			$this->data['blogies'][] = array(
				'blog_id' => $blog_1['blog_id'],
				'name' => $blog_1['name'],
				'children' => $level_2_data
			);
		}
		$this->data['records'] = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_tag'])) {
			$data = array(
				'filter_name' => $filter_name,
				'filter_tag' => $filter_tag,
				'filter_description' => $filter_description,
				'filter_blog_id' => $filter_blog_id,
				'filter_sub_blog' => $filter_sub_blog,
				'sort' => $sort,
				'order' => $order,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
			);

			$record_total = $this->model_catalog_record->getTotalRecords($data);
			$results = $this->model_catalog_record->getRecords($data);

			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = false;
				}
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				if ((float) $result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float) $result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}
				if ($this->config->get('config_comment_status')) {
					$rating = (int) $result['rating'];
				} else {
					$rating = false;
				}
				if (!isset($result['sdescription'])) {
					$result['sdescription'] = '';
				}
				if ($result['description'] && $result['sdescription'] == '') {
					$flag_desc                   = 'pred';
					$amount                      = 1;
					$this->data['blog_num_desc'] = $this->config->get('blog_num_desc');
					if ($this->data['blog_num_desc'] == '') {
						$this->data['blog_num_desc'] = 50;
					} else {
						$amount    = $this->data['blog_num_desc'];
						$flag_desc = 'symbols';
					}
					$this->data['blog_num_desc_words'] = $this->config->get('blog_num_desc_words');
					if ($this->data['blog_num_desc_words'] == '') {
						$this->data['blog_num_desc_words'] = 10;
					} else {
						$amount    = $this->data['blog_num_desc_words'];
						$flag_desc = 'words';
					}
					$this->data['blog_num_desc_pred'] = $this->config->get('blog_num_desc_pred');
					if ($this->data['blog_num_desc_pred'] == '') {
						$this->data['blog_num_desc_pred'] = 3;
					} else {
						$amount    = $this->data['blog_num_desc_pred'];
						$flag_desc = 'pred';
					}
					switch ($flag_desc) {
						case 'symbols':
							$pattern = ('/((.*?)\S){0,' . $amount . '}/isu');
							preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
							$description = $out[0][0];
							break;
						case 'words':
							$pattern = ('/((.*?)\x20){0,' . $amount . '}/isu');
							preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
							$description = $out[0][0];
							break;
						case 'pred':
							$pattern = ('/((.*?)\.){0,' . $amount . '}/isu');
							preg_match_all($pattern, strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), $out);
							$description = $out[0][0];
							break;
					}
				} else
					$description = false;
				if (isset($result['sdescription']) && $result['sdescription'] != '') {
					$description = html_entity_decode($result['sdescription'], ENT_QUOTES, 'UTF-8');
				}
				if ($this->rdate($this->language->get('text_date')) == $this->rdate($this->language->get('text_date'), strtotime($result['date_available']))) {
					$date_str = $this->language->get('text_today');
				} else {
					$date_str = $this->language->get('text_date');
				}
				$date_available          = $this->rdate($date_str . $this->language->get('text_hours'), strtotime($result['date_available']));
				$blog_href               = $this->model_catalog_blog->getPathByrecord($result['record_id']);
				$this->data['records'][] = array(
					'record_id' => $result['record_id'],
					'thumb' => $image,
					'name' => $result['name'],
					'description' => $description,
					'date_added' => $result['date_added'],
					'date_available' => $date_available,
					'price' => $price,
					'special' => $special,
					'tax' => $tax,
					'rating' => $result['rating'],
					'viewed' => $result['viewed'],
					'comments' => (int) $result['comments'],
					'href' => $this->url->link('record/record', 'record_id=' . $result['record_id']),
					'blog_href' => $this->url->link('record/blog', 'blog_id=' . $blog_href['path']),
					'blog_name' => $blog_href['name']
				);
			}
			$url = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			if (isset($this->request->get['filter_blog_id'])) {
				$url .= '&filter_blog_id=' . $this->request->get['filter_blog_id'];
			}
			if (isset($this->request->get['filter_sub_blog'])) {
				$url .= '&filter_sub_blog=' . $this->request->get['filter_sub_blog'];
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$this->data['sorts']   = array();
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href' => $this->url->link('record/search', 'sort=p.sort_order&order=ASC' . $url)
			);
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href' => $this->url->link('record/search', 'sort=pd.name&order=ASC' . $url)
			);
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href' => $this->url->link('record/search', 'sort=pd.name&order=DESC' . $url)
			);
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href' => $this->url->link('record/search', 'sort=p.price&order=ASC' . $url)
			);
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href' => $this->url->link('record/search', 'sort=p.price&order=DESC' . $url)
			);
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_rating_desc'),
				'value' => 'rating-DESC',
				'href' => $this->url->link('record/search', 'sort=rating&order=DESC' . $url)
			);
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_rating_asc'),
				'value' => 'rating-ASC',
				'href' => $this->url->link('record/search', 'sort=rating&order=ASC' . $url)
			);
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href' => $this->url->link('record/search', 'sort=p.model&order=ASC' . $url)
			);
			$this->data['sorts'][] = array(
				'text' => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href' => $this->url->link('record/search', 'sort=p.model&order=DESC' . $url)
			);
			$url                   = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			if (isset($this->request->get['filter_blog_id'])) {
				$url .= '&filter_blog_id=' . $this->request->get['filter_blog_id'];
			}
			if (isset($this->request->get['filter_sub_blog'])) {
				$url .= '&filter_sub_blog=' . $this->request->get['filter_sub_blog'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			$this->data['limits']   = array();
			$this->data['limits'][] = array(
				'text' => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href' => $this->url->link('record/search', $url . '&limit=' . $this->config->get('config_catalog_limit'))
			);
			$this->data['limits'][] = array(
				'text' => 25,
				'value' => 25,
				'href' => $this->url->link('record/search', $url . '&limit=25')
			);
			$this->data['limits'][] = array(
				'text' => 50,
				'value' => 50,
				'href' => $this->url->link('record/search', $url . '&limit=50')
			);
			$this->data['limits'][] = array(
				'text' => 75,
				'value' => 75,
				'href' => $this->url->link('record/search', $url . '&limit=75')
			);
			$this->data['limits'][] = array(
				'text' => 100,
				'value' => 100,
				'href' => $this->url->link('record/search', $url . '&limit=100')
			);
			$url                    = '';
			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . $this->request->get['filter_name'];
			}
			if (isset($this->request->get['filter_tag'])) {
				$url .= '&filter_tag=' . $this->request->get['filter_tag'];
			}
			if (isset($this->request->get['filter_description'])) {
				$url .= '&filter_description=' . $this->request->get['filter_description'];
			}
			if (isset($this->request->get['filter_blog_id'])) {
				$url .= '&filter_blog_id=' . $this->request->get['filter_blog_id'];
			}
			if (isset($this->request->get['filter_sub_blog'])) {
				$url .= '&filter_sub_blog=' . $this->request->get['filter_sub_blog'];
			}
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
			$pagination               = new Pagination();
			$pagination->total        = $record_total;
			$pagination->page         = $page;
			$pagination->limit        = $limit;
			$pagination->text         = $this->language->get('text_pagination');
			$pagination->url          = $this->url->link('record/search', $url . '&page={page}');
			$this->data['pagination'] = $pagination->render();
		}
		$this->data['filter_name']        = $filter_name;
		$this->data['filter_description'] = $filter_description;
		$this->data['filter_blog_id']     = $filter_blog_id;
		$this->data['filter_sub_blog']    = $filter_sub_blog;
		$this->data['sort']               = $sort;
		$this->data['order']              = $order;
		$this->data['limit']              = $limit;
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/record/search.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/record/search.tpl';
		} else {
			$this->template = 'default/template/record/search.tpl';
		}
		$this->children      = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'
		);
		$this->data['theme'] = $this->config->get('config_template');
		$this->response->setOutput($this->render());
	}
}
?>