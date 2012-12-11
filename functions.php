<?php

/**
 Set default permissions for user roles
 */
$role = get_role( 'author' );
$role->add_cap( 'unfiltered_html' );
$role = get_role( 'contributor' );
$role->add_cap( 'unfiltered_html' );

add_action('wp_enqueue_scripts', 'register_assets');
add_theme_support( 'post-thumbnails' ); 
add_image_size( 'yarpp-thumbnail', 150, 150, true );

function register_assets() {
	wp_register_style("style", get_bloginfo('template_url')."/style.css");
	wp_register_style("style-thumbnails", get_bloginfo('template_url')."/css/thumbnails.php");
	wp_register_style("prettify", get_bloginfo('template_url')."/js/google-code-prettify/prettify.css");
	wp_register_style("alerts", get_bloginfo('template_url')."/css/alerts.css");
	wp_register_style("bootstrap", get_bloginfo('template_url')."/css/bootstrap.css");
	wp_register_style("responsive", get_bloginfo('template_url')."/css/bootstrap-responsive.css");

	wp_register_script( "prettify", get_bloginfo("template_url")."/js/google-code-prettify/prettify.js");
	wp_register_script("jquery", get_bloginfo('template_url')."jquery.js");
	wp_register_script("bootstrap-transition", get_bloginfo('template_url')."/js/bootstrap-transition.js");
	wp_register_script("bootstrap-alert", get_bloginfo('template_url')."/js/bootstrap-alert.js");
	wp_register_script("bootstrap-modal", get_bloginfo('template_url')."/js/bootstrap-modal.js");
	wp_register_script("bootstrap-dropdown", get_bloginfo('template_url')."/js/bootstrap-dropdown.js");
	wp_register_script("bootstrap-scrollspy", get_bloginfo('template_url')."/js/bootstrap-scrollspy.js");
	wp_register_script("bootstrap-tab", get_bloginfo('template_url')."/js/bootstrap-tab.js");
	wp_register_script("bootstrap-tooltip", get_bloginfo('template_url')."/js/bootstrap-tooltip.js");
	wp_register_script("bootstrap-popover", get_bloginfo('template_url')."/js/bootstrap-popover.js");
	wp_register_script("bootstrap-button", get_bloginfo('template_url')."/js/bootstrap-button.js");
	wp_register_script("bootstrap-collapse", get_bloginfo('template_url')."/js/bootstrap-collapse.js");
	wp_register_script("bootstrap-carousel", get_bloginfo('template_url')."/js/bootstrap-carousel.js");
	wp_register_script("bootstrap-typeahead", get_bloginfo('template_url')."/js/typeahead.js");
	wp_register_script( "jquery.tabSlideOut", get_bloginfo("template_url")."/js/jquery.tabSlideOut.js");
	wp_register_script( "jquery.scrollTo", get_bloginfo("template_url")."/js/jquery.scrollTo.js");
	wp_register_script( "toc.functions", get_bloginfo("template_url")."/js/toc.functions.js");
	wp_register_script( "site", get_bloginfo("template_url")."/js/site.js");

	if( !is_admin() )
	{
		wp_enqueue_style("bootstrap");
		wp_enqueue_style("responsive");
		wp_enqueue_style("alerts");
		wp_enqueue_style("style");
		wp_enqueue_style("prettify");
		wp_enqueue_script("jquery");
		wp_enqueue_script("bootstrap-dropdown");
		wp_enqueue_script("bootstrap-collapse");
		wp_enqueue_script("jquery.tabSlideOut");
		wp_enqueue_script("bootstrap-collapse");
		wp_enqueue_script("site");
	}
}

/**
 This theme uses the wp_nav_menu() for top navigation
 */
include 'walker-nav-header.php';
include 'walker-nav-footer.php';

register_nav_menus( array(
		'primary' => 'Primary Navigation'
) );

register_nav_menus( array(
		'mobile' => 'Mobile Navigation'
) );

register_nav_menus( array(
		'footer' => 'Footer Navigation'
) );

