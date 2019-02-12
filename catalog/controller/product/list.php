<?php
class ControllerProductList extends Controller {
    public function index() {
        $this->language->load('product/list');
        $this->load->model('catalog/category_video');
        $this->load->model('tool/image');

        $this->totals($this->request->post);

        $this->data['text_empty'] = $this->language->get('text_empty');
        $this->data['button_continue'] = $this->language->get('button_continue');
        $this->data['continue'] 			= $this->url->link('common/home');

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_catalog'),
            'href'      => $this->url->link('product/list'),
            'separator' => $this->language->get('text_separator')
        );

        $categories = $this->model_catalog_category_video->getCategories(0);
        $this->data['categories'] = array();

        if ($categories) {
            $title = $this->language->get('text_catalog');
            $this->data['heading_title'] = $title;
            $this->getText();

            $this->data['thumb'] = '';
            $this->data['description'] = '';

            foreach ($categories as $key => $category_video) {
                $this->data['categories'][$key] = $category_video;

                if ($category_video['image']) {
                    $image = $category_video['image'];
                } else {
                    $image = 'no_image.jpg';
                }

                $this->data['categories'][$key]['thumb'] = $this->model_tool_image->resize($image, $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
                $this->data['categories'][$key]['href'] = $this->url->link('product/catvideo', 'road=' . $category_video['category_video_id']);
            }

        } else {
            $title = $this->language->get('text_error');
            $this->data['heading_title'] = $title;
        }

        $file = '/template/product/list.tpl';
        $this->document->setTitle($title);

        $this->fileRender($file);
    }
}
?>