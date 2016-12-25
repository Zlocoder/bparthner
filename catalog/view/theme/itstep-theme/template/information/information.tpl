<?php echo $header; ?>

<div class="container">
  <div class="row">
  <div class="way">
    <span><a href="<?= $breadcrumbs[0]['href'] ?>">Главная</a></span>
    <i class="fa fa-angle-right" aria-hidden="true"></i>
    <span><a href="<?= $breadcrumbs[1]['href'] ?>"><?= $breadcrumbs[1]['text'] ?></a></span>
  </div>
  </div>
  <?php echo $description ?>
</div>

<?php echo $footer; ?>