<?php
class ControllerBlogSingle extends Controller {
	public function index() {
		$this->load->language('blog/single');

		$this->load->helper('blog');
		$this->load->model('blog/setting');
		$settings = $this->model_blog_setting->settings();
		$blog_config = setting($settings);
		$data['config'] = $blog_config;

		$this->document->setDescription($blog_config['meta_description']);
		$this->document->setKeywords($blog_config['meta_keyword']);

		$data['heading_title'] = $blog_config['name'] ? $blog_config['name'] : '';
		$data['title_related_product'] = $this->language->get('title_related_product');

		$data['text_author'] = $this->language->get('text_author');
		$data['text_publish'] = $this->language->get('text_publish');
		$data['text_tag'] = $this->language->get('text_tag');
		$data['text_view'] = $this->language->get('text_view');
		$data['text_comment'] = $this->language->get('text_comment');
		$data['text_related'] = $this->language->get('text_related');
		$data['text_gallery_title'] = $this->language->get('text_gallery_title');
		$data['not_found'] = $this->language->get('not_found');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/js/blogScript.js')) {
			$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/js/blogScript.js');
		}

		$add_default_style = false;
		if($blog_config['CSS_filename']) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/'.$blog_config['CSS_filename'])) {
				$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/'.$blog_config['CSS_filename']);
			} else {
				$add_default_style = true;
			}
		} 

		if(!$blog_config['CSS_filename'] || $add_default_style) {
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/blog.css')) {
				$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/stylesheet/blog.css');
			}
		}

		// Google font
		$this->document->addStyle('http://fonts.googleapis.com/css?family=Oswald|Philosopher|Ubuntu|Ubuntu+Condensed|Roboto|Happy+Monkey');

		// Social Sharing
		$this->document->addScript('//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54da4ef349e7f893');

		$this->document->addStyle('catalog/view/javascript/jquery/magnific/magnific-popup.css');
		$this->document->addScript('catalog/view/javascript/jquery/magnific/jquery.magnific-popup.min.js');

		$this->document->addStyle('catalog/view/theme/'.$this->config->get('config_template').'/summernote/summernote.css');
		$this->document->addScript('catalog/view/theme/'.$this->config->get('config_template').'/summernote/summernote.min.js');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('blog/home')
		);

		$this->load->model('tool/image');

		$logo_size = $blog_config['logo_image_size'];
		$size = explode('x', $logo_size);
		$logo_width = isset($size[0]) ? $size[0] : 100;
		$logo_height = isset($size[1]) ? $size[1] : 100;

		$icon_size = $blog_config['icon_image_size'];
		$size = explode('x', $icon_size);
		$icon_width = isset($size[0]) ? $size[0] : 30;
		$icon_height = isset($size[1]) ? $size[1] : 30;
		
		if ($blog_config['blog_logo'] && is_file(DIR_IMAGE . $blog_config['blog_logo'])) {
			$data['blog_logo'] =  $this->model_tool_image->resize($blog_config['blog_logo'], $logo_width, $logo_height);
		} else {
			$data['blog_logo'] = $this->model_tool_image->resize('no_image.png', $logo_width, $logo_height);
		}

		if ($blog_config['blog_icon'] && is_file(DIR_IMAGE . $blog_config['blog_icon'])) {
			$data['blog_icon'] =  $this->model_tool_image->resize($blog_config['blog_icon'], $icon_width, $icon_height);
		} else {
			$data['blog_icon'] = $this->model_tool_image->resize('no_image.png', $icon_width, $icon_height);
		}

		$this->load->model('blog/post');

		$data['post'] = array();
		$data['related_posts'] = array();
		$data['related_products'] = array();

		if(isset($this->request->get['pid'])) {
			
			$post = $this->model_blog_post->getPost(array("p.ID"=>"='".$this->request->get['pid']."'"));

			$doc_title = '';
			if($post['title']) {
				$doc_title = $post['title'] . ' | ';
			}

			if($blog_config['name']) {
				$doc_title =  $doc_title . $blog_config['name'];
			}

			$this->document->setTitle($doc_title);

			if(isset($post['meta_description'])) {
				$this->document->setDescription($post['meta_description']);
			}
			
			if(isset($post['meta_keyword'])) {
				$this->document->setKeywords($post['meta_keyword']);
			}
			
			if($post) {
				
				$pid = $post['ID'];
				
				$data['breadcrumbs'][] = array(
					'text' => ucfirst(words_limit($post['title'],2,'...')),
					'href' => $this->url->link('blog/single?pid=' . $post['title'], '', 'SSL')
				);

				$this->model_blog_post->increaseView($pid);	

				$thumb_size = explode('x', $blog_config['related_post_image_size']);
				$thumb_width  = isset($thumb_size[0]) ? $thumb_size[0] : 200;
				$thumb_height  = isset($thumb_size[1]) ? $thumb_size[1] : 250;
				
				// Related posts
				if($post['tag']) {
					$tags = explode(',', $post['tag']);
					$ids = array();

					for ($i=0; $i < count($tags); $i++) { 
						$post_ids = $ids ? implode(',',$ids) : 0;
						$related_posts = $this->model_blog_post->getPosts('',array("pd.tag" => " LIKE '%".$tags[$i]."%'","p.ID" => " NOT IN ('".$post['ID']."',".$post_ids.")"),'',"p.date_modified ASC",0,1);
						if($related_posts) {
							$post_thumb = array();
							foreach ($related_posts as $key => $related_post) {
								if (!empty($related_post['post_thumb']) && is_file(DIR_IMAGE . $related_post['post_thumb'])) {
									$post_thumb =  $this->model_tool_image->resize($related_post['post_thumb'], $thumb_width, $thumb_height);
								} else {
									$post_thumb = $this->model_tool_image->resize('no_image.png', $thumb_width, $thumb_height);
								}

								$data['related_posts'][] = array(
									'ID' => $related_post['ID'],
									'date_added' => $related_post['date_added'],
									'title' => $related_post['title'],
									'content' => $related_post['content'],
									'post_author' => $related_post['post_author'],
									'comment_count' => $related_post['comment_count'],
									'view' => $related_post['view'],
									'post_thumbnail' => $post_thumb,
									'tag' => $related_post['tag'],
									'comment_count' => $related_post['comment_count'],
								);

								array_push($ids, $related_post['ID']);
							}
						}
						
					}
				} // End If..

				// Related products
				$this->load->model('catalog/product');
				$related_product_id =  $this->model_blog_post->related_product(array("post_id"=>"='".$post['ID']."'"));
				if($related_product_id) {
					$data['relaed_product'] = array();
					foreach ($related_product_id as $product_id) {
						$product = $this->model_catalog_product->getProduct($product_id['product_id']);
						if($product) {
							if ($product['image'] && is_file(DIR_IMAGE . $product['image'])) {
								$product_thumb =  $this->model_tool_image->resize($product['image'], 100, 120);
							} else {
								$product_thumb = $this->model_tool_image->resize('no_image.png', 100, 120);
							}

							$data['related_products'][] = array(
								'product_id' => $product['product_id'],
								'name' => $product['name'],
								'description' => $product['description'],
								'product_thumb' => $product_thumb,
								'price' => $product['price']
							);
						}
					}
				} 

				$post_thumb = array();
				$post_images = array();

				$thumb_size = explode('x', $blog_config['post_thumbnail_image_size']);
				$thumb_width  = isset($thumb_size[0]) ? $thumb_size[0] : 200;
				$thumb_height  = isset($thumb_size[1]) ? $thumb_size[1] : 250;

				if (!empty($post['post_thumb']) && is_file(DIR_IMAGE . $post['post_thumb'])) {
					$post_thumb = $this->model_tool_image->resize($post['post_thumb'], $thumb_width, $thumb_height);
				} else {
					$post_thumb = $this->model_tool_image->resize('no_image.png', $thumb_width, $thumb_height);
				}

				if(isset($post['image'])) {
					$inc = 0;
		            foreach ($post['image'] as $key => $image) {
		            	if (!empty($image['meta_value']) && is_file(DIR_IMAGE . $image['meta_value'])) {
				       		$post_images[$inc]['image'] = $this->model_tool_image->resize($image['meta_value'], $thumb_width, $thumb_height);
				       		$post_images[$inc]['url'] = $this->model_tool_image->resize($image['meta_value'], $thumb_width * 4, $thumb_height * 4);
				       	} else {
							$post_images[$inc]['image'] = $this->model_tool_image->resize('no_image.png', $thumb_width, $thumb_height);
							$post_images[$inc]['url'] = $this->model_tool_image->resize('no_image.png', $thumb_width * 4, $thumb_height * 4);
						}
						$inc++;
			    	}
			    }

			    $data['post'] = array(
					'ID' => $post['ID'],
					'date_added' => $post['date_added'],
					'title' => $post['title'],
					'content' => $post['content'],
					'post_author' => $post['post_author'],
					'comment_count' => $post['comment_count'],
					'view' => $post['view'],
					'post_thumbnail' => $post_thumb,
					'images' => $post_images,
					'tag' => $post['tag'],
					'comment_count' => $post['comment_count'],
				);
			}

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/blog/single.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/blog/single.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/blog/single.tpl', $data));
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

			$data['continue'] = $this->url->link('blog/home');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found_blog.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/error/not_found_blog.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/error/not_found.tpl', $data));
			}

		}	
	}
}