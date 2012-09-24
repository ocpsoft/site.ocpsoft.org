<?php // Do not delete these lines
	if ('comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

        if (!empty($post->post_password)) { // if there's a password
            if ($_COOKIE['wp-postpass_'.$cookiehash] != $post->post_password) {  // and it doesn't match the cookie
				?>
				
				<p class="nocomments"><?php _e("This post is password protected. Enter the password to view comments."); ?><p>
				
				<?php
				return;
            }
        }

		/* This variable is for alternating comment background */
		$oddcomment = "graybox";
?>

<!-- You can start editing here. -->

<?php if ($comments) : ?>
	<a name="comments"></a><h2><?php comments_number('No Responses','One Response','% Responses' );?></h2> 

	<ol class="commentlist">

	<?php foreach ($comments as $comment) : ?>

		<li class="<?=$oddcomment;?>">
			<a name="comment-<?php comment_ID() ?>"></a>
			<?php if(function_exists('get_avatar')) { echo get_avatar($comment, '50'); } ?>
			<cite><?php comment_author_link() ?></cite> Says:<br />
			<!--<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title="<?php comment_date('l, F jS, Y') ?> at <?php comment_time() ?>"><?php /* $entry_datetime = abs(strtotime($post->post_date)); $comment_datetime = abs(strtotime($comment->comment_date)); echo time_since($entry_datetime, $comment_datetime) */ ?></a> after publication. <?php edit_comment_link('e','',''); ?></small>-->
			<small class="commentmetadata"><a href="#comment-<?php comment_ID() ?>" title=""><?php comment_date('F jS, Y') ?> at <?php comment_time() ?></a> <?php edit_comment_link('e','',''); ?></small>
			
			<?php comment_text() ?>
			
		</li>
		
		<?php /* Changes every other comment to a different class */	
			if("graybox" == $oddcomment) {$oddcomment="";}
			else { $oddcomment="graybox"; }
		?>

	<?php endforeach; /* end for each comment */ ?>

	</ol>

 <?php else : // this is displayed if there are no comments so far ?>

  <?php if ('open' == $post-> comment_status) : ?> 
		<!-- If comments are open, but there are no comments. -->
		
	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments">Comments are closed.</p>
		
	<?php endif; ?>
<?php endif; ?>


<?php if ('open' == $post-> comment_status) : ?>

<form action="<?php echo get_settings('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">
<a name="respond"></a><h3>Leave a Comment</h3>

<p><input type="text" name="author" id="author" class="styled" value="<?php echo $comment_author; ?>" size="22" tabindex="1" />
<input type="hidden" name="comment_post_ID" value="<?php echo $id; ?>" />
<input type="hidden" name="redirect_to" value="<?php echo htmlspecialchars($_SERVER["REQUEST_URI"]); ?>" />
<label for="author"><small>Name</small></label></p>

<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" />
<label for="email"><small>Mail (will not be published)</small></label></p>

<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" />
<label for="url"><small>Website</small></label></p>

<!--<p><small><strong>XHTML:</strong> You can use these tags: <?php echo allowed_tags(); ?></small></p>-->

<p><textarea name="comment" id="comment" cols="100%" rows="10" tabindex="4"></textarea></p>

<p><?php show_subscription_checkbox(); ?></p>

<?php if ('none' != get_settings("comment_moderation")) { ?>
	<p><small><strong>Please note:</strong> Comment moderation is enabled and may delay your comment. There is no need to resubmit your comment.</small></p>
<?php } ?>

<p><input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /></p>

</form>
<?php // if you delete this the sky will fall on your head
endif; ?>
