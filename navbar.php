<a id="top"></a>
<div class="ocpsoft-mobile-navbar navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span>
			</button>
			<a class="brand" href="<?php bloginfo('url'); ?>"> ocpsoft <!--	<img alt="OCPSoft logo" src="./img/desktop_logo.png"/>-->
			</a>
			<div class="nav-collapse in collapse">
				<ul class="nav">
					<?php 
					wp_nav_menu( array(
							'theme_location'  => 'mobile',
							'fallback_cb'     => 'wp_page_menu',
							'items_wrap'      => '%3$s',
							'depth'           => 1,
							'container'       => '',
							'container_class' => '',
							'container_id'    => '',
							'walker'          => new OCPsoft_Nav_Menu()
					) );
					?>
				</ul>
			</div>
		</div>
	</div>
</div>

<div class="ocpsoft-nav">
	<ul class="nav">
		<li class="ocpsoft-logo"><a href="<?php bloginfo('url'); ?>"><img alt="OCPSoft logo" src="<?php bloginfo('stylesheet_directory');?>/img/desktop_logo.png" /> </a>
		</li>
		<?php 
		wp_nav_menu( array(
				'theme_location'  => 'primary',
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
		) );
		?>
	</ul>
	<div style="clear: both;"></div>
</div>
<?php 
if (function_exists('get_sidebar'))
	get_sidebar('header');
?>
