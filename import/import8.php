<?php

$ocstore = mysqli_connect('localhost', 'root', '', 'ocstore');
mysqli_set_charset($ocstore, 'utf8');

//$query = "UPDATE `oc_product` SET `date_added` = NOW(), `date_modified` = NOW()";
//mysqli_query($ocstore, $query);

$query = "
  INSERT INTO `oc_product_to_store`
  (`product_id`, `store_id`)
  
  SELECT `product_id`, 0 FROM `oc_product`
";
mysqli_query($ocstore, $query);

?>
<a href="/import/import9.php">Далее</a>