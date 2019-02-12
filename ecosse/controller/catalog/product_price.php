<?php

class ControllerCatalogProductPrice extends Controller {
    public function index() {
        $this->load->language('catalog/product_price');
                
        $this->document->setTitle($this->language->get('heading_title')); 

        $this->load->model('catalog/product_price');

        $this->getData();
    }
    
    public function getData() {
        $this->load->model('catalog/product_price');
        $this->load->model('catalog/manufacturer');
        $this->load->language('catalog/product_price');
        
        $this->data['heading_title'] = $this->language->get('heading_title');
        
        $this->data['text_manufacturer'] = $this->language->get('text_manufacturer');
        $this->data['text_none'] = $this->language->get('text_none');
        $this->data['text_update'] = $this->language->get('text_update');
        $this->data['text_increase'] = $this->language->get('text_increase');
        $this->data['text_reduce'] = $this->language->get('text_reduce');
        $this->data['text_factor'] = $this->language->get('text_factor');
        $this->data['text_percent'] = $this->language->get('text_percent');
        $this->data['text_product'] = $this->language->get('text_product');
        $this->data['text_select_all'] = $this->language->get('text_select_all');
        $this->data['text_unselect_all'] = $this->language->get('text_unselect_all');
        
        $this->data['button_update'] = $this->language->get('button_update');
        
        $this->data['breadcrumbs'] = array();
        
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );
        
        $this->data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('catalog/product_price', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );
        
        $this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
        
        $this->template = 'catalog/product_price.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );
        
        $this->response->setOutput($this->render());
    }
    
    public function getProduct() {
        $this->load->model('catalog/product');
        
        $manufacturer_id = $this->request->get['manufacturer_id'];
        
        $products = $this->model_catalog_product->getProductManufacturerId($manufacturer_id);
        
        $data_product = array();
        
        foreach ($products as $product) {
            $data_product[] = array('product_id' => $product['product_id'], 'name' => $product['name'], 'model' => $product['model']);
        }
        
        $result = array();
        
        if (count($data_product)) {
            $result = array('type' => 'success', 'data' => $data_product);
        } else {
            $result = array('type' => 'error', 'message' => "Данные по товарам не получены");
        }
        
        print json_encode($result);
        return;
    }
    
    public function updatePrice() {
        $this->load->model('catalog/product_price');
        
        $products = explode(",", $this->request->get['product']);
        $type = $this->request->get['type'];
        $type_table = $this->request->get['type_table'];
        $factor = null;
        $fix_number = null;
        $text = false;
        $product_special['special'] = $this->request->get['special'];
        $product_special['date_start'] = $this->request->get['date_start'];
        $product_special['date_end'] = $this->request->get['date_end'];

        if (isset($this->request->get['factor']) && $this->request->get['factor'] != 0) {
            $factor = $this->request->get['factor'];
        }

        if (isset($this->request->get['fix_number']) && $factor == null) {
            if (is_int((int)$this->request->get['fix_number']) && (int)$this->request->get['fix_number'] > 0) {
                $fix_number = (int)$this->request->get['fix_number'];
            } else {
                $text = 'Число должно быть целым и положительным';
            }
        }
        
        if ($product_special['special'] == 1) {
            if ($product_special['date_start'] == '') {
                $text = 'Дата начала акции не определена';
            }

            if ($product_special['date_end'] == '') {
                $text = 'Дата окончания акции не определена';
            }
        }

        if ($text == false) {
            if (($factor != null || $fix_number != null) && $type != 0) {
                foreach ($products as $product) {
                    $this->model_catalog_product_price->updatePrice($product, $factor, $type, $type_table, $fix_number, $product_special);
                }
                
                $text = 'Операция успешна!';
            } else {
                $text = 'Не выбран тип изменения или числовой коэффициент!';
            }
        }
        
        print json_encode(array('message' => $text));
        return;
    }
}

?>
