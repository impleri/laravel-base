exports.config =
  # See http://brunch.io/#documentation for docs.
  paths:
    compass: './compass.rb'
  files:
    javascripts:
      joinTo:
        'js/app.js': /^app\/js\/(?!vendor)/
        'js/vendor.js': /^bower_components/
    stylesheets:
      joinTo:
        'css/app.css': /^app\/css/
        'css/vendor.css': /^bower_components/
