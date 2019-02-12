<?php

class ControllerCommonHeader extends Controller {
    
    protected function index() {
        $this->data['title'] = $this->document->getTitle();
        $this->language->load('common/header');
        $this->load->model('catalog/information');
        $this->load->model('tool/image');
        $this->load->model('setting/store');
        $this->load->model('catalog/manufacturer');
        $this->load->model('design/topmenu');
        $this->load->model('design/layout');
        $this->load->model('catalog/category');
        $this->load->model('catalog/product');
        $this->load->model('setting/extension');
        $this->load->model('catalog/blog');
        $this->load->model('catalog/record');
        $this->getChild('common/seoblog');

        if ($_SERVER['REQUEST_URI'] != '/index.php?route=account/login' && $_SERVER['REQUEST_URI'] != '/index.php?route=account/register' && $_SERVER['REQUEST_URI'] != '/index.php?route=account/success') {
            $this->session->data['last_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $this->data['base'] = $this->config->get('config_ssl');
        } else {
            $this->data['base'] = $this->config->get('config_url');
        }

        $this->data['audio'] = $this->config->get('GALKAControl_play_sound');

        $path_template = 'catalog/view/theme/' . $this->config->get('config_template') . '/';
        $path = 'catalog/view/javascript/';
        
        $files_style = array();
        $files_script = array();
        
        $files_script[] = $path . 'common.js';
        $files_script[] = $path_template . 'js/custom_scripts.js';
        $files_script[] = $path . 'jquery/ui/external/jquery.cookie.js';
        $files_script[] = $path . 'jquery/jquery.cycle.js';
        $files_script[] = $path . 'jquery.liveValidation.js';
//        $files_script[] = $path . 'fastorder.js';
        $files_script[] = $path . 'jquery/ui/jquery-ui-timepicker-addon.js';
        $files_script[] = $path . 'highslid.js';
        $files_script[] = $path . 'custom_scripts_end.js';
        $files_script[] = $path . 'jquery.scrollTo-min.js';
        $files_script[] = $path . 'jquery.bxslider/jquery.bxslider.min.js';

        $files_style[] = $path . 'jquery.bxslider/jquery.bxslider.css';

        $files_style[] = $path . 'jquery/ui/themes/ui-lightness/jquery-ui-1.8.16.custom.css';
        $files_style[] = $path . 'jquery/colorbox/colorbox.css';
//        $files_style[] = $path_template . 'stylesheet/fastorder.css';
        $files_style[] = $path_template . 'stylesheet/livesearch.css';
        $files_style[] = $path . 'callme/callme.css';

        $files_script[] = $path . 'callme/jquery.storage.js';
        $files_script[] = $path . 'callme/callme.js';
        $files_script[] = $path . 'plus_minus_quantity.js';
        $files_script[] = $path . 'jquery/colorbox/jquery.colorbox-min.js';
        
        if ($this->config->get('config_template') == 'default') {
            $files_style[] = $path_template . 'stylesheet/stylesheet.css';
            $files_style[] = $path_template . 'stylesheet/topmenu.css';
            
            $files_script[] = $path . 'livesearch.js';
            $files_script[] = $path . 'jquery/colorbox/jquery.colorbox.js';
            // $files_script[] = $path . 'jquery/tabs.js';
            $files_script[] = $path . 'jquery/modal/jquery.reveal.js';
            $files_script[] = $path . 'topmenu.js';
        } elseif ($this->config->get('config_template') == 'GALKA') {
            $files_script[] = $path_template . 'js/ayaSlider-minified.js';
            $files_script[] = $path_template . 'js/flex/jquery.flexslider-min.js';
            $files_script[] = $path_template . 'js/jquery.nivo.slider.pack.js';
            $files_script[] = $path_template . 'js/count/jquery.countdown.js';
            $files_script[] = $path_template . 'js/jquery.easing.min.js';
            // $files_script[] = $path . 'jquery/ui/minified/jquery.ui.slider.min.js';
            // $files_script[] = $path_template . 'js/cloud-zoom.1.0.2.min.js';
            $files_script[] = $path . 'jquery/tabs.js';
            // $files_script[] = $path . 'jquery/jquery.total-storage.min.js';
            
            $files_style[] = $path_template . 'stylesheet/font-awesome.min.css';
            $files_style[] = $path_template . 'stylesheet/slideshow.css';
            $files_style[] = $path_template . 'js/flex/flexslider.css';
            $files_style[] = $path_template . 'js/cloud-zoom.css';
            
            $files_style[] = $path . 'jquery/ui/themes/ui-lightness/jquery.ui.all.css';
            $files_style[] = $path_template . 'stylesheet/blog.css';
            
            $this->data['menuType'] = $this->config->get('GALKAControl_menu');
            
            if ($this->config->get('GALKAControl_status') == 1) {
                if ($this->config->get('GALKAControl_skin') != null) {
                    $files_style[] = $path_template . 'stylesheet/' . $this->config->get('GALKAControl_skin') . '.css';
                } else {
                    $files_style[] = $path_template . 'stylesheet/stylesheet.css';
                }

                if ($this->config->get('GALKAControl_custom_font') != null) {
                    $files_style[] = $this->config->get('GALKAControl_custom_font');
                } elseif ($this->config->get('GALKAControl_header_font') != 'Arial') {
                    $files_style[] = "https://fonts.googleapis.com/css?family=" . $this->config->get('GALKAControl_headings_font');
                } else {
                    $files_style[] = "https://fonts.googleapis.com/css?family=Ubuntu+Condensed";
                }

                if ($this->config->get('GALKAControl_responsive') == 1) {
                    $files_style[] = $path_template . 'stylesheet/responsive.css';
                    $files_script[] = $path_template . 'js/selectnav.min.js';
                }

                if ($this->config->get('GALKAControl_menu') == 'GALKA_menu.php') {
                    $this->data['brands'] = array();
                    $this->data['custom_menu'] = array();
                    $this->data['catCustomTop'] = '';
                    $this->data['catCustomBottom'] = '';
                    $prefix = 'GALKAControl_custom_';

                    if ($this->config->get('GALKAControl_cat_custom_top') != null) {
                        $this->data['catCustomTop'] = html_entity_decode($this->config->get('GALKAControl_cat_custom_top'), ENT_QUOTES, 'UTF-8');
                    }

                    if ($this->config->get('GALKAControl_cat_custom_bottom') != null) {
                        $this->data['catCustomBottom'] = html_entity_decode($this->config->get('GALKAControl_cat_custom_bottom'), ENT_QUOTES, 'UTF-8');
                    }

                    $this->data['brandCustomTop'] = '';
                    $this->data['brandCustomBottom'] = '';

                    if ($this->config->get('GALKAControl_brand_custom_top') != null) {
                        $this->data['brandCustomTop'] = html_entity_decode($this->config->get('GALKAControl_brand_custom_top'), ENT_QUOTES, 'UTF-8');
                    }

                    if ($this->config->get('GALKAControl_brand_custom_bottom') != null) {
                        $this->data['brandCustomBottom'] = html_entity_decode($this->config->get('GALKAControl_brand_custom_bottom'), ENT_QUOTES, 'UTF-8');
                    }
                    
                    if ($this->config->get('GALKAControl_brands') == 1) {
                        $this->data['config_image_manufacturer_menu_width'] = $this->config->get('config_image_manufacturer_menu_width') + PLUS_WIDTH_IMAGE_MANUFACTURER_MENU;
                        $this->data['config_image_manufacturer_menu_height'] = $this->config->get('config_image_manufacturer_menu_height');

                        $brands = $this->model_catalog_manufacturer->getManufacturers();

                        foreach ($brands as $brand) {
                            $file = 'data/not_found.jpg';

                            if ($brand['image']) {
                                $file = $brand['image'];
                            }

                            $image = $this->model_tool_image->resize($file, $this->config->get('config_image_manufacturer_menu_width'), $this->config->get('config_image_manufacturer_menu_height'));

                            $this->data['brands'][] = array(
                                'name'  => $brand['name'],
                                'image' => $image,
                                'href'  => $this->url->link('product/manufacturer', 'manufacturer_id=' . $brand['manufacturer_id'])
                            );
                        }
                    }
                    
                    for ($count = 1; $count <= 3; $count++) {
                        $name = $this->config->get($prefix . 'menu_' . $count);
                        $href = $this->config->get($prefix . 'link_' . $count);
                        $desc = $this->config->get($prefix . 'submenu_' . $count);

                        if ($name != null) {
                            $this->data['custom_menu'][] = array(
                                'href'  => $href,
                                'name'  => $name,
                                'desc'  => html_entity_decode($desc, ENT_QUOTES, 'UTF-8')
                            );
                        }
                    }
                }
            }
        }
        
        $files_style[] = $path_template . 'stylesheet/highslid.css';
        
        foreach ($files_style as $file_style) {
            $this->document->addStyle($file_style);
        }

        foreach ($files_script as $file_script) {
            $this->document->addScript($file_script);
        }

        $this->data['description'] = $this->document->getDescription();
        $this->data['keywords'] = $this->document->getKeywords();
        $this->data['links'] = $this->document->getLinks();
        $this->data['styles'] = $this->document->getStyles();
        $this->data['scripts'] = $this->document->getScripts();
        $this->data['fbmetas'] = $this->document->getFBMetas();
        $this->data['lang'] = $this->language->get('code');
        $this->data['direction'] = $this->language->get('direction');
        $this->data['google_analytics'] = html_entity_decode($this->config->get('config_google_analytics'), ENT_QUOTES, 'UTF-8');
        $this->data['special'] = $this->url->link('product/special');
        $this->data['discount'] = $this->url->link('product/discount');
        $this->data['brand'] = $this->url->link('product/manufacturer');

        $this->data['gallery_href'] = '#';
        $this->data['video_href'] = '#';
        $this->data['text_video'] = $this->language->get('text_video');
        $this->data['text_gallery'] = $this->language->get('text_gallery');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $server = HTTPS_IMAGE;
        } else {
            $server = HTTP_IMAGE;
        }

        if ($this->config->get('config_icon') && file_exists(DIR_IMAGE . $this->config->get('config_icon'))) {
            $this->data['icon'] = $server . $this->config->get('config_icon');
        } else {
            $this->data['icon'] = '';
        }

        $this->data['name'] = $this->config->get('config_name');

        $this->data['skype'] = $this->config->get('config_skype');
        $this->data['email_shop'] = $this->config->get('config_email');
        $this->data['credit'] = $this->config->get('config_top_credit');
        $this->data['logo'] = '';

        if ($this->config->get('config_logo') && file_exists(DIR_IMAGE . $this->config->get('config_logo'))) {
            $this->data['logo'] = $server . $this->config->get('config_logo');
        }

        $this->data['text_home']        = $this->language->get('text_home');
        $this->data['text_wishlist']    = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
        $this->data['text_shopping_cart'] = $this->language->get('text_shopping_cart');
        $this->data['text_search']      = $this->language->get('text_search');
        $this->data['text_cabinet']      = $this->language->get('text_cabinet');
        $this->data['text_welcome']     = sprintf($this->language->get('text_welcome'), $this->url->link('account/login', '', 'SSL'), $this->url->link('account/register', '', 'SSL'));
        $this->data['text_logged']      = sprintf($this->language->get('text_logged'), $this->url->link('account/account', '', 'SSL'), $this->customer->getFirstName(), $this->url->link('account/logout', '', 'SSL'));

        $this->data['text_skype']       = $this->language->get('text_skype');
        $this->data['text_email']       = $this->language->get('text_email');
        $this->data['text_telephone']   = $this->language->get('text_telephone');
        $this->data['credit_image']     = $this->language->get('credit_image');

        $this->data['text_account']     = $this->language->get('text_account');
        $this->data['text_contacts']    = $this->language->get('text_contacts');
        $this->data['text_delivery']    = $this->language->get('text_delivery');
        $this->data['text_checkout']    = $this->language->get('text_checkout');
        $this->data['text_sitemap']     = $this->language->get('text_sitemap');
        $this->data['text_catalog']     = $this->language->get('text_catalog');
        $this->data['text_models']     = $this->language->get('text_models');
        $this->data['text_club']     = $this->language->get('text_club');
        $this->data['text_tv']     = $this->language->get('text_tv');

        $this->data['home']         = $this->url->link('common/home');
        $this->data['wishlist']     = $this->url->link('account/wishlist');
        $this->data['compare']      = $this->url->link('product/compare');
        $this->data['logged']       = $this->customer->isLogged();
        $this->data['account']      = $this->url->link('account/account', '', 'SSL');
        $this->data['contact']      = $this->url->link('information/contact', '', 'SSL');
        $this->data['shopping_cart'] = $this->url->link('checkout/cart');
        $this->data['checkout']     = $this->url->link('checkout/checkout', '', 'SSL');
        $this->data['sitemap']      = $this->url->link('information/sitemap', '', 'SSL');

        $this->data['catalog']      = $this->url->link('product/catalog', '', 'SSL');
        $this->data['models']       = $this->url->link('information/models', '', 'SSL');
        $this->data['club']         = $this->url->link('information/list_category_article', '', 'SSL');
        $this->data['tv']           = $this->url->link('product/list', '', 'SSL');

        $this->data['text_contact']     = $this->language->get('text_contact');
        $this->data['text_information'] = $this->language->get('text_information');
        $this->data['text_special']     = $this->language->get('text_special');
        $this->data['text_discount']     = $this->language->get('text_discount');

        $this->language->load('GALKA_custom/GALKA');

        $this->data['text_toggle']      = $this->language->get('text_toggle');
        $this->data['text_question']    = $this->language->get('text_question');
        $this->data['text_facebook']    = $this->language->get('text_facebook');
        $this->data['text_twitter']     = $this->language->get('text_twitter');
        $this->data['text_payment']     = $this->language->get('text_payment');
        $this->data['text_skype_click'] = $this->language->get('text_skype_click');
        $this->data['text_compare']     = $this->language->get('text_compare');
        $this->data['text_news']        = $this->language->get('text_news');
        $this->data['text_brands']      = $this->language->get('text_brands');
        $this->data['text_header_support'] = $this->language->get('text_header_support');
        $this->data['text_blog']        = $this->language->get('text_blog');

        $status = true;
        
        if (isset($this->request->server['HTTP_USER_AGENT'])) {
            $robots = explode("\n", trim($this->config->get('config_robots')));

            foreach ($robots as $robot) {
                if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
                    $status = false;

                    break;
                }
            }
        }
        
