<?php

class ModelModulePriceFilter extends Model
{
    public function getMinMaxPrice($category_id)
    {
        $customer_group_id = $this->config->get('config_customer_group_id');
        $shipping_country_id = isset($this->session->data['shipping_country_id']) ? $this->session->data['shipping_country_id'] : (($this->config->get('config_tax_default') == 'shipping') ? $this->config->get('config_country_id') : null);
        $shipping_zone_id = isset($this->session->data['shipping_zone_id']) ? $this->session->data['shipping_zone_id'] : (($this->config->get('config_tax_default') == 'shipping') ? $this->config->get('config_zone_id') : null);
        $payment_country_id = isset($this->session->data['payment_country_id']) ? $this->session->data['payment_country_id'] : (($this->config->get('config_tax_default') == 'payment') ? $this->config->get('config_country_id') : null);
        $payment_zone_id = isset($this->session->data['payment_zone_id']) ? $this->session->data['payment_zone_id'] : (($this->config->get('config_tax_default') == 'payment') ? $this->config->get('config_zone_id') : null);

        $conditions = array();

        if ($shipping_country_id || $shipping_zone_id) {
            $conditions[] = "tr1.based = 'shipping' AND z2gz.country_id = '" . (int)$shipping_country_id . "' AND z2gz.zone_id IN ('0', '" . (int)$shipping_zone_id . "')";
        }

        if ($payment_country_id || $payment_zone_id) {
            $conditions[] = "tr1.based = 'payment' AND z2gz.country_id = '" . (int)$payment_country_id . "' AND z2gz.zone_id IN ('0', '" . (int)$payment_zone_id . "')";
        }

        $conditions[] = "tr1.based = 'store' AND z2gz.country_id = '" . (int)$this->config->get('config_country_id') . "' AND z2gz.zone_id IN ('0', '" . (int)$this->config->get('config_zone_id') . "')";

        $sql = "SELECT MIN((IF(special IS NOT NULL, special, IF(discount IS NOT NULL, discount, price)) * (1 + IFNULL(percent_tax, 0)/100) + IFNULL(fixed_tax, 0))) AS min, MAX((IF(special IS NOT NULL, special, IF(discount IS NOT NULL, discount, price)) * (1 + IFNULL(percent_tax, 0)/100) + IFNULL(fixed_tax, 0))) AS max FROM (SELECT p.product_id, p.price, MIN(pd2.price) AS discount, MIN(ps.price) AS special, AVG(rating) AS total, fixed_tax, percent_tax FROM ( SELECT p.* FROM `" . DB_PREFIX . "product` AS p INNER JOIN `" . DB_PREFIX . "product_to_category` AS p2c ON (p.product_id = p2c.product_id) WHERE p2c.category_id = '" . $category_id . "') AS p INNER JOIN `" . DB_PREFIX . "product_to_store` AS p2s ON (p.product_id = p2s.product_id) LEFT JOIN `" . DB_PREFIX . "product_discount` AS pd2 ON (pd2.product_id = p.product_id
                        AND pd2.quantity = '1'
                        AND (pd2.date_start = '0000-00-00' OR pd2.date_start < NOW())
                        AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())
                        AND pd2.customer_group_id = '" . (int)$customer_group_id . "') LEFT JOIN `" . DB_PREFIX . "product_special` AS ps ON (ps.product_id = p.product_id
                        AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())
                        AND (ps.date_start = '0000-00-00' OR ps.date_start < NOW())
                        AND ps.customer_group_id = '" . (int)$customer_group_id . "') LEFT JOIN `" . DB_PREFIX . "review` AS r1 ON (r1.product_id = p.product_id AND r1.status = 1) LEFT JOIN ( SELECT SUM(t.rate) AS fixed_tax, t.tax_class_id FROM ( SELECT DISTINCT tr1.tax_class_id, rate FROM `" . DB_PREFIX . "tax_rule` AS tr1 LEFT JOIN `" . DB_PREFIX . "tax_rate` AS tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN `" . DB_PREFIX . "tax_rate_to_customer_group` AS tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN `" . DB_PREFIX . "zone_to_geo_zone` AS z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN `" . DB_PREFIX . "geo_zone` AS gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr2.type = 'F' AND tr2cg.customer_group_id = '" . (int)$customer_group_id . "'";


        if (count($conditions)) {
            $sql .= ' AND ((' . implode(') OR (', $conditions) . '))';
        }

        $sql .= ") AS t GROUP BY t.tax_class_id) AS tr1 ON (tr1.tax_class_id = p.tax_class_id) LEFT JOIN ( SELECT tax_class_id, SUM(rate) AS percent_tax FROM ( SELECT DISTINCT tr1.tax_class_id, rate FROM `" . DB_PREFIX . "tax_rule` AS tr1 LEFT JOIN `" . DB_PREFIX . "tax_rate` AS tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN `" . DB_PREFIX . "tax_rate_to_customer_group` AS tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN `" . DB_PREFIX . "zone_to_geo_zone` AS z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN `" . DB_PREFIX . "geo_zone` AS gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr2.type = 'P' AND tr2cg.customer_group_id = '" . (int)$customer_group_id . "'";


        if (count($conditions)) {
            $sql .= ' AND ((' . implode(') OR (', $conditions) . '))';
        }

        $sql .= ") AS t GROUP BY t.tax_class_id) AS tr2 ON (tr2.tax_class_id = p.tax_class_id) WHERE p2s.store_id = '0' AND p.status = '1' AND p.date_available <= NOW() GROUP BY p.product_id) as min_max";


        $query = $this->db->query($sql);

        return $query->row;
    }

    public function getProducts($data = array())
    {
        $sql = "SELECT p.product_id, (SELECT AVG(rating) AS total FROM " . DB_PREFIX . "review r1 WHERE r1.product_id = p.product_id AND r1.status = '1' GROUP BY r1.product_id) AS rating, (SELECT price FROM " . DB_PREFIX . "product_discount pd2 WHERE pd2.product_id = p.product_id AND pd2.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND pd2.quantity = '1' AND ((pd2.date_start = '0000-00-00' OR pd2.date_start < NOW()) AND (pd2.date_end = '0000-00-00' OR pd2.date_end > NOW())) ORDER BY pd2.priority ASC, pd2.price ASC LIMIT 1) AS discount, (SELECT price FROM " . DB_PREFIX . "product_special ps WHERE ps.product_id = p.product_id AND ps.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((ps.date_start = '0000-00-00' OR ps.date_start < NOW()) AND (ps.date_end = '0000-00-00' OR ps.date_end > NOW())) ORDER BY ps.priority ASC, ps.price ASC LIMIT 1) AS special";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        if (!empty($data['price_filter'])) {

            $customer_group_id = $this->config->get('config_customer_group_id');
            $shipping_country_id = isset($this->session->data['shipping_country_id']) ? $this->session->data['shipping_country_id'] : (($this->config->get('config_tax_default') == 'shipping') ? $this->config->get('config_country_id') : null);
            $shipping_zone_id = isset($this->session->data['shipping_zone_id']) ? $this->session->data['shipping_zone_id'] : (($this->config->get('config_tax_default') == 'shipping') ? $this->config->get('config_zone_id') : null);
            $payment_country_id = isset($this->session->data['payment_country_id']) ? $this->session->data['payment_country_id'] : (($this->config->get('config_tax_default') == 'payment') ? $this->config->get('config_country_id') : null);
            $payment_zone_id = isset($this->session->data['payment_zone_id']) ? $this->session->data['payment_zone_id'] : (($this->config->get('config_tax_default') == 'payment') ? $this->config->get('config_zone_id') : null);

            $conditions = array();

            if ($shipping_country_id || $shipping_zone_id) {
                $conditions[] = "tr1.based = 'shipping' AND z2gz.country_id = '" . (int)$shipping_country_id . "' AND z2gz.zone_id IN ('0', '" . (int)$shipping_zone_id . "')";
            }

            if ($payment_country_id || $payment_zone_id) {
                $conditions[] = "tr1.based = 'payment' AND z2gz.country_id = '" . (int)$payment_country_id . "' AND z2gz.zone_id IN ('0', '" . (int)$payment_zone_id . "')";
            }

            $conditions[] = "tr1.based = 'store' AND z2gz.country_id = '" . (int)$this->config->get('config_country_id') . "' AND z2gz.zone_id IN ('0', '" . (int)$this->config->get('config_zone_id') . "')";

            $sql .= " LEFT JOIN (SELECT SUM(t.rate) AS fixed_tax, t.tax_class_id FROM (SELECT DISTINCT tr1.tax_class_id, rate FROM `" . DB_PREFIX . "tax_rule` AS tr1 LEFT JOIN `" . DB_PREFIX . "tax_rate` AS tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN `" . DB_PREFIX . "tax_rate_to_customer_group` AS tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN `" . DB_PREFIX . "zone_to_geo_zone` AS z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN `" . DB_PREFIX . "geo_zone` AS gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr2.type = 'F' AND tr2cg.customer_group_id = '" . (int)$customer_group_id . "'";


            if (count($conditions)) {
                $sql .= ' AND ((' . implode(') OR (', $conditions) . '))';
            }

            $sql .= ") AS t GROUP BY t.tax_class_id) AS tr1 ON (tr1.tax_class_id = p.tax_class_id) LEFT JOIN (SELECT tax_class_id, SUM(rate) AS percent_tax FROM (SELECT DISTINCT tr1.tax_class_id, rate FROM `" . DB_PREFIX . "tax_rule` AS tr1 LEFT JOIN `" . DB_PREFIX . "tax_rate` AS tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN `" . DB_PREFIX . "tax_rate_to_customer_group` AS tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN `" . DB_PREFIX . "zone_to_geo_zone` AS z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN `" . DB_PREFIX . "geo_zone` AS gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr2.type = 'P' AND tr2cg.customer_group_id = '" . (int)$customer_group_id . "'";


            if (count($conditions)) {
                $sql .= ' AND ((' . implode(') OR (', $conditions) . '))';
            }

            $sql .= ") AS t GROUP BY t.tax_class_id) AS tr2 ON (tr2.tax_class_id = p.tax_class_id)";

            $sql .= " LEFT JOIN (SELECT price, product_id FROM " . DB_PREFIX . "product_discount) AS pd2 ON (pd2.product_id = p.product_id) LEFT JOIN (SELECT price, product_id FROM " . DB_PREFIX . "product_special) AS ps ON (ps.product_id = p.product_id)";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $sql .= " " . implode(" AND ", $implode) . "";
                }

                if (!empty($data['filter_description'])) {
                    $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $sql .= "pd.tag LIKE '%" . $this->db->escape($data['filter_tag']) . "%'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            $sql .= ")";
        }

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        if (!empty($data['price_filter']['min']) && !empty($data['price_filter']['max'])) {

            $price_min = $this->currency->convert($data['price_filter']['min'], $this->currency->getCode(), $this->config->get('config_currency'));
            $price_max = $this->currency->convert($data['price_filter']['max'], $this->currency->getCode(), $this->config->get('config_currency'));

            $sql .= " AND (IF(ps.price IS NOT NULL, ps.price, IF(pd2.price IS NOT NULL, pd2.price, p.price)) * (1 + IFNULL(percent_tax, 0)/100) + IFNULL(fixed_tax, 0)) >= '" . $price_min . "'";
            $sql .= " AND (IF(ps.price IS NOT NULL, ps.price, IF(pd2.price IS NOT NULL, pd2.price, p.price)) * (1 + IFNULL(percent_tax, 0)/100) + IFNULL(fixed_tax, 0)) <= '" . $price_max . "'";
        }

        $sql .= " GROUP BY p.product_id";

        $sort_data = array(
            'pd.name',
            'p.model',
            'p.quantity',
            'p.price',
            'rating',
            'p.sort_order',
            'p.date_added'
        );

        if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
            if ($data['sort'] == 'pd.name' || $data['sort'] == 'p.model') {
                $sql .= " ORDER BY LCASE(" . $data['sort'] . ")";
            } elseif ($data['sort'] == 'p.price') {
                $sql .= " ORDER BY (CASE WHEN special IS NOT NULL THEN special WHEN discount IS NOT NULL THEN discount ELSE p.price END)";
            } else {
                $sql .= " ORDER BY " . $data['sort'];
            }
        } else {
            $sql .= " ORDER BY p.sort_order";
        }

        if (isset($data['order']) && ($data['order'] == 'DESC')) {
            $sql .= " DESC, LCASE(pd.name) DESC";
        } else {
            $sql .= " ASC, LCASE(pd.name) ASC";
        }

        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }

            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }

            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }

        return $sql;
    }

    public function getTotalProducts($data = array()) {
        $sql = "SELECT COUNT(DISTINCT p.product_id) AS total";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " FROM " . DB_PREFIX . "category_path cp LEFT JOIN " . DB_PREFIX . "product_to_category p2c ON (cp.category_id = p2c.category_id)";
            } else {
                $sql .= " FROM " . DB_PREFIX . "product_to_category p2c";
            }

            if (!empty($data['filter_filter'])) {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product_filter pf ON (p2c.product_id = pf.product_id) LEFT JOIN " . DB_PREFIX . "product p ON (pf.product_id = p.product_id)";
            } else {
                $sql .= " LEFT JOIN " . DB_PREFIX . "product p ON (p2c.product_id = p.product_id)";
            }
        } else {
            $sql .= " FROM " . DB_PREFIX . "product p";
        }

        if (!empty($data['price_filter'])) {

            $customer_group_id = $this->config->get('config_customer_group_id');
            $shipping_country_id = isset($this->session->data['shipping_country_id']) ? $this->session->data['shipping_country_id'] : (($this->config->get('config_tax_default') == 'shipping') ? $this->config->get('config_country_id') : null);
            $shipping_zone_id = isset($this->session->data['shipping_zone_id']) ? $this->session->data['shipping_zone_id'] : (($this->config->get('config_tax_default') == 'shipping') ? $this->config->get('config_zone_id') : null);
            $payment_country_id = isset($this->session->data['payment_country_id']) ? $this->session->data['payment_country_id'] : (($this->config->get('config_tax_default') == 'payment') ? $this->config->get('config_country_id') : null);
            $payment_zone_id = isset($this->session->data['payment_zone_id']) ? $this->session->data['payment_zone_id'] : (($this->config->get('config_tax_default') == 'payment') ? $this->config->get('config_zone_id') : null);

            $conditions = array();

            if ($shipping_country_id || $shipping_zone_id) {
                $conditions[] = "tr1.based = 'shipping' AND z2gz.country_id = '" . (int)$shipping_country_id . "' AND z2gz.zone_id IN ('0', '" . (int)$shipping_zone_id . "')";
            }

            if ($payment_country_id || $payment_zone_id) {
                $conditions[] = "tr1.based = 'payment' AND z2gz.country_id = '" . (int)$payment_country_id . "' AND z2gz.zone_id IN ('0', '" . (int)$payment_zone_id . "')";
            }

            $conditions[] = "tr1.based = 'store' AND z2gz.country_id = '" . (int)$this->config->get('config_country_id') . "' AND z2gz.zone_id IN ('0', '" . (int)$this->config->get('config_zone_id') . "')";

            $sql .= " LEFT JOIN (SELECT SUM(t.rate) AS fixed_tax, t.tax_class_id FROM (SELECT DISTINCT tr1.tax_class_id, rate FROM `" . DB_PREFIX . "tax_rule` AS tr1 LEFT JOIN `" . DB_PREFIX . "tax_rate` AS tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN `" . DB_PREFIX . "tax_rate_to_customer_group` AS tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN `" . DB_PREFIX . "zone_to_geo_zone` AS z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN `" . DB_PREFIX . "geo_zone` AS gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr2.type = 'F' AND tr2cg.customer_group_id = '" . (int)$customer_group_id . "'";


            if (count($conditions)) {
                $sql .= ' AND ((' . implode(') OR (', $conditions) . '))';
            }

            $sql .= ") AS t GROUP BY t.tax_class_id) AS tr1 ON (tr1.tax_class_id = p.tax_class_id) LEFT JOIN (SELECT tax_class_id, SUM(rate) AS percent_tax FROM (SELECT DISTINCT tr1.tax_class_id, rate FROM `" . DB_PREFIX . "tax_rule` AS tr1 LEFT JOIN `" . DB_PREFIX . "tax_rate` AS tr2 ON (tr1.tax_rate_id = tr2.tax_rate_id) INNER JOIN `" . DB_PREFIX . "tax_rate_to_customer_group` AS tr2cg ON (tr2.tax_rate_id = tr2cg.tax_rate_id) LEFT JOIN `" . DB_PREFIX . "zone_to_geo_zone` AS z2gz ON (tr2.geo_zone_id = z2gz.geo_zone_id) LEFT JOIN `" . DB_PREFIX . "geo_zone` AS gz ON (tr2.geo_zone_id = gz.geo_zone_id) WHERE tr2.type = 'P' AND tr2cg.customer_group_id = '" . (int)$customer_group_id . "'";


            if (count($conditions)) {
                $sql .= ' AND ((' . implode(') OR (', $conditions) . '))';
            }

            $sql .= ") AS t GROUP BY t.tax_class_id) AS tr2 ON (tr2.tax_class_id = p.tax_class_id)";

            $sql .= " LEFT JOIN (SELECT price, product_id FROM " . DB_PREFIX . "product_discount) AS pd2 ON (pd2.product_id = p.product_id) LEFT JOIN (SELECT price, product_id FROM " . DB_PREFIX . "product_special) AS ps ON (ps.product_id = p.product_id)";
        }

        $sql .= " LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) LEFT JOIN " . DB_PREFIX . "product_to_store p2s ON (p.product_id = p2s.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.status = '1' AND p.date_available <= NOW() AND p2s.store_id = '" . (int)$this->config->get('config_store_id') . "'";

        if (!empty($data['filter_category_id'])) {
            if (!empty($data['filter_sub_category'])) {
                $sql .= " AND cp.path_id = '" . (int)$data['filter_category_id'] . "'";
            } else {
                $sql .= " AND p2c.category_id = '" . (int)$data['filter_category_id'] . "'";
            }

            if (!empty($data['filter_filter'])) {
                $implode = array();

                $filters = explode(',', $data['filter_filter']);

                foreach ($filters as $filter_id) {
                    $implode[] = (int)$filter_id;
                }

                $sql .= " AND pf.filter_id IN (" . implode(',', $implode) . ")";
            }
        }

        if (!empty($data['filter_name']) || !empty($data['filter_tag'])) {
            $sql .= " AND (";

            if (!empty($data['filter_name'])) {
                $implode = array();

                $words = explode(' ', trim(preg_replace('/\s+/', ' ', $data['filter_name'])));

                foreach ($words as $word) {
                    $implode[] = "pd.name LIKE '%" . $this->db->escape($word) . "%'";
                }

                if ($implode) {
                    $sql .= " " . implode(" AND ", $implode) . "";
                }

                if (!empty($data['filter_description'])) {
                    $sql .= " OR pd.description LIKE '%" . $this->db->escape($data['filter_name']) . "%'";
                }
            }

            if (!empty($data['filter_name']) && !empty($data['filter_tag'])) {
                $sql .= " OR ";
            }

            if (!empty($data['filter_tag'])) {
                $sql .= "pd.tag LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_tag'])) . "%'";
            }

            if (!empty($data['filter_name'])) {
                $sql .= " OR LCASE(p.model) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.sku) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.upc) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.ean) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.jan) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.isbn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
                $sql .= " OR LCASE(p.mpn) = '" . $this->db->escape(utf8_strtolower($data['filter_name'])) . "'";
            }

            $sql .= ")";
        }

        if (!empty($data['filter_manufacturer_id'])) {
            $sql .= " AND p.manufacturer_id = '" . (int)$data['filter_manufacturer_id'] . "'";
        }

        if (!empty($data['price_filter']['min']) && !empty($data['price_filter']['max'])) {

            $price_min = $this->currency->convert($data['price_filter']['min'], $this->currency->getCode(), $this->config->get('config_currency'));
            $price_max = $this->currency->convert($data['price_filter']['max'], $this->currency->getCode(), $this->config->get('config_currency'));

            $sql .= " AND (IF(ps.price IS NOT NULL, ps.price, IF(pd2.price IS NOT NULL, pd2.price, p.price)) * (1 + IFNULL(percent_tax, 0)/100) + IFNULL(fixed_tax, 0)) >= '".$price_min."'";
            $sql .= " AND (IF(ps.price IS NOT NULL, ps.price, IF(pd2.price IS NOT NULL, pd2.price, p.price)) * (1 + IFNULL(percent_tax, 0)/100) + IFNULL(fixed_tax, 0)) <= '".$price_max."'";
        }

        return $sql;
    }
}