function ocpsoft_menu_fallback() {
	$locations = get_theme_mod('nav_menu_locations');

	if (! has_nav_menu('footer') && ! is_nav_menu( 'Footer Navigation' )) {
		$locations['footer'] = wp_create_nav_menu('Footer Navigation', array('slug' => 'footer'));
		set_theme_mod('nav_menu_locations', $locations);
	} else {
		$locations['footer'] = 'Footer Navigation';
		set_theme_mod('nav_menu_locations', $locations);
	}

	if (! has_nav_menu('primary') && ! is_nav_menu( 'Primary Navigation' )) {
		$locations['primary'] = wp_create_nav_menu('Primary Navigation', array('slug' => 'primary'));
		set_theme_mod('nav_menu_locations', $locations);
	} else {
		$locations['primary'] = 'Primary Navigation';
		set_theme_mod('nav_menu_locations', $locations);
	}

	if (! has_nav_menu('mobile') && ! is_nav_menu( 'Mobile Navigation' )) {
		$locations['mobile'] = wp_create_nav_menu('Mobile Navigation', array('slug' => 'mobile'));
		set_theme_mod('nav_menu_locations', $locations);
	} else {
		$locations['mobile'] = 'Mobile Navigation';
		set_theme_mod('nav_menu_locations', $locations);
	}
}

add_filter('wp_nav_menu_objects', function ($items) {
	$hasSub = function ($menu_item_id, &$items) {
		foreach ($items as $item) {
			if ($item->menu_item_parent && $item->menu_item_parent==$menu_item_id) {
				return true;
			}
		}
		return false;
	};

	foreach ($items as &$item) {
		if ($hasSub($item->ID, &$items)) {
			$item->hasSub = true;
			$item->classes[] = 'dropdown'; // all elements of field "classes" of a menu item get join together and render to class attribute of <li> element in HTML
		}
		else
			$item->hasSub = false;
	}
	return $items;
});

// Preserve comments for legacy 2.7 WP versions
add_filter( 'comments_template', 'legacy_comments' );
function legacy_comments( $file ) {
	if ( !function_exists('wp_list_comments') )
		$file = TEMPLATEPATH . '/legacy.comments.php';
	return $file;
}

// Fix up the search form
add_filter('get_search_form', 'my_search_form');

function my_search_form($text) {
	$text = str_replace('type="submit"', 'type="submit" class="btn"', $text);
	$text = str_replace('<form', '<form class="form-inline"', $text);
	$text = str_replace('Search for:', '', $text);
	return $text;
}

/**
 * ShortCodes
 */
function init_common_shortcodes() {
	add_shortcode('sourcecode', 'comment_code_func');
	add_shortcode('code', 'comment_code_func');
}
 
function init_comment_shortcodes() {
	remove_all_shortcodes();
	init_common_shortcodes();
	add_filter('comment_text', 'do_shortcode', -10);
}
 
init_common_shortcodes();
add_filter('comments_template', 'init_comment_shortcodes');

function code_func($atts, $content)
{
	$lang = $atts['lang'];
	$content = htmlspecialchars($content);
	return "<div class='snippit'><pre lang='$lang' class='prettyprint'>".trim($content)."</pre></div>";
}
add_shortcode('sourcecode', 'code_func');
add_shortcode('code', 'code_func');

function comment_code_func($atts, $content)
{
	$lang = $atts['lang'];
	return "<div class='snippit'><pre lang='$lang' class='prettyprint'>".trim($content)."</pre></div>";
}

// This will occur when the comment is posted
function plc_comment_post( $incoming_comment ) {
		  // convert everything in a comment to display literally
		  $incoming_comment['comment_content'] = htmlspecialchars($incoming_comment['comment_content']);

		  // the one exception is single quotes, which cannot be #039; because WordPress marks it as spam
		  $incoming_comment['comment_content'] = str_replace( "'", '&apos;', $incoming_comment['comment_content'] );

		  return( $incoming_comment );
}

// This will occur before a comment is displayed
function plc_comment_display( $comment_to_display ) {
		  // Put the single quotes back in
		  $comment_to_display = str_replace( '&apos;', "'", $comment_to_display );

		  return $comment_to_display;
}

