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
    $query = "
        INSERT INTO `oc_category_description`
        (
            `category_id`, `language_id`, `name`, `description`, 
            `meta_title`, `meta_h1`, `meta_description`, `meta_keyword`
        )
        
        VALUES (
            {$new_ids[$old_id]}, 1, 
            '{$old_category['categories_name']}', 
            '" . mysqli_escape_string($ocstore, $old_category['categories_description']) . "',
            '{$old_category['categories_meta_title']}',
            '{$old_category['categories_heading_title']}',
            '{$old_category['categories_meta_description']}',
            '{$old_category['categories_meta_keywords']}'
        )
    ";

    if (!mysqli_query($ocstore, $query)) {
        echo 'Не создается описание категории: <br/>';
        echo mysqli_error($ocstore) . '<br/>';
        echo '<pre>';
        var_dump($old_category);
        echo '</pre>';
        break;
    }

    $num++;
}

echo "Создано {$num} описаний категорий из {$count}";
?>
<a href="/import/import3.php">Далее</a>