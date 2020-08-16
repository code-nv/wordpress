<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */
// enable database interaction locally or on live environment
if (strstr($_SERVER['SERVER_NAME'], 'fictional-university.local')) {
    define('DB_NAME', 'local');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_HOST', 'localhost');
} else {
    define('DB_NAME', 'dbcwrguyzt54mc');
    define('DB_USER', 'ucsguk87zp73v');
    define('DB_PASSWORD', 'PleaseDontmessWithThiS');
    define('DB_HOST', '127.0.0.1');
}


/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 'bT8gbPEELNfc+mprfByMyQSV6jZHE+H9Tj6cVkVoT40fbn70AhiHx/Oz/3NYRlyBTq21Op+1YsZ4WrIkyIevkQ==');
define('SECURE_AUTH_KEY', 'Tmyzxsf029gOm7Fi6tujnCFcbdaL5ArPZ109VgrzCKfKc+cxqlC7TKc1VSuNFE+U8qOqSPk1L2Az+VpTEcokiA==');
define('LOGGED_IN_KEY', 'A0zi37pY20xnG4v+Vj37lWwzQRJ5V4SWck/YLlOtykiXATKAtfKr1NoCPwx4SCx2S70GTHXZ96CGKqhl3GkaLg==');
define('NONCE_KEY', 'QUqJdQ/a4yh/6OB8cABODNECK4d+352aoARaNz01RoHrVlZ4mLa9nwvvuua+0jeNzKvzGQR0l61IlGyUnZSYGQ==');
define('AUTH_SALT', 'eb/u2+Q1KxcRTb4j4it9jcW06jvbX/byBZzi8NT8PsbuYuA/2tWcQEWUzHwadYobYtkrDCglJlXxMFgu45+5tQ==');
define('SECURE_AUTH_SALT', 'hUdP71PlexSSLHOOegFLOr0qUTNrUIvR1+SHNRqPcf2YxsfZYFvfYYD9d10YVxXCg01l+oLwzNKi5dM1CIrbXw==');
define('LOGGED_IN_SALT', 'bvhNlirDHNe1cZ6jAnzWv3wncIXtgclnCPRNc+fbs2l4V2hzZXuxbSCch+ncHLCGFn+JJQUVTldXTSpW5ucd9w==');
define('NONCE_SALT', '2Cp1SakoYRKYudzCOLbkB8WDEhY5ukBr6FZeb5b4izUfK1xPUskSbcgCDuzTmrTUiaXvZmGvWbMbl6aUQwsW4A==');

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (! defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
