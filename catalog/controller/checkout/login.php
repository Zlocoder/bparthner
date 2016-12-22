<?php
class ControllerCheckoutLogin extends Controller {
	public function index() {
        $this->load->language('checkout/checkout');

        $this->load->model('account/address');
        $this->load->model('extension/extension');
        $this->load->model('account/customer');

        // Totals
        $total_data = array();
        $total = 0;
        $taxes = $this->cart->getTaxes();

        $sort_order = array();

        $results = $this->model_extension_extension->getExtensions('total');

        foreach ($results as $key => $value) {
            $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
        }

        array_multisort($sort_order, SORT_ASC, $results);

        foreach ($results as $result) {
            if ($this->config->get($result['code'] . '_status')) {
                $this->load->model('total/' . $result['code']);

                $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
            }
        }

        // Payment Methods
        $method_data = array();

        $results = $this->model_extension_extension->getExtensions('payment');

        $recurring = $this->cart->hasRecurringProducts();

        foreach ($results as $result) {
            if ($this->config->get($result['code'] . '_status')) {
                $this->load->model('payment/' . $result['code']);

                $method = $this->{'model_payment_' . $result['code']}->getMethod();

                if ($method) {
                    if ($recurring) {
                        if (method_exists($this->{'model_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_payment_' . $result['code']}->recurringPayments()) {
                            $method_data[$result['code']] = $method;
                        }
                    } else {
                        $method_data[$result['code']] = $method;
                    }
                }
            }
        }

        $sort_order = array();

        foreach ($method_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $method_data);

        $data['payment_methods'] = $method_data;

        // Shipping methods
        $method_data = array();

        $results = $this->model_extension_extension->getExtensions('shipping');

        foreach ($results as $result) {
            if ($this->config->get($result['code'] . '_status')) {
                $this->load->model('shipping/' . $result['code']);

                $quote = $this->{'model_shipping_' . $result['code']}->getQuote();

                if ($quote) {
                    $method_data[$result['code']] = array(
                        'title'      => $quote['title'],
                        'quote'      => $quote['quote'],
                        'cost'       => $quote['quote'][$quote['code']]['cost'],
                        'sort_order' => $quote['sort_order'],
                        'error'      => $quote['error']
                    );
                }
            }
        }

        $sort_order = array();

        foreach ($method_data as $key => $value) {
            $sort_order[$key] = $value['sort_order'];
        }

        array_multisort($sort_order, SORT_ASC, $method_data);

        $data['shipping_methods'] = $method_data;

        $data['errors'] = array();

	    if (!empty($this->request->post)) {
            if ((utf8_strlen(trim($this->request->post['firstname'])) < 1) || (utf8_strlen(trim($this->request->post['firstname'])) > 32)) {
                $data['errors']['firstname'] = $this->language->get('error_firstname');
            }

            if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
                $data['errors']['telephone'] = $this->language->get('error_telephone');
            }

            if ((utf8_strlen(trim($this->request->post['address'])) < 3) || (utf8_strlen(trim($this->request->post['address'])) > 128)) {
                $data['errors']['address'] = $this->language->get('error_address');
            }

            if (empty($this->request->post['shipping'])) {
                $data['errors']['shipping'] = $this->language->get('error_shipping');
            }

            if (empty($this->request->post['payment'])) {
                $data['errors']['payment'] = $this->language->get('error_payment');
            }

            if (empty($data['errors'])) {
                if (!$customer = $this->model_account_customer->getCustomerByTelephone($this->request->post['telephone'])) {
                    $customer_id = $this->model_account_customer->addCustomer(array(
                        'firstname' => $this->request->post['firstname'],
                        'lastname' => '',
                        'email' => '',
                        'telephone' => $this->request->post['telephone'],
                        'fax' => '',
                        'password' => $this->request->post['telephone'],
                        'company' => '',
                        'address_1' => $this->request->post['address'],
                        'address_2' => '',
                        'city' => 'Мариуполь',
                        'postcode' => '',
                        'country_id' => '220',
                        'zone_id' => '171'
                    ));
                } else {
                    $customer_id = $customer['customer_id'];
                }

                if ($customer_id) {
                    $this->customer->login2($customer_id);
                    $address = $this->model_account_address->getAddress($this->customer->getAddressId());
                    $this->session->data['payment_address'] = $this->session->data['shipping_address'] = $address;
                    $this->session->data['payment_method'] = $data['payment_methods'][$this->request->post['payment']];
                    $this->session->data['shipping_method'] = $data['shipping_methods'][$this->request->post['shipping']];
                    $this->session->data['comment'] = $this->request->post['comment'];
                    $this->response->redirect($this->url->link('checkout/confirm'));
                    return;
                }
            } else {
                $data['firstname'] = $this->request->post['firstname'];
                $data['telephone'] = $this->request->post['telephone'];
                $data['address'] = $this->request->post['address'];
                $data['shipping'] = $this->request->post['shipping'];
                $data['payment'] = $this->request->post['payment'];
                $data['comment'] = $this->request->post['comment'];
            }
        }

	    if ($this->customer->isLogged()) {
            $data['firstname'] = $this->customer->getFirstName();
            $data['telephone'] = $this->customer->getTelephone();

            $address = $this->model_account_address->getAddress($this->customer->getAddressId());
            $data['address'] = $address['address_1'];
        }

        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['column_right'] = $this->load->controller('common/column_right');
        $data['content_top'] = $this->load->controller('common/content_top');
        $data['content_bottom'] = $this->load->controller('common/content_bottom');
        $data['footer'] = $this->load->controller('common/footer');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/login.tpl')) {
			$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/checkout/login.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('default/template/checkout/login.tpl', $data));
		}
	}

	public function save() {
		$this->load->language('checkout/checkout');

		$json = array();

		if ($this->customer->isLogged()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		if (!$json) {
			$this->load->model('account/customer');

			// Check how many login attempts have been made.
			$login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

			if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
				$json['error']['warning'] = $this->language->get('error_attempts');
			}

			// Check if customer has been approved.
			$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

			if ($customer_info && !$customer_info['approved']) {
				$json['error']['warning'] = $this->language->get('error_approved');
			}

			if (!isset($json['error'])) {
				if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
					$json['error']['warning'] = $this->language->get('error_login');

					$this->model_account_customer->addLoginAttempt($this->request->post['email']);
				} else {
					$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
				}
			}
		}

		if (!$json) {
			// Trigger customer pre login event
			$this->event->trigger('pre.customer.login');

			// Unset guest
			unset($this->session->data['guest']);

			// Default Shipping Address
			$this->load->model('account/address');

			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			// Wishlist
			if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
				$this->load->model('account/wishlist');

				foreach ($this->session->data['wishlist'] as $key => $product_id) {
					$this->model_account_wishlist->addWishlist($product_id);

					unset($this->session->data['wishlist'][$key]);
				}
			}

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFirstName() . ' ' . $this->customer->getLastName()
			);

			$this->model_account_activity->addActivity('login', $activity_data);

			// Trigger customer post login event
			$this->event->trigger('post.customer.login');

			$json['redirect'] = $this->url->link('checkout/checkout', '', 'SSL');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
