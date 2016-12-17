<div class="header_right clearfix">
  <div class="header_right__left">
    <a class="cart-link-1" href="<?= $cart ?>">ОФОРМИТЬ ЗАКАЗ</a>
    <div class="order_qual">
        <?php if ($count) { ?>
          У вас <span class="qual red3"><?= $count ?></span>
          <?php
          switch(true) {
            case ($count % 100) > 4 && ($count % 100) < 21: echo 'товаров' ; break;
            case ($count % 10) > 5 : echo 'товаров'; break;
            case ($count % 10 > 1) : echo 'товара'; break;
            case ($count % 10) == 1 : echo 'товар'; break;
          }
          ?>
          на сумму <span class="red3"><span class="cash"><?= $total ?>
        <?php } else { ?>
          Корзина пуста
        <?php } ?>
      </div>
  </div>
  <div class="cart">
    <div class="quality"><?= $count ?></div>
    <a class="cart-link-2" href="<?= $cart ?>"></a>
  </div>
</div>