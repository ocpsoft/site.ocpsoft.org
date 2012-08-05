<footer>

	<?php 
	wp_nav_menu(array(
			'theme_location'  => 'footer',
			'container'       => '',
			'items_wrap'      => '%3$s',
			'walker'          => new OCPsoft_Footer_Menu()
	));
	?>

	<?php 
	if (function_exists('get_sidebar'))
		get_sidebar('footer');
	?>

	<p class="copyright">
		&copy;
		<?=date('Y');?>
		<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?> </a> All Rights Reserved. <a href="#">Terms of Use</a> and <a href="#">Privacy</a>
	</p>

	<?php wp_footer(); ?>

	<?php
	if ( function_exists( 'yoast_analytics' ) )
	{
		yoast_analytics();
	}
	?>
	<script type="text/javascript">jQuery(function(){jQuery('.slide-out-div').tabSlideOut({ tabHandle: '.handle',tabLocation: 'left',speed: 300,action: 'click',topPos: '300px', leftPos: '20px', fixedPosition: true});});</script>

</footer>
