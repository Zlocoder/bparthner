<?php echo $header; ?>
<div class="container">
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

  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php echo $text_message; ?>
      <div style="color: red; font-size: 3rem; text-transform: uppercase;">Это success!</div>
      <div class="buttons">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>