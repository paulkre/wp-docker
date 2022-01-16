ARG WORDPRESS_VERSION
ARG PHP_VERSION

FROM wordpress:cli-php${PHP_VERSION:-8.0} AS cli

FROM wordpress:${WORDPRESS_VERSION:-5.8.1}-php${PHP_VERSION:-8.0}-apache

# Install PDO MySQL extension (required by plugin "MailPoet")
RUN docker-php-ext-install pdo_mysql

# Add sudo in order to run wp-cli as the www-data user 
RUN apt-get update && apt-get install -y sudo wget less

# Cleanup
RUN apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# Add WP-CLI 
COPY --from=cli /usr/local/bin/wp /usr/local/bin/wp-cli.phar
COPY wp-su.sh /usr/local/bin/wp
RUN chmod +x /usr/local/bin/wp
RUN wp --version

# Add PHP configuration
COPY php.ini /usr/local/etc/php/conf.d/php.ini

# Remove default plugins
RUN rm -rf /usr/src/wordpress/wp-content/plugins/*
