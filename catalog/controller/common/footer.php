<?php
class ControllerCommonFooter extends Controller {
	public function index() {
		$this->load->language('common/footer');

		$data['scripts'] = $this->document->getScripts('footer');

        $data['return'] = $this->url->link('account/return/add', '', 'SSL');
        $data['sitemap'] = $this->url->link('information/sitemap');
        $data['manufacturer'] = $this->url->link('product/manufacturer');
        $data['voucher'] = $this->url->link('account/voucher', '', 'SSL');
        $data['affiliate'] = $this->url->link('affiliate/account', '', 'SSL');
        $data['special'] = $this->url->link('product/special');
        $data['account'] = $this->url->link('account/account', '', 'SSL');
        $data['order'] = $this->url->link('account/order', '', 'SSL');
        $data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
        $data['newsletter'] = $this->url->link('account/newsletter', '', 'SSL');

        $data['home'] = $this->url->link('common/home', '',  'SSL');
        $data['cat_60'] = $this->url->link('product/category', 'path=60', 'SSL');
        $data['cat_61'] = $this->url->link('product/category', 'path=61', 'SSL');
        $data['cat_59'] = $this->url->link('product/category', 'path=59', 'SSL');
        $data['cat_62'] = $this->url->link('product/category', 'path=62', 'SSL');

        $data['about'] = $this->url->link('information/information', 'information_id=4', 'SSL');
        $data['delivery'] = $this->url->link('information/information', 'information_id=6', 'SSL');
        $data['discount'] = $this->url->link('information/information', 'information_id=3', 'SSL');
		$data['contact'] = $this->url->link('information/contact');

		$data['powered'] = sprintf($this->language->get('text_powered'), $this->config->get('config_name'), date('Y', time()));
        $data['telephone'] = $this->config->get('config_telephone');


        if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }

        if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
            $data['logo'] = $server . 'image/' . $this->config->get('config_logo');
        } else {
            $data['logo'] = '';
        }

        // Whos Online
		if ($this->config->get('config_customer_online')) {
			$this->load->model('tool/online');

			if (isset($this->request->server['REMOTE_ADDR'])) {
				$ip = $this->request->server['REMOTE_ADDR'];
			} else {
				$ip = '';
			}

			if (isset($this->request->server['HTTP_HOST']) && isset($this->request->server['REQUEST_URI'])) {
				$url = 'http://' . $this->request->server['HTTP_HOST'] . $this->request->server['REQUEST_URI'];
			} else {
				$url = '';
			}

			if (isset($this->request->server['HTTP_REFERER'])) {
				$referer = $this->request->server['HTTP_REFERER'];
			} else {
				$referer = '';
			}

			$this->model_tool_online->addOnline($ip, $this->customer->getId(), $url, $referer);
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/footer.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/footer.tpl', $data);
		} else {
			return $this->load->view('default/template/common/footer.tpl', $data);
		}
	}
}
