<div class="sidebar span4">
	<?php global $toc_active; if ($toc_active) : ?>
	<div id="toc-outer" class="desktop">
		<div id="toc">
			<div class="sidebar-widget">
				<div class="sidebar-widget-content">
					<div id="toc-contents"></div>
					<div id="toc_fade"></div>
				</div>
			</div>
		</div>
	</div>
	<?php endif ?>
	<?php if ( function_exists('dynamic_sidebar'))
		dynamic_sidebar();
	?>
</div>
