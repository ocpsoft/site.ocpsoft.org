<footer>
	<div>
		<h3>OCPSoft</h3>
		<ul>
			<li><a href="#">About Us</a></li>
			<li><a href="#">Our Blog</a></li>
			<li><a href="#">Our Customers</a></li>
			<li><a href="#">Latest News & Events</a></li>
		</ul>
	</div>

	<div>
		<h3>Features</h3>
		<ul>
			<li><a href="#">Modern Web</a></li>
			<li><a href="#">Data Access</a></li>
			<li><a href="#">Integration</a></li>
		</ul>
	</div>

	<div>
		<h3>Get Started</h3>
		<ul>
			<li><a href="#">Grab the Tool</a></li>
			<li><a href="#">Tutorials</a></li>
			<li><a href="#">Code Samples</a></li>
			<li><a href="#">Documentation</a></li>
			<li><a href="#">Forums</a></li>
			<li><a href="#">Training</a></li>
		</ul>
	</div>

	<div>
		<h3>Get Involved</h3>
		<ul>
			<li><a href="#">Discussions</a></li>
			<li><a href="#">Issue Tracker</a></li>
			<li><a href="#">Source Repository</a></li>
		</ul>
	</div>

	<div>
		<h3>Projects</h3>
		<ul>
			<li><a href="#">PrettyFaces</a></li>
			<li><a href="#">Rewrite</a></li>
			<li><a href="#">SocialPM</a></li>
		</ul>
	</div>

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

	<!-- Blinking cursor -->
	<script type="text/javascript">
			window.setInterval(function(){
				var c = $(".ocpsoft-blinking-cursor");
				if (c.data('on')===true) {
					c.hide();
					c.data('on',false);
				}
				else {
					c.data('on',true);
					c.show();
				}
			},500)
		</script>
</footer>