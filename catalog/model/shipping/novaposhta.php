<?php

class ModelShippingnovaposhta extends Model {

    function getQuote($address) {
        $this->load->language('shipping/novaposhta');
        $status = FALSE;

        if ($this->config->get('novaposhta_status')) {
            $status = TRUE;
        }

        $method_data = array();

        if ($status) {
            $quote_data = array();

            $cost = 0.00;			
			
            if ($this->config->get('novaposhta_min_total_for_free_delivery') > $this->cart->getSubTotal()) {
                $cost = ($this->cart->getWeight() * $this->config->get('novaposhta_delivery_price')) + ($this->cart->getSubTotal() * $this->config->get('novaposhta_delivery_insurance') / 100) + $this->config->get('novaposhta_delivery_order');

                if ($this->session->data['payment_method']['code'] == 'cod') {
                    $cost += $this->config->get('novaposhta_delivery_nal');
                }
            }

            $quote_data['novaposhta'] = array(
                'code' => 'novaposhta.novaposhta',
                'title' => $this->language->get('text_description'),
                'cost' => $cost,
                'tax_class_id' => 0,
                'text' => $this->currency->format($cost)
            );

            $method_data = array(
                'code' => 'novaposhta',
                'title' => $this->language->get('text_title'),
                'quote' => $quote_data,
                'sort_order' => $this->config->get('novaposhta_sort_order'),
                'error' => FALSE
            );
        }

        return $method_data;
    }

}

?>