<?php echo $header; ?>

    <div class="container">
    <div class="row">
        <div class="way">
            <span class="way1"><a href="<?= $home ?>">Главная</a> </span>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <span class="way2"><a href="<?= $blog ?>">Статьи</a></span>
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <span class="way2"> <a href="#"><?= $category_info['name'] ?></a></span>
        </div>
    </div>

        <div class="article clearfix">
            <?= $column_left ?>

            <div class="content-article">
                <?php if (!empty($posts)) { ?>
                    <?php foreach ($posts as $post) { ?>
                        <div class="one-article">
                            <a href="<?php echo HTTP_SERVER; ?>index.php?route=blog/single&amp;pid=<?php echo $post['ID']; ?>">
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
                                <!--<a href="<?php echo HTTP_SERVER; ?>index.php?route=blog/tag&amp;tag=<?php echo urldecode($tags[$i]); ?>"><?php echo ucfirst($tags[$i]); ?></a>-->
                                <span class="tags-article">#<span class="tags-article1"><?php echo $tags[$i]; ?></span></span>
                            <?php endfor; ?>

                            <a class="read-article" href="<?php echo HTTP_SERVER; ?>index.php?route=blog/single&amp;pid=<?php echo $post['ID']; ?>">Читать</a>
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

<?php echo $footer; ?>