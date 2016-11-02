// Load our plugins
var	gulp			=	require('gulp')

//Our 'deploy' task which deploys on a local dev environment

gulp.task('deploylocal', function() {

	var files = [
		'js/**/*.js',
		'*.php',
		'*.css'];

	var dest = 'C:/wamp/www/theme-dev/wp-content/plugins/austeve-icebreaker';

	return gulp.src(files, {base:"."})
	        .pipe(gulp.dest(dest));
});

// Our default gulp task, which runs all of our tasks upon typing in 'gulp' in Terminal
gulp.task('default', ['deploylocal']);
