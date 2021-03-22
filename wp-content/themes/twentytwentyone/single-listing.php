<?php
/*
Template Post Name: Full-width page layout
Template Post Type: listing
*/
 
get_header(); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

<header class="entry-header alignwide">
    <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
</header>

<div class="entry-content">
    <?php
    the_content();

    ?>
</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
<?php wp_reset_query(); ?>
<?php get_footer(); ?>