<footer>

	<div class="row-fluid">
		<div class="span5">
			<a href="<?php bloginfo('url'); ?>"><img alt="OCPSoft logo" src="<?php bloginfo('stylesheet_directory');?>/img/desktop_logo_white.png" /> </a>
			<!-- Google+ -->

			<div style="margin-top: 90px;">
				<div class="g-plusone" data-annotation="none"></div>
			</div>
			
			<!-- Place this tag after the last +1 button tag. -->
			<script type="text/javascript">
			  (function() {
			    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
			    po.src = 'https://apis.google.com/js/plusone.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
			  })();
			</script>
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
