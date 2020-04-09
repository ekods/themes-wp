<?php

define( 'DIR', get_template_directory() . '/includes' );
define( 'THEME_VERSION', '1.1' );



function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


function no_generator() { return ''; }
add_filter( 'the_generator', 'no_generator' );



/**
 * Support Thumbnail
 */
add_theme_support( 'post-thumbnails' );

/**
 * Registers a widget area.
 */
function themes_name_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Copyright', 'themes_name' ),
		'id'            => 'copyright',
		'container' 		=> false,
		'before_widget' => '',
		'after_widget' => ''
	) );
}
add_action( 'widgets_init', 'themes_name_widgets_init' );


/**
 * Style Login
 */
function my_custom_login() {
  echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('stylesheet_directory') . '/css/custom-login-styles.css" />';
}
add_action('login_head', 'my_custom_login');


/**
 * Register Menu
 */
register_nav_menus(
  array(
    'main_menu' => __( 'Main Menu', 'themes_name' ),
    'inner_main_menu' => __( 'Inner Main Menu', 'themes_name' )
  )
);


/**
 * Custom Admin Login
 */
add_filter('admin_footer_text', 'remove_footer_admin');
function remove_footer_admin () {
  echo 'Themes Name &copy; 2019';
}

/*
 * Custom Login Logo
 */
add_action('login_head', 'themes_name_custom_login_logo');
function themes_name_custom_login_logo() {
	echo '<style type="text/css">
	.login h1 a { background-image: url('.get_bloginfo('template_directory').'/images/logo.png) !important; background-size:144px !important; height:60px !important; width:100% !important; }
	</style>';
}

add_filter( 'login_headerurl', 'themes_name_custom_login_url' );
function themes_name_custom_login_url($url) {
	return '';
}

/**
 * Custom Favicon
 */
add_action('admin_head','themes_name_favicon');
function themes_name_favicon(){
	echo '<link rel="shortcut icon" href="',get_template_directory_uri(),'/images/favicon/favicon.png" />',"\n";
}



// First, create a function that includes the path to your favicon
function add_favicon() {
  	$favicon_url = get_stylesheet_directory_uri() . '/images/favicon/favicon.png';
	echo '<link rel="shortcut icon" href="' . $favicon_url . '" />';
}

// Now, just make sure that function runs when you're on the login page and admin pages
add_action('login_head', 'add_favicon');
add_action('admin_head', 'add_favicon');



/**
 * Script
 */
function themes_name_scripts() {

	wp_enqueue_script( 'js-min', get_template_directory_uri() . '/js/jquery.min.js', array(), THEME_VERSION);
	wp_enqueue_script( 'JS-global', get_template_directory_uri() . '/js/global.js', array('jquery'), THEME_VERSION, TRUE );
	wp_enqueue_script( 'JS-global', get_template_directory_uri() . '/js/aos.js', array('jquery'), THEME_VERSION, TRUE );

	wp_enqueue_style( 'style', get_template_directory_uri() . '/aos.css', array(), THEME_VERSION );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/util.min.css', array(), THEME_VERSION );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', array(), THEME_VERSION );
	wp_enqueue_style( 'CSS-global', get_template_directory_uri() . '/css/global.css', array(), THEME_VERSION );
}

add_action( 'wp_enqueue_scripts', 'themes_name_scripts' );



/**
 * SEO
 */
