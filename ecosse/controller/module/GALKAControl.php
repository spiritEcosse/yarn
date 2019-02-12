<?php
class ControllerModuleGALKAControl extends Controller {

    private $error = array();

    public function index() {

        $this->load->language('module/GALKAControl');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        $this->load->model('tool/image');


        $BodyBgImg = 'GALKAControl_bodyBgImg';
        if (isset($this->request->post[$BodyBgImg])) {
            $this->data[$BodyBgImg] = $this->request->post[$BodyBgImg];
            $GALKAControl_bodyBgImg = $this->request->post[$BodyBgImg];
        } else {
            $this->data[$BodyBgImg] = '';
        }

        $HeaderBgImg = 'GALKAControl_HeaderBgImg';
        if (isset($this->request->post[$HeaderBgImg])) {
            $this->data[$HeaderBgImg] = $this->request->post[$HeaderBgImg];
            $GALKAControl_HeaderBgImg = $this->request->post[$HeaderBgImg];
        } else {
            $this->data[$HeaderBgImg] = '';
        }

        $FooterBgImg = 'GALKAControl_FooterBgImg';
        if (isset($this->request->post[$FooterBgImg])) {
            $this->data[$FooterBgImg] = $this->request->post[$FooterBgImg];
            $GALKAControl_FooterBgImg = $this->request->post[$FooterBgImg];
        } else {
            $this->data[$FooterBgImg] = '';
        }

        $this->document->addScript('view/javascript/jquery/colorpicker.js');
        $this->document->addScript('view/javascript/jquery/jquery.ibutton.min.js');
        $this->document->addStyle('view/stylesheet/css/colorpicker.css');
        $this->document->addStyle('view/stylesheet/css/GALKAControl.css');
        $this->document->addStyle('view/stylesheet/css/font-awesome.min.css');

        $this->data['text_general_settings'] = $this->language->get('text_general_settings');
        $this->data['text_menu_type'] = $this->language->get('text_menu_type');
        $this->data['map_module'] = $this->language->get('map_module');
        $this->data['text_longitude'] = $this->language->get('text_longitude');
        $this->data['text_latitude'] = $this->language->get('text_latitude');
        $this->data['text_map_helper'] = $this->language->get('text_map_helper');
        $this->data['text_site_mode'] = $this->language->get('text_site_mode');
        $this->data['text_mode_store'] = $this->language->get('text_mode_store');
        $this->data['text_mode_catalog'] = $this->language->get('text_mode_catalog');
        $this->data['text_header_settings'] = $this->language->get('text_header_settings');
        $this->data['text_layout_type'] = $this->language->get('text_layout_type');
        $this->data['text_layout_full'] = $this->language->get('text_layout_full');
        $this->data['text_layout_boxed'] = $this->language->get('text_layout_boxed');
        $this->data['text_footer_settings'] = $this->language->get('text_footer_settings');
        $this->data['text_content_settings'] = $this->language->get('text_content_settings');
        $this->data['text_common_colors'] = $this->language->get('text_common_colors');
        $this->data['text_titles_teasers'] = $this->language->get('text_titles_teasers');
        $this->data['text_fonts'] = $this->language->get('text_fonts');
        $this->data['text_social'] = $this->language->get('text_social');
        $this->data['text_icons'] = $this->language->get('text_icons');
        $this->data['text_color_helper'] = $this->language->get('text_color_helper');
        $this->data['text_body_color'] = $this->language->get('text_body_color');
        $this->data['text_header_color'] = $this->language->get('text_header_color');
        $this->data['text_category_menu_border'] = $this->language->get('text_category_menu_border');
        $this->data['text_body_pattern'] = $this->language->get('text_body_pattern');
        $this->data['text_header_pattern'] = $this->language->get('text_header_pattern');
        $this->data['text_footer_pattern'] = $this->language->get('text_footer_pattern');
        $this->data['text_default_value'] = $this->language->get('text_default_value');
        $this->data['text_pattern_samples'] = $this->language->get('text_pattern_samples');
        $this->data['text_headings_color'] = $this->language->get('text_headings_color');
        $this->data['text_body_text_color'] = $this->language->get('text_body_text_color');
        $this->data['text_right_column_background'] = $this->language->get('text_right_column_background');
        $this->data['text_right_column_titles'] = $this->language->get('text_right_column_titles');
        $this->data['text_links_color'] = $this->language->get('text_links_color');
        $this->data['text_links_hover_color'] = $this->language->get('text_links_hover_color');
        $this->data['text_buttons_color'] = $this->language->get('text_buttons_color');
        $this->data['text_buttons_hover_color'] = $this->language->get('text_buttons_hover_color');
        $this->data['text_new_color'] = $this->language->get('text_new_color');
        $this->data['text_sale_color'] = $this->language->get('text_sale_color');
        $this->data['text_save_color'] = $this->language->get('text_save_color');
        $this->data['text_cat_back'] = $this->language->get('text_cat_back');
        $this->data['text_cat_color'] = $this->language->get('text_cat_color');
        $this->data['text_breadcrumb_color'] = $this->language->get('text_breadcrumb_color');
        $this->data['text_box_border'] = $this->language->get('text_box_border');
        $this->data['text_header_top_color'] = $this->language->get('text_header_top_color');
        $this->data['text_header_top_border'] = $this->language->get('text_header_top_border');
        $this->data['text_category_menu_back'] = $this->language->get('text_category_menu_back');
        $this->data['text_box_featured_border'] = $this->language->get('text_box_featured_border');
        $this->data['text_menu_link_color'] = $this->language->get('text_menu_link_color');
        $this->data['text_menu_link_hover_color'] = $this->language->get('text_menu_link_hover_color');
        $this->data['text_menu_link_hover_back'] = $this->language->get('text_menu_link_hover_back');
        $this->data['text_drop_border'] = $this->language->get('text_drop_border');

        $this->data['text_category_link_color'] = $this->language->get('text_category_link_color');
        $this->data['text_headings_accent'] = $this->language->get('text_headings_accent');
        $this->data['text_category_link_hover_color'] = $this->language->get('text_category_link_hover_color');
        $this->data['text_category_link_hover_back'] = $this->language->get('text_category_link_hover_back');

        $this->data['text_menu_icon_back'] = $this->language->get('text_menu_icon_back');
        $this->data['text_cart_icon_back'] = $this->language->get('text_cart_icon_back');

        $this->data['text_footer_back_color'] = $this->language->get('text_footer_back_color');
        $this->data['text_footer_titles_color'] = $this->language->get('text_footer_titles_color');
        $this->data['text_footer_borders_color'] = $this->language->get('text_footer_borders_color');
        $this->data['text_pre_footer_back_color'] = $this->language->get('text_pre_footer_back_color');
        $this->data['text_pre_footer_top_border_color'] = $this->language->get('text_pre_footer_top_border_color');
        $this->data['text_pre_footer_titles_color'] = $this->language->get('text_pre_footer_titles_color');
        $this->data['text_pre_footer_titles_border'] = $this->language->get('text_pre_footer_titles_border');
        $this->data['text_copyright_back_color'] = $this->language->get('text_copyright_back_color');
        $this->data['text_copyright_text_color'] = $this->language->get('text_copyright_text_color');
        $this->data['text_footer_time'] = $this->language->get('text_footer_time');
        $this->data['text_footer_address'] = $this->language->get('text_footer_address');
        $this->data['text_footer_phone'] = $this->language->get('text_footer_phone');
        $this->data['text_footer_fax'] = $this->language->get('text_footer_fax');
        $this->data['text_footer_mail'] = $this->language->get('text_footer_mail');
        $this->data['text_footer_seals'] = $this->language->get('text_footer_seals');
        $this->data['text_footer_copyright'] = $this->language->get('text_footer_copyright');

        $this->data['text_titles_teasers_warning'] = $this->language->get('text_titles_teasers_warning');
        $this->data['text_titles_news_warning'] = $this->language->get('text_titles_news_warning');
        $this->data['text_titles_title'] = $this->language->get('text_titles_title');
        $this->data['text_titles_teaser'] = $this->language->get('text_titles_teaser');
        $this->data['text_titles_featured'] = $this->language->get('text_titles_featured');
        $this->data['text_titles_latest'] = $this->language->get('text_titles_latest');
        $this->data['text_titles_specials'] = $this->language->get('text_titles_specials');
        $this->data['text_titles_bestseller'] = $this->language->get('text_titles_bestseller');
        $this->data['text_titles_news'] = $this->language->get('text_titles_news');

        $this->data['text_font_settings'] = $this->language->get('text_font_settings');
        $this->data['text_headings_font'] = $this->language->get('text_headings_font');
        $this->data['text_body_font'] = $this->language->get('text_body_font');

        $this->data['text_twitter'] = $this->language->get('text_twitter');
        $this->data['text_twitter_helper'] = $this->language->get('text_twitter_helper');
        $this->data['text_twitter_widget_helper'] = $this->language->get('text_twitter_widget_helper');
        $this->data['text_twitter_link'] = $this->language->get('text_twitter_link');
        $this->data['text_facebook'] = $this->language->get('text_facebook');
        $this->data['text_facebook_helper'] = $this->language->get('text_facebook_helper');
        $this->data['text_facebook_link'] = $this->language->get('text_facebook_link');
        $this->data['text_vk_link'] = $this->language->get('text_vk_link');
        $this->data['text_classmates_link'] = $this->language->get('text_classmates_link');
        $this->data['text_vk'] = $this->language->get('text_vk');
        $this->data['text_classmates'] = $this->language->get('text_classmates');
        $this->data['text_skype'] = $this->language->get('text_skype');
        $this->data['text_skype_helper'] = $this->language->get('text_skype_helper');
        $this->data['text_skype_mode'] = $this->language->get('text_skype_mode');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_responsive'] = $this->language->get('text_responsive');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_countdown'] = $this->language->get('text_countdown');
        $this->data['text_news_link'] = $this->language->get('text_news_link');
        $this->data['text_specials_link'] = $this->language->get('text_specials_link');
        $this->data['text_rss_link'] = $this->language->get('text_rss_link');
        $this->data['text_opened'] = $this->language->get('text_opened');
        $this->data['text_hidden'] = $this->language->get('text_hidden');
        $this->data['text_new_label'] = $this->language->get('text_new_label');
        $this->data['text_css'] = $this->language->get('text_css');
        $this->data['text_skype_click'] = $this->language->get('text_skype_click');
        $this->data['text_map'] = $this->language->get('text_map');

