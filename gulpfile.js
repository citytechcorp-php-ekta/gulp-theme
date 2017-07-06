// including plugins
var gulp = require('gulp'), 
sass = require("gulp-sass"),
concat = require("gulp-concat"),
uglify = require("gulp-uglify"),
minifyCSS = require('gulp-minify-css'),
autoprefix = require('gulp-autoprefixer'),
gutil=require('gutil'),
changed = require('gulp-changed'),
imagemin = require('gulp-imagemin'),
rename = require('gulp-rename'); 

var browserSync = require('browser-sync').create();
var reload      = browserSync.reload;
//Error Function

// task
gulp.task('compile-sass', function () { 

gulp.src([
    './assets-input/css/*.scss',
    		]) 
	.pipe(sass().on('error', sass.logError)) 
  .pipe(concat('final.css')) 
  .pipe(minifyCSS())
	.pipe(gulp.dest('assets-output/css/')) 
     .pipe(browserSync.reload({stream: true}));
}); 

gulp.task('compile-js', function () { 
    gulp.src([
    	'bower_components/jquery/dist/jquery.js', 
    	'bower_components/bootstrap-sass/assets/javascripts/bootstrap.js', 
      'bower_components/slicknav/dist/jquery.slicknav.min.js',
    	'assets-input/js/*.js', 
    	],{base: 'bower_components/'})  
    .pipe(uglify())
    .on('error', gutil.log)
    .pipe(concat('final.js'))  
    .pipe(gulp.dest('assets-output/js/'))
     .pipe(browserSync.reload({stream: true})); 
     
}); 

gulp.task('imagemin', function() {
  var imgSrc = './assets-input/images/**/*',
      imgDst = './assets-output/images'; 

  gulp.src(imgSrc)
    .pipe(changed(imgDst))
    .on('error', gutil.log)
    .pipe(imagemin())
    .pipe(gulp.dest(imgDst))
     .pipe(browserSync.reload({stream: true}));
}); 

gulp.task('default',['compile-sass','compile-js','imagemin']); 

//gulp.task('watch', ['compile-sass','compile-js','imagemin'], function (){ 
  //gulp.watch('assets-input/css/*.scss', ['compile-sass']); 
  //gulp.watch('assets-input/js/*.js', ['compile-js']);   
  //gulp.watch('assets-input/images/**/*', ['imagemin']); 
//})

gulp.task('watch', function() {

  browserSync.init({
    files: ['./**/*.php'],
    proxy: 'http://192.168.0.222/wp/wp_plugins',
    browser: ["google chrome", "firefox"]
  });
  gulp.watch('assets-input/css/*.scss', ['compile-sass']); 
 gulp.watch('assets-input/js/*.js', ['compile-js']);   
 gulp.watch('assets-input/images/**/*', ['imagemin']); 
  
}); 


