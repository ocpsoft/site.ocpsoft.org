<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php bloginfo('name'); ?> <?php if ( is_single() ) { ?> &raquo; Blog Archive <?php } ?> <?php wp_title(); ?>
</title>
<meta name="generator" content="WordPress <?php bloginfo('version'); ?>" />
<meta name="author" content="Lincoln Baxter III| OCPSoft, Mike McNeil | Balderdash Design Co." />

<meta name="verify-v1" content="OQ0iBLFyJUjf6cQTqE2cgArwAgTFHdaaYd5+AWePVBY=" />
<meta name="google-site-verification" content="zNYqxiq_DV1Knn6U762dCVkUaJpw940jyHcn2qEwNIs" />
<meta name="google-site-verification" content="eB9eznz7aE8faLSEG6LtyZlfKZGw69Z-0NLHFiMdgmM" />
<meta name="google-site-verification" content="eB9eznz7aE8faLSEG6LtyZlfKZGw69Z-0NLHFiMdgmM" />
<meta name="viewport" content="width=device-width" />

<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
<link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('stylesheet_directory');?>/ico/favicon.ico" />
<?php wp_get_archives('type=monthly&format=link'); ?>

<!-- HTML5 shim (for IE6-8 support of HTML5 elements) -->
<!--[if lt IE 9]>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<!-- IE9 CSS Gradient support -->
<!--[if gte IE 9]>
<style type="text/css">
	.gradient {
		filter: none;
	}
</style>
<![endif]-->

<?php 
if ( is_single() || is_page() ) {
	wp_enqueue_script( 'comment-reply', null, null, null, true );
}
wp_head();


?>

</head>
