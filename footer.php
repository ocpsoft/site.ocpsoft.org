<footer>

	<div class="container">
		<div class="logo">
			<a href="<?php bloginfo('url'); ?>"><img alt="OCPSoft logo" src="<?php bloginfo('stylesheet_directory');?>/img/desktop_logo_white.png" /> </a>

		</div>

		<?php 
		wp_nav_menu(array(
				'theme_location'  => 'footer',
				'container'       => '',
				'items_wrap'      => '%3$s',
				'fallback_cb' => 'ocpsoft_menu_fallback',
				'walker'          => new OCPsoft_Footer_Menu()
		));
		?>
	</div>

	<?php 
	if (is_active_sidebar('sidebar-header'))
		dynamic_sidebar('sidebar-footer');
	?>


	<p class="copyright">
		
		<span class="pull-left" style="margin-left: 25px;">
		<span class="g-plusone" data-annotation="none"></span>
		</span>
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
	
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
	<a class="visible-desktop" href="#" id="toTop">Top</a>
</footer>
