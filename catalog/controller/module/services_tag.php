<?php
class ControllerModuleServicesTag extends Controller {
    public function index($settings) {

        $this->load->language('module/services_tag');

        foreach ($settings as $key => $setting) {
            $data[$key] = $setting;
        }

        $data['title'] = $settings['title'] ? $settings['title'] : $this->language->get('heading_title');

        $data['not_found'] = $this->language->get('not_found');

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/js/tagcanvas.js')) {
            $this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/tagcanvas.js');
        }

        $limit = $settings['limit'] ? (int)$settings['limit'] : (int)$this->language->get('limit');
        $this->load->model('services/post');
        $data['tags'] = $this->model_services_post->post_tag($limit);

        $data['selected'] = isset($this->request->get['tag']) ? $this->request->get['tag'] : '';

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/services_tag.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/module/services_tag.tpl', $data);
        } else {
            return $this->load->view('default/template/module/services_tag.tpl', $data);
        }
    }
}