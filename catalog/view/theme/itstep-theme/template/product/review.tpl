<?php if ($reviews) { ?>
<?php foreach ($reviews as $review) { ?>
<div class="name-text_description">
  <div class="name-description"><?php echo $review['author']; ?></div>
  <div class="text-description"><?php echo $review['text']; ?></div>
</div>
<?php } ?>
<div class="text-right"><?php echo $pagination; ?></div>
<?php } else { ?>
<p><?php echo $text_no_reviews; ?></p>
<?php } ?>
