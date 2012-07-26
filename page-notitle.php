<?php
/*
 Template Name: Page (No Title)
*/
?>
<!DOCTYPE html>
<html lang="en">
<?php get_header(); ?>

<body>
	<a id="top"></a>
	<div class="container">
		<?php include 'navbar.php';?>
		<div class="ocpsoft-middlearea">
			<div class="ocpsoft-middlearea-shadow-top">
				<div class="ocpsoft-middlearea-shadow-bottom">
					<div class="posts">
						<?php if (!have_posts()) : ?>
						<?php the_error_page(); ?>
						<?php else: ?>

						<?php include 'moreposts.php';?>

						<div class="row-fluid">
							<div class="span8 post-outer">

								<?php if (have_posts()) : ?>

								<?php while (have_posts()) : the_post(); ?>

								<div class="post" id="post-<?php the_ID(); ?>">
									<div class="entry">
										<?php the_content('Read the rest of this entry &raquo;'); ?>
									</div>
								</div>

								<?php endwhile; ?>

								<?php else : ?>

								<?php the_error_page(); ?>

								<?php endif; ?>

							</div>
							<?php get_sidebar(); ?>
						</div>

						<?php include 'moreposts.php';?>
						<?php endif;?>
					</div>
				</div>
			</div>
		</div>
		<?php get_footer(); ?>
	</div>
</body>

</html>
