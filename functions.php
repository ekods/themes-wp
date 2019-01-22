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


?>