        $this->data['stores'] = array();
        
        if ($this->config->get('config_shared') && $status) {
            $this->data['stores'][] = $server . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
            
            $stores = $this->model_setting_store->getStores();
                    
            foreach ($stores as $store) {
                $this->data['stores'][] = $store['url'] . 'catalog/view/javascript/crossdomain.php?session_id=' . $this->session->getId();
            }
        }
        
        $this->data['tops'] = array();
        $informations = $this->model_catalog_information->getInformations();

        foreach ($informations as $result) {
            if ($result['top']) {
                $this->data['tops'][] = array(
                    'title' => $result['title'],
                    'href' => $this->url->link('information/information', 'information_id=' . $result['information_id'])
                );
            }
        }

        $this->data['blogs'] = array();
        $blogs = $this->model_catalog_blog->getBlogs();
        
        foreach ($blogs as $blog) {
            $data = array(
                'filter_blog_id' => $blog['blog_id']
            );
            
            $records = $this->model_catalog_record->getRecords($data);
            $records_publ = array();
            
            foreach ($records as $record) {
                $blog_href = $this->model_catalog_blog->getPathByrecord($record['record_id']);
                
                $records_publ[] = array(
                    'name' => $record['name'],
                    'href' => $this->url->link('record/record', 'record_id=' . $record['record_id'] . '&blog_id=' . $blog_href['path'])
                );
            }
            
            $this->data['blogs'][] = array(
                'name' => $blog['name'],
                'records' => $records_publ,
                'href' => $this->url->link('record/blog', 'blog_id=' . $blog['blog_id'])
            );
        }
        
