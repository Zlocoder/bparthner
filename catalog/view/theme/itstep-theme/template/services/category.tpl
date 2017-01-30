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

<div class="container">
    <?= html_entity_decode($category_info['description']) ?>
</div>

<?php foreach($posts as $post){ ?>
<div class="service">

    <div class="for-title"><a href="<?php echo HTTP_SERVER; ?>index.php?route=services/single&amp;pid=<?php echo $post['ID'];?>"><?=html_entity_decode($post['title'])?></a></div>
    <div class="for-img"><img src="<?=$post['image']?>"></div>
</div>

<?php } ?>
<?php echo $footer; ?>