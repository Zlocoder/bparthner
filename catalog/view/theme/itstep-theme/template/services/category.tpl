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

    <div class="polygraphy"><?= $category_info['name'] ?></div>

</div>

<div class="container clearfix">
    <?= html_entity_decode($category_info['description']) ?>

<?php foreach($posts as $post){ ?>
    <div class="service">
        <div class="header-gen"><a href="<?php echo HTTP_SERVER; ?>index.php?route=services/single&amp;pid=<?php echo $post['ID'];?>"><?=html_entity_decode($post['title'])?></a></div>
        <div class="for-img"><img src="<?=$post['post_thumbnail'] ?>"></div>
    </div>
<?php } ?>
</div>

<?php echo $footer; ?>