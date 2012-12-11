<?php
/*
Template Name: Thumbnails
Description: Requires a theme which supports post thumbnails
Author: Lincoln Baxter, III
*/ ?>
<?php
$options = array( 'thumbnails_heading', 'thumbnails_default', 'no_results' );
extract( $this->parse_args( $args, $options ) );
if ( false !== ($dimensions = $this->thumbnail_size()) ) {
        $width = (int) $dimensions['width'];
        $height = (int) $dimensions['height'];
        $size = 'yarpp-thumbnail';
} else {
        $size = '150x150'; // the ultimate default
        $width = 150;
        $height = 150;
        $dimensions = array(
                'width' => $width,
                'height' => $height,
                'crop' => false );
        // @todo true for crop?
}

// a little easter egg: if the default image URL is left blank,
// default to the theme's header image. (hopefully it has one)
if ( empty($thumbnails_default) )
        $thumbnails_default = get_header_image();

$output .= '<h3>' . $thumbnails_heading . '</h3>' . "\n";

if (have_posts()) {
        $output .= '<div class="yarpp-thumbnails-horizontal">' . "\n";
        while (have_posts()) {
                the_post();

                $output .= "<a class='yarpp-thumbnail' href='" . get_permalink() . "' title='" . the_title_attribute('echo=0') . "'>" . "\n";

                if ( has_post_thumbnail() ) {
                        if ( $this->diagnostic_generate_thumbnails() )
                                $this->ensure_resized_post_thumbnail( get_the_ID(), $size, $dimensions );
                        $output .= get_the_post_thumbnail( null, $size );
                } else {
                        $output .= '<span class="yarpp-thumbnail-default"><img src="' . esc_url($thumbnails_default) . '"/></span>';
                        // assume default images (header images) are wider than they are tall
                }

                $output .= '<span class="yarpp-thumbnail-title">' . get_the_title() . '</span>';
                $output .= '</a>' . "\n";

        }
        $output .= "</div>\n";
} else {
        $output .= $no_results;
}

wp_enqueue_style( "style-thumbnails" );

?>
