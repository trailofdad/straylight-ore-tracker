import gulp from 'gulp';
import livereload from 'gulp-livereload';

const paths = {
  scripts: 'src/js/**/*.js',
  styles: 'src/sass/*.scss',
};

gulp.task('watch', () => {
  livereload.listen();
  gulp.watch(paths.scripts, ['clean', 'scripts-common', 'admin-scripts', 'lint']);
  gulp.watch(paths.styles, ['clean', 'styles']);
});
