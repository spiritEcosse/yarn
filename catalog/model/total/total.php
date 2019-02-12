<?php
class ModelTotalTotal extends Model {
	public function getTotal(&$total_data, &$total, &$taxes) {
		$this->load->language('total/total');
	 
//		$total_data[] = array(
//			'code'       => 'total',
//			'title'      => $this->language->get('text_total'),
//			'text'       => $this->currency->format(max(0, $total)),
//			'value'      => max(0, $total),
//			'sort_order' => $this->config->get('total_sort_order')
//		);
//
//        $special_price = $this->cart->getTotalSpecialPrice();
//
//        if ($special_price > 0) {
//            $will_save_sort_order = 2;
//
//            if ($this->config->get('will_save_sort_order')) {
//                $will_save_sort_order = $this->config->get('will_save_sort_order');
//            }
//
//            $total_data[] = array(
//                'title' => $this->language->get('text_diff_price'),
//                'text' => '<span class="red">' . $this->currency->format(max(0, $special_price)) . '</span>',
//                'sort_order' => $will_save_sort_order,
//                'code'       => 'total',
//                'value'      => max(0, $special_price)
//            );
//        }
	}
}
?>