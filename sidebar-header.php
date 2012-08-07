<?php
/**
 * The header widget areas.
 *
 * @package Lincoln
 * @subpackage Indigo
 * @since 4/1/2012
 */
?>

<?php
	/* The header widget area is triggered if any of the areas
	 * have widgets. So let's check that first.
	 *
	 * If none of the sidebars have widgets, then let's bail early.
	 */
	if (! is_active_sidebar( 'sidebar-header'  ))
		return;
	// If we get this far, we have widgets. Let do this.
?>

<div id="header-widgets">
	<?php if ( is_active_sidebar( 'sidebar-header' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-header' ); ?>
	<?php endif; ?>
</div><!-- #header-widgets -->