add_filter( 'preprocess_comment', 'plc_comment_post', '', 1 );
add_filter( 'comment_text', 'plc_comment_display', '', 1 );
add_filter( 'comment_text_rss', 'plc_comment_display', '', 1 );
add_filter( 'comment_excerpt', 'plc_comment_display', '', 1 );

// Embed HTML directly as a custom-field shortcode:
// [field name=name-of-custom-field]
function field_func($atts) {
	global $post;
	$name = $atts['name'];
	if (empty($name)) return;

	return do_shortcode(get_post_meta($post->ID, $name, true));
}
add_shortcode('field', 'field_func');

function show_signature($atts)
{
	$username = $atts['username'];
	$user = get_user_by("login", $username);
	if($user)
	{
		$id = $user->ID;
		return get_usermeta($id, 'ft_signature_01');
	}
}

add_shortcode('signature', 'show_signature');

// Generate an Amazon Item link
function amazon_func($atts) {
	global $post;
	$item_codes = $atts['codes'];
	if (empty($item_codes)) return;

	$exploded = explode(",",$item_codes);

	if($exploded == false) return;

	$bgcolor = empty($atts['bgcolor']) ? "FFFFFF" : $atts['bgcolor'];
	$referrer = empty($atts['referrer']) ? "o042-20" : $atts['referrer'];

	$books_html = "<div class='books'>";
	foreach($exploded as $code)
	{
		$books_html .= "<iframe src='http://rcm.amazon.com/e/cm?lt1=_blank&bc1=$bgcolor&IS2=1&npa=1&bg1=$bgcolor&fc1=000000&lc1=0000FF&t=$referrer&o=1&p=8&l=as4&m=amazon&f=ifr&ref=ss_til&asins=".$code."' style='width:120px;height:240px;' scrolling='no' marginwidth='0' marginheight='0' frameborder='0'></iframe>";
	}
	$books_html .= "</div>";
	return $books_html;
}

add_shortcode('amazon', 'amazon_func');


/* Callout alerts */

function callout_info($atts, $content)
{
	return "<div class='tip alert'> <div>$content</div> </div>";
}
add_shortcode('info', 'callout_info');

function callout_warn($atts, $content)
{
	return "<div class='warn alert'> <div>$content</div> </div>";
}
add_shortcode('warn', 'callout_warn');

function callout_error($atts, $content)
{
	return "<div class='error alert'> <div>$content</div> </div>";
}
add_shortcode('error', 'callout_error');

/* Callout command */


$callout_command_index = 0;
$callout_command_search_index = 0;
$callout_command_matches = array();

add_filter('the_content', 'callout_command_before_format', 7); // 7 is simply a lucky number, nothing more =)
	$content = htmlspecialchars($content);
function callout_command_before_format($content)
{
	return preg_replace_callback(
			"/\[command.*?\](.*?)\[\/command\]/siu",
			"callout_command_callback",
			$content
	);
}

function callout_command_callback($match)
{
	global $callout_command_matches, $callout_command_search_index;
	$callout_command_matches[$callout_command_search_index++] = $match[1];
	return $match[0];
}

add_shortcode('command', 'callout_command');
function callout_command($atts, $content)
{
	global $callout_command_matches, $callout_command_index;
	$code_content = trim(htmlspecialchars($callout_command_matches[$callout_command_index++]));
	return "<div class='command alert'> <pre>$code_content</pre> </div>";
}

/*

/* Code Snippits */
$code_snippit_index = 0;
$code_snippit_search_index = 0;
$code_snippit_matches = array();

add_filter('the_content', 'code_snippit_before_format', 7); // 7 is simply a lucky number, nothing more =)
function code_snippit_before_format($content)
{
	return preg_replace_callback(
			"/\[snippit.*?\](.*?)\[\/snippit\]/siu",
			"code_snippit_callback",
			$content
	);
}

function code_snippit_callback($match)
{
	global $code_snippit_matches, $code_snippit_search_index;
	$code_snippit_matches[$code_snippit_search_index++] = $match[1];
	return $match[0];
}

