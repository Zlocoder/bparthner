<div class="nav-article">
    <table class="nav-article-table">
        <thead>
        <tr>
            <td>Разделы</td>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($categories)) { ?>
        <tr>
            <?php foreach ($categories as $category) { ?>
            <td><a href="<?= $category['href'] ?>"><?= $category['name'] ?></a></td>
            <?php } ?>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<!--
<div class="widget services-category">
	<div class="widget-header">
		<h2 class="widget-title"><span class="<?php echo $titleicon; ?>"></span>&nbsp;<?php echo $title; ?></h2>
	</div>
	<div class="widget-body content">
		<?php if(!empty($categories)): ?>
			<ul class="list-unstyled list-top">
				<?php foreach ($categories as $category) : ?>
				<?php if ($category['category_id'] == $category_id) : ?>
					<li class="active">
						<a href="<?php echo $category['href']; ?>">
							<span class="<?php echo $listicon; ?>"></span>&nbsp;&nbsp;<strong><?php echo $category['name']; ?></strong>
						</a>
						<?php if(!empty($category['children'])) : ?>
							<ul class="child-list list-unstyled">
								<?php foreach ($category['children'] as $child) : ?>
						            <?php if ($child['category_id'] == $child_id) : ?>
						              <li class="active"><a href="<?php echo $child['href']; ?>">
						              	<span class="<?php echo $sublist_icon; ?>"></span>&nbsp;&nbsp;-&nbsp;<?php echo $child['name']; ?></a></li>
							        <?php else : ?>
							          <li><a href="<?php echo $child['href']; ?>">
							          	<span class="<?php echo $sublist_icon; ?>"></span>&nbsp;&nbsp;-&nbsp;<?php echo $child['name']; ?></a></li>
						            <?php endif; ?>
						        <?php endforeach; ?>
						    </ul>
					    <?php endif; ?>

					</li>
				<?php else : ?>
					<li>
						<a href="<?php echo $category['href']; ?>">
							<span class="<?php echo $listicon; ?>"></span>&nbsp;&nbsp;<?php echo $category['name']; ?>
						</a>
					</li>
					<?php endif; ?>
				<?php endforeach ?>
			</ul>
		<?php else: ?>
			<div class="alert alert-warning"><?php echo $not_found; ?></div>
		<?php endif; ?>

	</div>
</div>

<style type="text/css">
	<?php echo html_entity_decode($custom_style); ?>
</style>

<script type="text/javascript">
	<?php echo html_entity_decode($custom_script); ?>
</script>
-->