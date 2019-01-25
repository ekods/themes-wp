<?php


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

/**
 * Script
 */
function themes_name_scripts() {

	wp_enqueue_script( 'js-min', get_template_directory_uri() . '/js/jquery.min.js', array(), '2.1.4');

	wp_enqueue_script( 'global', get_template_directory_uri() . '/js/global.js', array('jquery'), '1.0.0', TRUE );

	wp_enqueue_style( 'style', get_template_directory_uri() . '/css/style.css', array(), '1.0' );

	wp_enqueue_style( 'global', get_template_directory_uri() . '/css/global.css', array(), '1.0' );

}

add_action( 'wp_enqueue_scripts', 'themes_name_scripts' );




function opengraph_tags() {
    // defaults
    $title = get_bloginfo('title');
    $img_src = get_stylesheet_directory_uri() . '/images/logo_level-tujuh.png';
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

	<meta name="resource-type" content="document" />
	<meta http-equiv="content-type" content="text/html; charset=US-ASCII" />
	<meta property="og:title" content="<?= $title; ?>"/>
	<meta property="og:description" content="<?= $excerpt; ?>"/>
	<meta property="og:url" content="<?= $permalink; ?>"/>
	<meta property="og:site_name" content="<?= get_bloginfo(); ?>"/>
	<meta property="og:type" content="<?php if ( is_front_page() ) { echo "website"; } else { echo "article"; } ?>">

	<meta name="language" content="Indonesia" />
	<meta name="organization" content="<?= get_bloginfo(); ?>" />
	<meta name="copyright" content="Copyright (c)2019 <?= get_bloginfo(); ?>" />
	<meta name="audience" content="<?= get_bloginfo(); ?>" />
	<meta name="classification" content="Indonesia, English, Company Profile, Company Spirit" />
	<meta name="rating" content="general" />
	<meta name="page-topic" content="" />
	<meta name="revisit-after" content="7 days" />
	<meta name="mssmarttagspreventparsing" content="true" />


	<?php if(!is_single()){
	if(is_home() || is_front_page()){ // not sure if you have set a static page as your front page
		echo '<meta property="og:url" content="'.get_bloginfo('url').'" />';
	}elseif(is_tag()){
		echo '<meta property="og:url" content="http://'.$_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"].' ">';
		}
	} ?>

<?php
}
add_action('wp_head', 'opengraph_tags', 5);


?>
