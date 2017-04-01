<?php

$vamshop = mysqli_connect('localhost', 'root', '', 'vamshop');
mysqli_set_charset($vamshop, 'utf8');

$ocstore = mysqli_connect('localhost', 'root', '', 'ocstore');
mysqli_set_charset($ocstore, 'utf8');

$query = "
    SELECT `products_id`, GROUP_CONCAT(`categories_id`) as `categories`
    FROM `products_to_categories`
    GROUP BY `products_id`
";

$rows = mysqli_fetch_all(mysqli_query($vamshop, $query), MYSQLI_ASSOC);
$old_products = [];
foreach ($rows as $row) {
    $old_products[$row['products_id']] = $row['categories'];
}

$query = "SELECT * FROM `_product_old`";
$rows = mysqli_fetch_all(mysqli_query($ocstore, $query), MYSQLI_ASSOC);
$new_prod_ids = [];
foreach ($rows as $row) {
    $new_prod_ids[$row['old_id']] = $row['product_id'];
}

$query = "SELECT * FROM `_category_old`";
$rows = mysqli_fetch_all(mysqli_query($ocstore, $query), MYSQLI_ASSOC);
$new_cat_ids = [];
foreach ($rows as $row) {
    $new_cat_ids[$row['old_id']] = $row['category_id'];
}


$count = count($old_products);
$num = 0;
foreach ($old_products as $old_id => $categories) {
    $main = true;
    foreach (explode(',', $categories) as $category) {
        $category = isset($new_cat_ids[$category]) ? $new_cat_ids[$category] : 156;

        $query = "
            INSERT INTO `oc_product_to_category`
            (`product_id`, `category_id`, `main_category`)
            
            VALUES ({$new_prod_ids[$old_id]}, {$category}, " . ($main ? 1 : 0) . ")
        ";

        if ($main) { $main = false; }

        if (!mysqli_query($ocstore, $query)) {
            echo 'Не установилась категория: <br/>';
            echo $query . '<br/>';
            echo mysqli_error($ocstore) . '<br/>';
            echo "Товар {$old_id}-{$new_prod_ids[$old_id]}. Категории {$categories}<br/>";
            break;
        }
    }

    $num++;
}

echo "Связано с категориями {$num} товаров из {$count}";
?>
<a href="/import/import8.php">Далее</a>