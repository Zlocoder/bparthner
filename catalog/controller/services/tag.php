<?php
class ControllerServicesTag extends Controller {
	public function index() {
		
		$this->load->language('services/tag');

		$this->load->helper('blog');
		$this->load->model('services/setting');
		$settings = $this->model_services_setting->settings();
		$services_config = setting($settings);
		$data['config'] = $services_config;

		// Heading Meta Tag
		$this->document->setDescription($services_config['meta_description']);
		$this->document->setKeywords($services_config['meta_keyword']);

		$data['heading_title'] = $services_config['name'] ? $services_config['name'] : '';

		// Label
		$data['text_author'] = $this->language->get('text_author');
		$data['text_tag'] = $this->language->get('text_tag');
		$data['text_view'] = $this->language->get('text_view');
		$data['text_readmore'] = $this->language->get('text_readmore');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['not_found'] = $this->language->get('not_found');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/js/servicesScript.js')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/servicesScript.js');
		}

		$add_default_style = false;
		if($services_config['CSS_filename']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/'.$services_config['CSS_filename'])) {
				$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/'.$services_config['CSS_filename']);
			} else {
				$add_default_style = true;
			}
		} 

		if(!$services_config['CSS_filename'] || $add_default_style) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/services.css')) {
				$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/services.css');
			}
		}

		// Google font
		$this->document->addStyle('http://fonts.googleapis.com/css?family=Oswald|Philosopher|Ubuntu|Ubuntu+Condensed|Roboto|Happy+Monkey');

		// Social Sharing
		$this->document->addScript('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54da4ef349e7f893');

		// Slider script
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/js/jquery.cycle.all.js')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/jquery.cycle.all.js');
		}
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/js/initSlider.js')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/initSlider.js');
		}

		if (isset($this->request->get['filter'])) {
			$filter = $this->request->get['filter'];
		} else {
			$filter = '';
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
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

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = isset($services_config['post_limit_front']) ? $services_config['post_limit_front'] : 5;
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('services/home')
		);

		$this->load->model('services/post');
		$this->load->model('tool/image');

		// Services log and Services icon image dimension
		$logo_size = $services_config['logo_image_size'];
		$size = explode('x', $logo_size);
		$logo_width = isset($size[0]) ? $size[0] : 100;
		$logo_height = isset($size[1]) ? $size[1] : 100;

		$icon_size = $services_config['icon_image_size'];
		$size = explode('x', $icon_size);
		$icon_width = isset($size[0]) ? $size[0] : 30;
		$icon_height = isset($size[1]) ? $size[1] : 30;

		if ($services_config['services_logo'] && is_file(DIR_IMAGE . $services_config['services_logo'])) {
			$data['services_logo'] =  $this->model_tool_image->resize($services_config['services_logo'], $logo_width, $logo_height);
		} else {
			$data['services_logo'] = $this->model_tool_image->resize('no_image.png', $logo_width, $logo_height);
		}

		if ($services_config['services_icon'] && is_file(DIR_IMAGE . $services_config['services_icon'])) {
			$data['services_icon'] =  $this->model_tool_image->resize($services_config['services_icon'], $icon_width, $icon_height);
		} else {
			$data['services_icon'] = $this->model_tool_image->resize('no_image.png', $icon_width, $icon_height);
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$limit = isset($services_config['post_limit_front']) ? $services_config['post_limit_front'] : 20;
		$tag = isset($this->request->get['tag']) ? $this->request->get['tag'] : ''; 

		if($tag) {

			$doc_title = '';
			if($tag) {
				$doc_title = $tag . ' | ';
			}

			if($services_config['name']) {
				$doc_title =  $doc_title . $services_config['name'];
			}

			$doc_metaDescription = $services_config['meta_description'];
			$doc_metaKeyword = $services_config['meta_keyword'];

			$this->document->setTitle($doc_title);
			$this->document->setDescription($doc_metaDescription);
			$this->document->setKeywords($doc_metaKeyword);

			$post = array();

			$filter_data = array(
				'filter_tag' => $tag,
				'sort' => $sort,	
				'order' => $order,
				'start' => ($page - 1) * $limit,
				'limit' => $limit
			);


			$total_post = $this->model_services_post->getTotalPost($filter_data);
			$posts = $this->model_services_post->getPosts($filter_data);

			$url = '';

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}


			$data['breadcrumbs'][] = array(
				'text' => ucfirst($tag),
				'href' => $this->url->link('services/tag', $url, 'SSL')
			);

			$thumb_size = explode('x', $services_config['post_thumbnail_image_size']);
			$thumb_width  = isset($thumb_size[0]) ? $thumb_size[0] : 200;
			$thumb_height  = isset($thumb_size[1]) ? $thumb_size[1] : 250;

			if($posts) {

				$post_thumb = '';

				foreach ($posts as $key => $post) {
					if (!empty($post['post_thumb']) && is_file(DIR_IMAGE . $post['post_thumb'])) {
						$post_thumb = $this->model_tool_image->resize($post['post_thumb'], $thumb_width, $thumb_height);
					} else {
						$post_thumb = $this->model_tool_image->resize('no_image.png', $thumb_width, $thumb_height);
					}

					$post_images = array();

					if($services_config['post_thumbnail_type'] == 'slide') {
						if(isset($post['image'])) {
							foreach ($post['image'] as $key => $image) {
				            	if (!empty($image['meta_value']) && is_file(DIR_IMAGE . $image['meta_value'])) {
						       		$post_images[] = $this->model_tool_image->resize($image['meta_value'], $thumb_width, $thumb_height);
						       	} else {
									$post_images[] = $this->model_tool_image->resize('no_image.png', $thumb_width, $thumb_height);
								}
					    	}
					    }
			        }

			        $data['posts'][] = array(
						'ID' => $post['ID'],
						'date_added' => $post['date_added'],
						'title' => $post['title'],
						'content' => words_limit(html_entity_decode($post['content']),$services_config['word_limit_in_post'],'...'),
						'post_author' => $post['post_author'],
						'comment_count' => $post['comment_count'],
						'view' => $post['view'],
						'post_thumbnail' => $post_thumb,
						'images' => $post_images,
						'tag' => $post['tag'],
						'comment_count' => $post['comment_count'],
					);
			    }

			}

			$pagination = new Pagination();
			$pagination->total = $total_post;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->url = $this->url->link('services/tag', $url . '&page={page}');
			$data['pagination'] = $pagination->render();

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/services/tag.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/services/tag.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/services/tag.tpl', $data));
			}
		} else {

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/404.css')) {
				$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/404.css');
			} 

			$url = '';

			if (isset($this->request->get['path'])) {
				$url .= '&path=' . $this->request->get['path'];
			}

			if (isset($this->request->get['filter'])) {
				$url .= '&filter=' . $this->request->get['filter'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$data['breadcrumbs'][] = array(
				'text' => $this->language->get('not_found'),
				'href' => $this->url->link('product/category', $url)
			);

			$this->document->setTitle($this->language->get('not_found'));

			$data['heading_title'] = $this->language->get('heading_title');

			$data['text_error'] = $this->language->get('not_found');

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('services/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found_services.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found_services.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}

		}
	}
}