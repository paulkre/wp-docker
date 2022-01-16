#!/bin/sh
# This is a wrapper so that wp-cli can run as the www-data user so that permissions
# remain correct
sudo -E -u www-data WP_CLI_CONFIG_PATH=/var/www/.wp-cli/config.yml /usr/local/bin/wp-cli.phar "$@"