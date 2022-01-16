<?php

// A detailed explaination of this file can be found here:
// https://github.com/docker-library/wordpress/blob/master/latest/php8.1/apache/wp-config-docker.php

if (!function_exists('getenv_docker')) {
  function getenv_docker($env, $default)
  {
    if ($fileEnv = getenv($env . '_FILE')) {
      return rtrim(file_get_contents($fileEnv), "\r\n");
    } else if (($val = getenv($env)) !== false) {
      return $val;
    } else {
      return $default;
    }
  }
}

$db_url = getenv_docker('DATABASE_URL', null);
if ($db_url) {
  $db = array_merge(['port' => 3306], parse_url($db_url));
  define('DB_NAME', substr($db['path'], 1));
  define('DB_USER', $db['user']);
  define('DB_PASSWORD', $db['pass']);
  define('DB_HOST', $db['host'] . ':' . $db['port']);
} else {
  define('DB_NAME', getenv_docker('WORDPRESS_DB_NAME', 'wp'));
  define('DB_USER', getenv_docker('WORDPRESS_DB_USER', 'root'));
  define('DB_PASSWORD', getenv_docker('WORDPRESS_DB_PASSWORD', 'secret'));
  define('DB_HOST', getenv_docker('WORDPRESS_DB_HOST', 'localhost'));
}
define('DB_CHARSET', getenv_docker('WORDPRESS_DB_CHARSET', 'utf8'));
define('DB_COLLATE', getenv_docker('WORDPRESS_DB_COLLATE', ''));

// https://api.wordpress.org/secret-key/1.1/salt/
define('AUTH_KEY',         getenv_docker('WORDPRESS_AUTH_KEY',         'put your unique phrase here'));
define('SECURE_AUTH_KEY',  getenv_docker('WORDPRESS_SECURE_AUTH_KEY',  'put your unique phrase here'));
define('LOGGED_IN_KEY',    getenv_docker('WORDPRESS_LOGGED_IN_KEY',    'put your unique phrase here'));
define('NONCE_KEY',        getenv_docker('WORDPRESS_NONCE_KEY',        'put your unique phrase here'));
define('AUTH_SALT',        getenv_docker('WORDPRESS_AUTH_SALT',        'put your unique phrase here'));
define('SECURE_AUTH_SALT', getenv_docker('WORDPRESS_SECURE_AUTH_SALT', 'put your unique phrase here'));
define('LOGGED_IN_SALT',   getenv_docker('WORDPRESS_LOGGED_IN_SALT',   'put your unique phrase here'));
define('NONCE_SALT',       getenv_docker('WORDPRESS_NONCE_SALT',       'put your unique phrase here'));

$table_prefix = getenv_docker('WORDPRESS_TABLE_PREFIX', 'wp_');

define('WP_DEBUG', !!getenv_docker('WORDPRESS_DEBUG', ''));

if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
  $_SERVER['HTTPS'] = 'on';
}

if ($configExtra = getenv_docker('WORDPRESS_CONFIG_EXTRA', '')) {
  eval($configExtra);
}

if (!defined('ABSPATH')) {
  define('ABSPATH', __DIR__ . '/');
}

require_once ABSPATH . 'wp-settings.php';
