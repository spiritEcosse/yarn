<?php  
class ControllerInformationSitemap extends Controller {
	public function index() {
    	$this->language->load('information/sitemap');
		$this->load->model('design/topmenu');
		$this->load->model('catalog/information');
 
		$this->document->setTitle($this->language->get('heading_title')); 

      	$this->breadcrumbs();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('information/sitemap'),      	
        	'separator' => $this->language->get('text_separator')
      	);	
		
    	$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_special'] = $this->language->get('text_special');
		$this->data['text_account'] = $this->language->get('text_account');
    	$this->data['text_edit'] = $this->language->get('text_edit');
    	$this->data['text_password'] = $this->language->get('text_password');
    	$this->data['text_address'] = $this->language->get('text_address');
    	$this->data['text_history'] = $this->language->get('text_history');
    	$this->data['text_download'] = $this->language->get('text_download');
    	$this->data['text_cart'] = $this->language->get('text_cart');
    	$this->data['text_checkout'] = $this->language->get('text_checkout');
    	$this->data['text_search'] = $this->language->get('text_search');
    	$this->data['text_information'] = $this->language->get('text_information');
    	$this->data['text_contact'] = $this->language->get('text_contact');
				
		$this->data['categories'] = $this->model_design_topmenu->getMenu();
		
		$this->data['special'] = $this->url->link('product/special');
		$this->data['account'] = $this->url->link('account/account', '', 'SSL');
  	$this->data['edit'] = $this->url->link('account/edit', '', 'SSL');
  	$this->data['password'] = $this->url->link('account/password', '', 'SSL');
  	$this->data['address'] = $this->url->link('account/address', '', 'SSL');
  	$this->data['history'] = $this->url->link('account/order', '', 'SSL');
  	$this->data['download'] = $this->url->link('account/download', '', 'SSL');
  	$this->data['cart'] = $this->url->link('checkout/cart');
  	$this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');
  	$this->data['search'] = $this->url->link('product/search');
  	$this->data['contact'] = $this->url->link('information/contact');
		
		$this->data['informations'] = array();
    	
		foreach ($this->model_catalog_information->getInformations() as $result) {
      		$this->data['informations'][] = array(
        		'title' => $result['title'],
        		'href'  => $this->url->link('information/information', 'information_id=' . $result['information_id']) 
      		);
    	}
        
        // $fp = fopen("sitemap.xml", "a+"); // Открываем файл в режиме записи 
        $mytext = '<?xml version="1.0" encoding="UTF-8"?>
            <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
              xmlns:image="http://www.google.com/schemas/sitemap-image/1.1" 
              xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">
              <url> 
                <loc>http://www.example.com/foo.html</loc> 
                <image:image>
                   <image:loc>http://example.com/image.jpg</image:loc> 
                </image:image>
                <video:video>     
                  <video:content_loc>
                    http://www.example.com/video123.flv
                  </video:content_loc>
                  <video:player_loc allow_embed="yes" autoplay="ap=1">
                    http://www.example.com/videoplayer.swf?video=123
                  </video:player_loc>
                  <video:thumbnail_loc>
                    http://www.example.com/thumbs/123.jpg
                  </video:thumbnail_loc>
                  <video:title>Приготовление шашлыков</video:title>  
                  <video:description>
                    Как приготовить отличные шашлыки
                  </video:description>
                </video:video>
              </url>
            </urlset>';
        
        // $test = fwrite($fp, $mytext);
        // if ($test) echo 'Данные в файл успешно занесены.';
        // else echo 'Ошибка при записи в файл.';
        // fclose($fp);

        // header('Location: http://' . $_SERVER['SERVER_NAME'] . '/sitemap.xml');

		$this->fileRender('/template/information/sitemap.tpl');
	}
}
?>