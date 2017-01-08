<?php

class ControllerProductLatest extends Controller {

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

    /* загрузка модулей страницы, в т.ч. хедера и футера */
    $data['column_left'] = $this->load->controller('common/column_left');
    $data['column_right'] = $this->load->controller('common/column_right');
    $data['content_top'] = $this->load->controller('common/content_top');
    $data['content_bottom'] = $this->load->controller('common/content_bottom');
    $data['footer'] = $this->load->controller('common/footer');
    $data['header'] = $this->load->controller('common/header');

    $filter_data = array(
        'sort'  => 'p.date_added',
        'order' => 'DESC',
        'start' => 0,
        'limit' => 0
    );

    $data['products'] = array();
    $results = $this->model_catalog_product->getProducts($filter_data);

    if ($results) {
      foreach ($results as $result) {
        if ($result['image']) {
          $image = $this->model_tool_image->resize($result['image'], 100, 100);
        } else {
          $image = $this->model_tool_image->resize('placeholder.png', 100, 100);
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

      if (file_exists(DIR_TEMPLATE . $view_path)) {
        $this->response->setOutput($this->load->view($view_path, $data));
      } else {
        $this->response->setOutput($this->load->view($default_view_path, $data));
      }
    }
  }
}
