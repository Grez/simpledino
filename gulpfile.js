var gulp = require('gulp');
var concat = require('gulp-concat');
var concatCss = require('gulp-concat-css');
var bower = require('gulp-bower');

gulp.task('css', function() {
	var files = [
		'./www/bower_components/bootstrap/dist/css/bootstrap.min.css',
	];

	return gulp.src(files)
		.pipe(concatCss('style.css'))
		.pipe(gulp.dest('./www/css'));
});

gulp.task('js', function () {
	var files = [
		'./www/bower_components/jquery/dist/jquery.min.js',
		'./www/bower_components/nette.ajax.js/nette.ajax.js',
		'./www/bower_components/bootstrap/dist/js/bootstrap.min.js',
		'./www/bower_components/nette-forms/src/assets/netteForms.min.js',
	];

	return gulp.src(files)
		.pipe(concat('main.js'))
		.pipe(gulp.dest('./www/js'));
});

gulp.task('bower', function() {
	return bower()
		.pipe(gulp.dest('./www/bower_components'))
});

gulp.task('default', gulp.series('bower', 'css', 'js'));
