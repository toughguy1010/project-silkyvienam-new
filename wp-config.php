<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'silkyvietnam' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8bin' );

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
define( 'AUTH_KEY',         'n`7K,BG[MLNwt<*Yqc9NLvfd,|XLEo<0 HDG/p5::A!a#umCQ28$9I^BSJH_^v r' );
define( 'SECURE_AUTH_KEY',  'z-ZK%<#ZompM`@#~Q/lo0^)+@(Pur^?86LR9;G.<%tcl[7SgX8Vb(^bMMnk^gx3]' );
define( 'LOGGED_IN_KEY',    '2;`I*8OyI~TYW!_4/ &Dr>>#_:_a)]wai%Y.rLQuUdAE`Aa+!:j~nwrzcM34Ij 8' );
define( 'NONCE_KEY',        'Dv&C6Qm.@r^o ry7bMm?0Z$wnLQ)tr,4C=(To5i:k:w[,}2QonLmx`_I,iqv=>J[' );
define( 'AUTH_SALT',        'z!$XAy6cXuFx&M+Q$J0+2@Z5 TMrD}G`K72#dVQAOMJFMsRO@<<Bz97fi/,>&gV{' );
define( 'SECURE_AUTH_SALT', 'ZB g?+yS-jp$tc-!ifNm_fo5>gUthoyAHJv2xl)X{%RM$NNykpmKZrj(FYFU%{Eh' );
define( 'LOGGED_IN_SALT',   'vG[QWJ)Shr5F+t]@08(+@Fcqaed:Nq& xpfS5[$O9a6w4k<?WF#Xk9:78]k;niC+' );
define( 'NONCE_SALT',       'He;O1AH{+h,4v$%C8w<@t/I^c<t_BwG/REk{<*C#;e:OikBMJk9*#xZvU!C2Bn3A' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', false );

define( 'WP_DEBUG_LOG', true );
// define('SCRIPT_DEBUG', true);
/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
