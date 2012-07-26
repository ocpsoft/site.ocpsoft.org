<?php
/*
Template Name: Page (Full Width)
*/
?>
<?php get_header(); ?>

	<div class="container">
		
		<div class="content" style="width: 100%; margin: auto;">

			<?php if (have_posts()) : ?>

			<?php while (have_posts()) : the_post(); ?>

			<div class="post" id="post-<?php the_ID(); ?>">
				<div class="entry">

					<?php the_content('Read the rest of this entry &raquo;'); ?>

				</div>
			</div>


			<?php endwhile; ?>

			<p align="center"><?php next_posts_link('&laquo; Previous Entries') ?> <?php previous_posts_link('Next Entries &raquo;') ?></p>

			<?php else : ?>

			<?php the_error_page(); ?>

			<?php endif; ?>

		</div>

		<div class="clearer"></div>
	</div>
	<?php get_footer(); ?>

</body>

</html>
