<?php
/*
 Template Name: Page (Splash)
*/
?>

<?php get_header(); ?>

<body>
	<div class="container">
		<div class="ocpsoft-toparea">
			<?php include 'navbar.php';?>

			<?php if (have_posts()) : ?>

			<?php while (have_posts()) : the_post(); ?>

			<?php the_content(); ?>

			<?php endwhile; ?>

			<?php else : ?>

			<?php the_error_page(); ?>

			<?php endif; ?>

		</div>
		<?php get_footer(); ?>
	</div>
</body>
