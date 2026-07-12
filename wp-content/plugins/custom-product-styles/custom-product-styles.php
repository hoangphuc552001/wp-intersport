<?php
/**
 * Plugin Name: Custom Product Description Styles
 * Description: Adds clean professional CSS for WooCommerce product descriptions.
 * Version: 1.0
 * Author: Developer
 */

function custom_product_description_styles() {
    wp_enqueue_style('product-desc-styles', plugin_dir_url(__FILE__) . 'product-description.css', [], '1.3');
}
add_action('wp_enqueue_scripts', 'custom_product_description_styles');
