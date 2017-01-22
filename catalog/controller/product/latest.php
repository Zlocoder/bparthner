<?php

class ControllerProductLatest extends Controller {


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
    $view_path = $this->config->get('config_template') . '/template/product/latest.tpl';
    $default_view_path = 'default/template/module/latest.tpl';

    /* загрузка модели */
    $this->load->language('product/latest');
    $this->load->model('catalog/product');
    $this->load->model('tool/image');

    /* загрузка локализации */
    $data['heading_title'] = $this->language->get('heading_title');
    $data['text_tax'] = $this->language->get('text_tax');
    $data['button_cart'] = $this->language->get('button_cart');
    $data['button_wishlist'] = $this->language->get('button_wishlist');
    $data['button_compare'] = $this->language->get('button_compare');
    $data['heading_title'] = $this->language->get('heading_title');

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

    $this->document->setTitle('Новые товары');
    $this->document->setDescription('Новые товары');

    /* загрузка модулей страницы, в т.ч. хедера и футера */
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['column_right'] = $this->load->controller('common/column_right');
    $data['content_top'] = $this->load->controller('common/content_top');
    $data['content_bottom'] = $this->load->controller('common/content_bottom');
    $data['footer'] = $this->load->controller('common/footer');
    $data['header'] = $this->load->controller('common/header');

    if (isset($this->request->get['limit'])) {
        $limit = (int)$this->request->get['limit'];
    } else {
        $limit = 15;
    }

    if (isset($this->request->get['page'])) {
        $page = $this->request->get['page'];
    } else {
        $page = 1;
    }

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
      $data['sorts'][] = [
        //'text'  => $this->language->get('text_rating_desc'),
          'text'  => 'По рейтингу',
          'value' => 'rating-DESC',
          'href'  => $this->url->link('product/viewed', '&sort=rating&order=DESC' . $url)
      ];
    }

    $data['limits'] = array();

    if (empty($data['categories'])) {
      $limits = array(15, 25, 50);
    } else {
      $limits = array(12, 24, 48);
    }

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

    $filter_data = array(
      'sort'  => 'p.date_added',
      'order' => 'DESC',
      'start' => $limit * ($page - 1),
      'limit' => $limit
    );

    $data['products'] = array();
    $product_total = $this->model_catalog_product->getTotalProducts($filter_data);
    $results = $this->model_catalog_product->getProducts($filter_data);

    if ($results) {
      foreach ($results as $result) {
        if ($result['image']) {
          $image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
        } else {
          $image = $this->model_tool_image->resize('placeholder.png', $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
        }

        if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
          $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
        } else {
          $price = false;
        }

        if ((float)$result['special']) {
          $special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
        } else {
          $special = false;
        }

        if ($this->config->get('config_tax')) {
          $tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
        } else {
          $tax = false;
        }

        if ($this->config->get('config_review_status')) {
          $rating = $result['rating'];
        } else {
          $rating = false;
        }

        $data['products'][] = array(
            'product_id'  => $result['product_id'],
            'thumb'       => $image,
            'name'        => $result['name'],
            'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
            'price'       => $price,
            'special'     => $special,
            'tax'         => $tax,
            'rating'      => $rating,
            'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'])
        );
      }

      $url = '';

      if (isset($this->request->get['limit'])) {
        $url .= '&limit=' . $this->request->get['limit'];
      }

      $data['pages_count'] = ceil($product_total / $limit);
      $data['current_page'] = $page;
      $data['pagination_url'] = $this->url->link('product/latest', $url . '&page={page}');

      if (file_exists(DIR_TEMPLATE . $view_path)) {
        $this->response->setOutput($this->load->view($view_path, $data));
      } else {
        $this->response->setOutput($this->load->view($default_view_path, $data));
      }
    }
  }
}
