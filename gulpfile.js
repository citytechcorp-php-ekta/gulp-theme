// including plugins
var gulp = require('gulp'), 
sass = require("gulp-sass"),
concat = require("gulp-concat"),
uglify = require("gulp-uglify"),
minifyCSS = require('gulp-minify-css'),
autoprefix = require('gulp-autoprefixer'),
liveReload = require('gulp-livereload'),
gutil=require('gutil'),
changed = require('gulp-changed'),
imagemin = require('gulp-imagemin'),
rename = require('gulp-rename'); 
//Error Function

// task
gulp.task('compile-sass', function () { 

gulp.src([
		'./assets-input/css/*.scss',
		'bower_components/bootstrap-sass/assets/stylesheets/_bootstrap.scss',
    		]) 
	.pipe(sass().on('error', sass.logError))
  .pipe(rename('final.css'))
  .pipe(minifyCSS())
	.pipe(gulp.dest('assets-output/css/'))
     
}); 

gulp.task('compile-js', function () { 
    gulp.src([
    	'bower_components/jquery/dist/jquery.js', 
    	'bower_components/bootstrap-sass/assets/javascripts/bootstrap.js',
    	'assets-input/js/*.js', 
    	],{base: 'bower_components/'})  
    .pipe(uglify())
    .on('error', gutil.log)
    .pipe(concat('final.js'))  
    .pipe(gulp.dest('assets-output/js/'));  
     
});

gulp.task('imagemin', function() {
  var imgSrc = './assets-input/images/**/*',
      imgDst = './assets-output/images'; 

  gulp.src(imgSrc)
    .pipe(changed(imgDst))
    .on('error', gutil.log)
    .pipe(imagemin())
    .pipe(gulp.dest(imgDst));
}); 

gulp.task('default',['compile-sass','compile-js','imagemin']); 

gulp.task('watch', ['compile-sass','compile-js','imagemin'], function (){ 
  gulp.watch('assets-input/css/*.scss', ['compile-sass']); 
  gulp.watch('assets-input/js/*.js', ['compile-js']);   
  //gulp.watch('assets-input/images/**/*', ['imagemin']); 
})