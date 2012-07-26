<?php if (have_posts()) : ?>
<div class="row-fluid">
	<div class="span12">
		<section>
			<div class="pull-left">
				<?php previous_posts_link('&laquo; Newer Entries') ?>
			</div>
			<div class="pull-right">
				<?php next_posts_link('Older Entries &raquo;') ?>
			</div>
		</section>
	</div>
</div>
<?php endif; ?>