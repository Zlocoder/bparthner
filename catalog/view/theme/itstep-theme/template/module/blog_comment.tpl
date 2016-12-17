<?php 
function extractURLcontent($url,$indexComment,$indexLInk) { 
	echo "<script type='text/javascript'>

	function limitWords(textToLimit, wordLimit)
	{
		var finalText = '';

		var text2 = textToLimit.replace(/\s+/g, ' ');

		var text3 = text2.split(' ');

		var numberOfWords = text3.length;

		var i=0;

		if(numberOfWords > wordLimit)
		{
			for(i=0; i< wordLimit; i++)
				finalText = finalText+' '+ text3[i]+' ';

				return finalText+'...';
		} else {
			return textToLimit;
		}	
	}

	$.getJSON('http://api.embed.ly/1/extract?key=74439f33cfc24354bd4cfadacdcbd59a&url=" . $url . "&maxwidth=500&maxheight=250&format=json&callback=?',  
		{dataPass:'', format:'json'},
		function (data) { 
			console.log(data);
			// console.log(data['images'][0]['url']);
			var image = data['images'][0]['url'];
			var title = data['title'];
			var content = (!data['content']) ? data['description'] : data['content'];
			var url =  data['original_url'];
			output = '';
			output += '<div style=\"clear:both;margin:10px;border:1px dotted #F5F5F5;padding:5px;display:block;\">';
			output += '<img style=\"float:left;margin-right:10px\" src=\"' + image + '\" width=\"80\" height=\"80\">';
			output += '<h1>' + title + '</h1>';
			output += limitWords(content,50);
			output += '<a target=\"_blink\" href=\"' + url + '\"> More+ </a>';
			output += '</div>';
			$('#comment" . $indexComment . " a:eq(" . $indexLInk . ")" . "').replaceWith(output);
		});
	</script>";
} ?>

<div class="row">
<div class="col-lg-12">
	<div id="blog-comment">
		<div class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title"><span class="<?php echo $titleicon_list; ?>"></span>&nbsp;<?php echo $title_commentlist; ?></h2>
		</div>
		<div class="panel-body">
			<ul id="commentList" class="comment-box">
			<?php if(!empty($comments)): ?>
				<?php 
				$inc = 0;
				foreach ($comments as $comment) : ?>
					<li class="comment">
					<div class="comment-author <?php echo $author_photo_position ? 'comment-author-'.$author_photo_position : null; ?>">
						<?php if($author_photo_display) : ?>
						<div class="author-img">
							<img class="img-rounded" src="<?php echo $comment['author_image']; ?>" onerror="this.style.display='none'" alt="">
						</div>
						<?php endif; ?>
						<span>BY: <?php echo $comment['comment_author']; ?>, </span>
						<span><?php echo $comment['comment_date']; ?></span>
					</div>
					<div class="comment-content <?php echo $author_photo_position ? 'comment-content-'.$author_photo_position : null; ?>">
						<div id="comment<?php echo $inc; ?>"><?php echo html_entity_decode($comment['comment_content']); ?></div>
						<?php
							$html = str_get_html(html_entity_decode($comment['comment_content']));
							$index = 0;
							foreach($html->find('a') as $e) {
								extractURLcontent($e->href,$inc,$index);
								$index++;
							}
						?>
					</div>
					<div class="clearfix"></div>
					</li>
				<?php 
				$inc++;
				endforeach; ?>
				<div class="pagination-container">
                    <div id="comment-pagination">
		                <?php echo $pagination; ?><br>
		                <?php echo $results; ?>
		            </div>
		            <div class="clerarfix"></div>
				</div>
			<?php else: ?>
				<div class="alert alert-warning"><?php echo $not_found; ?></div>
			<?php endif; ?>
			</ul>
		</div>
		</div>
		<!-- .panel -->
	</div>
	<!-- #blog-comment -->
</div>
</div>

<?php if($comment_status == 'open') : ?>
	
<div id="commentAlert">
	<?php form_error(); ?>
	<?php form_msg(); ?>
</div>

