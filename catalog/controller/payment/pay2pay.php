<?php
class ControllerPaymentpay2pay extends Controller {
  protected function index() {
    $this->data['button_confirm'] = $this->language->get('button_confirm');
    $this->data['button_back'] = $this->language->get('button_back');


    $this->data['action'] = 'https://merchant.pay2pay.com/?page=init';

    $this->load->model('checkout/order');

    $order_info = $this->model_checkout_order->getOrder($this->session->data['order_id']);

    $lang = strtolower($this->session->data['language']);
    if ($lang != 'en') $lang = 'ru';
    $this->data['version'] = '1.2';
    $this->data['merchant_id'] = $this->config->get('pay2pay_merchant_id');
    $this->data['language'] = $lang;
    $this->data['order_id'] =  $this->session->data['order_id'];
    $cur_code = $order_info['currency_code'];
    if (strtoupper($cur_code) == 'RUR')
      $cur_code = 'RUB';
    $order_total = $order_info['total'];
    $this->data['amount'] = $this->currency->format($order_total, $cur_code, $order_info['currency_value'], FALSE);
    $this->data['currency'] = strtoupper($cur_code);
    $this->data['description'] = $this->config->get('config_store') . ' ' . $order_info['payment_firstname'] . ' ' . $order_info['payment_address_1'] . ' ' . $order_info['payment_address_2'] . ' ' . $order_info['payment_city'] . ' ' . $order_info['email'];
    $this->data['paymode'] = $this->config->get('pay2pay_paymode');
    $this->data['test_mode'] = $this->config->get('pay2pay_test');
    $this->data['SecretKey'] = $this->config->get('pay2pay_secret_key');

    $this->data['xml'] = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
    $this->data['xml'] .="<request>";
    $this->data['xml'] .= "<version>" .$this->data['version']. "</version>";
    $this->data['xml'] .= "<merchant_id>" .$this->data['merchant_id']. "</merchant_id>";
    $this->data['xml'] .= "<language>" .$this->data['language']. "</language>";
    $this->data['xml'] .= "<order_id>" .$this->data['order_id']. "</order_id>";
    $this->data['xml'] .= "<amount>" .$this->data['amount']. "</amount>";
    $this->data['xml'] .= "<currency>" .$this->data['currency']. "</currency>";
    $this->data['xml'] .= "<description>" .$this->data['description']. "</description>";
    $this->data['xml'] .= "<paymode><code>" .$this->data['paymode']. "</code></paymode>";
    $this->data['xml'] .= "<test_mode>" .$this->data['test_mode']. "</test_mode>";
    $this->data['xml'] .= "</request>";

    $this->data['sign']= md5($this->data['SecretKey'] .$this->data['xml']. $this->data['SecretKey']);

    $this->data['xml'] =  base64_encode($this->data['xml']);
    $this->data['sign']= base64_encode($this->data['sign']);

    if ($this->request->get['route'] != 'checkout/guest_step_3') {
      $this->data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
    } else {
      $this->data['cancel_return'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
    }

    if ($this->request->get['route'] != 'checkout/guest_step_3') {
      $this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/payment';
    } else {
      $this->data['back'] = HTTPS_SERVER . 'index.php?route=checkout/guest_step_2';
    }

    $this->id = 'payment';

    if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/payment/pay2pay.tpl')) {
      $this->template = $this->config->get('config_template') . '/template/payment/pay2pay.tpl';
    } else {
      $this->template = 'default/template/payment/pay2pay.tpl';
    }

    $this->render();
  }

  public function fail() {
    $this->redirect(HTTPS_SERVER . 'index.php?route=checkout/checkout');
  }

  public function success() {
    $this->redirect(HTTPS_SERVER . 'index.php?route=checkout/success');
  }

  public function callback() 
  {
    $SecretKey = $this->config->get('pay2pay_hidden_key');
    $xml_post = base64_decode(str_replace(' ', '+', $this->request->post['xml']));
    $vars = simplexml_load_string($xml_post);
    $ar_req['status']      = $vars->status;
    $ar_req['order_id']    = $vars->order_id;
    $ar_req['amount']      = $vars->amount;
    $ar_req['currency']    = $vars->currency;
    $inv_id = $ar_req['order_id'];
    $sign = md5($SecretKey .$xml_post. $SecretKey);
  
    $sign = base64_encode($sign);
    $sign_post = $this->request->post['sign'];
    $sign_encode =  $sign;
    $this->load->model('checkout/order');
    $order_info = $this->model_checkout_order->getOrder($inv_id);
    $cur_code = $order_info['currency_code'];
    if (strtoupper($cur_code) == 'RUR')
      $cur_code = 'RUB';
    $order_total = $order_info['total'];
    $amount = $this->currency->format($order_total, $cur_code, $order_info['currency_value'], FALSE);

    if ($sign_post != $sign_encode) {
      echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>no</status><err_msg>Security check failed</err_msg></response>";
    }
    elseif ($amount > $ar_req['amount']) {
      echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>no</status><err_msg>Amount check failed</err_msg></response>";
    }
    elseif (strtoupper($cur_code) != $ar_req['currency']) {
      echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>no</status><err_msg>Currency check failed</err_msg></response>";
    }
    elseif ($ar_req['status'] == 'success')
    {
      $this->load->model('checkout/order');
      $order_info = $this->model_checkout_order->getOrder($inv_id);

      if (! $order_info) {
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>no</status><err_msg>Undefined order</err_msg></response>";
      }
      else
      {
        if( $order_info['order_status_id'] == 0) {
          $this->model_checkout_order->confirm($inv_id, $this->config->get('pay2pay_order_status_id'), 'Pay2Pay');
        }
        if( $order_info['order_status_id'] != $this->config->get('pay2pay_order_status_id')) {
          $this->model_checkout_order->update($inv_id, $this->config->get('pay2pay_order_status_id'),'Pay2Pay',TRUE);
        }
        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?><response><status>yes</status><err_msg></err_msg></response>";
      }
    }
  }
}
?>