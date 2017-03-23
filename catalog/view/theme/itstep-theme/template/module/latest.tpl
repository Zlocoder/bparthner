<div class="main_links">
  <a href="<?= $latest ?>">Новинки</a>
</div>

<div class="products latests products-5n clearfix">
  <?php foreach ($products as $product) { ?>
    <div class="trade_card">
      <?php if ($product['special'] && ($product['price'] - $product['special']) > 0) { ?>
        <div class="container2">
          <div class="quality2">-<?= 100 - round($product['special'] * 100 / $product['price']) ?>%</div>
          <img src="/catalog/view/theme/itstep-theme/bp-site-1/img/sale.png" alt="">
        </div>
      <?php } ?>

      <?php if ($product['new']) { ?><div class="new2"></div><?php } ?>

      <div class="trade_card_img">
        <img src="<?= $product['thumb'] ?>" alt="<?= $product['name'] ?>" title="<?= $product['name']?>" />
      </div>

      <div class="title_trade_card">
        <a href="<?= $product['href'] ?>"><?= $product['name'] ?></a>
      </div>

      <div class="trade_card_description"><?= $product['description'] ?></div>

      <div class="container_price clearfix">
        <button type="submit" onclick="cart.add(<?= $product['product_id'] ?>);">Купить (<?= $product['minimum'] ?> шт.)</button>
        <div class="card_price"><?= preg_replace('/[^\d]+$/', '<sup>$0</sup>', $product['price']) ?></div>
      </div>
    </div>
  <?php } ?>
</div>

<br/>
<br/>