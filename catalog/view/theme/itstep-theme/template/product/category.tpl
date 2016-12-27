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

  <div class="container">
    <?php if (!empty($categories)) { ?>
      <div class="article clearfix">
        <div class="nav-products">
          <table class="nav-article-table">
            <thead><tr><td>Подразделы</td></tr></thead>

            <tbody>
              <tr>
                <?php foreach($categories as $category) { ?>
                  <td><a href="<?= $category['href'] ?>"><?= $category['name'] ?></a></td>
                <?php } ?>
              </tr>
            </tbody>
          </table>
        </div>

        <div class="content-products">
    <?php } ?>

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

    <div class="products clearfix <?= empty($categories) ? 'products-5n' : 'products-4n' ?>">
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
            <div class="card_price"><?= preg_replace('/[^\d]+$/', '<sup>$0</sup>', $product['price']) ?></div>

            <button type="submit">Купить</button>
          </div>
        </div>
      <?php } ?>
    </div>

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

    <?php if (!empty($categories)) { ?>
        </div>
      </div>
    <?php } ?>
  </div>
</div>
<?php echo $footer; ?>
