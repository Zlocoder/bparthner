<?php
$ocstore = mysqli_connect('localhost', 'root', '', 'ocstore');
mysqli_set_charset($ocstore, 'utf8');

$query = "SELECT * FROM `oc_category`";
$categories = mysqli_fetch_all(mysqli_query($ocstore, $query), MYSQLI_ASSOC);
$path_count = 0;

function build_path($parent_id, &$categories, $parents = []) {
    global $ocstore, $path_count;

    $parents[] = $parent_id;

    foreach ($categories as $category) {
        if ($category['parent_id'] == $parent_id) {
            foreach ($parents as $level => $parent) {
                $query = "
                    INSERT INTO `oc_category_path`
                    (`category_id`, `path_id`, `level`)
                    
                    VALUES ({$category['category_id']}, $parent, $level)
                ";

                if (!mysqli_query($ocstore, $query)) {
                    echo 'Не удалось добавить path для категории: <br/>';
                    echo $query . '<br/>';
                    echo mysqli_error($ocstore) . '<br/>';
                    echo '<pre>';
                    var_dump($category);
                    echo '</pre>';
                    die();
                }

                $path_count++;
            }

            $query = "
                INSERT INTO `oc_category_path`
                (`category_id`, `path_id`, `level`)
                
                VALUES ({$category['category_id']}, {$category['category_id']}, " . (count($parents)) . ")
            ";

            if (!mysqli_query($ocstore, $query)) {
                echo 'Не удалось добавить path для категории: <br/>';
                echo $query . '<br/>';
                echo mysqli_error($ocstore) . '<br/>';
                echo '<pre>';
                var_dump($category);
                echo '</pre>';
                die();
            }

            $path_count++;

            build_path($category['category_id'], $categories, $parents);
        }
    }
}

build_path(156, $categories);
$count = count($categories);
echo "Установлено {$path_count} связок для {$count} категорий";
?>
<a href="/import/import5.php">Далее</a>