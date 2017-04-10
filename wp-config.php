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

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'mananitas');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '~&zKxh^&0AT6NTSV&`d!?RGY?S|@x.j*th~0U+vDr(77OjrubgF ct}2tU3s&cTN');
define('SECURE_AUTH_KEY',  'y|<Z]6D$Qu [-<&WhMfy3eShMu.]%p,AWH^fGKB$gbStBrJ0/`FMdpJ*P.y^HG2:');
define('LOGGED_IN_KEY',    'A7.iF!+N#4c~[jtd+>L-F^7N;5?1#DQ(Po2 DhZ1Ri!W$oS^` AaG$75Fxd.g QT');
define('NONCE_KEY',        '#}B`iYV_-r+@#UZq;|ka7BDdKtj= $3]Bn-,.E];5|&p|,uc,3d*GkN@G)T@XU4{');
define('AUTH_SALT',        'zeVi_DmyKn%~.[w{|Gr|W.~k}{,)euz}F9pm&d >#%o&r}g 0Z@)BP9mCy$!C^Wm');
define('SECURE_AUTH_SALT', '?(EN]d~t7BMs3n&j/yc@s`/CAy-2eK+v0p*|vMFT@IWB^3JHNuu=qi8&|=GEXrxV');
define('LOGGED_IN_SALT',   'dkS`_+x**r6B_JkpB>MUK{y`Tom~C&5.>9]&OtaNsal- *Eue8>)F?73]6t -ExI');
define('NONCE_SALT',       'o.)7xg]s]t.PF-*z=9OPtSw~wqK+3?xwSy~NpeB9(mfk[}GZ^pkN7.r?Es>J<req');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
