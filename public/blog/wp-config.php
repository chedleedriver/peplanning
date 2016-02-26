<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, and ABSPATH. You can find more information by visiting
 * {@link http://codex.wordpress.org/Editing_wp-config.php Editing wp-config.php}
 * Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'peplanning');

/** MySQL database username */
define('DB_USER', 'peplanning');

/** MySQL database password */
define('DB_PASSWORD', 'ferd1nand');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY',         '4 8N1|{>2*-R(.u7H<x+T(N!& &Fov|oU:@CP}HCh|WgqK#-2nm6~B5JEyNLs|ON');
define('SECURE_AUTH_KEY',  'Ce!nK<BqwC%;BxQ2`{(_|:.khKsyb{QK2}LaY%X<Gh{*p;VZ>(.x%PKi@Clr!hT}');
define('LOGGED_IN_KEY',    '>AOL[_@Z3*d}20GVF|F#^S(2yY)|cO_dt!FJd5Z^)8ed0HyI+bsVOiV;-Oa:Z|*-');
define('NONCE_KEY',        'U7*/r#KO#Am*GEx}^c]ObL[tPa9+*x~G|1MQ.J)Etm1}wc?1a|FF76O> >cwBTx9');
define('AUTH_SALT',        'IeJms6xyq><n-RxYBsHPHiPsQ!&,lkB.5iZ1v&kXs5u%Y*_6xij<YgSZ5BC+R(S{');
define('SECURE_AUTH_SALT', '`T|_Hx?(gIo3tx!ad0pU:Lv>18PQQ}E?#[KG/|vRTU .< l>[6@&xBUzqnl:20@]');
define('LOGGED_IN_SALT',   '(HAxF:iiV_+Y-Q(T%yL-,6-q{[bn5>]f:ci&m)P03yzib?wv%!S3zLTZ3E6K}ksK');
define('NONCE_SALT',       '`[&s^_`P-|3Sh|x0~duw*>A8$L5fdrf)~dgbT|%!DnVm.HsAQ|~1!}P8CJ|;|GAW');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
