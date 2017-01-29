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

    <div class="annotation">
        <div class="title2"><?= $category_info['name'] ?></div>
        <div class="description"><?= html_entity_decode($category_info['description']) ?></div>
    </div>

</div>

<div class="container clearfix">
    <?php foreach ($posts as $post) { ?>
        <div class="for-men-product">
            <div class="for-title"><a href="<?php echo HTTP_SERVER; ?>index.php?route=services/single&amp;pid=<?php echo $post['ID']; ?>"><?php echo ucfirst($post['title']); ?></a></div>
            <div class="for-img"><img src="<?php echo $post['post_thumbnail']; ?>" alt=""></div>
        </div>
    <?php } ?>
</div>

    <!--
    <div class="container">
        <div class="article clearfix">
            <?= $column_left ?>

            <div class="content-article">
                <?php if (!empty($posts)) { ?>
                    <?php foreach ($posts as $post) { ?>
                        <div class="one-article">
                            <a href="<?php echo HTTP_SERVER; ?>index.php?route=services/single&amp;pid=<?php echo $post['ID']; ?>">
                                <h1 class="title-article"><?php echo ucfirst($post['title']); ?></h1>
                            </a>

                            <?php $time = strtotime($post['date_added']); ?>
                            <span class="date-article"><?php echo date('d',$time); ?>.<?php echo date('m',$time); ?>.<?php echo date('Y',$time); ?></span>

                            <div class="img-article">
                                <img src="<?php echo $post['post_thumbnail']; ?>" alt="<?php echo ucfirst($post['title']); ?>">
                            </div>

                            <p class="description-robotolight"><?php echo $post['excerpt']; ?></p>

                            <?php $tags = explode(',', $post['tag']);?>
                            <?php for ($i=0; $i < count($tags); $i++) : ?>
                                <span class="tags-article">#<span class="tags-article1"><?php echo $tags[$i]; ?></span></span>
                            <?php endfor; ?>

                            <a class="read-article" href="<?php echo HTTP_SERVER; ?>index.php?route=services/single&amp;pid=<?php echo $post['ID']; ?>">Читать</a>
                        </div>
                    <?php } ?>
                <?php } ?>

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
            </div>
        </div>
    </div>
    -->

<?php echo $footer; ?>