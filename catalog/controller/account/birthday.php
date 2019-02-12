<?php

class ControllerAccountBirthday extends Controller {
	public function index($setting) {
        $this->load->model('catalog/product');
        $this->load->model('catalog/category');
        $this->language->load('account/birthday');

        if ($setting['logged'] && $setting['discount_birthday'] != NULL) {
            $this->data['first_name'] = $setting['first_name'];
            $this->data['last_name'] = $setting['last_name'];
        } else {
            return false;
        }

        if (count($this->config->get('discount_birthday_days_products')) == 1) {
            $this->data['warning_birthday_price'] = sprintf($this->language->get('warning_birthday_product'), $this->currency->format($this->config->get('discount_birthday_total_price'), $this->currency->getCode(), 1));
        } elseif (count($this->config->get('discount_birthday_days_products')) > 1) {
            $this->data['warning_birthday_price'] = sprintf($this->language->get('warning_birthday_products'), $this->currency->format($this->config->get('discount_birthday_total_price'), $this->currency->getCode(), 1));
        }

        $this->data['birthday_description'] = html_entity_decode($this->config->get('birthday_description'));
        $this->data['discount_birthday_days_products'] = array();

        foreach ($this->config->get('discount_birthday_days_products') as $product_id) {
            $product = $this->model_catalog_product->getProduct($product_id);

            $category_id = $this->model_catalog_category->getCategroyByProduct($product_id);

            $path = $this->model_catalog_category->treeCategory($category_id);
            $path = array_reverse($path);
            $path = implode('_', $path);

            $this->data['discount_birthday_days_products'][] = array(
                'name' => $product['name'],
                'product_id' => $product['product_id'],
                'href' => $this->url->link('product/product', $path . '&product_id=' . $product_id)
            );
        }

        $this->fileRenderModule('/template/account/birthday.tpl');
  	}

    public function sendMailCustomersBirthday() {
        $this->reset_cache();

        $this->load->model('account/customer');
        $customers = $this->model_account_customer->getCustomers();

        $module['setting'] = array();
        $module['setting']['logged'] = true;

        foreach ($customers as $customer) {
            $module['setting']['first_name'] = $customer['firstname'];
            $module['setting']['last_name'] = $customer['lastname'];
            $module['setting']['discount_birthday'] = $this->customer->getDate($module['setting']['logged'], $customer['date_birthday'], '', $customer['date_get_gift']);

            $get_html = $this->getChild('account/birthday', $module['setting']);

            if ($get_html) {
                $subject = 'Поздравление с днем рождения.';

                if (addslashes($this->config->get('discount_birthday_subject'))) {
                    $subject = addslashes($this->config->get('discount_birthday_subject'));
                }

                $mail = new Mail();
                $mail->protocol = $this->config->get('config_mail_protocol');
                $mail->parameter = $this->config->get('config_mail_parameter');
                $mail->hostname = $this->config->get('config_smtp_host');
                $mail->username = $this->config->get('config_smtp_username');
                $mail->password = $this->config->get('config_smtp_password');
                $mail->port = $this->config->get('config_smtp_port');
                $mail->timeout = $this->config->get('config_smtp_timeout');
                $mail->setTo($customer['email']);
                $mail->setFrom($this->config->get('config_email'));
                $mail->setSender($this->config->get('config_name'));
                $mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
                $mail->setHtml($get_html);
                $mail->send();
            }
        }
    }
}

?>