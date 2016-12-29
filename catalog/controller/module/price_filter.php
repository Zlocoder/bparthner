<?php

class ControllerModulePriceFilter extends Controller
{
    public function index()
    {
        $this->load->language('module/price_filter');
        $this->load->model('module/price_filter');
        $this->load->model('setting/setting');

        $this->document->addScript('catalog/view/javascript/price_filter.min.js');

        $data['heading_title'] = $this->language->get('heading_title');
        $data['reset_button'] = $this->language->get('reset_button');
        $data['empty_message'] = $this->language->get('empty_message');

        $data['current_path'] = isset($this->request->get['path']) ? $this->request->get['path'] : false;

        $category_id = 0;

        if (isset($this->request->get['category_id'])) {
            $category_id = $this->request->get['category_id'];
        } elseif (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
            $category_id = array_pop($parts);
        }

        if ($this->currency->getsymbolleft()) {
            $data['currency_symbol'] = $this->currency->getsymbolleft();
            $data['cur_symbol_side'] = 'left';
        } else {
            $data['currency_symbol'] = $this->currency->getsymbolright();
            $data['cur_symbol_side'] = 'right';
        }

        $min_max = $this->model_module_price_filter->getMinMaxPrice($category_id);
        $min = floor($this->currency->format($min_max['min'], '', '', false));
        $max = ceil($this->currency->format($min_max['max'], '', '', false));

        if (isset($this->request->get['price_filter'])) {
            $p = explode('-', $this->request->get['price_filter']);
            $input_min = (int)$p[0];
            $input_max = (int)$p[1];
        }

        $data['price_min'] = isset($min) ? $min : 0;
        $data['price_max'] = isset($max) ? $max : 0;
        $data['lower_limit'] = isset($input_min) ? $input_min : $data['price_min'];
        $data['upper_limit'] = isset($input_max) ? $input_max : $data['price_max'];
        $data['base_url'] = preg_replace('/https?:\/\/[^\/]+/', '', $this->config->get('config_url'));

        $data['settings'] = $this->model_setting_setting->getSetting('price_filter');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/price_filter.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/module/price_filter.tpl', $data);
        } else {
            return $this->load->view('default/template/module/price_filter.tpl', $data);
        }
    }

    public function ajax()
    {
        $category_id = 0;

        if (isset($this->request->get['category_id'])) {
            $category_id = $this->request->get['category_id'];
        } elseif (isset($this->request->get['path'])) {
            $parts = explode('_', (string)$this->request->get['path']);
            $category_id = array_pop($parts);
        }

        $this->load->model('module/price_filter');
        $min_max = $this->model_module_price_filter->getMinMaxPrice($category_id);
        $min = floor($this->currency->format($min_max['min'], '', '', false));
        $max = ceil($this->currency->format($min_max['max'], '', '', false));

        $products = $this->response->getOutput($this->load->controller('product/category'));

        $json = array(
            'products' => $products,
            'min' => $min,
            'max' => $max
        );

        $this->response->setOutput(json_encode($json));
    }
}