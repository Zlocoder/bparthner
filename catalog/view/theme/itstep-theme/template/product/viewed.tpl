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

    <div class="filters">
        <form id="filter">
            <div class="line" style="text-align: center; display: none;">
                <div class="select-container">
                    <select id="filter_order" name="sort">
                        <?php foreach ($sorts as $sort) { ?>
                        <?php if ("{$filter_form['sort']}-{$filter_form['order']}" == $sort['value']) { ?>
                        <option value="<?= $sort['value'] ?>" data-url="<?= $sort['href'] ?>" selected><?= $sort['text'] ?></option>
                        <?php }  else { ?>
                        <option value="<?= $sort['value'] ?>" data-url="<?= $sort['href'] ?>"><?= $sort['text'] ?></option>
                        <?php } ?>
                        <?php } ?>
                    </select>
                </div>

                <!--<div class="select-container-big">
                    от <span class="min-price">57</span>
                    <input type="range" name="price" min="0" max="10000" step="1"> <span class="max-price">10000</span> грн.
                    <input type="submit" value="OK">
                </div>-->

                <div class="paygering">
                    <span>Показывать по</span>
                    <?php foreach ($limits as $limit) { ?>
                    <label><input type="submit" name="limit" data-url="<?= $limit['href'] ?>" value="<?= $limit['value'] ?>"/></label>
                    <?php } ?>
                </div>
            </div>

            <div class="line">
                <a class="command" id="slideUp" style="display: none;"> Сортировать ▲</a>
                <a class="command" id="slideDown" style="display: inline-block;"> Сортировать ▼</a>
            </div>

            <script type="text/javascript">
                $(function () {
                    $('#filter_order').change(function() {
                        var $select = $(this);
                        var url = '';
                        $('option', this).each(function() {
                            var $option = $(this);
                            if ($option.attr('value') == $select.val()) {
                                url = $option.data('url');
                            }
                        });

                        document.location = url;
                    });

                    $('#filter .paygering input').click(function(e) {
                        e.preventDefault();

                        document.location = $(this).data('url');
                    });

                    $('#slideDown').on('click', function (e) {
                        $('#filter .line').not(':last').slideDown();
                        $('#slideDown').hide();
                        $('#slideUp').show();
                    });

                    $('#slideUp').on('click', function (e) {
                        $('#filter .line').not(':last').slideUp();
                        $('#slideUp').hide();
                        $('#slideDown').show();
                    })
                });
            </script>
        </form>
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
                        <div class="card_price"><?= preg_replace('/[^\d]+$/', '<sup>$0</sup>', $product['special'] ? $product['special'] : $product['price']) ?></div>

                        <button type="submit" onclick="cart.add(<?= $product['product_id'] ?>)">Купить</button>
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