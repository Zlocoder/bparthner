<?php

class ControllerModulePriceFilter extends Controller
{
    private $error = array();

    public function index()
    {
        $this->load->language('module/price_filter');

        $this->document->setTitle($this->language->get('heading_title'));
        $this->document->addScript('view/javascript/jquery/colorpicker/bootstrap-colorpicker.min.js');
        $this->document->addStyle('view/javascript/jquery/colorpicker/bootstrap-colorpicker.min.css');

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
            $this->model_setting_setting->editSetting('price_filter', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');

        $data['text_edit'] = $this->language->get('text_edit');
        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');
        $data['text_type_default'] = $this->language->get('text_type_default');
        $data['text_type_round'] = $this->language->get('text_type_round');
        $data['text_type_square'] = $this->language->get('text_type_square');

        $data['entry_container_selector'] = $this->language->get('entry_container_selector');
        $data['entry_paginator_selector'] = $this->language->get('entry_paginator_selector');
        $data['entry_line_background'] = $this->language->get('entry_line_background');
        $data['entry_active_background'] = $this->language->get('entry_active_background');
        $data['entry_line_border'] = $this->language->get('entry_line_border');
        $data['entry_handle_background'] = $this->language->get('entry_handle_background');
        $data['entry_handle_border'] = $this->language->get('entry_handle_border');
        $data['entry_handle_type'] = $this->language->get('entry_handle_type');
        $data['entry_status'] = $this->language->get('entry_status');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->request->post['price_filter_container_selector'])) {
            $data['container_selector'] = $this->request->post['price_filter_container_selector'];
        } else {
            $data['container_selector'] = $this->config->get('price_filter_container_selector');
        }

        if (isset($this->request->post['price_filter_paginator_selector'])) {
            $data['paginator_selector'] = $this->request->post['price_filter_paginator_selector'];
        } else {
            $data['paginator_selector'] = $this->config->get('price_filter_paginator_selector');
        }

        if (isset($this->request->post['price_filter_line_background'])) {
            $data['line_background'] = $this->request->post['price_filter_line_background'];
        } else {
            $data['line_background'] = $this->config->get('price_filter_line_background');
        }

        if (isset($this->request->post['price_filter_active_background'])) {
            $data['active_background'] = $this->request->post['price_filter_active_background'];
        } else {
            $data['active_background'] = $this->config->get('price_filter_active_background');
        }

        if (isset($this->request->post['price_filter_line_border'])) {
            $data['line_border'] = $this->request->post['price_filter_line_border'];
        } else {
            $data['line_border'] = $this->config->get('price_filter_line_border');
        }

        if (isset($this->request->post['price_filter_handle_background'])) {
            $data['handle_background'] = $this->request->post['price_filter_handle_background'];
        } else {
            $data['handle_background'] = $this->config->get('price_filter_handle_background');
        }

        if (isset($this->request->post['price_filter_handle_border'])) {
            $data['handle_border'] = $this->request->post['price_filter_handle_border'];
        } else {
            $data['handle_border'] = $this->config->get('price_filter_handle_border');
        }

        if (isset($this->request->post['price_filter_handle_type'])) {
            $data['handle_type'] = $this->request->post['price_filter_handle_type'];
        } else {
            $data['handle_type'] = $this->config->get('price_filter_handle_type');
        }

        if (isset($this->request->post['price_filter_status'])) {
            $data['price_filter_status'] = $this->request->post['price_filter_status'];
        } else {
            $data['price_filter_status'] = $this->config->get('price_filter_status');
        }

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        if (isset($this->error['container_selector'])) {
            $data['error_container_selector'] = $this->error['container_selector'];
        } else {
            $data['error_container_selector'] = '';
        }

        if (isset($this->error['paginator_selector'])) {
            $data['error_paginator_selector'] = $this->error['paginator_selector'];
        } else {
            $data['error_paginator_selector'] = '';
        }

        if (isset($this->error['line_background'])) {
            $data['error_line_background'] = $this->error['line_background'];
        } else {
            $data['error_line_background'] = '';
        }

        if (isset($this->error['active_background'])) {
            $data['error_active_background'] = $this->error['active_background'];
        } else {
            $data['error_active_background'] = '';
        }

        if (isset($this->error['line_border'])) {
            $data['error_line_border'] = $this->error['line_border'];
        } else {
            $data['error_line_border'] = '';
        }

        if (isset($this->error['handle_background'])) {
            $data['error_handle_background'] = $this->error['handle_background'];
        } else {
            $data['error_handle_background'] = '';
        }

        if (isset($this->error['handle_border'])) {
            $data['error_handle_border'] = $this->error['handle_border'];
        } else {
            $data['error_handle_border'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_home'),
            'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('text_module'),
            'href' => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['breadcrumbs'][] = array(
            'text' => $this->language->get('heading_title'),
            'href' => $this->url->link('module/price_filter', 'token=' . $this->session->data['token'], 'SSL')
        );

        $data['action'] = $this->url->link('module/price_filter', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('module/price_filter.tpl', $data));
    }

    protected function validate()
    {
        if (!$this->user->hasPermission('modify', 'module/price_filter')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }

        return !$this->error;
    }
}