<?php echo $header; ?>

<div class="container">
    <div class="article">
        <div class="content-article2">
            <h1 class="title-article"><?php echo ucfirst($post['title']); ?></h1>

            <?php $time = strtotime($post['date_added']); ?>
            <span class="date-article"><?php echo date('d',$time); ?>.<?php echo date('m',$time); ?>.<?php echo date('Y',$time); ?></span>

            <div class="img-article"><img src="<?= $post['post_thumbnail'] ?>" alt="<?php echo ucfirst($post['title']); ?>"></div>

            <p class="description-robotolight"><?= html_entity_decode($post['content']); ?></p>
        </div>
    </div>
</div>

<?php echo $footer; ?>