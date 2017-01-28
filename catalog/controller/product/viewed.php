<?php

  class ControllerProductViewed extends Controller {

    /*
     * Конструктор URL
     * добавляет get-параметры
     * @param $params array названия параметров
     * @return string
     */
    private function getURL($params) {
      $url = '';

      foreach ($params as $param) {
        if (isset($this->request->get[$param])) {
          $url .= '&' . $param . '=' . $this->request->get[$param];
        }
      }

      return $url;
    }

    public function index() {

      /* пути к модулям вьюх*/
      $view_path = $this->config->get('config_template') . '/template/product/viewed.tpl';
      $default_view_path = 'default/template/module/viewed.tpl';

      /* загрузка модели */
      $this->load->language('module/viewed');
      $this->load->model('catalog/product');
      $this->load->model('tool/image');

      /* загрузка локализации */
      $data['heading_title'] = $this->language->get('heading_title');
      $data['text_tax'] = $this->language->get('text_tax');
      $data['button_cart'] = $this->language->get('button_cart');
      $data['button_wishlist'] = $this->language->get('button_wishlist');
      $data['button_compare'] = $this->language->get('button_compare');

      /* организация "хлебных крошек" */
      $data['breadcrumbs'] = array();
      $data['breadcrumbs'][] = array(
          'text' => $this->language->get('text_home'),
          'href' => $this->url->link('common/home')
      );
      $data['breadcrumbs'][] = array(
          'text' => $this->language->get('heading_title'),
          'href' => $this->url->link('product/latest')
      );

      /* загрузка модулей страницы, в т.ч. хедера и футера */
      $data['column_left'] = $this->load->controller('common/column_left');
      $data['column_right'] = $this->load->controller('common/column_right');
      $data['content_top'] = $this->load->controller('common/content_top');
      $data['content_bottom'] = $this->load->controller('common/content_bottom');
      $data['footer'] = $this->load->controller('common/footer');
      $data['header'] = $this->load->controller('common/header');

      /* Фильтры */
      if (isset($this->request->get['filter'])) {
        $filter = $this->request->get['filter'];
      } else {
        $filter = '';
      }

      if (isset($this->request->get['sort'])) {
        $sort = $this->request->get['sort'];
      } else {
        $sort = 'p.date_modified';
      }

      if (isset($this->request->get['order'])) {
        $order = $this->request->get['order'];
      } else {
        $order = 'DESC';
      }

      $url = $this->getURL(array('filter', 'sort', 'order', 'limit'));

      if (isset($this->request->get['limit'])) {
        $limit = (int)$this->request->get['limit'];
      } else if (empty($data['categories'])) {
        $limit = 15;
      } else {
        $limit = 12;
      }

      $data['sorts'][] = array(
        //'text'  => $this->language->get('text_name_asc'),
          'text' => 'По новизне',
          'value' => 'p.date_modified-DESC',
          'href'  => $this->url->link('product/viewed', '&sort=p.date_modified&order=DESC' . $url)
      );

      $data['sorts'][] = array(
        //'text'  => $this->language->get('text_name_asc')
          'text' => 'От А до Я',
          'value' => 'pd.name-ASC',
          'href'  => $this->url->link('product/viewed', '&sort=pd.name&order=ASC' . $url)
      );

      $data['sorts'][] = array(
        //'text'  => $this->language->get('text_name_desc'),
          'text' => 'От Я до А',
          'value' => 'pd.name-DESC',
          'href'  => $this->url->link('product/viewed', '&sort=pd.name&order=DESC' . $url)
      );

      $data['sorts'][] = array(
        //'text'  => $this->language->get('text_price_asc'),
          'text' => 'От дешевых к дорогим',
          'value' => 'p.price-ASC',
          'href'  => $this->url->link('product/viewed', '&sort=p.price&order=ASC' . $url)
      );

      $data['sorts'][] = array(
        //'text'  => $this->language->get('text_price_desc'),
          'text'  => 'От дорогих к дешевым',
          'value' => 'p.price-DESC',
          'href'  => $this->url->link('product/viewed', '&sort=p.price&order=DESC' . $url)
      );

      if ($this->config->get('config_review_status')) {
        $data['sorts'][] = array(
          //'text'  => $this->language->get('text_rating_desc'),
            'text'  => 'По рейтингу',
            'value' => 'rating-DESC',
            'href'  => $this->url->link('product/viewed', '&sort=rating&order=DESC' . $url)
        );
      }

      $data['limits'] = array();

      $limits = array(15, 25, 50);

      sort($limits);

      foreach($limits as $value) {
        $data['limits'][] = array(
            'text'  => $value,
            'value' => $value,
            'href'  => $this->url->link('product/viewed', $url . '&limit=' . $value)
        );
      }

      $data['filter_form'] = array(
          'filter' => $filter,
          'sort' => $sort,
          'order' => $order,
          'limit' => $limit,
      );

      $products = array();

      if (isset($this->request->cookie['viewed'])) {
        $products = explode(',', $this->request->cookie['viewed']);
      } else if (isset($this->session->data['viewed'])) {
        $products = $this->session->data['viewed'];
      }

      if (isset($this->request->get['route']) && $this->request->get['route'] == 'product/product') {
        $product_id = $this->request->get['product_id'];
        $products = array_diff($products, array($product_id));
        array_unshift($products, $product_id);
        setcookie('viewed', implode(',',$products), time() + 60 * 60 * 24 * 30, '/', $this->request->server['HTTP_HOST']);
      }

//      $products = array_slice($products, 0, (int)$setting['limit']);

      foreach ($products as $product_id) {
        $product_info = $this->model_catalog_product->getProduct($product_id);

        if ($product_info) {
          if ($product_info['image']) {
            $image = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
          } else {
            $image = $this->model_tool_image->resize('placeholder.png', 100, 100);
          }

          if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
            $price = $this->currency->format($this->tax->calculate($product_info['price'], $product_info['tax_class_id'], $this->config->get('config_tax')));
          } else {
            $price = false;
          }

          if ((float)$product_info['special']) {
            $special = $this->currency->format($this->tax->calculate($product_info['special'], $product_info['tax_class_id'], $this->config->get('config_tax')));
          } else {
            $special = false;
          }

          if ($this->config->get('config_tax')) {
            $tax = $this->currency->format((float)$product_info['special'] ? $product_info['special'] : $product_info['price']);
          } else {
            $tax = false;
          }

          if ($this->config->get('config_review_status')) {
            $rating = $product_info['rating'];
          } else {
            $rating = false;
          }

          $data['products'][] = array(
              'product_id'  => $product_info['product_id'],
              'thumb'       => $image,
              'name'        => $product_info['name'],
              'description' => utf8_substr(strip_tags(html_entity_decode($product_info['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
              'price'       => $price,
              'special'     => $special,
              'tax'         => $tax,
              'rating'      => $rating,
              'href'        => $this->url->link('product/product', 'product_id=' . $product_info['product_id'])
          );
        }
      }

      if (file_exists(DIR_TEMPLATE . $view_path)) {
        $this->response->setOutput($this->load->view($view_path, $data));
      } else {
        $this->response->setOutput($default_view_path, $data);
      }
    }
  }
