<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php $title = wp_title("", false);?>
	<title><?php echo ($title == '') ? get_bloginfo('name') : $title .' - '. get_bloginfo('name'); ?></title>
	<meta name="author" content="" />
  <meta name="description" content="<?php if ( is_single() ) {
          single_post_title('', true);
      } else {
          bloginfo('name'); echo " - "; bloginfo('description');
      }
      ?>" />
  <meta name="keywords"  content="" />
  <meta name="theme-color" content="#000">



  <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon.png">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-72x72.png">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-114x114.png">
  <link rel="apple-touch-icon" sizes="228x228" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-228x228.png">

  <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>

</head>

<body <?php echo body_class();?>>

  <header>


  </header>
