<div id="slideshow<?php echo $module; ?>" class="home-slider">
  <?php foreach ($banners as $banner) { ?>
  <div>
    <?php if ($banner['link']) { ?>
    <a href="<?php echo $banner['link']; ?>"><img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" class="img-responsive" /></a>
    <?php } else { ?>
    <img src="<?php echo $banner['image']; ?>" alt="<?php echo $banner['title']; ?>" />
    <?php } ?>
  </div>
  <?php } ?>
</div>

<script type="text/javascript">
  $(function() {
    $('#slideshow<?php echo $module; ?>').owlCarousel({
      items: 1,
      autoplay: true,
      autoplayTimeout: 3000,
      loop: true
    });
  });
</script>