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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'dbt7gnygxfdqy7' );

/** MySQL database username */
define( 'DB_USER', 'u5zhfyf96dm4n' );

/** MySQL database password */
define( 'DB_PASSWORD', 'e1)&7eq^(%gx' );

/** MySQL hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'SAnh6&H-P9XcbFwLd8YqzG99x7#QVVo3uoC8/Q{v6fPK#e%3}Z<VX5 `Y%hnQ;%P' );
define( 'SECURE_AUTH_KEY',  'dVV6c}:aHEoEhq)/wB{Y2o*k0m/l#5$K &uuFY>(I`EM&06O&G?4?e:99x,3n9J`' );
define( 'LOGGED_IN_KEY',    'C{Igp[YO AHp{?sMCzpRY918a~hYN/[`mFe)9C w_G;_nSHxyb`f5FR=!IU-Ftb2' );
define( 'NONCE_KEY',        'XXh7rMC(8RqK=$<K`K]|Th=$!lS12v^#_>KtT8`h0d6^YJ?],4MG>z^gF#wUPa)C' );
define( 'AUTH_SALT',        '95uu{&%U(-N4(nqy?56].*:k,}&RL>jf`dv@2X<fWiBktL/D65f?FvDqzAO~@YA+' );
define( 'SECURE_AUTH_SALT', 'Q)[t9Z28*PTVgt 4ZzMmMRR]lor6^h:^DKT5W+c~S/.X#Lj,mvl}vBo,7igMZB}L' );
define( 'LOGGED_IN_SALT',   'o:DP1UqcNx~5ix!)LHYOl-2S&7c9D/L@21A[ZYZe/:3X=z@9u=)Fh/JHraVZ>nAA' );
define( 'NONCE_SALT',       'ZjFkKyz;+cTov c/WR88IOcs^bmOtxgg^Tv%h<9QeP$at74@`kzOe^$~Fvc{3 q<' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
