<?php
class ModelTotalSubTotal extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		$this->load->language('total/sub_total');
		
		$sub_totals = $this->cart->getSubTotal();

		// if (isset($this->session->data['vouchers']) && $this->session->data['vouchers']) {
		// 	foreach ($this->session->data['vouchers'] as $voucher) {
		// 		$sub_total += $voucher['amount'];
		// 	}
		// }
		
		foreach ($sub_totals as $sub_total) {
			$total_data[] = array(
				'code'       => 'sub_total',
				'currency'	 => $sub_total['currency'],
				'title'      => $this->language->get('text_sub_total'),
				'text'       => $this->currency->format($sub_total['price'], $sub_total['currency'], 1),
				'value'      => $sub_total['price'],
				'sort_order' => $this->config->get('sub_total_sort_order')
			);
		}
		
		if (isset($total_data[0]['value'])) {
			$total += $total_data[0]['value'];
		}
	}
}
?>