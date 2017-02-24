import gulp from 'gulp';
import eslint from 'gulp-eslint';

gulp.task('lint', () =>
  gulp.src([
    'src/js/*.js',
    '!src/js/vendor/**',
  ]).pipe(eslint())
    .pipe(eslint.format())
    .pipe(eslint.failAfterError()),
);
