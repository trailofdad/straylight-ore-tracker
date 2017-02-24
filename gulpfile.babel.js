import requireDir from 'requiredir';
import gulp from 'gulp';

requireDir('./gulp-tasks');
gulp.task('default', ['watch', 'scripts-common', 'admin', 'styles', 'lint']);
gulp.task('build-release', ['scripts-common', 'styles']);
