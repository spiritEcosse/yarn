<?php

class ControllerCommonFurnitureOrderHeader extends Controller {

    protected function index() {
        $this->data['title'] = $this->document->getTitle();

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = $this->config->get('config_ssl');
        } else {
            $this->data['base'] = $this->config->get('config_url');
        }
        
        $this->document->addScript('catalog/view/javascript/topmenu.js');
        
        $this->data['description'] = $this->document->getDescription();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['links'] = $this->document->getLinks();
        $this->data['styles'] = $this->document->getStyles();
        $this->data['scripts'] = $this->document->getScripts();
        $this->data['lang'] = $this->language->get('code');
        $this->data['direction'] = $this->language->get('direction');
        $this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');

        $this->load->model('catalog/information');
        
        $this->language->load('common/header');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = HTTPS_IMAGE;
        } else {
            $server = HTTP_IMAGE;
        }

        if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
            $this->data['icon'] = $server . $this->config->get('config_icon');
        } else {
            $this->data['icon'] = '';
        }

        $this->data['name'] = $this->config->get('config_name');

        $telephones = explode(',', $this->config->get('config_telephone'));
        foreach ($telephones as $telephone) {
            $this->data['telephones'][] = $telephone;
        }
        $this->data['skype'] = $this->config->get('config_skype');
        $this->data['email_shop'] = $this->config->get('config_email');
        $this->data['credit'] = $this->config->get('config_top_credit');

        if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
            $this->data['logo'] = $server . $this->config->get('config_logo');
        } else {
            $this->data['logo'] = '';
        }

        $this->data['text_home'] = $this->language->get('text_home');
        $this->data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        $this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
        $this->data['text_search'] = $this->language->get('text_search');
        $this->data['text_welcome'] = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
        $this->data['text_logged'] = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

        $this->data['text_skype'] = $this->language->get('text_skype');
        $this->data['text_email'] = $this->language->get('text_email');
        $this->data['text_telephone'] = $this->language->get('text_telephone');
        $this->data['credit_image'] = $this->language->get('credit_image');

        $this->data['text_account'] = $this->language->get('text_account');
        $this->data['text_contacts'] = $this->language->get('text_contacts');
        $this->data['text_delivery'] = $this->language->get('text_delivery');
        $this->data['text_checkout'] = $this->language->get('text_checkout');

        $this->data['logged'] = $this->customer->isLogged();

        $this->data['tops'] = array();

        foreach ($this->model_catalog_information->getInformations() as $result) {
            if ($result['top']) {
                $this->data['tops'][] = array(
                    'title' => $result['title'],
                    'href' => $this->url->link('information/information', 'information_id=' . $result['information_id'])
                );
            }
        }
        
        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/furniture_order_header.tpl')) {
            $this->template = $this->config->get('config_template') . '/template/common/furniture_order_header.tpl';
        } else {
            $this->template = 'default/template/common/furniture_order_header.tpl';
        }

        $this->render();
    }
}

?>