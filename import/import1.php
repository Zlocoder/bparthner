<?php

$vamshop = mysqli_connect('localhost', 'root', '', 'vamshop');
mysqli_set_charset($vamshop, 'utf8');

$ocstore = mysqli_connect('localhost', 'root', '', 'ocstore');
mysqli_set_charset($ocstore, 'utf8');

$query = "
    SELECT *
    FROM `categories`
    LEFT JOIN `categories_description` ON `categories_description`.`categories_id` = `categories`.`categories_id`
";

$rows = mysqli_fetch_all(mysqli_query($vamshop, $query), MYSQLI_ASSOC);
$old_categories = [];
foreach ($rows as $row) {
    $old_categories[$row['categories_id']] = $row;
}

$count = count($old_categories);
$num = 0;
foreach ($old_categories as $old_id => $old_category) {
    $query = "
        INSERT INTO `oc_category`
        (`column`)
        VALUES (1)
    ";

    if (!mysqli_query($ocstore, $query)) {
        echo 'Не создается категория: <br/>';
        echo '<pre>';
        var_dump($old_category);
        echo '</pre>';
        break;
    }

    $num++;

    $new_id = mysqli_insert_id($ocstore);

    $query = "INSERT INTO `_category_old` (`category_id`, `old_id`) VALUES ({$new_id}, {$old_id})";

    if (!mysqli_query($ocstore, $query)) {
        echo 'Не могу связать новую категорию со старой: <br/>';
        echo "Новый id: {$new_id}<br/>";

        echo '<pre>';
        var_dump($old_category);
        echo '</pre>';
        break;
    }
}

echo "Создано {$num} категорий из {$count}";
?>

<a href="/import/import2.php">Далее</a>

