<?php
require_once __DIR__ . '/wp-load.php';

if ( ! class_exists( 'WooCommerce' ) ) {
    die( "WooCommerce is not active.\n" );
}

// Increase time limit for processing many images
set_time_limit(300);

echo "Starting variation image assignment...\n";

// Color tint definitions (RGB values for the overlay)
$color_tints = array(
    'red'   => array( 'r' => 220, 'g' => 40,  'b' => 40  ),
    'blue'  => array( 'r' => 30,  'g' => 80,  'b' => 200 ),
    'black' => array( 'r' => 30,  'g' => 30,  'b' => 30  ),
);

/**
 * Apply a color tint to an image using GD.
 * Returns the path to the new tinted image file, or false on failure.
 */
function apply_color_tint( $source_path, $color_name, $rgb, $product_id ) {
    $upload_dir = wp_upload_dir();
    $ext = strtolower( pathinfo( $source_path, PATHINFO_EXTENSION ) );

    // Load source image
    switch ( $ext ) {
        case 'jpg':
        case 'jpeg':
            $src = @imagecreatefromjpeg( $source_path );
            break;
        case 'png':
            $src = @imagecreatefrompng( $source_path );
            break;
        case 'webp':
            if ( function_exists('imagecreatefromwebp') ) {
                $src = @imagecreatefromwebp( $source_path );
            } else {
                return false;
            }
            break;
        default:
            return false;
    }

    if ( ! $src ) return false;

    $width  = imagesx( $src );
    $height = imagesy( $src );

    // Create a copy to work on
    $tinted = imagecreatetruecolor( $width, $height );
    imagealphablending( $tinted, false );
    imagesavealpha( $tinted, true );
    imagecopy( $tinted, $src, 0, 0, 0, 0, $width, $height );
    imagealphablending( $tinted, true );

    // Create a semi-transparent overlay
    $overlay = imagecreatetruecolor( $width, $height );
    $tint_color = imagecolorallocatealpha( $overlay, $rgb['r'], $rgb['g'], $rgb['b'], 80 ); // 80 = ~37% opacity
    imagefill( $overlay, 0, 0, $tint_color );

    // Merge overlay onto the image
    imagecopy( $tinted, $overlay, 0, 0, 0, 0, $width, $height );

    // Save tinted image
    $filename = "product-{$product_id}-{$color_name}.jpg";
    $dest_path = $upload_dir['path'] . '/' . $filename;

    imagejpeg( $tinted, $dest_path, 90 );

    imagedestroy( $src );
    imagedestroy( $tinted );
    imagedestroy( $overlay );

    return $dest_path;
}

/**
 * Upload a file to the WP Media Library and return the attachment ID.
 */
function upload_to_media_library( $file_path, $title ) {
    $upload_dir = wp_upload_dir();
    $filename = basename( $file_path );

    $attachment = array(
        'guid'           => $upload_dir['url'] . '/' . $filename,
        'post_mime_type' => 'image/jpeg',
        'post_title'     => $title,
        'post_content'   => '',
        'post_status'    => 'inherit',
    );

    $attach_id = wp_insert_attachment( $attachment, $file_path );

    if ( is_wp_error( $attach_id ) ) return false;

    require_once ABSPATH . 'wp-admin/includes/image.php';
    $attach_data = wp_generate_attachment_metadata( $attach_id, $file_path );
    wp_update_attachment_metadata( $attach_id, $attach_data );

    return $attach_id;
}

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
$product_count = 0;

foreach ( $products as $post ) {
    $product_id = $post->ID;
    $product = wc_get_product( $product_id );
    if ( ! $product ) continue;

    // Get the main product image
    $thumbnail_id = $product->get_image_id();
    if ( ! $thumbnail_id ) {
        echo "Product ID {$product_id} ('{$product->get_name()}') has no image, skipping.\n";
        continue;
    }

    $source_path = get_attached_file( $thumbnail_id );
    if ( ! $source_path || ! file_exists( $source_path ) ) {
        echo "Product ID {$product_id}: image file not found, skipping.\n";
        continue;
    }

    echo "Processing Product ID {$product_id} ('{$product->get_name()}')...\n";

    // Generate tinted images for each color and cache their attachment IDs
    $color_attachment_ids = array();
    foreach ( $color_tints as $color_slug => $rgb ) {
        $tinted_path = apply_color_tint( $source_path, $color_slug, $rgb, $product_id );
        if ( ! $tinted_path ) {
            echo "  Could not tint image for color: $color_slug\n";
            continue;
        }

        $title = $product->get_name() . ' - ' . ucfirst( $color_slug );
        $attach_id = upload_to_media_library( $tinted_path, $title );
        if ( $attach_id ) {
            $color_attachment_ids[ $color_slug ] = $attach_id;
            echo "  Created tinted image for $color_slug (Attachment ID: $attach_id)\n";
        }
    }

    // Now assign each tinted image to the matching variations
    $variation_ids = $product->get_children();
    foreach ( $variation_ids as $variation_id ) {
        $variation = wc_get_product( $variation_id );
        if ( ! $variation ) continue;

        $var_color = $variation->get_attribute( 'pa_color' );
        $var_color_slug = strtolower( $var_color );

        if ( isset( $color_attachment_ids[ $var_color_slug ] ) ) {
            $variation->set_image_id( $color_attachment_ids[ $var_color_slug ] );
            $variation->save();
        }
    }

    $product_count++;
    echo "  Done — assigned variation images for Product ID {$product_id}.\n";
}

echo "\nCompleted! Processed $product_count products.\n";
