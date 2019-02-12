<?php
/**
 * Created by PhpStorm.
 * User: igor
 * Date: 02.09.14
 * Time: 14:27
 */

class ControllerExtensionTranslateSeo extends Controller {
    private $error = array();

    public function index() {
        $this->getForm();
    }

    public function getForm() {
        $this->load->language('extension/translate');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('extension/translate', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['heading_title'] = $this->language->get('heading_title');

        $this->data['text_confirm'] = $this->language->get('text_confirm');

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        if (isset($this->session->data['error'])) {
            $this->data['error'] = $this->session->data['error'];

            unset($this->session->data['error']);
        } else {
            $this->data['error'] = '';
        }

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $this->data['action'] = $this->url->link('extension/translate_seo/translate', 'token=' . $this->session->data['token'], 'SSL');

        $this->template = 'extension/translate.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    public function translate() {
        $this->load->language('extension/translate');

        if ($this->validateForm()) {
            $this->load->model('catalog/product');

            $products = $this->model_catalog_product->getProducts($data['filter_status'] = 1);

            foreach ($products as $product) {
                if (!$this->model_catalog_product->selectProductSeo($product['product_id'])) {
                    $product_name = preg_replace('/\(.*\)/', '', $product['name']);
                    $manufact = $this->model_catalog_product->getProdManuf($product['product_id']);
                    $maufact_seo = '';

                    if (isset($manufact['name'])) {
                        $maufact_seo = '_' . strtolower(str_replace(" ", "_", $this->translitIt(trim($manufact['name']))));
                    }

                    $seo = strtolower(str_replace(" ", "_", $this->translitIt(trim($product_name)))) . $maufact_seo;

                    if (!$this->model_catalog_product->repeatSeo($product['product_id'], $seo)) {
                        $this->model_catalog_product->addProductSeo($product['product_id'], $seo);
                    } else {
                        $this->error['warning'][] = "Повторение seo для " . $product['name'] . ", seo ($seo), id: (" . $product['product_id'] . ")";
                    }
                }
            }

            if (!$this->error) {
                $this->redirect($this->url->link('extension/translate_seo', 'token=' . $this->session->data['token'], 'SSL'));
            }
        }

        $this->getForm();
    }

    private function validateForm() {
        if (!$this->user->hasPermission('modify', 'extension/translate_seo')) {
            $this->error['warning'][] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return true;
        }

        return false;
    }

    function translitIt($str) {
        $tr = array(
            "А" => "A", "Б" => "B", "В" => "V", "Г" => "G",
            "Д" => "D", "Е" => "E", "Ж" => "J", "З" => "Z", "И" => "I",
            "Й" => "Y", "К" => "K", "Л" => "L", "М" => "M", "Н" => "N",
            "О" => "O", "П" => "P", "Р" => "R", "С" => "S", "Т" => "T",
            "У" => "U", "Ф" => "F", "Х" => "H", "Ц" => "TS", "Ч" => "CH",
            "Ш" => "SH", "Щ" => "SCH", "Ъ" => "", "Ы" => "YI", "Ь" => "",
            "Э" => "E", "Ю" => "YU", "Я" => "YA", "а" => "a", "б" => "b",
            "в" => "v", "г" => "g", "д" => "d", "е" => "e", "ж" => "j",
            "з" => "z", "и" => "i", "й" => "y", "к" => "k", "л" => "l",
            "м" => "m", "н" => "n", "о" => "o", "п" => "p", "р" => "r",
            "с" => "s", "т" => "t", "у" => "u", "ф" => "f", "х" => "h",
            "ц" => "ts", "ч" => "ch", "ш" => "sh", "щ" => "sch", "ъ" => "y",
            "ы" => "yi", "ь" => "", "э" => "e", "ю" => "yu", "я" => "ya"
        );
        return strtr($str, $tr);
    }
}

?>