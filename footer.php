<footer>

	<div class="row-fluid">
		<div class="span5">
			<a href="<?php bloginfo('url'); ?>"><img alt="OCPSoft logo" src="<?php bloginfo('stylesheet_directory');?>/img/desktop_logo_white.png" /> </a>
		</div>

		<?php 
		wp_nav_menu(array(
				'theme_location'  => 'footer',
				'container'       => '',
				'items_wrap'      => '%3$s',
				'walker'          => new OCPsoft_Footer_Menu()
		));
		?>
	</div>

	<?php 
	if (function_exists('get_sidebar'))
		get_sidebar('footer');
	?>

	<p class="copyright">
		&copy;
		<?=date('Y');?>
		<a href="<?php bloginfo('url'); ?>"><?php bloginfo('name'); ?> </a> All Rights Reserved.
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
