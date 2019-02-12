<?php
class ControllerLocalisationNovaPochta extends Controller {
    private $error = array();

    public function index() {
        $this->language->load('localisation/novapochta');

        $this->document->settitle($this->language->get('heading_title_depart'));

        $this->load->model('localisation/novapochta');

        $this->getList();
    }

    public function insert() {
        $this->language->load('localisation/novapochta');

        $this->document->settitle($this->language->get('heading_title_depart'));

        $this->load->model('localisation/novapochta');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localisation_novapochta->addDepart($this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->redirect($this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function update() {
        $this->language->load('localisation/novapochta');

        $this->document->settitle($this->language->get('heading_title_depart'));

        $this->load->model('localisation/novapochta');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
            $this->model_localisation_novapochta->editDepart($this->request->get['depart_id'], $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->redirect($this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getForm();
    }

    public function delete() {
        $this->language->load('localisation/novapochta');

        $this->document->settitle($this->language->get('heading_title_depart'));

        $this->load->model('localisation/novapochta');

        if (isset($this->request->post['selected'])) {
            foreach ($this->request->post['selected'] as $depart_id) {
                $this->model_localisation_novapochta->deleteDepart($depart_id);
            }

            $this->session->data['success'] = $this->language->get('text_success');

            $url = '';

            if (isset($this->request->get['sort'])) {
                $url .= '&sort=' . $this->request->get['sort'];
            }

            if (isset($this->request->get['order'])) {
                $url .= '&order=' . $this->request->get['order'];
            }

            if (isset($this->request->get['page'])) {
                $url .= '&page=' . $this->request->get['page'];
            }

            $this->redirect($this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . $url, 'SSL'));
        }

        $this->getList();
    }

    protected function getList() {
        if (isset($this->request->get['sort'])) {
            $sort = $this->request->get['sort'];
        } else {
            $sort = 'title_depart';
        }

        if (isset($this->request->get['order'])) {
            $order = $this->request->get['order'];
        } else {
            $order = 'ASC';
        }

        if (isset($this->request->get['page'])) {
            $page = $this->request->get['page'];
        } else {
            $page = 1;
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_depart'),
            'href'      => $this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        $this->data['insert'] = $this->url->link('localisation/novapochta/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $this->data['delete'] = $this->url->link('localisation/novapochta/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');

        $data = array(
            'sort'  => $sort,
            'order' => $order,
            'start' => ($page - 1) * $this->config->get('config_admin_limit'),
            'limit' => $this->config->get('config_admin_limit')
        );

        $depart_total = $this->model_localisation_novapochta->getTotalDepart();
        $results = $this->model_localisation_novapochta->getDeparts($data);
        $this->data['departs'] = array();

        foreach ($results as $result) {
            $action = array();

            $action[] = array(
                'text' => $this->language->get('text_edit'),
                'href' => $this->url->link('localisation/novapochta/update', 'token=' . $this->session->data['token'] . '&depart_id=' . $result['depart_id'] . $url, 'SSL')
            );

            $this->data['departs'][] = array(
                'depart_id'  => $result['depart_id'],
                'title_country'        => $result['title_country'],
                'title_zone'        => $result['title_zone'],
                'title_city'        => $result['title_city'],
                'title_depart'       => $result['title_depart'],
                'region_title_city' => $result['title_city'],
                'selected'   => isset($this->request->post['selected']) && in_array($result['depart_id'], $this->request->post['selected']),
                'action'     => $action
            );
        }

        $this->data['heading_title_depart'] = $this->language->get('heading_title_depart');

        $this->data['text_no_results'] = $this->language->get('text_no_results');

        $this->data['column_title_country'] = $this->language->get('column_title_country');
        $this->data['column_title_zone'] = $this->language->get('column_title_zone');
        $this->data['column_title_city'] = $this->language->get('column_title_city');
        $this->data['column_title_depart'] = $this->language->get('column_title_depart');
        $this->data['column_action'] = $this->language->get('column_action');

        $this->data['button_insert'] = $this->language->get('button_insert');
        $this->data['button_delete'] = $this->language->get('button_delete');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        if (isset($this->session->data['success'])) {
            $this->data['success'] = $this->session->data['success'];

            unset($this->session->data['success']);
        } else {
            $this->data['success'] = '';
        }

        $url = '';

        if ($order == 'ASC') {
            $url .= '&order=DESC';
        } else {
            $url .= '&order=ASC';
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['sort_title_country'] = $this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . '&sort=title_country' . $url, 'SSL');
        $this->data['sort_title_zone'] = $this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . '&sort=title_zone' . $url, 'SSL');
        $this->data['sort_title_city'] = $this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . '&sort=title_city' . $url, 'SSL');
        $this->data['sort_title_depart'] = $this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . '&sort=title_depart' . $url, 'SSL');

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        $pagination = new Pagination();
        $pagination->total = $depart_total;
        $pagination->page = $page;
        $pagination->limit = $this->config->get('config_admin_limit');
        $pagination->text = $this->language->get('text_pagination');
        $pagination->url = $this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

        $this->data['pagination'] = $pagination->render();

        $this->data['sort'] = $sort;
        $this->data['order'] = $order;

        $this->template = 'localisation/novapochta_list.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function getForm() {
        $this->load->model('localisation/country');
        $this->load->model('localisation/zone');
        $this->load->model('localisation/city');

        $this->data['heading_title_depart'] = $this->language->get('heading_title_depart_form');

        $this->data['text_enabled'] = $this->language->get('text_enabled');
        $this->data['text_disabled'] = $this->language->get('text_disabled');
        $this->data['text_yes'] = $this->language->get('text_yes');
        $this->data['text_no'] = $this->language->get('text_no');

        $this->data['entry_title_country'] = $this->language->get('entry_title_country');
        $this->data['entry_title_zone'] = $this->language->get('entry_title_zone');
        $this->data['entry_title_city'] = $this->language->get('entry_title_city');
        $this->data['entry_title_depart'] = $this->language->get('entry_title_depart');
        $this->data['entry_city_id'] = $this->language->get('entry_city_id');
        $this->data['entry_status_depart'] = $this->language->get('entry_status_depart');

        $this->data['button_save'] = $this->language->get('button_save');
        $this->data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $this->data['error_warning'] = $this->error['warning'];
        } else {
            $this->data['error_warning'] = '';
        }

        $url = '';

        if (isset($this->request->get['sort'])) {
            $url .= '&sort=' . $this->request->get['sort'];
        }

        if (isset($this->request->get['order'])) {
            $url .= '&order=' . $this->request->get['order'];
        }

        if (isset($this->request->get['page'])) {
            $url .= '&page=' . $this->request->get['page'];
        }

        $this->data['breadcrumbs'] = array();

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $this->data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title_depart'),
            'href'      => $this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . $url, 'SSL'),
            'separator' => ' :: '
        );

        if (!isset($this->request->get['depart_id'])) {
            $this->data['action'] = $this->url->link('localisation/novapochta/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
        } else {
            $this->data['action'] = $this->url->link('localisation/novapochta/update', 'token=' . $this->session->data['token'] . '&depart_id=' . $this->request->get['depart_id'] . $url, 'SSL');
        }

        $this->data['cancel'] = $this->url->link('localisation/novapochta', 'token=' . $this->session->data['token'] . $url, 'SSL');
        $country = $this->model_localisation_country->getCountryByNovaPochta();
        $this->data['zones'] = $this->model_localisation_zone->getZones(array('country_id' => $country['country_id'], 'sort' => 'z.name'));
        $this->data['country'] = $country;
        $this->data['cities'] = array();

        if (isset($this->request->get['depart_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
            $depart_info = $this->model_localisation_novapochta->getDepart($this->request->get['depart_id']);
        }

        if (isset($this->request->post['zone_id'])) {
            $this->data['cities'] = $this->model_localisation_city->getCitiesByZoneId($this->request->post['zone_id']);
        } elseif (isset($depart_info['zone_id'])) {
            $this->data['cities'] = $this->model_localisation_city->getCitiesByZoneId($depart_info['zone_id']);
        } elseif (isset($this->data['zones'][0]['zone_id'])) {
            $this->data['cities'] = $this->model_localisation_city->getCitiesByZoneId($this->data['zones'][0]['zone_id']);
        }

        if (isset($this->request->post['title_depart'])) {
            $this->data['title_depart'] = $this->request->post['title_depart'];
        } elseif (!empty($depart_info)) {
            $this->data['title_depart'] = $depart_info['title_depart'];
        } else {
            $this->data['title_depart'] = '';
        }

        if (isset($this->request->post['zone_id'])) {
            $this->data['zone_id'] = $this->request->post['zone_id'];
        } elseif (!empty($depart_info)) {
            $this->data['zone_id'] = $depart_info['zone_id'];
        } else {
            $this->data['zone_id'] = '';
        }

        if (isset($this->request->post['city_id'])) {
            $this->data['city_id'] = $this->request->post['city_id'];
        } elseif (!empty($depart_info)) {
            $this->data['city_id'] = $depart_info['city_id'];
        } else {
            $this->data['city_id'] = '';
        }

        if (isset($this->request->post['status_depart'])) {
            $this->data['status_depart'] = $this->request->post['status_depart'];
        } elseif (!empty($depart_info)) {
            $this->data['status_depart'] = $depart_info['status_depart'];
        } else {
            $this->data['status_depart'] = 1;
        }

        if (isset($this->error['title_depart'])) {
            $this->data['error_title_depart'] = $this->error['title_depart'];
        } else {
            $this->data['error_title_depart'] = '';
        }

        if (isset($this->error['city_id'])) {
            $this->data['error_city_id'] = $this->error['city_id'];
        } else {
            $this->data['error_city_id'] = '';
        }

        $this->template = 'localisation/novapochta_form.tpl';
        $this->children = array(
            'common/header',
            'common/footer'
        );

        $this->response->setOutput($this->render());
    }

    protected function validateForm() {
        if (!$this->user->hasPermission('modify', 'localisation/novapochta')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        if ($this->request->post['city_id'] == 0) {
            $this->error['city_id'] = $this->language->get('error_title_city');
        }

        if ((utf8_strlen($this->request->post['title_depart']) < 3) || (utf8_strlen($this->request->post['title_depart']) > 255)) {
            $this->error['title_depart'] = $this->language->get('error_title_depart');
        }

        if (!$this->error) {
            return true;
        } else {
            return false;
        }
    }

    public function getCities() {
        $this->load->model('localisation/city');

        $cities = $this->model_localisation_city->getCitiesByZoneId($this->request->get['zone_id']);

        if (count($cities)) {
            $result = array('type' => 'success', 'data' => $cities);
        } else {
            $result = array('type' => 'error', 'message' => "Данные по городам не получены");
        }

        print json_encode($result);
        return;
    }
}
?>