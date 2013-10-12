# Laraval for Brunch

Laravel is a great framework for building sites in PHP. The power of composer is
awesome. Brunch is a great way to assemble front-end components. This skeleton
provides both in an initial configuration. Included in the configuration are
presets to use Bower, SASS/Compass, and CoffeeScript. All of your code should be
placed in app/ (see below for structure details). Configurations for the Bower,
Brunch, Compass, Composer, PHPunit, and NPM are included in the root.

## File Structure

    / Repository root
    |
    | app/ - Everything specific to your web application
    | | assets/   - Static files which will be copied without modification to
    | | |           public/
    | | | assets/ - All assets for the application
    | | | | font/ - Symlink to FontAwesome font directory
    | | \_\_images/ - Static images (DataTables images are symlinked here)
    | |
    | | commands/ - Your commands for artisan go here
    | | config/   - Laravel configuration files
    | | controllers/ - Laravel controllers
    | | css/ - Plain CSS files for your site. These will be joined in brunch and
    | |        copied to public/assets/css
    | | css-generated/ - CSS files generated from SASS/Compass. These will be
    | |                  joined in brunch and copied to public/assets/css
    | | database/ - Laravel database files
    | | | migrations/ - Laravel database schema migration classes
    | | \_seeds/      - Laravel database seeding classes
    | |
    | | js/ - JavaScript and CoffeeScript files for your site. These will be
    | |       joined in brunch and copied to public/assets/css
    | | lang/    - Laravel language/internationalization files
    | | models/  - Laravel ORM models
    | | sass/    - SASS/Compass files. These will be generated then joined in
    | |            brunch before being copied to public/assets/css
    | | start/   - Laravel post-bootstrap setup
    | | storage/ - Where Laravel will dump generated views, logs, session data
    | | tests/   - Put all of your unit, BDD, etc tests here
    | \_views/   - Laravel Blade templates go here
    |
    | bootstrap/        - Laravel bootstrap setup
    | bower_components/ - Where Bower will install its files. Brunch integrates
    |                     with whatever is reported to Bower as a main file.
    |                     Javascript and CSS will be joined in brunch and copied
    |                     to public/assets/js or public/assets/css
    | node_modules/     - Where Node/NPM will install its files. This is
    |                     primarily for brunch plugins.
    | public/           - The public root directory for your http server.
    \_vendor/           - Where Composer will install its files.


## Shortcuts

The file structure is organised to make it quite painless to start over:

    $ rm -rf app/css-generated public bower_components node_modules vendor composer.lock
    $ npm install
    $ bower install
    $ composer install


## Autoloading in Laravel

While Laravel does not require application models and controllers to be
namespaced, I prefer to conform as much as possible to PSR-0. Composer is
configured to autoload the `app` root namespace from the app/ directory (e.g.
app/model/Page should exist at app/model/Page.php). Eventually, I hope to have
everything autoloaded for the `app` namespace.
