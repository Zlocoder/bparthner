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

    <?php echo $column_left; ?>

    <div class="product clearfix">
        <div class="product-img">
            <img class="main-img" src="<?= $thumb ?>" alt="<?= $product_name ?>" title="<?= $product_name ?>"/>

            <?php if ($images) { ?>
                <div class="thumbnails">
                    <?php $i = 0; ?>
                    <?php foreach ($images as $image) { ?>
                        <a class="thumbnail" href="<?php echo $image['popup']; ?>" title="<?php echo $heading_title; ?>" <?php if (++$i > 4) { echo 'style="display: none;"'; } ?>> <img src="<?php echo $image['thumb']; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>" /></a></li>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>

        <div class="product-info">
            <div class="product-info_title"><?= $product_name ?> <?= $model ?></div>

            <div class="product-info_desc clearfix">
                <table class="product_desc" cellspacing="0">
                    <tbody>
                        <?php if ($article) { ?>
                            <tr>
                                <td>Артикул</td>
                                <td><?= $article ?></td>
                            </tr>
                        <?php } ?>

                        <?php foreach ($attribute_groups as $attribute_group) { ?>
                            <?php foreach ($attribute_group['attribute'] as $attribute) { ?>
                                <tr>
                                    <td><?php echo $attribute['name']; ?></td>
                                    <td><?php echo $attribute['text']; ?></td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    </tbody>
                </table>

                <div class="product-controls">
                    <form method="post" action="index.php?route=checkout/cart/add">
                        <input type="hidden" name="product_id" value="<?= $product_id ?>" />

                        <button type="submit" class="add-to-cart">
                            <span>Добавить</span>
                            <img src="/catalog/view/theme/itstep-theme/bp-site-1/img/cart_w.png">
                        </button>

                        <div class="counter">Количество</div>
                        <div class="product-counter">
                            <div class="counter- btn"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/minus.png" alt="-"></div>
                            <input class="counter-display" type="text" name="quantity" value="<?php echo $minimum; ?>" size="2"  />
                            <div class="counter-plus btn"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/plus.png" alt="+"></div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="product-price clearfix">
                <div class="left-product-price">
                    <div class="product-price-delivery"><a href="#">Доставка</a></div>
                    <div class="product-price-nal"><a href="#"><?= $quantity ? 'Есть в наличии' : 'Нет в наличии' ?></a></div>
                </div>
                <div class="product-price-price"><?= $price ?></div>
            </div>
        </div>
    </div>

    <div class="tradecard_description">
        <div class="title-description-reviews">Описание</div>

        <?= $description ?>

        <div class="rating">
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style"><a class="addthis_button_facebook_like" fb:like:layout="button_count"></a> <a class="addthis_button_tweet"></a> <a class="addthis_button_pinterest_pinit"></a> <a class="addthis_counter addthis_pill_style"></a></div>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-515eeaf54693130e"></script>
            <!-- AddThis Button END -->
        </div>
    </div>

    <div class="tradecard_reviews clearfix">
        <div class="title-description-reviews">Отзывы</div>

        <div id="review"></div>

        <!--<?php echo $reviews; ?>-->

        <form id="form-review" action="#" class="clearfix">
            <input type="hidden" name="rating" value="5" />
            <input type="text" name="name" placeholder="Имя...">
            <textarea name="text" placeholder="Сообщение..."></textarea>
            <input id="button-review" type="button" value="ОК">
            <input type="button" value="Авторизация">
            <?php echo $captcha; ?>
        </form>
    </div>

    <?php if ($products) { ?>
        <div class="similar_products">
            <h2>Похожие товары</h2>
            <div class="products">
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
        </div>
    <?php } ?>
</div>

<script type="text/javascript">
/*
$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){
	$.ajax({
		url: 'index.php?route=product/product/getRecurringDescription',
		type: 'post',
		data: $('input[name=\'product_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),
		dataType: 'json',
		beforeSend: function() {
			$('#recurring-description').html('');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['success']) {
				$('#recurring-description').html(json['success']);
			}
		}
	});
});
*/
</script>

<script type="text/javascript">
/*
$('#button-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							element.parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							element.after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['recurring']) {
					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parent().addClass('has-error');
			}

			if (json['success']) {
				$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');

				$('html, body').animate({ scrollTop: 0 }, 'slow');

				$('#cart > ul').load('index.php?route=common/cart/info ul li');
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
});
*/
</script>

<script type="text/javascript">
/*
$('button[id^=\'button-upload\']').on('click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);

						$(node).parent().find('input').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});
*/
</script>

<script type="text/javascript">
$('#review').delegate('.pagination a', 'click', function(e) {
    e.preventDefault();

    $('#review').fadeOut('slow');

    $('#review').load(this.href);

    $('#review').fadeIn('slow');
});

$('#review').load('index.php?route=product/product/review&product_id=<?php echo $product_id; ?>');

$('#button-review').on('click', function() {
	$.ajax({
		url: 'index.php?route=product/product/write&product_id=<?php echo $product_id; ?>',
		type: 'post',
		dataType: 'json',
		data: $("#form-review").serialize(),
		success: function(json) {
			$('.alert-success, .alert-danger').remove();

			if (json['error']) {
				$('#review').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');
			}

			if (json['success']) {
				$('#review').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

				$('input[name=\'name\']').val('');
				$('textarea[name=\'text\']').val('');
				$('input[name=\'rating\']:checked').prop('checked', false);
			}
		}
	});
});
/*
$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		type:'image',
		delegate: 'a',
		gallery: {
			enabled:true
		}
	});
});
*/

$('.products').owlCarousel({
    items: 5,
    dotsClass: 'dots',
    dotClass: 'dot',
    onInitialized: function () {
        $('.dot').css('width', $('.dots').width() / $('.dot').length);
    }
});
</script>

<script>
    $(function() {
        $('.product-counter .btn').click(function() {
            var $input = $(this).siblings('input');
            $input.val(parseInt($input.val()) + ($(this).is('.counter-plus') ? 1 : -1));
        })
    });

    $('.thumbnails').magnificPopup({
        type:'image',
        delegate: 'a',
        gallery: {
            enabled:true
        }
    });
</script>

<?php echo $footer; ?>
