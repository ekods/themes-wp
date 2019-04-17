<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">

		<link href="//www.google-analytics.com" rel="dns-prefetch">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php $title = wp_title("", false);?>
  	<title><?php echo ($title == '') ? get_bloginfo('name') : $title .' - '. get_bloginfo('name'); ?></title>

		<!-- meta tag seo html-->
    <meta name="description" content="<?php if ( is_single() ) {
            single_post_title('', true);
        } else {
            bloginfo('name'); echo " - "; bloginfo('description');
        }
        ?>" />
    <meta name="keywords"  content="" />
    <meta name="theme-color" content="#000">

		<!-- favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon.png">
		<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-16x16.png" sizes="16x16">
		<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-32x32.png" sizes="32x32">
		<link rel="apple-touch-icon" sizes="72x72" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-72x72.png">
		<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-96x96.png" sizes="96x96">
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-114x114.png">
    <link rel="apple-touch-icon" sizes="228x228" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon-228x228.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo get_template_directory_uri(); ?>/images/favicon/favicon.png">

		<link rel="icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon/android-chrome-192x192.png" sizes="192x192">
		<meta name="msapplication-square70x70logo" content="<?php echo get_template_directory_uri(); ?>/images/favicon/smalltile.png" />
		<meta name="msapplication-square150x150logo" content="<?php echo get_template_directory_uri(); ?>/images/favicon/mediumtile.png" />
		<meta name="msapplication-wide310x150logo" content="<?php echo get_template_directory_uri(); ?>/images/favicon/widetile.png" />
		<meta name="msapplication-square310x310logo" content="<?php echo get_template_directory_uri(); ?>/images/favicon/largetile.png" />

		<!-- google fontsl-->
    <link href="https://fonts.googleapis.com/css?family=Barlow:400,400i,500,500i,600,600i,700,700i,800,800i" rel="stylesheet">

    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  	<?php endif; ?>
  	<?php wp_head(); ?>

  </head>

<body <?php echo body_class();?>>

  <header>


  </header>
