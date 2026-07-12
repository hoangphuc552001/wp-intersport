<?php
require_once __DIR__ . '/wp-load.php';

if ( ! class_exists( 'WooCommerce' ) ) {
    die( "WooCommerce is not active.\n" );
}

echo "Starting variation price update...\n";

// Get all product variations
$args = array(
    'post_type'      => 'product_variation',
    'posts_per_page' => -1,
);

$variations = get_posts( $args );
$count = 0;

foreach ( $variations as $post ) {
    $variation_id = $post->ID;
    $variation = wc_get_product( $variation_id );
    
    if ( ! $variation ) continue;
    
    $size = $variation->get_attribute('pa_size');
    
    // Base price
    $new_price = 20.00;
    
    // Increase price for larger sizes
    if ( strtolower($size) === 'medium' ) {
        $new_price += 5.00;
    } elseif ( strtolower($size) === 'large' ) {
        $new_price += 10.00;
    }
    
    // Add some random variation between $0.00 and $4.99 so colors might vary slightly
    $new_price += mt_rand(0, 4) + (mt_rand(0, 99) / 100);
    
    $variation->set_regular_price( $new_price );
    $variation->set_price( $new_price );
    $variation->save();
    $count++;
}

// Sync the variable products so they show the correct "From $X to $Y" price range
$args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'tax_query'      => array(
        array(
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => 'variable',
        ),
    ),
);
$variable_products = get_posts($args);
foreach ($variable_products as $post) {
    WC_Product_Variable::sync( $post->ID );
}

echo "Successfully updated prices for $count variations. Products have been synced.\n";
