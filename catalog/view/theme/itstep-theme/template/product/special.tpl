<?php echo $header; ?>
<div class="container">
  <div class="row">
    <!-- breadcrumbs begin -->
    <div class="way">
      <?php foreach ($breadcrumbs as $i => $breadcrumb) { ?>

      <span><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></span>
      <? if ($i < count($breadcrumbs) - 1) { ?>
      <i class="fa fa-angle-right" aria-hidden="true"></i>
      <? } ?>
      <?php } ?>
    </div>
    <!-- breadcrumbs end -->
  </div>

  <div class="row">
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($products) { ?>
      <!-- пагинация begin -->
      <div class="nav-pages">
        <?php if ($pages_count > 1) { ?>
        <div class="nav-pages">
          <label>
            <a href="<?= str_replace('{page}', '1', $pagination_url) ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
          </label>

          <?php for ($num = 1; $num <= $pages_count; $num++) { ?>
          <label>
            <a href="<?= str_replace('{page}', $num, $pagination_url) ?>"><?= $num ?></a>
          </label>
          <?php } ?>

          <label>
            <a href="<?= str_replace('{page}', $pages_count, $pagination_url) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
          </label>
        </div>
        <?php } ?>
      </div>
      <!-- пагинация end -->

      <!-- выдача товаров begin -->

      <div class="products products-5n">
        <?php foreach ($products as $product) { ?>
        <div class="trade_card">
          <?php if ($product['special'] && ($product['price'] - $product['special']) > 0) { ?>
          <div class="container2">
            <div class="quality2">-<?= 100 - round($product['special'] * 100 / $product['price']) ?>%</div>
            <img src="/catalog/view/theme/itstep-theme/bp-site-1/img/sale.png" alt=" ">
          </div>
          <?php } ?>

          <div class="trade_card_img"><img src="<?= $product['thumb'] ?>" alt="Sony VAIO" title="Sony VAIO"></div>

          <div class="title_trade_card"><a href="<?= $product['href'] ?>"><?= $product['name'] ?></a></div>
          <div class="trade_card_description"><?= $product['description'] ?></div>

          <div class="container_price clearfix">
              <button type="submit" onclick="cart.add(<?= $product['product_id'] ?>);">Купить (<?= $product['minimum'] ?> шт.)</button>
              <div class="card_price"><?= preg_replace('/[^\d]+$/', '<sup>$0</sup>', $product['price']) ?></div>
          </div>
        </div>
        <?php } ?>
      </div>
      <!-- выдача товаров end -->

        <!-- пагинация begin -->
        <div class="nav-pages">
            <?php if ($pages_count > 1) { ?>
            <div class="nav-pages">
                <label>
                    <a href="<?= str_replace('{page}', '1', $pagination_url) ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
                </label>

                <?php for ($num = 1; $num <= $pages_count; $num++) { ?>
                <label>
                    <a href="<?= str_replace('{page}', $num, $pagination_url) ?>"><?= $num ?></a>
                </label>
                <?php } ?>

                <label>
                    <a href="<?= str_replace('{page}', $pages_count, $pagination_url) ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
                </label>
            </div>
            <?php } ?>
        </div>
        <!-- пагинация end -->

      <?php } else { ?>

      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <?php echo $content_bottom; ?>

    </div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>