        $this->data['GALKAControl_custom_menu_heading'] = $this->language->get('GALKAControl_custom_menu_heading');
        $this->data['GALKAControl_custom_menu_helper'] = $this->language->get('GALKAControl_custom_menu_helper');
        $this->data['GALKAControl_custom_menu'] = $this->language->get('GALKAControl_custom_menu');
        $this->data['GALKAControl_custom_title'] = $this->language->get('GALKAControl_custom_title');
        $this->data['GALKAControl_custom_link'] = $this->language->get('GALKAControl_custom_link');
        $this->data['GALKAControl_custom_submenu'] = $this->language->get('GALKAControl_custom_submenu');
        $this->data['text_opencart_menu'] = $this->language->get('text_opencart_menu');
        $this->data['text_GALKA_menu'] = $this->language->get('text_GALKA_menu');
        $this->data['text_menu_brands'] = $this->language->get('text_menu_brands');
        $this->data['text_product_page'] = $this->language->get('text_product_page');
        $this->data['text_zoom'] = $this->language->get('text_zoom');
        $this->data['text_colorbox'] = $this->language->get('text_colorbox');
        $this->data['text_preview_type'] = $this->language->get('text_preview_type');
        $this->data['text_cart_button_color'] = $this->language->get('text_cart_button_color');
        $this->data['text_wish_button_color'] = $this->language->get('text_wish_button_color');
        $this->data['text_compare_button_color'] = $this->language->get('text_compare_button_color');
        $this->data['text_main_price'] = $this->language->get('text_main_price');
        $this->data['text_old_price'] = $this->language->get('text_old_price');
        $this->data['text_tab_color'] = $this->language->get('text_tab_color');

