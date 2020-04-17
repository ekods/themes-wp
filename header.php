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

		<?php
			$themes_keyword = myprefix_get_theme_option( 'themes_keyword' );
			if (!empty( $themes_keyword )) {
				echo '<meta name="keywords"  content="'. $themes_keyword .'" />';
			}
		?>


    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
  	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  	<?php endif; ?>


		<?php
	  	$themes_css = myprefix_get_theme_option( 'themes_css' );
	  	if (!empty( $themes_css )) {
				echo "<style>";
	  			echo $themes_css;
				echo "</style>";
	  	}
	  ?>


				<!--
				==================================================================================
				==================================================================================

							        =================  ====== // =====         ================
							       ===============    ====== //  ======	      ================
							      ===				         ======	      ======     ======
							     === 			          ======		    ======	  ======
							    ===				         ======		      ======	 ======
						     ===============	  ======		       =====  =================
					      ===============	   ======          ======  =================
						   ===			          ======	        ======	           ======
					    ===				         ======	        ======			        ======
					   ===				        ======	      ======			         ======
					  ===============    ====== // =========     =================
					 =============== 	  ====== // ========	    =================   Copyright 2020

				==================================================================================
				==================================================================================
				-->


  	<?php wp_head(); ?>

  </head>

<body <?php echo body_class();?>>

  <header>


  </header>
