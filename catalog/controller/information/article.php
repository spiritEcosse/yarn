<?php
class ControllerInformationArticle extends Controller {
    public function index() {
        $this->language->load('information/article');
        $this->load->model('catalog/article');

        $this->data['heading_title'] = $this->language->get('heading_title');
        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['text_empty'] = $this->language->get('text_empty');

        $this->data['continue'] = $this->url->link('common/home');

        $this->totals($this->request->post);

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('product/article'),
            'separator' => $this->language->get('text_separator')
        );

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

        $article_total = $this->model_catalog_article->getTotalarticles();
        $articles = $this->model_catalog_article->getarticles();

        if ($articles) {
            $this->data['articles'] = array();

            foreach ($articles as $article) {
                $article['article_link'] = html_entity_decode($article['article_link'], ENT_QUOTES, 'UTF-8');
                $this->data['articles'][] = $article;
            }

            $pagination = new Pagination();
            $pagination->total = $article_total;
            $pagination->page = $page;
            $pagination->limit = $limit;
            $pagination->text = $this->language->get('text_pagination');
            $pagination->url = $this->url->link('product/', '&page={page}');

            $this->data['pagination'] = $pagination->render();

            $this->data['sort'] = $sort;
            $this->data['order'] = $order;
            $this->data['limit'] = $limit;

            $this->data['continue'] = $this->url->link('common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/information/article.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/information/article.tpl';
            } else {
                $this->template = 'default/template/information/article.tpl';
            }

            $this->children = array(
                'common/column_left',
                'common/column_right',
                'common/content_top',
                'common/content_bottom',
                'common/footer',
                'common/header'
            );

            $this->response->setOutput($this->render());
        } else {
            $url = '';

            if (isset($this->request->get['path'])) {
                $url .= '&path=' . $this->request->get['path'];
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

            $this->data['breadcrumbs'][] = array(
                'text'      => $this->language->get('text_error'),
                'href'      => $this->url->link('product/category', $url),
                'separator' => $this->language->get('text_separator')
            );

            $this->document->setTitle($this->language->get('text_error'));

            $this->data['heading_title'] = $this->language->get('text_error');
            $this->data['text_error'] = $this->language->get('text_error');
            $this->data['button_continue'] = $this->language->get('button_continue');

            $this->data['continue'] = $this->url->link('common/home');

            if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
            } else {
                $this->template = 'default/template/error/not_found.tpl';
            }

            $this->children = array(
                'common/column_left',
                'common/column_right',
                'common/content_top',
                'common/content_bottom',
                'common/footer',
                'common/header'
            );

            $this->response->setOutput($this->render());
        }
    }
}
?>