<?php   
class ControllerErrorNotFound extends Controller {
	public function index() {		
		$this->language->load('error/not_found');
		
		$this->document->setTitle($this->language->get('heading_title'));
      	$this->breadcrumbs();
				
		if (isset($this->request->get['route'])) {
       		$this->data['breadcrumbs'][] = array(
        		'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link($this->request->get['route']),
        		'separator' => $this->language->get('text_separator')
      		);	   	
		}
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_error'] = $this->language->get('text_error');
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . '/1.1 404 Not Found');
		$this->data['continue'] = $this->url->link('common/home');

		$this->fileRender('/template/error/not_found.tpl');
  	}
}
?>