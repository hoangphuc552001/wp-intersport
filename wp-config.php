<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'ecom_wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'D2p])|=d4}E.7T)bKOrT[]Mg{6JuYC#jK$??,%(,cG5l1D.MrDS7fF%?,L-aa(6k' );
define( 'SECURE_AUTH_KEY',  '%LxtPHQ-|UO0_c9S|e>H CH:xm)rLI_J={iZrO]wdaHe8`?!U{05Mtwcc&%H!XKV' );
define( 'LOGGED_IN_KEY',    'K ?_6$,W^q99Z#`v]i^Y(Y~[34,Uc`^~rO^hILTY_y:H-f)-:fDg&S>rnyllXphE' );
define( 'NONCE_KEY',        'PH%!+/?)XkM(zIA2gEiU{p$1cb8o$(Ujc{H``AEyr&9XxfDS+*~ij^t+I!$UiDCP' );
define( 'AUTH_SALT',        'dLEvZi~h`^PpN0x:Z>8D[|iMk`*.DXzU&$IYG{J I*jm/|%@t7Ud1V4zy0F>9_nE' );
define( 'SECURE_AUTH_SALT', '`A._m|[>1^3}Svu0Ac!(wE J|qcaB,XomLKJbn6(I;1I[3Nd@Eg]P{4yiuxGMbDM' );
define( 'LOGGED_IN_SALT',   '1O_<}uQS<P|$pSJC@]T6g&8TV+bb|`8A*Ok$2Vzz3*E*OOg5`^g0WcSv;NPa<$Xp' );
define( 'NONCE_SALT',       'mD~BGy=L&<<K110_W]a9CF|gx+r!Uh8V~}]z9h^I;b#9>gc5rbIWa=e1g);+NihD' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