        $this->data['text_headings1_size'] = $this->language->get('text_headings1_size');
        $this->data['text_headings2_size'] = $this->language->get('text_headings2_size');
        $this->data['text_headings3_size'] = $this->language->get('text_headings3_size');
        $this->data['text_headings4_size'] = $this->language->get('text_headings4_size');

        $this->data['text_price_size'] = $this->language->get('text_price_size');
        $this->data['text_module_title_size'] = $this->language->get('text_module_title_size');
        $this->data['text_column_title_size'] = $this->language->get('text_column_title_size');
        $this->data['text_category_item_size'] = $this->language->get('text_category_item_size');

        $this->data['text_custom_font'] = $this->language->get('text_custom_font');
        $this->data['text_custom_font_code'] = $this->language->get('text_custom_font_code');
        $this->data['text_custom_font_family'] = $this->language->get('text_custom_font_family');
        $this->data['text_blog_link'] = $this->language->get('text_blog_link');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('GALKAControl', $this->request->post);



            $this->session->data['success'] = $this->language->get('text_success');


            $this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $this->data['text_image_manager'] = 'Image manager';
        $this->data['token'] = $this->session->data['token'];

        $text_strings = array(
            'heading_title',
            'text_enabled',
            'text_disabled',
            'text_content_top',
            'text_content_bottom',
            'text_column_left',
            'text_column_right',
            'entry_layout',
            'entry_position',
            'entry_status',
            'entry_sort_order',
            'button_save',
            'button_cancel',
            'button_add_module',
            'button_remove',
            'entry_example'
        );