        if (isset($this->request->get['filter_name'])) {
            $this->data['filter_name'] = $this->request->get['filter_name'];
        } else {
            $this->data['filter_name'] = '';
        }

        // Search
        if (isset($this->request->get['search'])) {
            $this->data['search'] = $this->request->get['search'];
        } else {
            $this->data['search'] = '';
        }
        
        // Menu
        $this->data['categories'] = $this->model_design_topmenu->getMenu();
        
        if (isset($this->request->get['manufacturer_id'])) {
            $this->data['breadcrumbs'][] = array( 
                'text'      => $this->language->get('text_brand'),
                'href'      => $this->url->link('product/manufacturer'),
                'separator' => $this->language->get('text_separator')
            );  
            
            $manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($this->request->get['manufacturer_id']);

            if ($manufacturer_info) {   
                $this->data['breadcrumbs'][] = array(
                    'text'      => $manufacturer_info['name'],
                    'href'      => $this->url->link('product/manufacturer/info', 'manufacturer_id=' . $this->request->get['manufacturer_id']),                  
                    'separator' => $this->language->get('text_separator')
                );
            }
        }

        $this->data['request'] = array(
            array(
                'route' => 'common/home',
                'ident' => 'a.home_link'
            ),
            array(
                'route' => 'account/wishlist',
                'ident' => '#wishlist_total'
            ),
            array(
                'route' => 'checkout/cart',
                'ident' => '.cart_link'
            ),
            array(
                'route' => 'checkout/checkout',
                'ident' => '.checkout_link'
            ),
            array(
                'route' => 'information/contact',
                'ident' => '.contact_link'
            ),
            array(
                'route' => 'information/contact',
                'ident' => '.info_link'
            ),
            array(
                'route' => 'account/login',
                'ident' => '.account_link'
            ),
            array(
                'route' => 'account/account',
                'ident' => '.account_link'
            ),
            array(
                'route' => 'product/special',
                'ident' => '.special_link'
            ),
            array(
                'route' => 'product/compare',
                'ident' => '.compare_link'
            ),
            array(
                'route' => 'blog/article',
                'ident' => '.blog_link'
            ),
            array(
                'route' => 'blog/category/home',
                'ident' => '.blog_link'
            ),
            array(
                'route' => 'information/sitemap',
                'ident' => '.info_link'
            ),
            array(
                'route' => 'information/information',
                'ident' => '.info_link'
            ),
            array(
                'route' => 'record/blog',
                'ident' => '.blog'
            ),
            array(
                'route' => 'record/record',
                'ident' => '.blog'
            ),
        );
        
        $this->children = array(
            'module/language',
            'common/content_header',
            'module/currency',
            'module/cart'
        );
        
        $this->fileRenderModule('/template/common/header.tpl');
    }
}
?>