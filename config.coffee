exports.config =
  plugins:
    stylus:
      plugins: [
        'fluidity'
      ]
    autoprefixer:
      browsers: [
        "last 2 versions",
        "> 1%"
      ]
  files:
    javascripts:
      joinTo:
        'assets/js/app.js': /^app\/scripts/
        'assets/vendor/js/vendor.js': /^(bower_components|app\/vendor)/
      order:
        before: [
          "bower_components/modernizr/modernizr.js"
          "bower_components/jquery/jquery.js"
          "bower_components/jquery-ui/ui/jquery-ui.js"
        ]
        after: [
          "bower_components/datatables/media/js/jquery.dataTables.js"
          "bower_components/bootstrap-wysiwyg/bootstrap-wysiwyg.js"
        ]
    stylesheets:
      joinTo:
        'assets/css/app.css': /^app\/styles/
        'assets/vendor/css/vendor.css': /^(bower_components|app\/vendor)/
      order:
        before: [
          "bower_components/font-awesome/css/font-awesome.css"
        ]
  overrides:
    production:
      sourceMaps: false
      plugins:
        cleancss:
          keepSpecialComments: 0
          removeEmpty: true
