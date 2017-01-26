<?php echo $header; ?>

<div class="container">
    <div class="article">
        <div class="content-article2">
            <h1 class="title-article"><?php echo ucfirst($post['title']); ?></h1>

            <?php $time = strtotime($post['date_added']); ?>
            <span class="date-article"><?php echo date('d',$time); ?>.<?php echo date('m',$time); ?>.<?php echo date('Y',$time); ?></span>

            <div class="img-article"><img src="<?= $post['post_thumbnail'] ?>" alt="<?php echo ucfirst($post['title']); ?>"></div>

            <?= html_entity_decode($post['content']); ?>

            <div class="article-leftright clearfix">
                <div class="article-left">
                    <?php $tags = explode(',', $post['tag']);?>
                    <?php for ($i=0; $i < count($tags); $i++) : ?>
                    <span class="tags-article2">#<span class="tags-article1"><?php echo $tags[$i]; ?></span></span>
                    <?php endfor; ?>
                </div>

                <div class="article-right">
                    <div class="repost-article">
                        <span>Поделиться статьей в социальной сети</span>
                        <a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost-article/vk.png" alt="vk"></a>
                        <a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost-article/google.png" alt="google"></a>
                        <a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost-article/facebook.png" alt="facebook"></a>
                        <a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost-article/od.png" alt="OD"></a>
                        <a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost-article/twitter.png" alt="twitter"></a>
                        <a href="#"><img src="/catalog/view/theme/itstep-theme/bp-site-1/img/repost-article/insta.png" alt="instagram"></a>
                    </div>
                    <div id="comment_bubble">55</div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $footer; ?>