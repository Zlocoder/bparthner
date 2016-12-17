<?php //print_r($popular_posts); ?>
<div class="widget blogtab">
	<div class="widget-header">
		<div class="tabbale-tabs">
			<ul class="nav nav-tabs nav-justified">
			  <li class="active">
			  	<a href="#recent-post" data-toggle="tab"><?php echo $title_recent; ?></a></li>
			  <li>
			  	<a href="#popular-post" data-toggle="tab"><?php echo $title_popular; ?></a></li>
			</ul>
		</div>
	</div>
	<div class="widget-body content">
		<div class="tab-content">

			<div class="tab-pane active tab-post" id="recent-post">
				<?php if( count ($recent_posts) > 0 ) : ?>

					<?php 
					$inc = 0;
					foreach ($recent_posts as $post) : ?>
					<div class="single-post">
						<?php 
						if($thumbnail_show_recent) : ?>
                            <div class="post-thumbnail clearfix">
                                <?php if($thumbnail_type_recent == 'static') : ?>
                                  <img class="post-img" src="<?php echo $thumbnail_recent[$inc]; ?>" alt="...">
                                <?php elseif($thumbnail_type_recent == 'slide') : ?>
                                    <?php if(isset($post_images_recent[$post['ID']])) : ?>
                                      <ul class='thumbslider list-unstyled'>
                                        <?php for ($i=0; $i < count($post_images_recent[$post['ID']]); $i++) : ?>
                                          <li><img src="<?php echo $post_images_recent[$post['ID']][$i]; ?>" alt=""></li>
                                        <?php endfor; ?>
                                      </ul>
                                    <?php else: ?>
                                        <img class="post-img" src="<?php echo $thumbnail_recent[$inc]; ?>" alt="...">
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                            <!-- .post-thumbnail -->
                        <?php endif; ?>
                        <h4 class="post-title">
                        	<a href="index.php?route=blog/single&amp;pid=<?php echo $post['ID']; ?>" title=""><?php echo words_limit($post['title'],$limit_title,'...'); ?></a></h4>
						<div class="text">
							<?php 
							$decoded_content = html_entity_decode($post['content']);
							$stripted_content = strip_tags($decoded_content);
							$limited_content = words_limit($stripted_content, $limit_content, '...');
							?>
							<?php echo $limited_content; ?>
						</div>
					</div>
					<?php 
					$inc++;
					endforeach; ?>

				<?php else: ?>
					<div class="alert alert-warning"><?php echo $not_found_recent; ?></div>
				<?php endif; ?>
			</div>
			<!-- #recent-post -->

			<div class="tab-pane tab-post" id="popular-post">
				<?php if( count ($popular_posts) > 0 ) : ?>

					<?php 
					$inc = 0;
					foreach ($popular_posts as $post) : ?>
					<div class="single-post">
						<?php 
						if($thumbnail_show_recent) : ?>
                            <div class="post-thumbnail clearfix">
                                <?php if($thumbnail_type_recent == 'static') : ?>
                                  <img class="post-img" src="<?php echo $thumbnail_recent[$inc]; ?>" alt="...">
                                <?php elseif($thumbnail_type_recent == 'slide') : ?>
                                    <?php if(isset($post_images_recent[$post['ID']])) : ?>
                                      <ul class='thumbslider list-unstyled'>
                                        <?php for ($i=0; $i < count($post_images_recent[$post['ID']]); $i++) : ?>
                                          <li><img src="<?php echo $post_images_recent[$post['ID']][$i]; ?>" alt=""></li>
                                        <?php endfor; ?>
                                      </ul>
                                    <?php else: ?>
                                        <img class="post-img" src="<?php echo $thumbnail_recent[$inc]; ?>" alt="...">
                                    <?php endif; ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <a href="index.php?route=blog/single&amp;pid=<?php echo $post['ID']; ?>" title=""><?php echo words_limit($post['title'],$limit_title,'...'); ?></a></h4>
                        
						<div class="text">
							<?php 
							$decoded_content = html_entity_decode($post['content']);
							$stripted_content = strip_tags($decoded_content);
							$limited_content = words_limit($stripted_content, 35, '...');
							?>

							<?php echo $limited_content; ?>
						</div>
					</div>
					<?php 
					$inc++;
					endforeach; ?>

				<?php else: ?>
					<div class="alert alert-warning"><?php echo $not_found_popular; ?></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>
<!-- .blogtab -->

<style type="text/css">
	<?php echo html_entity_decode($custom_style); ?>
</style>

<script type="text/javascript">
	<?php echo html_entity_decode($custom_script); ?>
</script>
