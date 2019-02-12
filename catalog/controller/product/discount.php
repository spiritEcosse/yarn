<?php 
class ControllerProductDiscount extends Controller { 	
	public function index() { 
    	$this->language->load('product/discount');
		$this->load->model('catalog/information');
		$this->addScriptSample();
		
		$this->totals($this->request->post);
		
		$this->document->setTitle($this->language->get('heading_title'));
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('product/discount'),
      		'separator' => $this->language->get('text_separator')
   		);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->getText();
        $this->sample($this->request->get);

        $file = '/template/product/discount.tpl';
		$this->fileRender($file);
  	}

  	public function sample($data_get) {
		$this->parentSample($data_get);
  	}
}
?>