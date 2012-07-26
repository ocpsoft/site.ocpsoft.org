<div class="ocpsoft-toparea">
	<a id="top"></a>
	<div class="ocpsoft-mobile-navbar navbar navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
				</button>
				<a class="brand" href="<?php bloginfo('url'); ?>"> ocpsoft <!--	<img alt="OCPSoft logo" src="./img/desktop_logo.png"/>-->
				</a>
				<div class="nav-collapse collapse">
					<ul class="nav">
						<?php 
						wp_nav_menu( array( 'items_wrap' => '%3$s' ) );
						?>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="ocpsoft-nav">
		<ul class="nav">
			<li class="ocpsoft-logo"><a href="<?php bloginfo('url'); ?>"><img alt="OCPSoft logo" src="<?php bloginfo('stylesheet_directory');?>/img/desktop_logo.png" /> </a></li>
			<?php 
			$settings = array(
					'theme_location'  => '',
					'menu'            => '',
					'container'       => 'ul',
					'container_class' => '',
					'container_id'    => '',
					'menu_class'      => '',
					'menu_id'         => '',
					'echo'            => true,
					'fallback_cb'     => 'wp_page_menu',
					'before'          => '',
					'after'           => '',
					'link_before'     => '',
					'link_after'      => '',
					'items_wrap'      => '%3$s',
					'depth'           => 0,
					'walker'          => new OCPsoft_Nav_Menu
			);
			
			wp_nav_menu( $settings );
			?>
		</ul>
		<div style="clear: both;"></div>
	</div>
	<?php 
	if (function_exists('get_sidebar'))
		get_sidebar('header');
	?>
</div>