        foreach ($text_strings as $text) {
            $this->data[$text] = $this->language->get($text);
        }


        $config_data = array(
            'GALKAControl_status',
            'GALKAControl_blog_link',
            'GALKAControl_layout',
            'GALKAControl_skin',
            'GALKAControl_menu',
            'GALKAControl_site_mode',
            'GALKAControl_preheader',
            'GALKAControl_countdown',
            'GALKAControl_news_link',
            'GALKAControl_specials_link',
            'GALKAControl_new_label',
            'GALKAControl_custom_css',
            'GALKAControl_headings_color',
            'GALKAControl_text_color',
            'GALKAControl_links_color',
            'GALKAControl_links_color_hover',
            'GALKAControl_main_menu_color',
            'GALKAControl_main_menu_hover_color',
            'GALKAControl_main_menu_hover_background',
            'GALKAControl_category_menu_color',
            'GALKAControl_category_menu_hover_color',
            'GALKAControl_category_menu_hover_background',
            'GALKAControl_menu_icon_back',
            'GALKAControl_cart_icon_back',
            'GALKAControl_powered_bg',
            'GALKAControl_powered_text',
            'GALKAControl_prefooter_borders',
            'GALKAControl_map_status',
            'GALKAControl_latitude',
            'GALKAControl_longitude',
            'GALKAControl_body_bg_color',
            'GALKAControl_header_bg_color',
            'GALKAControl_body_bg_pattern',
            'GALKAControl_header_bg_pattern',
            'GALKAControl_prefooter_titles',
            'GALKAControl_prefooter_border_top',
            'GALKAControl_container_bg_color',
            'GALKAControl_footer_bg_color',
            'GALKAControl_header_top_color',
            'GALKAControl_header_top_border',
            'GALKAControl_category_menu_back',
            'GALKAControl_content_background_color',
            'GALKAControl_content_bg_pattern',
            'GALKAControl_category_menu_bg',
            'GALKAControl_prefooter_bg',
            'GALKAControl_column_box_color',
            'GALKAControl_column_box_title',
            'GALKAControl_footer_link_color',
            'GALKAControl_footer_link_border',
            'GALKAControl_old_price_color',
            'GALKAControl_main_price_color',
            'GALKAControl_cart_button_color',
            'GALKAControl_wish_button_color',
            'GALKAControl_compare_button_color',
            'GALKAControl_buttons_color_hover',
            'GALKAControl_new_label_color',
            'GALKAControl_cat_title_background',
            'GALKAControl_cat_title_color',
            'GALKAControl_breadcrumb_color',
            'GALKAControl_boxtop_border',
            'GALKAControl_Featuredtop_border',
            'GALKAControl_map',
            'GALKAControl_sale_label_color',
            'GALKAControl_save_label_color',
            'GALKAControl_buttons_color',
            'GALKAControl_featured_custom_title',
            'GALKAControl_featured_custom_teaser',
            'GALKAControl_latest_custom_title',
            'GALKAControl_latest_custom_teaser',
            'GALKAControl_specials_custom_title',
            'GALKAControl_specials_custom_teaser',
            'GALKAControl_bestseller_custom_title',
            'GALKAControl_bestseller_custom_teaser',
            'GALKAControl_news_custom_teaser',
            'GALKAControl_rss_link',
            'GALKAControl_headings_font',
            'GALKAControl_body_font',
            'GALKAControl_twitter_id',
            'GALKAControl_twitter_widget_id',
            'GALKAControl_twitter_link',
            'GALKAControl_facebook_id',
            'GALKAControl_facebook_link',
            'GALKAControl_vk_link',
            'GALKAControl_classmates_link',
            'GALKAControl_skype_mode',
            'GALKAControl_skype',
            'GALKAControl_western',
            'GALKAControl_switch',
            'GALKAControl_solo',
            'GALKAControl_delivery_text',
            'GALKAControl_delivery_switch',
            'GALKAControl_sage',
            'GALKAControl_moneybookers',
            'GALKAControl_google',
            'GALKAControl_discover',
            'GALKAControl_delta',
            'GALKAControl_2checkout',
            'GALKAControl_cirrus',
            'GALKAControl_american',
            'GALKAControl_maestro',
            'GALKAControl_master',
            'GALKAControl_electron',
            'GALKAControl_visa',
            'GALKAControl_paypal',
            'GALKAControl_footer_time',
            'GALKAControl_footer_address',
            'GALKAControl_footer_phone',
            'GALKAControl_footer_fax',
            'GALKAControl_footer_mail',
            'GALKAControl_seals',
            'GALKAControl_copyright',
            'GALKAControl_custom_menu_1',
            'GALKAControl_custom_link_1',
            'GALKAControl_custom_submenu_1',
            'GALKAControl_custom_menu_2',
            'GALKAControl_custom_link_2',
            'GALKAControl_custom_submenu_2',
            'GALKAControl_custom_menu_3',
            'GALKAControl_custom_link_3',
            'GALKAControl_custom_submenu_3',
            'GALKAControl_preview',
            'GALKAControl_brands',
            'GALKAControl_brands',
            'GALKAControl_category_menu_border',
            'GALKAControl_drop_border',
            'GALKAControl_product_tab_color',
            'GALKAControl_headings1_size',
            'GALKAControl_headings2_size',
            'GALKAControl_headings3_size',
            'GALKAControl_headings4_size',
            'GALKAControl_price_size',
            'GALKAControl_module_title_size',
            'GALKAControl_column_title_size',
            'GALKAControl_category_item_size',
            'GALKAControl_custom_font',
            'GALKAControl_custom_font_family',
            'GALKAControl_headings_accent',
            'GALKAControl_cat_custom_top',
            'GALKAControl_cat_custom_bottom',
            'GALKAControl_brand_custom_top',
            'GALKAControl_brand_custom_bottom',
            'GALKAControl_countdown_color',
            'GALKAControl_play_sound',
            'GALKAControl_sticky_menu',
            'GALKAControl_bodyBgImg',
            'GALKAControl_bodyBgImg_preview',
            'GALKAControl_HeaderBgImg',
            'GALKAControl_HeaderBgImg_preview',
            'GALKAControl_FooterBgImg',
            'GALKAControl_footer_bg_pattern',
            'GALKAControl_FooterBgImg_preview',
            'GALKAControl_responsive'
        );

