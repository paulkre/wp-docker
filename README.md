# paulkre/wp

This is an extension of the [WordPress Docker image](https://hub.docker.com/_/wordpress) using sane defaults and bundled with [WP-CLI](https://wp-cli.org).

## Configuration

The database connection for this image can be defined with the environment variable `DATABASE_URL` (unlike the [base image](https://hub.docker.com/_/wordpress) which only uses the `WORDPRESS_DB_...` variables).
The value for `DATABASE_URL` should have the following format: `mysql://<username>:<password>@<host>[:<port>]/<dbname>` (e.g. `mysql://root:secret@localhost:3306/wp`).
