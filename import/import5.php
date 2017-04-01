<?php

$vamshop = mysqli_connect('localhost', 'root', '', 'vamshop');
mysqli_set_charset($vamshop, 'utf8');

$ocstore = mysqli_connect('localhost', 'root', '', 'ocstore');
mysqli_set_charset($ocstore, 'utf8');

$query = "
    SELECT *
    FROM `products`
    INNER JOIN `products_description` ON `products_description`.`products_id` = `products`.`products_id`
";

$rows = mysqli_fetch_all(mysqli_query($vamshop, $query), MYSQLI_ASSOC);
$old_products = [];
foreach ($rows as $row) {
    $old_products[$row['products_id']] = $row;
}

$count = count($old_products);
$num = 0;
foreach ($old_products as $old_id => $old_product) {
    $stock_status = $old_product['products_quantity'] ? 7 : 5;
    $name = mysqli_escape_string($ocstore, $old_product['products_name']);

    $query = "
        INSERT INTO `oc_product`
        (
            `model`, `quantity`, `stock_status_id`, `shipping`, `price`, 
            `tax_class_id`, `weight_class_id`, `length_class_id`, `minimum`, `subtract`, `status`
        )
        
        VALUES (
            '{$name}', {$old_product['products_quantity']}, {$stock_status}, 1, 
            {$old_product['products_price']}, 9, 1, 1, 1, 1, 1 
        )
    ";

    if (!mysqli_query($ocstore, $query)) {
        echo 'Не создается товар: <br/>';
        echo mysqli_error($ocstore) . '<br/>';
        echo '<pre>';
        var_dump($old_product);
        echo '</pre>';
        break;
    }

    $num++;

    $new_id = mysqli_insert_id($ocstore);

    $query = "INSERT INTO `_product_old` (`product_id`, `old_id`) VALUES ({$new_id}, {$old_id})";

    if (!mysqli_query($ocstore, $query)) {
        echo 'Не могу связать новый товар со старым: <br/>';
        echo "Новый id: {$new_id}<br/>";

        echo '<pre>';
        var_dump($old_product);
        echo '</pre>';
        break;
    }
}

echo "Создано {$num} товаров из {$count}";
?>

<a href="/import/import6.php">Далее</a>

