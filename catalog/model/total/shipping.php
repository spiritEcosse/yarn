<?php
class ModelTotalShipping extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		if ($this->cart->hasShipping() && isset($this->session->data['shipping_method'])) {
            $cost = $this->session->data['shipping_method']['cost'];

            if ($this->session->data['shipping_method']['code'] == 'novaposhta.novaposhta' && isset($this->session->data['nova_pochta'])) {
                $zone_price = $cost;

                if (isset($this->session->data['zone_price'])) {
                    $zone_price = $this->session->data['zone_price'];
                } else if ($this->config->get('novaposhta_delivery_price')) {
                    $zone_price = $this->config->get('novaposhta_delivery_price');
                }

                if ($this->config->get('novaposhta_min_total_for_free_delivery') > $this->cart->getTotal()) {
                    $cost = $zone_price * $this->cart->getWeight() + $this->config->get('novaposhta_delivery_order') + ($this->cart->getTotal() * $this->config->get('novaposhta_delivery_insurance') / 100);

                    if (isset($this->session->data['payment_method']['code']) && $this->session->data['payment_method']['code'] == 'cod') {
                        $cost += $this->config->get('novaposhta_delivery_nal');
                    }
                }

                $total_data[] = array(
                    'code'       => 'shipping',
                    'title'      => $this->session->data['shipping_method']['title'],
                    'text'       => $cost . ' грн.',
                    'value'      => $cost . ' грн.',
                    'sort_order' => $this->config->get('shipping_sort_order')
                );
            } else {
                $total_data[] = array(
                    'code'       => 'shipping',
                    'title'      => $this->session->data['shipping_method']['title'],
                    'text'       => $this->currency->format($cost),
                    'value'      => $this->currency->format($cost),
                    'sort_order' => $this->config->get('shipping_sort_order')
                );
            }

			if ($this->session->data['shipping_method']['tax_class_id']) {
				$tax_rates = $this->tax->getRates($this->session->data['shipping_method']['cost'], $this->session->data['shipping_method']['tax_class_id']);
				
				foreach ($tax_rates as $tax_rate) {
					if (!isset($taxes[$tax_rate['tax_rate_id']])) {
						$taxes[$tax_rate['tax_rate_id']] = $tax_rate['amount'];
					} else {
						$taxes[$tax_rate['tax_rate_id']] += $tax_rate['amount'];
					}
				}
			}
			
			$total += $this->session->data['shipping_method']['cost'];
		}			
	}
}
?>