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

$query = "SELECT * FROM `_product_old`";
$rows = mysqli_fetch_all(mysqli_query($ocstore, $query), MYSQLI_ASSOC);
$new_ids = [];

foreach ($rows as $row) {
    $new_ids[$row['old_id']] = $row['product_id'];
}

$count = count($old_products);
$num = 0;
foreach ($old_products as $old_id => $old_product) {
    $query = "
        INSERT INTO `oc_product_description`
        (
            `product_id`, `language_id`, `name`, `description`, 
            `meta_title`, `meta_h1`, `meta_description`, `meta_keyword`
        )
        
        VALUES (
            {$new_ids[$old_id]}, 1, 
            '" . mysqli_escape_string($ocstore, $old_product['products_name']) . "', 
            '" . mysqli_escape_string($ocstore, $old_product['products_description']) . "',
            '" . mysqli_escape_string($ocstore, $old_product['products_meta_title']) . "',
            '" . mysqli_escape_string($ocstore, $old_product['products_name']) . "',
            '" . mysqli_escape_string($ocstore, $old_product['products_meta_description']) . "',
            '" . mysqli_escape_string($ocstore, $old_product['products_meta_keywords']) . "'
        )
    ";

    if (!mysqli_query($ocstore, $query)) {
        echo 'Не создается описание товара: <br/>';
        echo $query . '<br/>';
        echo mysqli_error($ocstore) . '<br/>';
        echo '<pre>';
        var_dump($old_product);
        echo '</pre>';
        break;
    }

    $num++;
}

echo "Создано {$num} описаний товаров из {$count}";
?>

<a href="/import/import7.php">Далее</a>

