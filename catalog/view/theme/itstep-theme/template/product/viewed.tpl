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

                    <div class="title_trade_card"><a href="index_tradecard.html"><?= $product['name'] ?></a></div>
                    <div class="trade_card_description"><?= $product['description'] ?></div>

                    <div class="container_price clearfix">
                        <div class="card_price"><?= $product['price'] ?></div>

                        <button type="submit">Купить</button>
                    </div>
                </div>
                <?php } ?>
            </div>

            <!-- выдача товаров end -->

            <!-- TODO: добавить стилизацию пагинации -->
            <!-- пагинация begin -->
            <!--
            <div class="row">
                <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
                <div class="col-sm-6 text-right"><?php echo $results; ?></div>
            </div>
            -->
            <!-- пагинация end -->

            <?php } else { ?>

            <p><?php echo $text_empty; ?></p>
            <?php } ?>
            <?php echo $content_bottom; ?>

        </div>
        <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>