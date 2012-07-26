<!DOCTYPE html>
<html lang="en">
<?php get_header(); ?>

<body>
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

									<div class="post-title">
										<div class="post-title-text">
											<h1>
												<?php the_title(); ?>
											</h1>
										</div>
									</div>

									<div class="entry">
										<?php the_content('Read the rest of this entry &raquo;'); ?>
									</div>

								</div>

								<?php endwhile; ?>

								<p align="center">
									<?php next_posts_link('&laquo; Previous Entries') ?>
									<?php previous_posts_link('Next Entries &raquo;') ?>
								</p>

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
