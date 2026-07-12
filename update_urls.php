<?php
/**
 * Temporary script to update WordPress URLs from localhost to production.
 * DELETE THIS FILE AFTER RUNNING.
 */

// Load WordPress
define('ABSPATH', __DIR__ . '/');
require_once ABSPATH . 'wp-load.php';

$old_url = '';
$new_url = 'http://148.230.122.225:8081';

// 1. Get current values
global $wpdb;

echo "<h2>Current values:</h2>";
$siteurl = get_option('siteurl');
$home = get_option('home');
echo "siteurl: " . esc_html($siteurl) . "<br>";
echo "home: " . esc_html($home) . "<br>";

// Use the current siteurl as the old URL to replace
$old_url = $siteurl;

if ($old_url === $new_url) {
    echo "<p><strong>URLs are already correct. Nothing to do.</strong></p>";
    exit;
}

echo "<h2>Updating from: " . esc_html($old_url) . " to: " . esc_html($new_url) . "</h2>";

// 2. Update wp_options
update_option('siteurl', $new_url);
update_option('home', $new_url);
echo "✅ Updated siteurl and home<br>";

// 3. Update URLs in post content
$count = $wpdb->query($wpdb->prepare(
    "UPDATE {$wpdb->posts} SET post_content = REPLACE(post_content, %s, %s) WHERE post_content LIKE %s",
    $old_url, $new_url, '%' . $wpdb->esc_like($old_url) . '%'
));
echo "✅ Updated {$count} rows in posts<br>";

// 4. Update URLs in post excerpt
$count = $wpdb->query($wpdb->prepare(
    "UPDATE {$wpdb->posts} SET post_excerpt = REPLACE(post_excerpt, %s, %s) WHERE post_excerpt LIKE %s",
    $old_url, $new_url, '%' . $wpdb->esc_like($old_url) . '%'
));
echo "✅ Updated {$count} rows in post excerpts<br>";

// 5. Update URLs in post meta
$count = $wpdb->query($wpdb->prepare(
    "UPDATE {$wpdb->postmeta} SET meta_value = REPLACE(meta_value, %s, %s) WHERE meta_value LIKE %s",
    $old_url, $new_url, '%' . $wpdb->esc_like($old_url) . '%'
));
echo "✅ Updated {$count} rows in postmeta<br>";

// 6. Update URLs in options (non-serialized only for safety)
$count = $wpdb->query($wpdb->prepare(
    "UPDATE {$wpdb->options} SET option_value = REPLACE(option_value, %s, %s) WHERE option_value LIKE %s AND option_name NOT IN ('siteurl', 'home')",
    $old_url, $new_url, '%' . $wpdb->esc_like($old_url) . '%'
));
echo "✅ Updated {$count} rows in options<br>";

// 7. Update guid in posts
$count = $wpdb->query($wpdb->prepare(
    "UPDATE {$wpdb->posts} SET guid = REPLACE(guid, %s, %s) WHERE guid LIKE %s",
    $old_url, $new_url, '%' . $wpdb->esc_like($old_url) . '%'
));
echo "✅ Updated {$count} rows in post guids<br>";

echo "<h2>✅ All done! DELETE this file now.</h2>";
