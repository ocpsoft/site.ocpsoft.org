<!DOCTYPE html>
<html lang="en">
<?php get_header(); ?>

<body>
	<div class="container">
		<div class="ocpsoft-toparea">
			<?php include 'navbar.php';?>
		</div>
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

								<section class="post well box-shadow" id="post-<?php the_ID(); ?>">
									<div class="post-title">
										<div class="post-title-meta">
											<img class="entry-img" src="<?php bloginfo('stylesheet_directory'); ?>/img/timeicon.gif" alt="" />
											<?php the_time('F jS, Y') ?>
											by <img class="entry-img" src="<?php bloginfo('stylesheet_directory'); ?>/img/author.gif" alt="" />
											<?php the_author() ?>
										</div>
										<div class="post-title-text">
											<h1>
												<a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title(); ?>"><?php the_title(); ?> </a>
											</h1>
										</div>
									</div>

									<div class="entry">
										<?php the_content(""); ?>
									</div>

									<div class="post-meta">
										Posted in
										<?php the_category(', ') ?>
										|
										<?php edit_post_link('Edit','',' | '); ?>
										<img class="entry-img" src="<?php bloginfo('stylesheet_directory'); ?>/img/comments.gif" />
										<?php comments_popup_link('No Comments', '1 Comment', '% Comments'); ?>
										<a class="more-link pull-right" href="<?php print get_permalink(get_the_ID()); ?>"> Read the full article &raquo;</a>
									</div>

								</section>

								<?php endwhile; ?>
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
