// jshint ignore: start

var gulp         = require('gulp'),
    fs           = require('fs'),
    less         = require('gulp-less'),
    autoprefixer = require('gulp-autoprefixer'),
    minifycss    = require('gulp-minify-css'),
    uglify       = require('gulp-uglify'),
    rename       = require('gulp-rename'),
    concat       = require('gulp-concat'),
    sourcemaps   = require('gulp-sourcemaps'),
    plumber      = require('gulp-plumber'),
    data_uri     = require('gulp-data-uri'),
    del          = require('del'),
    gutil        = require('gulp-util'),
    ftp          = require('vinyl-ftp'),
    passes       = fs.existsSync('./ftppass.json') ? require('./ftppass.json') : {};



// Custom
var customThemeDir  = 'htdocs/';


function onError (err) {
  gutil.log(err);
  this.emit('end');
}


gulp.task('default', function() {
    gulp.start('styles', 'concatstyles', 'scripts');
});


gulp.task('styles', function() {
  gutil.log(customThemeDir + 'css/less/styles.less');
  return gulp.src(customThemeDir + 'css/less/styles.less')
    .pipe(plumber({errorHandler: onError}))
    .pipe(sourcemaps.init())
    .pipe(less({ style: 'expanded' }))
    .pipe(data_uri())
    .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
    .pipe(sourcemaps.write(customThemeDir + 'dist/css'))
    .pipe(gulp.dest(customThemeDir +  'dist/css'));
});


gulp.task('concatstyles', ['styles'], function() {
  return gulp.src([
        customThemeDir + 'css/vendor/normalize.css',
        customThemeDir + 'css/vendor/bootstrap.css',
        customThemeDir + 'css/vendor/bootstrap-datepicker3.standalone.css',
        customThemeDir + 'dist/css/styles.css',
      ])
      .pipe(concat('main.out.css'))
      .pipe(rename({suffix: '.min'}))
      .pipe(minifycss())
      .pipe(gulp.dest(customThemeDir + 'dist/css'));
});


gulp.task('scripts', function() {
  return gulp.src([
      customThemeDir + 'js/vendor/jquery.min.js',
      customThemeDir + 'js/vendor/bootstrap.js',
      customThemeDir + 'js/vendor/bootstrap-datepicker.js',
      customThemeDir + 'js/vendor/bootstrap-datepicker.de.min.js',
      customThemeDir + 'js/vendor/cbpAnimatedHeader.js',
      customThemeDir + 'js/vendor/classie.js',
      customThemeDir + 'js/vendor/jquery.easing.1.3.min.js',
      customThemeDir + 'js/vendor/freelancer.js',
      customThemeDir + 'js/vendor/masonry.js',
      customThemeDir + 'js/vendor/moment.js',
      customThemeDir + 'js/custom/**/*.js'
    ])
    .pipe(concat('main.js'))
    // .pipe(jshint('.jshintrc'))
    // .pipe(jshint.reporter('default'))
    .pipe(gulp.dest(customThemeDir + 'dist/js'))
    .pipe(rename({suffix: '.min'}))
    .pipe(uglify())
    .pipe(gulp.dest(customThemeDir + 'dist/js'))
});


gulp.task('watch', function() {
  // Watch .less files
  gulp.watch(customThemeDir + 'css/less/**/*.less', ['concatstyles', 'styles']);

  // Watch .js files
  gulp.watch(customThemeDir + 'js/**/*.js', ['scripts']);
});


gulp.task('deploy', function(){
  if (passes != 'undefined') {
    return process.stdout.write('\nYou have to set up the ftppass.json before you can deploy!\n');
  }

  var conn = ftp.create({
    host:     'th9014-web495.vorschau.server15.tophoster.de',
    user:     passes.user.username,
    password: passes.user.password,
    parallel: 10,
    log:      gutil.log
  });

  var globs = [
    // customThemeDir + 'core/**',
    // customThemeDir + 'dist/**',
    // customThemeDir + 'font-awesome/**',
    // customThemeDir + 'fonts/**',
    // customThemeDir + '.htaccess',
    // customThemeDir + 'favicon.ico',
    // customThemeDir + 'index.php',
    customThemeDir + 'infos.php',
    customThemeDir + 'robots.txt'
  ];

  // turn off buffering in gulp.src for best performance

  return gulp.src(globs, {base: 'htdocs', buffer: false})
    .pipe(conn.newer('/')) // only upload newer files
    .pipe(conn.dest('/'));
});
