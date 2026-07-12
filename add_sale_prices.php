<?php
require_once __DIR__ . '/wp-load.php';

if ( ! class_exists( 'WooCommerce' ) ) {
    die( "WooCommerce is not active.\n" );
}

echo "Adding sale prices to product variations...\n";

// Get all variable products
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

$products = get_posts( $args );
$sale_count = 0;
$product_sale_count = 0;

foreach ( $products as $post ) {
    $product_id = $post->ID;
    $product = wc_get_product( $product_id );
    if ( ! $product ) continue;

    // Put roughly 40% of products on sale (random)
    if ( mt_rand(1, 100) > 40 ) continue;

    $product_sale_count++;
    $variation_ids = $product->get_children();

    foreach ( $variation_ids as $variation_id ) {
        $variation = wc_get_product( $variation_id );
        if ( ! $variation ) continue;

        $regular_price = (float) $variation->get_regular_price();
        if ( $regular_price <= 0 ) continue;

        // Random discount between 10% and 35%
        $discount = mt_rand(10, 35) / 100;
        $sale_price = round( $regular_price * (1 - $discount), 2 );

        $variation->set_sale_price( $sale_price );
        $variation->set_price( $sale_price );
        $variation->save();
        $sale_count++;
    }

    // Sync the parent variable product so it picks up the sale badge
    WC_Product_Variable::sync( $product_id );

    echo "Set sale prices for Product ID {$product_id} ('{$product->get_name()}').\n";
}

echo "\nDone! Added sale prices to $sale_count variations across $product_sale_count products.\n";
