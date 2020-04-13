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
	wp_enqueue_script( 'js-global', get_template_directory_uri() . '/js/global.js', array('jquery'), THEME_VERSION, TRUE );
	wp_enqueue_script( 'js-global', get_template_directory_uri() . '/js/aos.js', array('jquery'), THEME_VERSION, TRUE );

	wp_enqueue_style( 'css-aos', get_template_directory_uri() . '/css/aos.css', array(), THEME_VERSION );
	wp_enqueue_style( 'css-util', get_template_directory_uri() . '/css/util.min.css', array(), THEME_VERSION );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css', array(), THEME_VERSION );
	wp_enqueue_style( 'css-global', get_template_directory_uri() . '/css/global.css', array(), THEME_VERSION );
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






// Pagination

 /*

 USING
 <?php pagination_numeric_posts_nav(); ?>

 */

function pagination_numeric_posts_nav() {

  if( is_singular() )
      return;

  global $wp_query;

  /** Stop execution if there's only 1 page */
  if( $wp_query->max_num_pages <= 1 )
      return;

  $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
  $max   = intval( $wp_query->max_num_pages );

  /** Add current page to the array */
  if ( $paged >= 1 )
      $links[] = $paged;

  /** Add the pages around the current page to the array */
  if ( $paged >= 3 ) {
      $links[] = $paged - 1;
      $links[] = $paged - 2;
  }

  if ( ( $paged + 2 ) <= $max ) {
      $links[] = $paged + 2;
      $links[] = $paged + 1;
  }

  echo '<div class="navigation"><ul>' . "\n";



  /** Link to first page, plus ellipses if necessary */
  if ( ! in_array( 1, $links ) ) {
      $class = 1 == $paged ? ' class="active"' : '';

      printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

      if ( ! in_array( 2, $links ) )
          echo '<li>…</li>';
  }

  /** Link to current page, plus 2 pages in either direction if necessary */
  sort( $links );
  foreach ( (array) $links as $link ) {
      $class = $paged == $link ? ' class="active"' : '';
      printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
  }

  /** Link to last page, plus ellipses if necessary */
  if ( ! in_array( $max, $links ) ) {
      if ( ! in_array( $max - 1, $links ) )
          echo '<li>…</li>' . "\n";

      $class = $paged == $max ? ' class="active"' : '';
      printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
  }


  echo '</ul></div>' . "\n";

}





// Breadcrumbs

/*

USING
<?php custom_breadcrumbs(); ?>

*/


function custom_breadcrumbs() {

    // Settings
    $separator          = '&#47;';
    $breadcrums_id      = 'breadcrumbs';
    $breadcrums_class   = 'breadcrumbs';
    $home_title         = 'Beranda';

    // If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
    $custom_taxonomy    = 'product_cat';

    // Get the query & post information
    global $post,$wp_query;

    // Do not display on the homepage
    if ( !is_front_page() ) {

        // Build the breadcrums
        echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';

        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            $custom_tax_name = get_queried_object()->name;
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

        } else if ( is_single() ) {

            // If post is a custom post type
            $post_type = get_post_type();

            // If it is a custom post type display name and link
            if($post_type != 'post') {

                $post_type_object = get_post_type_object($post_type);
                $post_type_archive = get_post_type_archive_link($post_type);

                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';

            }

            // Get post category info
            $category = get_the_category();

            if(!empty($category)) {

                // Get last category post is in
                $last_category = end(array_values($category));

                // Get parent any categories and create array
                $get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
                $cat_parents = explode(',',$get_cat_parents);

                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach($cat_parents as $parents) {
                    $cat_display .= '<li class="item-cat">'.$parents.'</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                }

            }

            // If it's a custom post type within a custom taxonomy
            $taxonomy_exists = taxonomy_exists($custom_taxonomy);
            if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                $cat_id         = $taxonomy_terms[0]->term_id;
                $cat_nicename   = $taxonomy_terms[0]->slug;
                $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                $cat_name       = $taxonomy_terms[0]->name;

            }

            // Check if the post is in a category
            if(!empty($last_category)) {
                echo $cat_display;
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            // Else if post is in a custom taxonomy
            } else if(!empty($cat_id)) {

                echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            } else {

                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

            }

        } else if ( is_category() ) {

            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

        } else if ( is_page() ) {

            // Standard page
            if( $post->post_parent ){

                // If child page, get parents
                $anc = get_post_ancestors( $post->ID );

                // Get parents in the right order
                $anc = array_reverse($anc);

                // Parent page loop
                if ( !isset( $parents ) ) $parents = null;
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }

                // Display parent pages
                echo $parents;

                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

            } else {

                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';

            }

        } else if ( is_tag() ) {

            // Tag page

            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;

            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

        } elseif ( is_day() ) {

            // Day archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_month() ) {

            // Month Archive

            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

        } else if ( is_year() ) {

            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

        } else if ( is_author() ) {

            // Auhor archive

            // Get the author information
            global $author;
            $userdata = get_userdata( $author );

            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

        } else if ( get_query_var('paged') ) {

            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

        } else if ( is_search() ) {

            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

        } elseif ( is_404() ) {

            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }

        echo '</ul>';

    }

}




	//Disable Comment
	add_action('admin_init', function () {
	    // Redirect any user trying to access comments page
	    global $pagenow;

	    if ($pagenow === 'edit-comments.php') {
	        wp_redirect(admin_url());
	        exit;
	    }

	    // Remove comments metabox from dashboard
	    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

	    // Disable support for comments and trackbacks in post types
	    foreach (get_post_types() as $post_type) {
	        if (post_type_supports($post_type, 'comments')) {
	            remove_post_type_support($post_type, 'comments');
	            remove_post_type_support($post_type, 'trackbacks');
	        }
	    }
	});

	// Close comments on the front-end
	add_filter('comments_open', '__return_false', 20, 2);
	add_filter('pings_open', '__return_false', 20, 2);

	// Hide existing comments
	add_filter('comments_array', '__return_empty_array', 10, 2);

	// Remove comments page in menu
	add_action('admin_menu', function () {
	    remove_menu_page('edit-comments.php');
	});

	// Remove comments links from admin bar
	add_action('init', function () {
	    if (is_admin_bar_showing()) {
	        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
	    }
	});







// Admin meta
include( DIR . '/themes-options.php' );

?>
