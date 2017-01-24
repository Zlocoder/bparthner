<?php
class ControllerCommonHeader extends Controller {
	public function index() {
		// Analytics
		$this->load->model('extension/extension');

        $data['customer'] = $this->customer;
		$data['analytics'] = array();

		$analytics = $this->model_extension_extension->getExtensions('analytics');

		foreach ($analytics as $analytic) {
			if ($this->config->get($analytic['code'] . '_status')) {
				$data['analytics'][] = $this->load->controller('analytics/' . $analytic['code']);
			}
		}

        if ($this->request->server['HTTPS']) {
            $server = $this->config->get('config_ssl');
        } else {
            $server = $this->config->get('config_url');
        }

        if (is_file(DIR_IMAGE . $this->config->get('config_icon'))) {
			$this->document->addLink($server . 'image/' . $this->config->get('config_icon'), 'icon');
		}

		$data['title'] = $this->document->getTitle();

		$data['base'] = $server;
		$data['description'] = $this->document->getDescription();
		$data['keywords'] = $this->document->getKeywords();
		$data['links'] = $this->document->getLinks();
		$data['styles'] = $this->document->getStyles();
		$data['scripts'] = $this->document->getScripts();
		$data['lang'] = $this->language->get('code');
		$data['direction'] = $this->language->get('direction');

		$data['name'] = $this->config->get('config_name');

		if (is_file(DIR_IMAGE . $this->config->get('config_logo'))) {
			$data['logo'] = $server . 'image/' . $this->config->get('config_logo');
		} else {
			$data['logo'] = '';
		}

		$this->load->language('common/header');
		$data['og_url'] = (isset($this->request->server['HTTPS']) ? HTTPS_SERVER : HTTP_SERVER) . substr($this->request->server['REQUEST_URI'], 1, (strlen($this->request->server['REQUEST_URI'])-1));
		$data['og_image'] = $this->document->getOgImage();

		$data['text_home'] = $this->language->get('text_home');

		// Wishlist
		if ($this->customer->isLogged()) {
			$this->load->model('account/wishlist');

			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), $this->model_account_wishlist->getTotalWishlist());
		} else {
			$data['text_wishlist'] = sprintf($this->language->get('text_wishlist'), (isset($this->session->data['wishlist']) ? count($this->session->data['wishlist']) : 0));
		}

		// special links
		$data['wishlist'] = $this->url->link('account/wishlist', '', 'SSL');
		$data['register'] = $this->url->link('account/register', '', 'SSL');
		$data['order'] = $this->url->link('account/order', '', 'SSL');
		$data['transaction'] = $this->url->link('account/transaction', '', 'SSL');
		$data['download'] = $this->url->link('account/download', '', 'SSL');
		$data['shopping_cart'] = $this->url->link('checkout/cart');
		$data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

        $data['home'] = $this->url->link('common/home');

        // top menu links
        $data['about'] = $this->url->link('information/information', 'information_id=4', 'SSL');
        $data['blog'] = $this->url->link('blog/home');
        $data['delivery'] = $this->url->link('information/information', 'information_id=6', 'SSL');
        $data['discount'] = $this->url->link('information/information', 'information_id=3', 'SSL');
        $data['contact'] = $this->url->link('information/contact');
        $data['login'] = $this->url->link('account/login', '', 'SSL');
        $data['logout'] = $this->url->link('account/logout', '', 'SSL');
        $data['account'] = $this->url->link('account/account', '', 'SSL');

		$data['telephone'] = $this->config->get('config_telephone');

		$status = true;

		if (isset($this->request->server['HTTP_USER_AGENT'])) {
			$robots = explode("\n", str_replace(array("\r\n", "\r"), "\n", trim($this->config->get('config_robots'))));

			foreach ($robots as $robot) {
				if ($robot && strpos($this->request->server['HTTP_USER_AGENT'], trim($robot)) !== false) {
					$status = false;

					break;
				}
			}
		}

		// Menu
		$this->load->model('catalog/category');

		$this->load->model('catalog/product');

		$data['categories'] = $this->getCategories();
		$data['categories'][] = $this->getServices();

		$data['language'] = $this->load->controller('common/language');
		$data['currency'] = $this->load->controller('common/currency');
		$data['search'] = $this->load->controller('common/search');
		$data['cart'] = $this->load->controller('common/cart');

		// For page specific css
		if (isset($this->request->get['route'])) {
			if (isset($this->request->get['product_id'])) {
				$class = '-' . $this->request->get['product_id'];
			} elseif (isset($this->request->get['path'])) {
				$class = '-' . $this->request->get['path'];
			} elseif (isset($this->request->get['manufacturer_id'])) {
				$class = '-' . $this->request->get['manufacturer_id'];
			} else {
				$class = '';
			}

			$data['class'] = str_replace('/', '-', $this->request->get['route']) . $class;
		} else {
			$data['class'] = 'common-home';
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/header.tpl')) {
			return $this->load->view($this->config->get('config_template') . '/template/common/header.tpl', $data);
		} else {
			return $this->load->view('default/template/common/header.tpl', $data);
		}
	}

	public function getServices() {
	    $this->load->helper('blog');

	    $this->load->model('services/setting');
	    $this->load->model('services/category');

	    $settings = setting($this->model_services_setting->settings());

	    $services = [
	        'image' => $settings['services_logo'],
            'name' => $settings['name'],
            'href' => '',
            'childrens' => []
        ];

        $menu_posts = '';
        foreach ($this->model_services_category->post_by_category(['c.category_id' => ' = 4']) as $post) {
            $menu_posts .= $post['ID'] . ',';
        }
        $menu_posts = rtrim($menu_posts, ',');

	    foreach ($this->model_services_category->getCategories() as $category) {
            $cat = [
                'image' => $category['image'],
                'name' => $category['name'],
                'href' => $this->url->link('services/category', 'path=' . $category['category_id']),
                'childrens' => []
            ];

            foreach ($this->model_services_category->post_by_category(['c.category_id' => " = {$category['category_id']}", 'p.ID' => " IN ($menu_posts)"]) as $post) {
                $cat['childrens'][] = [
                    'name' => $post['title'],
                    'href' => $this->url->link('services/single', 'pid=' . $post['ID'])
                ];
            }

            $services['childrens'][] = $cat;
        }

        return $services;
    }

	public function getCategories() {
	    $result = array();
        $categories = $this->model_catalog_category->getCategories(0);

        foreach ($categories as $category) {
            if ($category['top']) {
                // Level 2
                $category_data = array(
                    'image' => $category['image'],
                    'name' => $category['name'],
                    'href' => $this->url->link('product/category', 'path=' . $category['category_id']),
                    'childrens' => array()
                );

                $childrens1 = $this->model_catalog_category->getCategories($category['category_id']);

                foreach ($childrens1 as $children1) {
                    $children1_data = array(
                        'image' => $children1['image'],
                        'name'  => $children1['name'],
                        'href'  => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $children1['category_id']),
                        'childrens' => array()
                    );

                    $childrens2 = $this->model_catalog_category->getCategories($children1['category_id']);

                    foreach ($childrens2 as $children2) {
                        $children2_data = array(
                            'name' => $children2['name'],
                            'href' => $this->url->link('product/category', 'path=' . $category['category_id'] . '_' . $children1['category_id'] . '_' . $children2['category_id']),
                        );

                        $children1_data['childrens'][] = $children2_data;
                    }

                    $category_data['childrens'][] = $children1_data;
                }

                $result[] = $category_data;
            }
        }

        return $result;
    }
}
