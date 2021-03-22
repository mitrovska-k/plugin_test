<?php
 /*Template Name: Listing Template
 */
 
get_header(); 
get_template_part( 'single-listing.php' );
?>
<div id="primary">
    <div id="content" role="main">
    <?php
    $mypost = array( 'post_type' => 'listings', );
    $loop = new WP_Query( $mypost );
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <header class="entry-header">
 
                <!-- Display featured image in right-aligned floating div -->
                <div style="float: right; margin: 10px">
                    <?php the_post_thumbnail( array( 100, 100 ) ); ?>
                </div>
 
                <!-- Display Title and Author Name -->
                <strong>Title: </strong><a href="<?php echo get_the_permalink($post->ID);?>"><?php the_title(); ?></a><br />
                <strong>Realtor: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), 'realtor', true ) ); ?>
                <br />
 
                <!-- Display yellow stars based on rating -->
                <strong>Rating: </strong>
                <?php
                $nb_stars = intval( get_post_meta( get_the_ID(), 'listing_rating', true ) );
                for ( $star_counter = 1; $star_counter <= 5; $star_counter++ ) {
                    if ( $star_counter <= $nb_stars ) {
                        echo '<img src="' . plugins_url( 'custom-plugin-keti/icon.png' ) . '" />';
                    } else {
                        echo '<img src="' . plugins_url( 'custom-plugin-keti/grey.png' ). '" />';
                    }
                }
                ?>
            </header>
 
            <!-- Display movie review contents -->
            <div class="entry-content"><?php the_content(); ?></div>
        </article>
 
    <?php endwhile; ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>