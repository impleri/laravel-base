# Laraval for Brunch

Laravel is a great framework for building sites in PHP. The power of composer is
awesome. Brunch is a great way to assemble front-end components. This skeleton
provides both in an initial configuration. Included in the configuration are
presets to use Bower, SASS/Compass, and CoffeeScript. All of your code should be
placed in app/ (see beloef for structure details). Configurations for the
respective applications are included in the root.

## File Structure

    / Repository root
    |
    | app/ - Everything specific to your web application
    | |
    | | assets/   - Static files which will be copied without modification to public/
    | | commands/ - Your commands for artisan go here
    | | config/   - Laravel configuration files
    | | controllers/ - Laravel controllers
    | | css/ - Plain CSS files for your site. These will be joined in brunch and
    | |        copied to public/css
    | | css-generated/ - CSS files generated from SASS/Compass. These will be joined
    | |                  in brunch and copied to public/css
    | | database/ - Laravel database files
    | | |
    | | | migrations/ - Laravel database schema migration classes
    | | \_seeds/      - Laravel database seeding classes
    | |
    | | js/ - JavaScript and CoffeeScript files for your site. These will be joined
    | |       in brunch and copied to public/css
    | | lang/    - Laravel language/internationalization files
    | | models/  - Laravel ORM models
    | | sass/    - SASS/Compass files. These will be generated then joined in brunch
    | |            before being copied to public/css
    | | start/   - Laravel post-bootstrap setup
    | | storage/ - Where Laravel will dump generated views, logs, session data
    | | tests/   - Put all of your unit, BDD, etc tests here
    | | views/   - Laravel Blade templates go here
    | | filters.php - Customise the filter definitions for use in routing
    | \_routes.php  - The primary routing file.
    |
    | bootstrap/        - Laravel bootstrap setup
    | bower_components/ - Where Bower will install its files. Brunch integrates with
    |                     whatever is reported to Bower as a main file. Javascript
    |                     and CSS will be joined in brunch and copied to public/js or
    |                     public/css
    | node_modules/     - Where Node/NPM will install its files. This is primarily
    |                     for brunch plugins.
    | public/           - The public root directory for your http server.
    | vendor/           - Where Composer will install its files.
    | .gitignore    - Your Git ignore file
    | artisan       - The CLI script for Laravel
    | bower.json    - Bower's configuration file
    | compass.rb    - Compass's configuration file
    | composer.json - Composer's configuration file
    | package.json  - Brunch's configuration file
    \_phpunit.xml   - phpUnit configuration file
