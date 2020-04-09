<?php if ( have_posts() ) : ?>
    <?php get_template_part( 'template-parts/blog/content' ); ?>
<?php else : ?>
    <?php get_template_part( 'template-parts/blog/content-home', 'none' ); // If no content, include the "No posts found" template ?>
<?php endif; ?>
