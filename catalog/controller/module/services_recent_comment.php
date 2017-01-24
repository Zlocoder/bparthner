<?php
class ControllerModuleServicesrecentComment extends Controller {
    public function index($settings) {
        $this->load->language('module/services_recent_comment');

        $this->load->helper('blog');

        foreach ($settings as $key => $setting) {
            $data[$key] = $setting;
        }

        $data['title'] = $settings['title'] ? $settings['title'] : $this->language->get('heading_title');
        $data['author'] = $this->language->get('author');
        $data['date'] = $this->language->get('date');

        $data['not_found'] = $this->language->get('not_found');

        $this->load->model('services/comment');

        $data['recent_comments'] = $this->model_services_comment->comments(array("bc.comment_approve"=>"='publish'"),'bc.comment_ID DESC', 0, $settings['limit']);

        if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/services_recent_comment.tpl')) {
            return $this->load->view($this->config->get('config_template') . '/template/module/services_recent_comment.tpl', $data);
        } else {
            return $this->load->view('default/template/module/services_recent_comment.tpl', $data);
        }
    }
}