function opengraph_tags() {
    // defaults
    $title = get_bloginfo('title');
    $img_src = get_stylesheet_directory_uri() . '/images/logo.png';
    $excerpt = get_bloginfo('description');
    // for non posts/pages, like /blog, just use the current URL
    $permalink = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    if(is_single() || is_page()) {
        global $post;
        setup_postdata( $post );
        $title = get_the_title();
        $permalink = get_the_permalink();
        if (has_post_thumbnail($post->ID)) {
            $img_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large')[0];
        }
        $excerpt = get_the_excerpt();
        if ($excerpt) {
            $excerpt = strip_tags($excerpt);
            $excerpt = str_replace("", "'", $excerpt);
        }
    }
    ?>

	<!-- favicon -->
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-16x16.png" sizes="16x16">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-32x32.png" sizes="32x32">
	<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-72x72.png">
	<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-96x96.png" sizes="96x96">
	<link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-114x114.png">
	<link rel="apple-touch-icon" sizes="228x228" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-228x228.png">
	<link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon.png">
	<link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon.png">

	<?php
		$themes_header_color = myprefix_get_theme_option( 'themes_header_color' );
		if (!empty( $themes_header_color )) {
			echo '<meta name="keywords" content="'. $themes_header_color .'"/>';
			echo '<meta name="msapplication-TileColor" content="'. $themes_header_color .'">';
		}
	?>



	<!-- meta tag facebook -->
	<meta name="resource-type" content="document" />
	<meta property="og:title" content="<?= $title; ?>"/>
	<meta property="og:description" content="<?= $excerpt; ?>"/>
	<?php if(!is_single()){
	if(is_home() || is_front_page()){ // not sure if you have set a static page as your front page
		echo '<meta property="og:url" content="'.get_bloginfo('url').'" />';
	}elseif(is_tag()){
		echo '<meta property="og:url" content="http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].' ">';
		}
	} ?>
	<meta property="og:site_name" content="<?= get_bloginfo(); ?>"/>
	<meta property="og:type" content="<?php if ( is_front_page() ) { echo "website"; } else { echo "article"; } ?>">
	<meta property="og:image" content="<?php
				if (is_single()) {
					$post_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(),'large');
					echo $post_thumbnail[0];
				}else{
						echo get_template_directory_uri().'/images/favicon/favicon.png';
				}?>" />
	<meta property="og:image:secure_url" content="<?php
				if (is_single()) {
					$post_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(),'large');
					echo $post_thumbnail[0];
				}else{
						echo get_template_directory_uri().'/images/favicon/favicon.png';
				}?>" />

	<meta name="language" content="Indonesia" />
	<meta name="organization" content="<?= get_bloginfo(); ?>" />
	<meta name="copyright" content="Copyright (c)2020 <?= get_bloginfo(); ?>" />
	<meta name="audience" content="<?= get_bloginfo(); ?>" />
	<meta name="classification" content="Indonesia, English, Company Profile, Company Spirit" />
	<meta name="rating" content="general" />
	<meta name="page-topic" content="" />
	<meta name="revisit-after" content="7 days" />
	<meta name="mssmarttagspreventparsing" content="true" />
	<meta name="twitter:image" content="<?php
				if (is_single()) {
					$post_thumbnail = wp_get_attachment_image_src(get_post_thumbnail_id(),'large');
					echo $post_thumbnail[0];
				}else{
						echo get_template_directory_uri().'/images/favicon/favicon.png';
				}?>" />

	<link rel="alternate" type="application/rss+xml" title="Feed" href="<?= get_bloginfo('feed'); ?>" />


    <?php
    	$themes_mix = myprefix_get_theme_option( 'themes_mix' );
    	if (!empty( $themes_mix )) {
    		echo $themes_mix;
    	}
    ?>


<?php
}
add_action('wp_head', 'opengraph_tags', 5);






function custom_pre_get_posts( $query ) {
if( $query->is_main_query() && !$query->is_feed() && !is_admin() && is_category()) {
  $query->set( 'paged', str_replace( '/', '', get_query_var( 'page' ) ) );  }  }

add_action('pre_get_posts','custom_pre_get_posts');

function custom_request($query_string ) {
   if( isset( $query_string['page'] ) ) {
       if( ''!=$query_string['page'] ) {
           if( isset( $query_string['name'] ) ) { unset( $query_string['name'] ); } } } return $query_string; }

add_filter('request', 'custom_request');


// Admin meta
include( DIR . '/themes-options.php' );

?>
