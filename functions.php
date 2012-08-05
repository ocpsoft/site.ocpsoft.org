<?php

/**
 Set default permissions for user roles
 */
$role = get_role( 'author' );
$role->add_cap( 'unfiltered_html' );
$role = get_role( 'contributor' );
$role->add_cap( 'unfiltered_html' );

wp_register_style("style", get_bloginfo('template_url')."/style.css");
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

if( !is_admin() )
{
	wp_enqueue_style("bootstrap");
	wp_enqueue_style("responsive");
	wp_enqueue_style("style");
	wp_enqueue_style("alerts");
	wp_enqueue_style("prettify");

	wp_enqueue_script("jquery");
	wp_enqueue_script("bootstrap-dropdown");
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
		'footer' => 'Footer Navigation'
) );

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
?>

<?php 
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

?>

<?php
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
?>

<?php

register_sidebar( array(
		'name' => __( 'Header Area', 'ocpsoft' ),
		'id' => 'sidebar-header',
		'description' => __( 'An optional widget area for the site header', 'ocpsoft' ),
		'before_widget' => '',
		'after_widget' => "",
		'before_title' => '',
		'after_title' => '',
) );

register_sidebar( array(
		'name' => __( 'Footer Area', 'ocpsoft' ),
		'id' => 'sidebar-header',
		'description' => __( 'An optional widget area for the site footer', 'ocpsoft' ),
		'before_widget' => '',
		'after_widget' => "",
		'before_title' => '',
		'after_title' => '',
) );

if ( function_exists('register_sidebar') )
	register_sidebar(array(
			'name' => __( 'Sidebar Area', 'ocpsoft' ),
			'id' => 'sidebar-1',
			'before_widget' => '<div class="sidebar-widget"><div class="sidebar-widget-content">',
			'after_widget' => '</div></div>',
			'before_title' => '<h3>',
			'after_title' => '</h3>',
	));

// WP-indigo Pages Box
function widget_indigo_pages() {
	?>

<h1>
	<?php _e('Pages'); ?>
</h1>
<ul>
	<li class="page_item"><a href="<?php bloginfo('url'); ?>">Home</a></li>

	<?php wp_list_pages('title_li='); ?>

</ul>

<?php
}
if ( function_exists('register_sidebar_widget') )
	register_sidebar_widget(__('Pages'), 'widget_indigo_pages');


// WP-indigo Search Box
function widget_indigo_search() {
	?>

<ul>
	<li><h1>
			<label for="s"> <?php _e('Search Posts'); ?>
			</label>
		</h1>
		<form id="searchform" method="get" action="<?php bloginfo('url'); ?>/index.php">

			<input type="text" name="s" size="18" /><br> <input type="submit" id="submit" name="Submit" value="Search" />


		</form>
	</li>
</ul>

<?php
}
if ( function_exists('register_sidebar_widget') )
	register_sidebar_widget(__('Search'), 'widget_indigo_search');

// WP-indigo Blogroll
function widget_indigo_blogroll() {
	?>

<h1>
	<?php _e('Blogroll'); ?>
</h1>

<ul>

	<?php get_links(-1, '<li>', '</li>', '', FALSE, 'name', FALSE, FALSE, -1, FALSE); ?>

</ul>



<?php
}
if ( function_exists('register_sidebar_widget') )
	register_sidebar_widget(__('Blogroll'), 'widget_indigo_blogroll');


function the_subpages()
{
	global $post, $wpdb;

	if ( is_page() )
	{
		if ( $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type='page' AND post_parent = ".$post->ID) > 0 ){
			$subpages = $post->ID;
		}
		else if ( $post->post_parent != 0 ){
			$subpages = $post->post_parent;
		}

		if ($subpages)
		{
			echo '<h1>Subpages</h1>' . "\n";
			echo '<ul>' . "\n";
			wp_list_pages('title_li=&child_of='.$subpages);
			echo '</ul>' . "\n";
		}
	}
}

function the_error_page()
{
	include 'error.php';
}

?>
