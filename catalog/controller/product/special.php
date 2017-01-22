<?php
class ControllerProductSpecial extends Controller {


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

    $view_path = $this->config->get('config_template') . '/template/product/special.tpl';
    $default_view_path = 'default/template/module/special.tpl';

    $this->load->language('product/special');

    $this->load->model('catalog/product');

    $this->load->model('tool/image');

    $url = '';

    if (isset($this->request->get['sort'])) {
      $sort = $this->request->get['sort'];
      $url .= '&sort=' . $this->request->get['sort'];
    } else {
      $sort = 'p.sort_order';
    }

    if (isset($this->request->get['order'])) {
      $order = $this->request->get['order'];
      $url .= '&order=' . $this->request->get['order'];
    } else {
      $order = 'ASC';
    }

    if (isset($this->request->get['page'])) {
      $page = $this->request->get['page'];
      $url .= '&page=' . $this->request->get['page'];
    } else {
      $page = 1;
    }

    if (isset($this->request->get['limit'])) {
      $limit = (int)$this->request->get['limit'];
      $url .= '&limit=' . $this->request->get['limit'];
    } else {
      $limit = $this->config->get('config_product_limit');
    }

    $this->document->setTitle($this->language->get('heading_title'));

    $data['breadcrumbs'] = array();

    $data['breadcrumbs'][] = array(
        'text' => $this->language->get('text_home'),
        'href' => $this->url->link('common/home')
    );

    $data['breadcrumbs'][] = array(
        'text' => $this->language->get('heading_title'),
        'href' => $this->url->link('product/special', $url)
    );

    $data['heading_title'] = $this->language->get('heading_title');

    $data['text_empty'] = $this->language->get('text_empty');
    $data['text_quantity'] = $this->language->get('text_quantity');
    $data['text_manufacturer'] = $this->language->get('text_manufacturer');
    $data['text_model'] = $this->language->get('text_model');
    $data['text_price'] = $this->language->get('text_price');
    $data['text_tax'] = $this->language->get('text_tax');
    $data['text_points'] = $this->language->get('text_points');
    $data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
    $data['text_sort'] = $this->language->get('text_sort');
    $data['text_limit'] = $this->language->get('text_limit');

    $data['button_cart'] = $this->language->get('button_cart');
    $data['button_wishlist'] = $this->language->get('button_wishlist');
    $data['button_compare'] = $this->language->get('button_compare');
    $data['button_list'] = $this->language->get('button_list');
    $data['button_grid'] = $this->language->get('button_grid');
    $data['button_continue'] = $this->language->get('button_continue');

    $data['compare'] = $this->url->link('product/compare');

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


    $data['products'] = array();

    $filter_data = array(
        'sort'  => $sort,
        'order' => $order,
        'start' => ($page - 1) * $limit,
        'limit' => $limit
    );

    $product_total = $this->model_catalog_product->getTotalProductSpecials();

    $results = $this->model_catalog_product->getProductSpecials($filter_data);

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
        $rating = (int)$result['rating'];
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
          'minimum'     => $result['minimum'] > 0 ? $result['minimum'] : 1,
          'rating'      => $result['rating'],
          'href'        => $this->url->link('product/product', 'product_id=' . $result['product_id'] . $url)
      );
    }

    $data['pages_count'] = ceil($product_total / $limit);
    $data['current_page'] = $page;
    $data['pagination_url'] = $this->url->link('product/latest', $url . '&page={page}');

    // http://googlewebmastercentral.blogspot.com/2011/09/pagination-with-relnext-and-relprev.html
    if ($page == 1) {
      $this->document->addLink($this->url->link('product/special', '', 'SSL'), 'canonical');
    } elseif ($page == 2) {
      $this->document->addLink($this->url->link('product/special', '', 'SSL'), 'prev');
    } else {
      $this->document->addLink($this->url->link('product/special', 'page='. ($page - 1), 'SSL'), 'prev');
    }

    if ($limit && ceil($product_total / $limit) > $page) {
      $this->document->addLink($this->url->link('product/special', 'page='. ($page + 1), 'SSL'), 'next');
    }

    $data['continue'] = $this->url->link('common/home');
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['column_right'] = $this->load->controller('common/column_right');
    $data['content_top'] = $this->load->controller('common/content_top');
    $data['content_bottom'] = $this->load->controller('common/content_bottom');
    $data['footer'] = $this->load->controller('common/footer');
    $data['header'] = $this->load->controller('common/header');

    if (file_exists(DIR_TEMPLATE . $view_path)) {
      $this->response->setOutput($this->load->view($view_path, $data));
    } else {
      $this->response->setOutput($this->load->view($default_view_path, $data));
    }
  }
}
