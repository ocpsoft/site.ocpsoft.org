<div class="sidebar span4">
	<?php global $toc_active; if ($toc_active) : ?>
	<div id="toc_outer" class="sidebar-widget">
		<div class="sidebar-widget-content">
			<div id="toc"></div>
		</div>
	</div>
	<?php endif ?>
	<?php if ( function_exists('dynamic_sidebar'))
		dynamic_sidebar();
	?>
</div>