<div class="row">
<div class="col-lg-12">
	<div id="comment-form" class="panel panel-default">
		<div class="panel-heading">
			<h2 class="panel-title"><span class="<?php echo $titleicon_comment; ?>"></span>&nbsp;<?php echo $title_commentbox; ?></h2>
		</div>
		<div class="panel-body">
		<form id="form" class="form" action="<?php echo HTTP_SERVER; ?>index.php?route=module/blog_comment/submit&amp;pid=<?php echo $_GET['pid']; ?>" method="post">

			<?php if(!getId()) : ?>
			<div class="form-group">
				<label for="name" class="control-label col-sm-12"><?php echo $entry_name; ?></label>
				<div class="col-sm-12">
					<input type="text" name="name" id="name" class="form-control" data-toggle="tooltip" data-placement="top" data-original-title="">
					<?php if (isset($form_error['name'])) { ?>
                      <div class="label label-danger"><?php echo ucfirst($form_error['name']); ?></div>
                    <?php } ?>
				</div>
			</div>

			<div class="form-group">
				<label for="website" class="control-label col-sm-12"><?php echo $entry_email; ?></label>
				<div class="col-sm-12">
					<input type="email" name="email" id="email" placeholder="" class="form-control"  data-toggle="tooltip" data-placement="top" data-original-title="">
					<?php if (isset($form_error['email'])) { ?>
                      <div class="label label-danger"><?php echo ucfirst($form_error['email']); ?></div>
                    <?php } ?>
				</div>
			</div>
			<?php endif; ?>

			<div class="form-group">
				<label for="comment" class="control-label col-sm-12"><?php echo $entry_comment; ?></label>
				<div class="col-sm-12">
					<textarea name="comment" id="comment" rows="10" class="form-control" data-toggle="tooltip" data-placement="top" data-original-title=""></textarea>
					<?php if (isset($form_error['comment'])) { ?>
                      <div class="label label-danger"><?php echo ucfirst($form_error['comment']); ?></div>
                    <?php } ?>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-12">
					<button type="submit" class="btn btn-success btn-lg" id="submit"><?php echo $button_submit; ?></button>&nbsp;&nbsp;
					<button type="reset" class="btn btn-warning btn-lg"><?php echo $button_reset; ?></button>
				</div>
			</div>

		</form>
		</div>
	</div>
	<!-- #comment-form -->
</div>
</div>
<?php endif; ?>

<script type="text/javascript"><!--
	$('#submitxx').on('click', function() {
	var comment = $('#comment').code();
	$.ajax({
		url: "index.php?route=module/blog_comment/submit&pid=<?php echo $_GET['pid']; ?>",
		type: 'post',
		dataType: 'json',
		data: $('#form').serialize()+'&comment='+comment+'&ajax=1',
		beforeSend: function() {
			$('#submit').button('loading');
		},
		complete: function() {
			$('#submit').button('reset');
		},
		success: function(json) {
			$('.alert-success, .alert-danger').remove();
			$('input[name="name"]').attr('data-original-title','').css('border','1px solid #ccc');
			$('input[name="email"]').attr('data-original-title','').css('border','1px solid #ccc');
			$('.note-editable').attr('data-original-title','').css('border','none');
			for (var key in json['form_error']) {
				if (json['form_error'].hasOwnProperty(key)) {	
					var msg = json['form_error'][key];
					var msgText = $(msg).text();
				  	$('input[name="'+key+'"]').attr('data-original-title',msgText).tooltip('show').css('border','1px solid #970000');  
				  	if(key == 'comment') {
				  		$('.note-editable').attr({'data-toggle':'tooltip','data-placement':'top','data-original-title':msgText}).tooltip('show').css('border','1px solid #970000');
				  	}
				}
			};
			if (json['success']) {
				$('#blog-comment').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');
				
				$('input[name=\'name\']').val('');
				$('input[name=\'email\']').val('');
				$('#comment').code('');

				$('input[name="name"]').attr('data-original-title','').css('border','1px solid #ccc');
				$('input[name="email"]').attr('data-original-title','').css('border','1px solid #ccc');
				$('.note-editable').attr('data-original-title','').css('border','none');

				$('#commentList').load('index.php?route=blog/single&pid=<?php echo $_GET['pid']; ?> #commentList');

				var position = $('#blog-comment').offset().top - 80;
				$("html, body").animate({ scrollTop: position }, "slow");
			}
		}
	});
	return false;
});
//--></script> 

<style type="text/css">
	<?php echo html_entity_decode($custom_style_comment); ?>
	<?php echo html_entity_decode($custom_style_commentbox); ?>
</style>

<script type="text/javascript">
	<?php echo html_entity_decode($custom_script_comment); ?>
	<?php echo html_entity_decode($custom_script_commentbox); ?>
</script>

<script type="text/javascript"><!--
  $('#comment').summernote({
    height: 200
  });
//--></script>