add_shortcode('snippit', 'code_snippit');
function code_snippit($atts, $content)
{
	global $code_snippit_index, $code_snippit_matches;

	$html = "";

	if($code_snippit_index == 0)
	{
		wp_enqueue_script( "prettify" );
		$html .= "<script type='text/javascript'>jQuery(window).load(function(){prettyPrint();});</script>";
	}

	$lang = $atts['lang'];
	$href = $atts['href'];
	$label = $atts['label'];
	$filename = $atts['filename'];

	if(!$filename)
	{
		$filename = "Exhibit $code_snippit_index";
	}

	$class = "prettyprint";
	if($lang)
	{
		$class .= " lang-$lang";
	}

	$code_content = trim(htmlspecialchars($code_snippit_matches[$code_snippit_index++]));

	$html .= "<div class='snippit'>";
	$html .= "<div class='snippit-filename'>$filename";
	if($href)
	{
		if(!$label) $label = "Source";
		$html .= "<a href='$href' target='_blank' class='snippit-file' style='float:right;'>";
		$html .= "$label";
		$html .= "</a>";
	}
	$html.="<div class='clearer'></div></div><pre class='$class' id='code_snippit_".$code_snippit_index."_total_".$code_snippit_search_index."'>"
	.$code_content
	."</pre>"
	."</div>";

	return $html;
}


/* End code snippits */

function slide_out($atts, $content)
{
	wp_enqueue_script( "jquery.tabSlideOut" );
	$handle = empty($atts['handle']) ? "Click me!" : $atts['handle'];
	$header = empty($atts['header']) ? "" : $atts['header'];

	$content = do_shortcode($content);
	$html = "<div class='slide-out-div'>  <div class='inner'> <a rel='nofollow' target='_blank' class='handle' href='#'> <div class='rotate text'><center>$handle</center></div></a>  <center><h3>$header</h3><p>$content</p></center> <div class='clearer'></div> </div> </div>";

	return $html;
}

add_shortcode('slideout', 'slide_out');

/* TOC */
function toc($atts, $content)
{
	if(is_single() || is_page())
	{
		wp_enqueue_script( "jquery.scrollTo" );
		wp_enqueue_script( "toc.functions" );
		$html = "<script type='text/javascript'>jQuery(document).ready(function(){toc_init();});</script>";
		global $toc_active;
		$toc_active = true;
	}
	return $html;
}

add_shortcode('toc', 'toc');

function section($atts, $content)
{
	return '<span class="toc hr"><a href="#"></a><hr/></span>';
}
add_shortcode('section', 'section');
/* End TOC */

if ( function_exists('register_sidebar') )
{
	register_sidebar( array(
			'name' => 'Header Area',
			'id' => 'sidebar-header',
			'description' => __( 'An optional widget area for the site header', 'ocpsoft' ),
			'before_widget' => '',
			'after_widget' => "",
			'before_title' => '',
			'after_title' => '',
	) );

	register_sidebar( array(
			'name' => 'Footer Area',
			'id' => 'sidebar-footer',
			'description' => __( 'An optional widget area for the site footer', 'ocpsoft' ),
			'before_widget' => '',
			'after_widget' => "",
			'before_title' => '',
			'after_title' => '',
	) );

	register_sidebar(array(
			'name' => 'Sidebar Area',
			'id' => 'sidebar-1',
			'before_widget' => '<div class="sidebar-widget"><div class="sidebar-widget-content">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
	));
}

function the_error_page()
{
	include 'error.php';
}

function extra_editor_buttons($buttons) {
	$buttons[] = 'fontselect';
	$buttons[] = 'backcolor';
	$buttons[] = 'image';
	$buttons[] = 'media';
	$buttons[] = 'anchor';
	$buttons[] = 'sub';
	$buttons[] = 'sup';
	$buttons[] = 'hr';
	$buttons[] = 'wp_page';
	$buttons[] = 'cut';
	$buttons[] = 'copy';
	$buttons[] = 'paste';
	$buttons[] = 'newdocument';
	$buttons[] = 'code';
	$buttons[] = 'cleanup';
	$buttons[] = 'styleselect';
	return $buttons;
}
add_filter("mce_buttons_3", "extra_editor_buttons");

?>
