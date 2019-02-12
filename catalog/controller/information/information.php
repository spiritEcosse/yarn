<?php 
class ControllerInformationInformation extends Controller {
	public function index() {  
    	$this->language->load('information/information');
		$this->load->model('catalog/information');

		$this->breadcrumbs();
		
		$information_id = 0;

		if (isset($this->request->get['information_id'])) {
			$information_id = $this->request->get['information_id'];
		}
		
		$information_info = $this->model_catalog_information->getInformation($information_id);
   		
		if ($information_info) {
			$seo_title = $information_info['title'];

			if ($information_info['seo_title']) {
				$seo_title = $information_info['seo_title'];
			}

			$this->document->setDescription($information_info['meta_description']);
			$this->document->setKeywords($information_info['meta_keyword']);
			
      		$this->data['breadcrumbs'][] = array(
        		'text'      => $information_info['title'],
				'href'      => $this->url->link('information/information', 'information_id=' .  $information_id),      		
        		'separator' => $this->language->get('text_separator')
      		);		
						
			$this->data['seo_h1'] = $information_info['seo_h1'];
			$this->data['heading_title'] = $information_info['title'];
			$this->data['description'] = html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8');

			$file = '/template/information/information.tpl';
    	} else {
      		$this->data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('information/information', 'information_id=' . $information_id),
        		'separator' => $this->language->get('text_separator')
      		);
				
	  		$seo_title = $this->language->get('text_error');
      		$this->data['heading_title'] = $this->language->get('text_error');
      		$this->data['text_error'] = $this->language->get('text_error');

      		$file = '/template/error/not_found.tpl';
    	}

		$this->document->setTitle($seo_title);
		$this->data['continue'] = $this->url->link('common/home');
      	$this->data['button_continue'] = $this->language->get('button_continue');
    	$this->fileRender($file);
  	}
	
	public function info() {
		$this->load->model('catalog/information');
		$information_id = 0;
		
		if (isset($this->request->get['information_id'])) {
			$information_id = $this->request->get['information_id'];
		}
		
		$information_info = $this->model_catalog_information->getInformation($information_id);
		
		if ($information_info) {
			$output  = '<html dir="ltr" lang="en">' . "\n";
			$output .= '<head>' . "\n";
			$output .= '  <title>' . $information_info['title'] . '</title>' . "\n";
			$output .= '  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">' . "\n";
			$output .= '</head>' . "\n";
			$output .= '<body>' . "\n";
			$output .= '  <h1>' . $information_info['title'] . '</h1>' . "\n";
			$output .= html_entity_decode($information_info['description'], ENT_QUOTES, 'UTF-8') . "\n";
			$output .= '  </body>' . "\n";
			$output .= '</html>' . "\n";			

			$this->response->setOutput($output);
		}
	}
}
?>