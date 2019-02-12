<?php
class ControllerModuleSpecialPriceCountDown extends Controller {
	protected function index($setting) {
		static $module = 0;
		
		
		$this->data['heading_title'] = $this->config->get('special_price_countdown_heading_title_' . $this->config->get('config_language_id') );
		
		$this->load->model('module/special_price_countdown');
		
		$this->data['show_special_price_countdown'] = 0;
		
		if (isset($this->request->get['product_id'])){
		
			$date_stop = $this->model_module_special_price_countdown->getSpecialPriceEndData($this->request->get['product_id']);
			
			if ($date_stop){
				$this->data['show_special_price_countdown'] = 1;
				
				$target_split = preg_split('/\-/', $date_stop);		
				
				$now = time();
				$target = mktime(0,0,0, $target_split[1], $target_split[2], $target_split[0]);

				$diffSecs = $target - $now;

				$date = array();
				$date['secs'] = $diffSecs % 60;
				$date['mins'] = floor($diffSecs/60)%60;
				$date['hours'] = floor($diffSecs/60/60)%24;
				$date['days'] = floor($diffSecs/60/60/24);//%7;
				$date['weeks']	= floor($diffSecs/60/60/24/7);
			
				foreach ($date as $i => $d) {
					$d1 = $d%10;
					$d2 = ($d-$d1) / 10;
					$date[$i] = array(
						(int)$d2,
						(int)$d1,
						(int)$d
					);
				}
				
				$this->data['target_split'] = $target_split;
				$this->data['date']         = $date;
				
				$this->data['secs']  = $diffSecs % 60;
				$this->data['mins']  = floor($diffSecs/60)%60;
				$this->data['hours'] = floor($diffSecs/60/60)%24;
				$this->data['days']  = floor($diffSecs/60/60/24);//%7;
				$this->data['weeks'] = floor($diffSecs/60/60/24/7);
				$this->data['type']  = $setting['type'];
			} 	
		}
		
		$this->data['theme_name'] = $this->config->get('config_template');

		$this->data['module'] = $module++;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/special_price_countdown.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/special_price_countdown.tpl';
		} else {
			$this->template = 'default/template/module/special_price_countdown.tpl';
		}

		$this->render();
	}
}
?>