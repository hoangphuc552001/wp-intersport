<?php
// Bootstrap WordPress
require_once __DIR__ . '/wp-load.php';

if ( ! class_exists( 'WooCommerce' ) ) {
    die( "WooCommerce is not active.\n" );
}

echo "Starting WooCommerce variation generator...\n";

/**
 * Creates a global attribute if it doesn't exist.
 */
function wc_create_or_get_attribute( $name, $slug ) {
    global $wpdb;

    $attribute_id = $wpdb->get_var( $wpdb->prepare( "SELECT attribute_id FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_name = %s", $slug ) );

    if ( ! $attribute_id ) {
        $attribute_id = wc_create_attribute( array(
            'name'         => $name,
            'slug'         => $slug,
            'type'         => 'select',
            'order_by'     => 'menu_order',
            'has_archives' => false,
        ) );
        if ( is_wp_error( $attribute_id ) ) {
            die( "Error creating attribute $name: " . $attribute_id->get_error_message() . "\n" );
        }
        echo "Created global attribute: $name\n";
    } else {
        echo "Global attribute $name already exists.\n";
    }

    $taxonomy = 'pa_' . $slug;

    if ( ! taxonomy_exists( $taxonomy ) ) {
        register_taxonomy( $taxonomy, array('product'), array(
            'hierarchical' => true,
            'show_ui'      => false,
            'query_var'    => true,
            'rewrite'      => false,
        ) );
    }

    return $taxonomy;
}

$color_tax = wc_create_or_get_attribute( 'Color', 'color' );
$size_tax = wc_create_or_get_attribute( 'Size', 'size' );

// Define our terms
$colors = ['Red', 'Blue', 'Black'];
$sizes = ['Small', 'Medium', 'Large'];

/**
 * Ensures terms exist and returns their slugs.
 */
function wc_ensure_terms( $taxonomy, $terms ) {
    $term_slugs = [];
    foreach ( $terms as $term_name ) {
        if ( ! term_exists( $term_name, $taxonomy ) ) {
            $term_info = wp_insert_term( $term_name, $taxonomy );
            if ( ! is_wp_error( $term_info ) ) {
                $term = get_term( $term_info['term_id'], $taxonomy );
                $term_slugs[] = $term->slug;
                echo "Added term $term_name to $taxonomy.\n";
            } else {
                echo "Error adding term $term_name: " . $term_info->get_error_message() . "\n";
            }
        } else {
            $term = get_term_by( 'name', $term_name, $taxonomy );
            $term_slugs[] = $term->slug;
        }
    }
    return $term_slugs;
}

$color_slugs = wc_ensure_terms( $color_tax, $colors );
$size_slugs = wc_ensure_terms( $size_tax, $sizes );

// Find all simple products and convert them
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => 'simple',
        ),
    ),
);

$simple_products = get_posts( $args );

if ( empty( $simple_products ) ) {
    echo "No simple products found. All products might already be variable or not created yet.\n";
    die();
}

foreach ( $simple_products as $post ) {
    $product_id = $post->ID;
    $product = wc_get_product( $product_id );

    if ( ! $product ) continue;

    echo "Converting Product ID {$product_id} ('{$product->get_name()}') to variable product...\n";

    // Convert to variable product
    wp_set_object_terms( $product_id, 'variable', 'product_type' );
    
    // Clear the class cache so WC knows it's a variable product now
    clean_post_cache( $product_id );
    $variable_product = new WC_Product_Variable( $product_id );

    // Build attributes array
    $attributes = array();

    // Setup Color Attribute
    $attr_color = new WC_Product_Attribute();
    $attr_color->set_id( wc_attribute_taxonomy_id_by_name( 'color' ) );
    $attr_color->set_name( $color_tax );
    $attr_color->set_options( $color_slugs );
    $attr_color->set_position( 0 );
    $attr_color->set_visible( true );
    $attr_color->set_variation( true );
    $attributes[$color_tax] = $attr_color;

    // Setup Size Attribute
    $attr_size = new WC_Product_Attribute();
    $attr_size->set_id( wc_attribute_taxonomy_id_by_name( 'size' ) );
    $attr_size->set_name( $size_tax );
    $attr_size->set_options( $size_slugs );
    $attr_size->set_position( 1 );
    $attr_size->set_visible( true );
    $attr_size->set_variation( true );
    $attributes[$size_tax] = $attr_size;

    $variable_product->set_attributes( $attributes );
    $variable_product->save();

    // Also link the taxonomy terms to the post so they appear in filters
    wp_set_object_terms( $product_id, $color_slugs, $color_tax );
    wp_set_object_terms( $product_id, $size_slugs, $size_tax );

    // Get the original regular price to use for variations
    $base_price = $product->get_regular_price();
    if ( empty( $base_price ) ) $base_price = '19.99';

    // Generate variation posts
    foreach ( $color_slugs as $color_slug ) {
        foreach ( $size_slugs as $size_slug ) {
            $variation = new WC_Product_Variation();
            $variation->set_parent_id( $product_id );
            
            // Set the attributes for this specific variation
            $variation->set_attributes( array(
                $color_tax => $color_slug,
                $size_tax  => $size_slug
            ) );
            
            $variation->set_regular_price( $base_price );
            $variation->set_price( $base_price );
            $variation->set_manage_stock( false );
            $variation->save();
        }
    }

    // Trigger price sync
    WC_Product_Variable::sync( $product_id );

    echo "Successfully generated variations for Product ID {$product_id}.\n";
}

echo "Completed processing all products.\n";
