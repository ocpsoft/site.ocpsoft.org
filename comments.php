<?php // Do not delete these lines

	/* enable password protection on posts */
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME'])) {
		die ('Please do not load this page directly. Thanks!');
	}
	if ( post_password_required() ) {
		echo '<p class="nocomments">This post is password protected. Enter the password to view comments.</p>';
		return;
	}

	/* This variable is for alternating comment background */
	$oddcomment = "graybox";
?>

<!-- You can start editing here. -->

<?php 

if ( function_exists('wp_list_comments') ) :

	if ( have_comments() ) : ?>
	<h4 id="comments"><?php comments_number('No Comments', 'One Comment', '% Comments' );?></h4>
	<ol class="commentlist">
		<?php wp_list_comments(array('style' => 'ol', 'avatar_size'=>48, 'reply_text'=>'[reply]')); ?>
	</ol>
	<div class="navigation">
	<div class="alignleft"><?php previous_comments_link() ?></div>
	<div class="alignright"><?php next_comments_link() ?></div>
	</div>
	<?php else : // this is displayed if there are no comments so far ?>
		<?php if ( comments_open() ) :
			// If comments are open, but there are no comments.
		else : // comments are closed
		endif;
	endif;

endif;
?>

<?php if ('open' == $post-> comment_status) : ?>

<div id="respond">
<form action="<?php echo get_settings('siteurl'); ?>/wp-comments-post.php" method="post" id="commentform">

	<h3><?php comment_form_title( 'Leave a Comment', 'Reply to %s' ); ?></h3>
	<div id="cancel-comment-reply"><small><?php cancel_comment_reply_link() ?></small></div>

	<div id="commentinputs">
		<?php if(!is_user_logged_in()) { ?>
		<p><input type="text" name="author" id="author" value="<?php echo $comment_author; ?>" size="22" tabindex="1" /><br/>
		<label for="author"><small>Name</small></label></p>

		<p><input type="text" name="email" id="email" value="<?php echo $comment_author_email; ?>" size="22" tabindex="2" /><br/>
		<label for="email"><small>Mail (will not be published)</small></label></p>

		<p><input type="text" name="url" id="url" value="<?php echo $comment_author_url; ?>" size="22" tabindex="3" /><br/>
		<label for="url"><small>Website</small></label></p>
		<?php } ?>

		<p><small><strong>Please note: </strong>In order to submit code or special characters, wrap it in <pre style="color: green; margin-bottom: 10px;">[sourcecode lang="xml"][/sourcecode]</pre> (for your language) - or your tags will be eaten.</small></p>
		<p><textarea name="comment" id="comment" cols="100%" rows="8" tabindex="4"></textarea></p>

		<p><small><?php do_action('comment_form' , $post->ID); ?></small>
		<input name="submit" type="submit" id="submit" tabindex="5" value="Submit Comment" /></p>

		<?php if ('none' != get_settings("comment_moderation")) { ?>
			<p><small><strong>Please note:</strong> Comment moderation is enabled and may delay your comment from appearing. 
			There is no need to resubmit your comment.</small></p>
		<?php } ?>

		<?php comment_id_fields(); ?>
	</div>

</form>
</div>
<?php else : //Comments are closed ?>
<p class="nocomments">Comments are closed.</p>


<?php endif; ?>

