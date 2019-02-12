<?php 
class ControllerProductSpecial extends Controller { 	
	public function index() { 
    	$this->language->load('product/special');
		$this->load->model('catalog/information');
		$this->addScriptSample();
		
		$this->totals($this->request->post);
		
		$this->document->setTitle($this->language->get('heading_title'));
		
   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('product/special'),
      		'separator' => $this->language->get('text_separator')
   		);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		$this->getText();
    	
		$informations = $this->model_catalog_information->getInformations();
		$this->data['description'] = array();
		
		foreach ($informations as $information) {
		    if ($information['special'] == 1) {
		        $this->data['description'][] = html_entity_decode($information['description'], ENT_QUOTES, 'UTF-8');
		    }
		}

        $this->sample($this->request->get);

        $file = '/template/product/special.tpl';
		$this->fileRender($file);
  	}

  	public function sample($data_get) {
        $data_get['special'] = true;
		$this->parentSample($data_get);
  	}
}
?>