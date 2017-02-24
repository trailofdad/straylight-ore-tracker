import autoprefixer from 'gulp-autoprefixer';
import cleanCSS from 'gulp-clean-css';
import combineMq from 'gulp-combine-mq';
import concatCss from 'gulp-concat-css';
import gulp from 'gulp';
import sass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';
import livereload from 'gulp-livereload';
import normalize from 'node-normalize-scss';

gulp.task('styles', ['clean'], () =>

  gulp.src('src/sass/main.scss')
    .pipe(sourcemaps.init())
    .pipe(sass({
      includePaths: ['node_modules/susy/sass', normalize.includePaths],
    }).on('error', sass.logError))
    .pipe(combineMq({
      beautify: false,
    }))
    .pipe(concatCss('bundle.css'))
    .pipe(cleanCSS({
      compatibility: 'ie11',
    }))
    .pipe(autoprefixer({
      browsers: ['last 3 versions'],
      cascade: false,
    }))
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest('dist/css'))
    .pipe(livereload()),
);
