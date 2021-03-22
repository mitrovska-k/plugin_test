<?php
/*
Plugin Name: Listings
Description: Declares a plugin that will create a custom post type displaying listings.
Version: 1.0
Author: Keti Mitrovska
*/

add_action( 'init', 'create_listing' );

function create_listing() {
    register_post_type( 'listings',
        array(
            'labels' => array(
                'name' => 'Listings',
                'singular_name' => 'Listing',
                'add_new' => 'Add New',
                'add_new_item' => 'Add New Listing',
                'edit' => 'Edit',
                'edit_item' => 'Edit Listing',
                'new_item' => 'New Listingw',
                'view' => 'View',
                'view_item' => 'View Listing',
                'search_items' => 'Search Listings',
                'not_found' => 'No Listings found',
                'not_found_in_trash' => 'No Listings found in Trash',
                'parent' => 'Parent Listing'
            ),
 
            'public' => true,
            'menu_position' => 15,
            'supports' => array( 'title', 'editor', 'comments', 'thumbnail','page-attributes'),
            'taxonomies' => array( '' ),
            'has_archive' => true
        )
    );
}

add_action( 'init', 'pages_tax' );
function pages_tax() {
    register_taxonomy(
        'Locations',
        'listings',
        array(
            'label' => __( 'Locations' ),
            'rewrite' => array( 'slug' => 'locations' ),
            'hierarchical' => true,
        )
    );
    register_taxonomy(
        'Prices-Prices',
        'listings',
        array(
            'label' => __( 'Prices-Prices' ),
            'rewrite' => array( 'slug' => 'prices-prices' ),
            'hierarchical' => true,
        )
    );
}


add_action( 'admin_init', 'my_admin' );

function my_admin() {
    add_meta_box( 'listing_meta_box',
        'Listing Details',
        'display_listing_meta_box',
        'listings', 'normal', 'high'
    );
}

add_action( 'save_post', 'add_listing_fields', 10, 2 );

function add_listing_fields( $listing_id, $listing ) {
    // Check post type for movie reviews
    if ( $listing->post_type == 'listings' ) {
        // Store data in post meta table if present in post data
        if ( isset( $_POST['listing_realtor_name'] ) && $_POST['listing_realtor_name'] != '' ) {
            update_post_meta( $listing_id, 'realtor', $_POST['listing_realtor_name'] );
        }
        if ( isset( $_POST['listing_rating'] ) && $_POST['listing_rating'] != '' ) {
            update_post_meta( $listing_id, 'list_rating', $_POST['listing_rating'] );
        }
    }
}

add_filter( 'template_include', 'include_template_function', 1 );
function include_template_function( $template_path ) {
    if ( get_post_type() == 'listings' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-listings.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . './themes/maxomedia-starter-child/single-listings.php';
            }
        }
    }
    return $template_path;
}
?>

<?php
function display_listing_meta_box( $listing ) {
    // Retrieve current name of the Director and Movie Rating based on review ID
    $realtor = esc_html( get_post_meta( $listing->ID, 'listing_realtor_name', true ) );
    $listing_rating = intval( get_post_meta( $listing->ID, 'listing_rating', true ) );
    ?>
    <table>
        <tr>
            <td style="width: 100%">Listing Realtor</td>
            <td><input type="text" size="80" name="listing_realtor_name" value="<?php echo $realtor; ?>" /></td>
        </tr>
        <tr>
            <td style="width: 150px">Listing Rating</td>
            <td>
                <select style="width: 100px" name="listing_rating">
                <?php
                // Generate all items of drop-down list
                for ( $rating = 5; $rating >= 1; $rating -- ) {
                ?>
                    <option value="<?php echo $rating; ?>" <?php echo selected( $rating, $listing_rating ); ?>>
                    <?php echo $rating; ?> stars <?php } ?>
                </select>
            </td>
        </tr>
    </table>
    <?php
}
?>