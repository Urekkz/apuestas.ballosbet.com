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
define( 'DB_NAME', 'dannygue_wp609' );

/** Database username */
define( 'DB_USER', 'dannygue_wp609' );

/** Database password */
define( 'DB_PASSWORD', '3S6pw.3W[z' );

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
define( 'AUTH_KEY',         'kfb4mprkn0rzgyfhlgnnmrospb83z6p4q13ykassxskr5ptk91o5jhqshnt31och' );
define( 'SECURE_AUTH_KEY',  'x5po7angodnjns22x3jjx7zxjkzh6lghpsm0k2vxn5ytnpqzeee0cmqngggsresq' );
define( 'LOGGED_IN_KEY',    'cjdg7ycu8fksuovmrtqqcdwatjcew62j3hsosynluzqt5vgegpkncl6gw3ntemdz' );
define( 'NONCE_KEY',        'lf86g2jyyn0jf74bekvmgx61x9dlyutxa0u33tfmueqnczlowwf81wocpsf7kflb' );
define( 'AUTH_SALT',        'pqu4tmtjvpuhevzzlf6w9q83rpk42izkqlcncapmzqkdiedjvugqpzrg0xh4zfce' );
define( 'SECURE_AUTH_SALT', 'u0vf0fstdgtyeqjy865dfyt0g7l5ghtlh1flldiexmo4mgpeo9aioyxxhnx4igyi' );
define( 'LOGGED_IN_SALT',   'wksqz2ocma6s3x3vzfzm3wm4mn97ef5zm214gyirf6c70mxrspxzsduikilywj38' );
define( 'NONCE_SALT',       'xtwywnanhhhxqync8nqaebfkkjenx5ibj3ex9qhy7om390tg77lqzvzciubel02q' );

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
