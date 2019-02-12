<?php
class ControllerCatalogCategoryArticle extends Controller {
    private $error = array();
    private $category_article_id = 0;
    private $path = array();

    public function index() {
        $this->load->language('catalog/category_article');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/category_article');

        $this->getList();
    }

    public function insert() {
        $this->load->language('catalog/category_article');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/category_article');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_category_article->addCategory($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('catalog/category_article', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->getForm();
    }

    public function update() {
        $this->load->language('catalog/category_article');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/category_article');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_catalog_category_article->editCategory($this->request->get['category_article_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('catalog/category_article', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {
        $this->load->language('catalog/category_article');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('catalog/category_article');

        if (isset($this->request->post['selected']) && $this->validateDelete()) {
            foreach ($this->request->post['selected'] as $category_article_id) {
                $this->model_catalog_category_article->deleteCategory($category_article_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $this->redirect($this->url->link('catalog/category_article', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->getList();
    }

    private function getList() {
        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('catalog/category_article', 'token=' . $this->session->data['token'] . '&path=', 'SSL'),
            'separator' => ' :: '
        );

        $this->data['insert'] = $this->url->link('catalog/category_article/insert', 'token=' . $this->session->data['token'], 'SSL');
        $this->data['delete'] = $this->url->link('catalog/category_article/delete', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->get['path'])) {
            if ($this->request->get['path'] != '') {
                $this->path = explode('_', $this->request->get['path']);
                $this->category_article_id = end($this->path);
                $this->session->data['path'] = $this->request->get['path'];
            } else {
                unset($this->session->data['path']);
            }
        } elseif (isset($this->session->data['path'])) {
            $this->path = explode('_', $this->session->data['path']);
            $this->category_article_id = end($this->path);
        }

        $this->data['categories'] = $this->getCategories(0);

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_name'] = $this->language->get('column_name');
        $this->data['column_sort_order'] = $this->language->get('column_sort_order');
        $this->data['column_action'] = $this->language->get('column_action');

        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_delete'] = $this->language->get('button_delete');

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

        $this->template = 'catalog/category_article_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    private function getForm() {
        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_default'] = $this->language->get('text_default');
        $this->data['text_image_manager'] = $this->language->get('text_image_manager');
        $this->data['text_browse'] = $this->language->get('text_browse');
        $this->data['text_clear'] = $this->language->get('text_clear');
        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_percent'] = $this->language->get('text_percent');
        $this->data['text_amount'] = $this->language->get('text_amount');

        $this->data['entry_name'] = $this->language->get('entry_name');
        $this->data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
        $this->data['entry_meta_description'] = $this->language->get('entry_meta_description');
        $this->data['entry_description'] = $this->language->get('entry_description');
        $this->data['entry_store'] = $this->language->get('entry_store');
        $this->data['entry_keyword'] = $this->language->get('entry_keyword');
        $this->data['entry_parent'] = $this->language->get('entry_parent');
        $this->data['entry_image'] = $this->language->get('entry_image');
        $this->data['entry_top'] = $this->language->get('entry_top');
        $this->data['entry_column'] = $this->language->get('entry_column');
        $this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $this->data['entry_status'] = $this->language->get('entry_status');
        $this->data['entry_layout'] = $this->language->get('entry_layout');
        $this->data['entry_seo_title'] = $this->language->get('entry_seo_title');
        $this->data['entry_seo_h1'] = $this->language->get('entry_seo_h1');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        $this->data['tab_general'] = $this->language->get('tab_general');
        $this->data['tab_data'] = $this->language->get('tab_data');
        $this->data['tab_design'] = $this->language->get('tab_design');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->error['name'])) {
            $this->data['error_name'] = $this->error['name'];
        } else {
            $this->data['error_name'] = array();
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('catalog/category_article', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        if (!isset($this->request->get['category_article_id'])) {
            $this->data['action'] = $this->url->link('catalog/category_article/insert', 'token=' . $this->session->data['token'], 'SSL');
        } else {
            $this->data['action'] = $this->url->link('catalog/category_article/update', 'token=' . $this->session->data['token'] . '&category_article_id=' . $this->request->get['category_article_id'], 'SSL');
        }

        $this->data['cancel'] = $this->url->link('catalog/category_article', 'token=' . $this->session->data['token'], 'SSL');

        if (isset($this->request->get['category_article_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $category_article_info = $this->model_catalog_category_article->getCategory($this->request->get['category_article_id']);
        }

        $this->data['token'] = $this->session->data['token'];

        $this->load->model('localisation/language');

        $this->data['languages'] = $this->model_localisation_language->getLanguages();

        if (isset($this->request->post['category_article_description'])) {
            $this->data['category_article_description'] = $this->request->post['category_article_description'];
        } elseif (isset($this->request->get['category_article_id'])) {
            $this->data['category_article_description'] = $this->model_catalog_category_article->getCategoryDescriptions($this->request->get['category_article_id']);
        } else {
            $this->data['category_article_description'] = array();
        }

        $categories = $this->model_catalog_category_article->getAllCategories();

        $this->data['categories'] = $this->getAllCategories($categories);

        if (isset($category_article_info)) {
            unset($this->data['categories'][$category_article_info['category_article_id']]);
        }

        if (isset($this->request->post['parent_id'])) {
            $this->data['category_article_parent_id'] = $this->request->post['category_article_parent_id'];
        } elseif (!empty($category_article_info)) {
            $this->data['category_article_parent_id'] = $category_article_info['category_article_parent_id'];
        } else {
            $this->data['category_article_parent_id'] = 0;
        }

        $this->load->model('setting/store');

        $this->data['stores'] = $this->model_setting_store->getStores();

        if (isset($this->request->post['category_article_store'])) {
            $this->data['category_article_store'] = $this->request->post['category_article_store'];
        } elseif (isset($this->request->get['category_article_id'])) {
            $this->data['category_article_store'] = $this->model_catalog_category_article->getCategoryStores($this->request->get['category_article_id']);
        } else {
            $this->data['category_article_store'] = array(0);
        }

        if (isset($this->request->post['keyword'])) {
            $this->data['keyword'] = $this->request->post['keyword'];
        } elseif (!empty($category_article_info)) {
            $this->data['keyword'] = $category_article_info['keyword'];
        } else {
            $this->data['keyword'] = '';
        }

        if (isset($this->request->post['image'])) {
            $this->data['image'] = $this->request->post['image'];
        } elseif (!empty($category_article_info)) {
            $this->data['image'] = $category_article_info['image'];
        } else {
            $this->data['image'] = '';
        }

        $this->load->model('tool/image');

        if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
            $this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
        } elseif (!empty($category_article_info) && $category_article_info['image'] && file_exists(DIR_IMAGE . $category_article_info['image'])) {
            $this->data['thumb'] = $this->model_tool_image->resize($category_article_info['image'], 100, 100);
        } else {
            $this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }

        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

        if (isset($this->request->post['column'])) {
            $this->data['column'] = $this->request->post['column'];
        } elseif (!empty($category_article_info)) {
            $this->data['column'] = $category_article_info['column'];
        } else {
            $this->data['column'] = 1;
        }

        if (isset($this->request->post['category_article_sort_order'])) {
            $this->data['category_article_sort_order'] = $this->request->post['category_article_sort_order'];
        } elseif (!empty($category_article_info)) {
            $this->data['category_article_sort_order'] = $category_article_info['category_article_sort_order'];
        } else {
            $this->data['category_article_sort_order'] = 0;
        }

        if (isset($this->request->post['drop_down'])) {
            $this->data['drop_down'] = $this->request->post['drop_down'];
        } elseif (!empty($category_article_info)) {
            $this->data['drop_down'] = $category_article_info['drop_down'];
        } else {
            $this->data['drop_down'] = 0;
        }

        if (isset($this->request->post['category_article_status'])) {
            $this->data['category_article_status'] = $this->request->post['category_article_status'];
        } elseif (!empty($category_article_info)) {
            $this->data['category_article_status'] = $category_article_info['category_article_status'];
        } else {
            $this->data['category_article_status'] = 1;
        }

        if (isset($this->request->post['category_article_layout'])) {
            $this->data['category_article_layout'] = $this->request->post['category_article_layout'];
        } elseif (isset($this->request->get['category_article_id'])) {
            $this->data['category_article_layout'] = $this->model_catalog_category_article->getCategoryLayouts($this->request->get['category_article_id']);
        } else {
            $this->data['category_article_layout'] = array();
        }

        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        $this->template = 'catalog/category_article_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'catalog/category_article')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        foreach ($this->request->post['category_article_description'] as $language_id => $value) {
            if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
                $this->error['name'][$language_id] = $this->language->get('error_name');
            }
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

    private function validateDelete() {
        if (!$this->user->hasPermission('modify', 'catalog/category_article')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    private function getCategories($parent_id, $parent_path = '', $indent = '') {
        $category_article_id = array_shift($this->path);

        $output = array();

        static $href_category_article = null;
        static $href_action = null;

        if ($href_category_article === null) {
            $href_category_article = $this->url->link('catalog/category_article', 'token=' . $this->session->data['token'] . '&path=', 'SSL');
            $href_action = $this->url->link('catalog/category_article/update', 'token=' . $this->session->data['token'] . '&category_article_id=', 'SSL');
        }

        $results = $this->model_catalog_category_article->getCategoriesByParentId($parent_id);

        foreach ($results as $result) {
            $path = $parent_path . $result['category_article_id'];

            $href = ($result['children']) ? $href_category_article . $path : '';

            $name = $result['name'];

            if ($category_article_id == $result['category_article_id']) {
                $name = '<b>' . $name . '</b>';

                $this->data['breadcrumbs'][] = array(
                    'text'      => $result['name'],
                    'href'      => $href,
                    'separator' => ' :: '
                );

                $href = '';
            }

            $selected = isset($this->request->post['selected']) && in_array($result['category_article_id'], $this->request->post['selected']);

            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $href_action . $result['category_article_id']
            );

            $output[$result['category_article_id']] = array(
                'category_article_id' => $result['category_article_id'],
                'name'        => $name,
                'category_article_sort_order'  => $result['category_article_sort_order'],
                'selected'    => $selected,
                'action'      => $action,
                'href'        => $href,
                'indent'      => $indent
            );

            if ($category_article_id == $result['category_article_id']) {
                $output += $this->getCategories($result['category_article_id'], $path . '_', $indent . str_repeat('&nbsp;', 8));
            }
        }

        return $output;
    }

    private function getAllCategories($categories, $parent_id = 0, $parent_name = '') {
        $output = array();

        if (array_key_exists($parent_id, $categories)) {
            if ($parent_name != '') {
                $parent_name .= $this->language->get('text_separator');
            }

            foreach ($categories[$parent_id] as $category_article) {
                $output[$category_article['category_article_id']] = array(
                    'category_article_id' => $category_article['category_article_id'],
                    'name'        => $parent_name . $category_article['name']
                );

                $output += $this->getAllCategories($categories, $category_article['category_article_id'], $parent_name . $category_article['name']);
            }
        }

        return $output;
    }
}
?>