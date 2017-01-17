<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $title; if (isset($_GET['page'])) { echo " - ". ($_GET['page']);} ?></title>
  <base href="<?php echo $base; ?>" />
  <?php if ($description) { ?>
  <meta name="description" content="<?php echo $description; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?>" />
  <?php } ?>
  <?php if ($keywords) { ?>
  <meta name="keywords" content= "<?php echo $keywords; ?>" />
  <?php } ?>
  <meta property="og:title" content="<?php echo $title; if (isset($_GET['page'])) { echo " - ". ((int) $_GET['page'])." ".$text_page;} ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:url" content="<?php echo $og_url; ?>" />
  <?php if ($og_image) { ?>
  <meta property="og:image" content="<?php echo $og_image; ?>" />
  <?php } else { ?>
  <meta property="og:image" content="<?php echo $logo; ?>" />
  <?php } ?>
  <meta property="og:site_name" content="<?php echo $name; ?>" />

  <link href="/catalog/view/theme/itstep-theme/bp-site-1/css/normalize.css" rel="stylesheet" />
  <link href="/catalog/view/theme/itstep-theme/bp-site-1/plugins/font-awesome-4.6.3/css/font-awesome.min.css" rel="stylesheet" />
  <link href="/catalog/view/theme/itstep-theme/bp-site-1/plugins/owl.carousel/assets/owl.carousel.css" rel="stylesheet" />
  <!-- Bootstrap CDN is here
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="/catalog/view/theme/itstep-theme/bp-site-1/plugins/bootstrap/css/bootstrap.min.css">
  -->

  <link href="/catalog/view/theme/itstep-theme/bp-site-1/css/style.css" rel="stylesheet" />

  <script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
  <script src="/catalog/view/theme/itstep-theme/bp-site-1/plugins/owl.carousel/owl.carousel.min.js"></script>

  <?php foreach ($styles as $style) { ?>
  <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
  <?php } ?>

  <?php foreach ($links as $link) { ?>
  <link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
  <?php } ?>

  <?php foreach ($scripts as $script) { ?>
  <script src="<?php echo $script; ?>" type="text/javascript"></script>
  <?php } ?>

  <?php /* ?>
  <?php foreach ($analytics as $analytic) { ?>
  <?php echo $analytic; ?>
  <?php } */ ?>
</head>

<body>
  <header>
    <div class="header_top_line">
      <div class="container clearfix">
        <div class="phone">
          <div class="phone_img"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/phone2.png" alt="phone"></div>
          <div class="telnumber"><?php echo $telephone ?></div>
        </div>
        <nav>
          <ul>
            <li><a href="<?= $about ?>">О компании</a></li>
            <li><a href="<?= $blog ?>">Статьи</a></li>
            <li><a href="<?= $delivery ?>">Доставка</a></li>
            <li><a href="<?= $discount ?>">Скидка</a></li>
            <li><a href="<?= $contact ?>">Контакты</a></li>
            <li><a href="<?= $login ?>">Войти</a></li>
          </ul>
        </nav>
      </div>
    </div>

    <div class="header_line">
      <div class="container clearfix">
        <div class="header_left clearfix">
          <div class="logo">
            <a href="<?php echo $home ?>"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" /></a>
          </div>

          <div id="search">
            <input type="text" placeholder="искать товар" name="search">
            <button type="button">
          </div>
        </div>

        <?= $cart ?>
      </div>
    </div>
  </header>

  <main>
    <div class="container">
      <div class="row">
        <nav>
        <ul id="nav" class="clearfix">
          <?php $ids = array('technic', 'stationary', 'paper', 'notion', 'services', 'gifts'); ?>
          <?php $i = 0; ?>
          <?php foreach ($categories as $category) { ?>
            <li>
              <a href="<?= $category['href'] ?>">
                <img src="/image/<?= $category['image'] ?>" alt="" title=""/>
                <span><?= $category['name'] ?></span>
              </a>

              <?php if (!empty($category['childrens'])) { ?>
                <ul class="subs" id="<?= $ids[$i++] ?>">
                  <?php foreach ($category['childrens'] as $children1) { ?>
                    <li>
                      <a href="<?= $children1['href'] ?>">
                        <div class="img_ots">
                          <img src="/image/<?= $children1['image'] ?>" alt="<?= $children1['name'] ?>" title="<?= $children1['name'] ?>" />
                        </div>
                        <?= $children1['name'] ?>
                      </a>

                      <?php if (!empty($children1['childrens'])) { ?>
                        <ul>
                          <?php foreach ($children1['childrens'] as $children2) { ?>
                            <li>
                              <a href="<?= $children2['href'] ?>">
                                <?= $children2['name'] ?>
                                <i class="fa fa-angle-right" aria-hidden="true"></i>
                              </a>
                            </li>
                          <?php } ?>
                        </ul>
                      <?php } ?>
                    </li>
                  <?php } ?>
                </ul>
              <?php } ?>
            </li>
          <?php } ?>
        </ul>
      </nav>
      </div>
    </div>