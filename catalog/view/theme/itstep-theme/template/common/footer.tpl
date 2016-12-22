</main>

<footer>
  <div class="container">

    <div class="logo2"><a href="<?= $home ?>"><img src="<?php echo $logo ?>" alt="business-partner_logo"></a></div>

    <div class="footer_katalog">
      <div class="title">Каталог</div>
      <ul>
        <li><a href="<?= $home ?>">Наша продукция</a></li>
        <li><a href="<?= $cat_60 ?>">Канцтовары</a></li>
        <li><a href="<?= $cat_61 ?>">Бумажные изделия</a></li>
        <li><a href="<?= $cat_59 ?>">Офисная техника</a></li>
        <li><a href="<?= $cat_62 ?>">Галантерея</a></li>
      </ul>
    </div>

    <div class="footer_info">
      <div class="title">Информация</div>
      <ul>
        <li><a href="<?= $about ?>">О компании</a></li>
        <li><a href="<?= $delivery ?>">Доставка</a></li>
        <li><a href="<?= $discount ?>">Скидки</a></li>
        <li><a href="<?= $contact ?>">Контакты</a></li>
      </ul>
    </div>

    <div class="footer_tel">
      <div class="title">Номера для заказов:</div><span><?php echo $telephone ?></span>
    </div>

    <div class="repost">
      <div class="repost_child"><a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost/vk.png" alt="vk"></a></div>
      <div class="repost_child"><a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost/google.png" alt="google"></a></div>
      <div class="repost_child"><a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost/fb.png" alt="facebook"></a></div>
      <div class="repost_child"><a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost/ok.png" alt="ok"></a></div>
      <div class="repost_child"><a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost/tw.png" alt="twitter"></a></div>
      <div class="repost_child"><a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost/insta.png" alt="instagram"></a></div>
    </div>
  </div>
</footer>

<div class="top" style="display: block;">
  <img src="/catalog/view/theme/itstep-theme/bp-site-1/img/top_arrow.png" alt="">
</div>

<script>
  var Kh = 0.5;
  $(window).scroll(function (e) {
    if ($(window).scrollTop() >= Kh * $(window).height()) {
      $('.top').fadeIn('slow');
    } else {
      $('.top').fadeOut('slow');
    }
  })
  $('.top').click(function (e) {
    $('body').animate({scrollTop: 0}, 500);
  });
</script>

<script src="/catalog/view/javascript/common.js"></script>


<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>

</body>
</html>