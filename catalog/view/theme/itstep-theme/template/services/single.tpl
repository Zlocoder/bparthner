<?php echo $header; ?>

<div class="container">
    <div class="polygraphy"><?php echo ucfirst($post['title']); ?></div>

    <?= $content_top ?>

    <div class="info-service">
        <?= html_entity_decode($post['content']); ?>
    </div>
</div>

<?php echo $footer; ?>