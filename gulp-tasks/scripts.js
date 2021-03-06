import babel from 'gulp-babel';
import concat from 'gulp-concat';
import gulp from 'gulp';
import sourcemaps from 'gulp-sourcemaps';
import uglify from 'gulp-uglify';
import livereload from 'gulp-livereload';

gulp.task('scripts-common', ['clean'], () =>
  gulp.src([
    'src/js/vendor/jquery-3.1.1.min.js',
    'src/js/vendor/bootstrap.min.js',
    'src/js/*.js',
    '!src/js/admin.js',
  ])
  .pipe(sourcemaps.init())
  .pipe(babel({
    compact: false,
    presets: ['es2015'],
    ignore: 'src/js/vendor/*.js',
  }))
  .pipe(uglify({
    ignore: 'src/js/vendor/*.js',
  }))
  .pipe(concat('all.min.js'))
  .pipe(sourcemaps.write('maps'))
  .pipe(gulp.dest('dist/js'))
  .pipe(livereload()),
);

gulp.task('admin-scripts', ['clean'], () =>
  gulp.src([
    'src/js/admin.js',
  ])
  .pipe(sourcemaps.init())
  .pipe(babel({
    compact: false,
    presets: ['es2015'],
  }))
  .pipe(uglify())
  .pipe(concat('admin.min.js'))
  .pipe(sourcemaps.write('maps'))
  .pipe(gulp.dest('dist/js'))
  .pipe(livereload()),
);
