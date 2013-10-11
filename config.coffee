exports.config =
  # See http://brunch.io/#documentation for docs.
  plugins:
    sass:
      debug: 'comments'
  files:
    javascripts:
      joinTo:
        'assets/js/app.js': /^app\/js\/(?!vendor)/
        'assets/js/vendor.js': /^bower_components/
      order:
        before: [
          "bower_components/jquery/jquery.js",
          "bower_components/jquery-ui/ui/jquery-ui.js",
          "bower_components/jquery.hotkeys/jquery.hotkeys.js",
          "bower_components/modernizr/modernizr.js"
        ]
    stylesheets:
      joinTo:
        'assets/css/app.css': /^app\/(css|sass)/
        'assets/css/vendor.css': /^bower_components/
      order:
        before: [
          "bower_components/normalize-css/normalize.css",
          "bower_components/font-awesome/css/font-awesome.css"
        ]
  overrides:
    production:
      sourceMaps: false
      plugins:
        cleancss:
          keepSpecialComments: 0
          removeEmpty: true
