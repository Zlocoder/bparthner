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

$query = "SELECT * FROM `_category_old`";
$rows = mysqli_fetch_all(mysqli_query($ocstore, $query), MYSQLI_ASSOC);
$new_ids = [];

foreach ($rows as $row) {
    $new_ids[$row['old_id']] = $row['category_id'];
}

$count = count($old_categories);
$num = 0;

foreach ($old_categories as $old_id => $old_category) {
    $parent_id = 156;

    if ($old_category['parent_id'] && isset($new_ids[$old_category['parent_id']])) {
        $parent_id = $new_ids[$old_category['parent_id']];
    }

    $query = "
        UPDATE `oc_category`
        SET `parent_id` = {$parent_id}
        WHERE `category_id` = {$new_ids[$old_id]}
    ";

    if (!mysqli_query($ocstore, $query)) {
        echo 'Не обновилась родительская категория: <br/>';
        echo mysqli_error($ocstore) . '<br/>';
        echo '<pre>';
        var_dump($old_category);
        echo '</pre>';
        break;
    }

    $num++;
}

echo "Обновлено {$num} родительских категорий из {$count}";
?>
<a href="/import/import4.php">Далее</a>