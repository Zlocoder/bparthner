<?php echo $header; ?>

<div class="container">
  <div class="way">
    <?php $last = array_pop($breadcrumbs) ?>

    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <span><a href="<?= $breadcrumb['href'] ?>"><?= $breadcrumb['text'] ?></a></span>

      <i class="fa fa-angle-right" aria-hidden="true"></i>
    <?php } ?>

    <span><a href="<?= $last['href'] ?>"><?= $last['text'] ?></a></span>
  </div>

  <?php if ($attention) { ?>
  <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $attention; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>

  <?php if ($success) { ?>
  <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>

  <?php if ($error_warning) { ?>
  <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
    <button type="button" class="close" data-dismiss="alert">&times;</button>
  </div>
  <?php } ?>

  <div class="cart-container clearfix">
    <h1>Корзина</h1>

    <form action="<?php echo $action; ?>" method="post" style="background: none; box-shadow: none;">
    <table class="cart_table" cellspacing="0">
        <thead>
          <tr>
              <td></td>
              <td></td>
              <td>артикул</td>
              <td>количество</td>
              <td>сумма</td>
              <td></td>
          </tr>
        </thead>

        <tbody>
          <?php foreach ($products as $product) { ?>
            <tr>
              <td><img src="<?= $product['thumb'] ?>" alt="<?= $product['name'] ?>"></td>
              <td class="title"><a href="<?= $product['href'] ?>"><?= $product['name'] ?> <?= $product['model'] ?></a></td>
              <td class="cart-product_article"><?= $product['article'] ?></td>

              <td>
                <div class="product-counter">
                  <div class="counter-"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/minus.png" alt="-"></div>
                  <div class="counter-display"><?php echo $product['quantity']; ?></div>
                  <div class="counter-plus"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/plus.png" alt="+"></div>
                </div>
              </td>

              <!--
              <td class="text-left">
                <div class="input-group btn-block" style="max-width: 200px;">
                  <input type="text" name="quantity[<?php echo $product['cart_id']; ?>]" value="<?php echo $product['quantity']; ?>" size="1" class="form-control" />

                  <span class="input-group-btn">
                      <button type="submit" data-toggle="tooltip" title="<?php echo $button_update; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i></button>
                      <button type="button" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger" onclick="cart.remove('<?php echo $product['cart_id']; ?>');"><i class="fa fa-times-circle"></i></button>
                  </span>
                </div>
              </td>
              -->

              <td class="cart-product_price"><?= $product['price'] ?></td>
              <td class="close"><span class="delete_product"><i class="fa fa-times" aria-hidden="true"></i></span></td>
            </tr>
          <?php } ?>
        </tbody>
      </tbody>
    </table>
  </form>

    <?php $last = end($totals); ?>
    <div class="product-price-price"><?= $last['title']; ?>: <?= $last['text']; ?></div>
  </div>

  <div class="cart-button_container">
    <a href="<?= $continue ?>" class="button">Продолжить покупки</a>
    <a href="<?= $checkout ?>" class="button">Оформить заказ</a>
  </div>

    <?php /*
    <?php if ($coupon || $voucher || $reward || $shipping) { ?>
    <div class="panel-group" id="accordion"><?php echo $reward; ?><?php echo $shipping; ?></div>
    <?php } ?>
    */ ?>
</div>

<?php echo $footer; ?>

<script>
    $(function() {
        $('.product-counter .btn').click(function() {
            var product_id = $(this).data('product_id');
            var quantity = parseInt($(this).siblings('.counter-display').text()) + ($(this).is('.counter-plus') ? 1 : -1);

            cart.update(product_id, quantity)
        })
    });
</script>