        foreach ($config_data as $conf) {
            if (isset($this->request->post[$conf])) {
                $this->data[$conf] = $this->request->post[$conf];
            } else {
                $this->data[$conf] = $this->config->get($conf);
            }
        }





        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }


        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_module'),
            'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('module/GALKAControl', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $this->data['action'] = $this->url->link('module/GALKAControl', 'token=' . $this->session->data['token'], 'SSL');

        $this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');



        if (isset($this->request->post['GALKAControl_module'])) {
            $modules = explode(',', $this->request->post['GALKAControl_module']);
        } elseif ($this->config->get('GALKAControl_module') != '') {
            $modules = explode(',', $this->config->get('GALKAControl_module'));
        } else {
            $modules = array();
        }

        $this->load->model('design/layout');

        $this->data['layouts'] = $this->model_design_layout->getLayouts();

        foreach ($modules as $module) {
            if (isset($this->request->post['GALKAControl_' . $module . '_layout_id'])) {
                $this->data['GALKAControl_' . $module . '_layout_id'] = $this->request->post['GALKAControl_' . $module . '_layout_id'];
            } else {
                $this->data['GALKAControl_' . $module . '_layout_id'] = $this->config->get('GALKAControl_' . $module . '_layout_id');
            }

            if (isset($this->request->post['GALKAControl_' . $module . '_position'])) {
                $this->data['GALKAControl_' . $module . '_position'] = $this->request->post['GALKAControl_' . $module . '_position'];
            } else {
                $this->data['GALKAControl_' . $module . '_position'] = $this->config->get('GALKAControl_' . $module . '_position');
            }

            if (isset($this->request->post['GALKAControl_' . $module . '_status'])) {
                $this->data['GALKAControl_' . $module . '_status'] = $this->request->post['GALKAControl_' . $module . '_status'];
            } else {
                $this->data['GALKAControl_' . $module . '_status'] = $this->config->get('GALKAControl_' . $module . '_status');
            }

            if (isset($this->request->post['GALKAControl_' . $module . '_sort_order'])) {
                $this->data['GALKAControl_' . $module . '_sort_order'] = $this->request->post['GALKAControl_' . $module . '_sort_order'];
            } else {
                $this->data['GALKAControl_' . $module . '_sort_order'] = $this->config->get('GALKAControl_' . $module . '_sort_order');
            }
        }



        $this->data['modules'] = $modules;

        if (isset($this->request->post['GALKAControl_module'])) {
            $this->data['GALKAControl_module'] = $this->request->post['GALKAControl_module'];
        } else {
            $this->data['GALKAControl_module'] = $this->config->get('GALKAControl_module');
        }

        $this->template = 'module/GALKAControl.tpl';
        $this->children = array(
            'common/header',
            'common/footer',
        );

        // BODY BG IMAGE PREVIEW
        $BodyBgImg_Preview = 'GALKAControl_bodyBgImg_preview';
        if (isset($this->data[$BodyBgImg]) && $this->data[$BodyBgImg] != "" && file_exists(DIR_IMAGE . $this->data[$BodyBgImg])) {
            $this->data[$BodyBgImg_Preview] = $this->model_tool_image->resize($this->data[$BodyBgImg], 100, 100);
        } else {
            $this->data[$BodyBgImg_Preview] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }

        // HEADER BG IMAGE PREVIEW
        $HeaderBgImg_Preview = 'GALKAControl_HeaderBgImg_preview';
        if (isset($this->data[$HeaderBgImg]) && $this->data[$HeaderBgImg] != "" && file_exists(DIR_IMAGE . $this->data[$HeaderBgImg])) {
            $this->data[$HeaderBgImg_Preview] = $this->model_tool_image->resize($this->data[$HeaderBgImg], 100, 100);
        } else {
            $this->data[$HeaderBgImg_Preview] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }

        // FOOTER BG IMAGE PREVIEW
        $FooterBgImg_Preview = 'GALKAControl_FooterBgImg_preview';
        if (isset($this->data[$FooterBgImg]) && $this->data[$FooterBgImg] != "" && file_exists(DIR_IMAGE . $this->data[$FooterBgImg])) {
            $this->data[$FooterBgImg_Preview] = $this->model_tool_image->resize($this->data[$FooterBgImg], 100, 100);
        } else {
            $this->data[$FooterBgImg_Preview] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        }


        // NO IMAGE
        $this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

        $this->response->setOutput($this->render());
    }



    private function validate() {
        if (!$this->user->hasPermission('modify', 'module/GALKAControl')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if (!$this->error) {
            return TRUE;
        } else {
            return FALSE;
        }
    }


}
?>