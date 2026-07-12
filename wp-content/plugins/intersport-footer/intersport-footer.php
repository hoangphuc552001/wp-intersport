<?php
/**
 * Plugin Name: Intersport Elverys Footer
 * Description: Adds a professional, feature-rich footer styled like Intersport Elverys
 * Version: 1.0
 * Author: Custom
 */

if (!defined('ABSPATH')) exit;

/**
 * Register footer widget areas
 */
function intersport_register_footer_widgets() {
    register_sidebar(array(
        'name'          => 'Intersport Footer - Newsletter',
        'id'            => 'intersport-footer-newsletter',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ));
}
add_action('widgets_init', 'intersport_register_footer_widgets');

/**
 * Enqueue footer styles
 */
function intersport_footer_styles() {
    wp_enqueue_style(
        'intersport-footer-css',
        plugin_dir_url(__FILE__) . 'footer-style.css',
        array(),
        '1.0'
    );
    // Google Fonts for premium typography
    wp_enqueue_style(
        'intersport-footer-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'intersport_footer_styles');

/**
 * Output the custom Intersport-style footer HTML
 * Hooks into flatsome_before_footer to appear above the existing absolute footer
 */
function intersport_custom_footer_output() {
    ?>
    <!-- INTERSPORT ELVERYS CUSTOM FOOTER -->
    <div class="intersport-footer">

        <!-- USP Banner Bar -->
        <div class="intersport-footer__usp-bar">
            <div class="container">
                <div class="intersport-footer__usp-items">
                    <div class="intersport-footer__usp-item">
                        <svg class="intersport-footer__usp-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                        <div class="intersport-footer__usp-text">
                            <strong>Free Delivery</strong>
                            <span>On orders over €50</span>
                        </div>
                    </div>
                    <div class="intersport-footer__usp-item">
                        <svg class="intersport-footer__usp-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        <div class="intersport-footer__usp-text">
                            <strong>Click & Collect</strong>
                            <span>Collect in-store for free</span>
                        </div>
                    </div>
                    <div class="intersport-footer__usp-item">
                        <svg class="intersport-footer__usp-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="20 12 20 22 4 22 4 12"/>
                            <rect x="2" y="7" width="20" height="5"/>
                            <line x1="12" y1="22" x2="12" y2="7"/>
                            <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"/>
                            <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"/>
                        </svg>
                        <div class="intersport-footer__usp-text">
                            <strong>Easy Returns</strong>
                            <span>30-day returns policy</span>
                        </div>
                    </div>
                    <div class="intersport-footer__usp-item">
                        <svg class="intersport-footer__usp-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2"/>
                            <line x1="1" y1="10" x2="23" y2="10"/>
                        </svg>
                        <div class="intersport-footer__usp-text">
                            <strong>Secure Payment</strong>
                            <span>100% secure checkout</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Signup Section -->
        <div class="intersport-footer__newsletter">
            <div class="container">
                <div class="intersport-footer__newsletter-inner">
                    <div class="intersport-footer__newsletter-text">
                        <h3>Stay in the Game</h3>
                        <p>Sign up for exclusive offers, new arrivals, and insider-only discounts.</p>
                    </div>
                    <form class="intersport-footer__newsletter-form" onsubmit="event.preventDefault(); this.querySelector('.intersport-footer__newsletter-success').style.display='flex'; this.querySelector('input').value='';">
                        <div class="intersport-footer__newsletter-input-wrap">
                            <input type="email" placeholder="Enter your email address" required aria-label="Email address for newsletter">
                            <button type="submit">Subscribe</button>
                        </div>
                        <div class="intersport-footer__newsletter-success" style="display:none;">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="18" height="18"><polyline points="20 6 9 17 4 12"/></svg>
                            Thanks for subscribing!
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Footer Links Grid -->
        <div class="intersport-footer__main">
            <div class="container">
                <div class="intersport-footer__grid">

                    <!-- Column 1: Customer Service -->
                    <div class="intersport-footer__col">
                        <h4 class="intersport-footer__heading">Customer Service</h4>
                        <ul class="intersport-footer__links">
                            <li><a href="<?php echo home_url('/contact'); ?>">Contact Us</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Delivery Information</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Returns & Exchanges</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Size Guide</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">FAQs</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Track Your Order</a></li>
                        </ul>
                    </div>

                    <!-- Column 2: About Us -->
                    <div class="intersport-footer__col">
                        <h4 class="intersport-footer__heading">About Us</h4>
                        <ul class="intersport-footer__links">
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Our Story</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Store Locator</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Careers</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Sustainability</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Blog & News</a></li>
                        </ul>
                    </div>

                    <!-- Column 3: Quick Links / Shopping -->
                    <div class="intersport-footer__col">
                        <h4 class="intersport-footer__heading">Shop</h4>
                        <ul class="intersport-footer__links">
                            <?php
                            $product_cats = get_terms(array(
                                'taxonomy'   => 'product_cat',
                                'hide_empty' => true,
                                'number'     => 6,
                                'orderby'    => 'count',
                                'order'      => 'DESC',
                            ));
                            if (!is_wp_error($product_cats) && !empty($product_cats)) {
                                foreach ($product_cats as $cat) {
                                    if ($cat->slug === 'uncategorized') continue;
                                    echo '<li><a href="javascript:void(0);" onclick="event.preventDefault();">' . esc_html($cat->name) . '</a></li>';
                                }
                            }
                            ?>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">View All Products</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Sale Items</a></li>
                        </ul>
                    </div>

                    <!-- Column 4: My Account -->
                    <div class="intersport-footer__col">
                        <h4 class="intersport-footer__heading">My Account</h4>
                        <ul class="intersport-footer__links">
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Sign In / Register</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Order History</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Wishlist</a></li>
                            <li><a href="javascript:void(0);" onclick="event.preventDefault();">Shopping Cart</a></li>
                        </ul>

                        <h4 class="intersport-footer__heading intersport-footer__heading--mt">Get in Touch</h4>
                        <div class="intersport-footer__contact">
                            <div class="intersport-footer__contact-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                    <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/>
                                </svg>
                                <a href="javascript:void(0);" onclick="event.preventDefault();">(051) 877 4111</a>
                            </div>
                            <div class="intersport-footer__contact-item">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="16" height="16">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                                <a href="javascript:void(0);" onclick="event.preventDefault();">info@intersportelverys.ie</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Social Media & Payment Row -->
        <div class="intersport-footer__social-payment">
            <div class="container">
                <div class="intersport-footer__social-payment-inner">
                    <!-- Social Media Icons -->
                    <div class="intersport-footer__social">
                        <span class="intersport-footer__social-label">Follow Us</span>
                        <div class="intersport-footer__social-icons">
                            <a href="javascript:void(0);" onclick="event.preventDefault();" aria-label="Facebook" class="intersport-footer__social-link">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                            </a>
                            <a href="javascript:void(0);" onclick="event.preventDefault();" aria-label="Instagram" class="intersport-footer__social-link">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" width="20" height="20"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                            </a>
                            <a href="javascript:void(0);" onclick="event.preventDefault();" aria-label="X / Twitter" class="intersport-footer__social-link">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="javascript:void(0);" onclick="event.preventDefault();" aria-label="TikTok" class="intersport-footer__social-link">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-2.88 2.5 2.89 2.89 0 01-2.89-2.89 2.89 2.89 0 012.89-2.89c.28 0 .55.04.81.1v-3.5a6.37 6.37 0 00-.81-.05A6.34 6.34 0 003.15 15.2a6.34 6.34 0 006.34 6.34 6.34 6.34 0 006.34-6.34V8.73a8.19 8.19 0 004.76 1.52V6.8a4.84 4.84 0 01-1-.11z"/></svg>
                            </a>
                            <a href="javascript:void(0);" onclick="event.preventDefault();" aria-label="YouTube" class="intersport-footer__social-link">
                                <svg viewBox="0 0 24 24" fill="currentColor" width="20" height="20"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Payment Icons -->
                    <div class="intersport-footer__payments">
                        <span class="intersport-footer__payments-label">We Accept</span>
                        <div class="intersport-footer__payment-icons">
    <div class="intersport-footer__payment-icon" title="Visa">
        <svg viewBox="0 0 48 32" width="42" height="28">
            <rect width="48" height="32" rx="4" fill="#1A1F71"/>
            <text x="24" y="20" text-anchor="middle" fill="#FFFFFF" font-family="Arial,sans-serif" font-size="12" font-weight="700" font-style="italic">VISA</text>
        </svg>
    </div>
    <div class="intersport-footer__payment-icon" title="Mastercard">
        <svg viewBox="0 0 48 32" width="42" height="28">
            <rect width="48" height="32" rx="4" fill="#252525"/>
            <circle cx="19" cy="16" r="9" fill="#EB001B"/>
            <circle cx="29" cy="16" r="9" fill="#F79E1B"/>
            <path d="M24 9.3a9 9 0 013 6.7 9 9 0 01-3 6.7 9 9 0 01-3-6.7 9 9 0 013-6.7z" fill="#FF5F00"/>
        </svg>
    </div>
    <div class="intersport-footer__payment-icon" title="American Express">
        <svg viewBox="0 0 48 32" width="42" height="28">
            <rect width="48" height="32" rx="4" fill="#006FCF"/>
            <text x="24" y="19" text-anchor="middle" fill="white" font-family="Arial,sans-serif" font-size="7.5" font-weight="700">AMEX</text>
        </svg>
    </div>
    <div class="intersport-footer__payment-icon" title="PayPal">
        <svg viewBox="0 0 48 32" width="42" height="28">
            <rect width="48" height="32" rx="4" fill="#FFF"/>
            <rect x="0.5" y="0.5" width="47" height="31" rx="3.5" fill="none" stroke="#E5E7EB"/>
            <text x="16" y="19" text-anchor="middle" fill="#003087" font-family="Arial,sans-serif" font-size="8" font-weight="700">Pay</text>
            <text x="30" y="19" text-anchor="middle" fill="#009CDE" font-family="Arial,sans-serif" font-size="8" font-weight="700">Pal</text>
        </svg>
    </div>
    <div class="intersport-footer__payment-icon" title="Apple Pay">
        <svg viewBox="0 0 48 32" width="42" height="28">
            <rect width="48" height="32" rx="4" fill="#000"/>
            <path d="M15.2 12.1c.4-.5.7-1.2.6-1.9-.6 0-1.3.4-1.8.9-.4.4-.7 1.1-.6 1.8.7.1 1.4-.3 1.8-.8z" fill="white"/>
            <path d="M15.8 13c-1 0-1.8.6-2.3.6s-1.2-.5-2-.5c-1 0-2 .6-2.5 1.5-1.1 1.9-.3 4.6.8 6.1.5.7 1.1 1.6 1.9 1.5.8 0 1-.5 1.9-.5s1.1.5 1.9.5c.8 0 1.3-.7 1.8-1.5.6-.8.8-1.6.8-1.6s-1.5-.6-1.5-2.3c0-1.4 1.2-2.1 1.2-2.1-.7-1-1.7-1.1-2-1.1z" fill="white"/>
            <text x="30" y="19.5" text-anchor="middle" fill="white" font-family="Arial,sans-serif" font-size="8" font-weight="500">Pay</text>
        </svg>
    </div>
    <div class="intersport-footer__payment-icon" title="Google Pay">
        <svg viewBox="0 0 48 32" width="42" height="28">
            <rect width="48" height="32" rx="4" fill="#FFF"/>
            <rect x="0.5" y="0.5" width="47" height="31" rx="3.5" fill="none" stroke="#E5E7EB"/>
            <text x="15" y="19" text-anchor="middle" fill="#4285F4" font-family="Arial,sans-serif" font-size="9" font-weight="700">G</text>
            <text x="30" y="19" text-anchor="middle" fill="#3C4043" font-family="Arial,sans-serif" font-size="8" font-weight="500">Pay</text>
        </svg>
    </div>
</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar: Copyright & Legal -->
        <div class="intersport-footer__bottom">
            <div class="container">
                <div class="intersport-footer__bottom-inner">
                    <div class="intersport-footer__copyright">
                        &copy; <?php echo date('Y'); ?> INTERSPORT Elverys — Waterford. All Rights Reserved.
                    </div>
                    <div class="intersport-footer__legal">
                        <a href="javascript:void(0);" onclick="event.preventDefault();">Privacy Policy</a>
                        <a href="javascript:void(0);" onclick="event.preventDefault();">Terms & Conditions</a>
                        <a href="javascript:void(0);" onclick="event.preventDefault();">Cookie Policy</a>
                        <a href="javascript:void(0);" onclick="event.preventDefault();">Accessibility</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php
}
add_action('flatsome_footer', 'intersport_custom_footer_output', 5);

/**
 * Remove default Flatsome footer widget areas to avoid duplicate content.
 * Our custom footer replaces them entirely. The absolute footer bar is hidden via CSS.
 */
function intersport_remove_default_footer_widgets() {
    remove_action('flatsome_footer', 'flatsome_page_footer', 10);
}
add_action('wp', 'intersport_remove_default_footer_widgets', 20);
