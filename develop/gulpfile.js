/* eslint-disable no-console */
const gulp = require('gulp');
const sass = require('gulp-sass');
const autoprefixer = require('gulp-autoprefixer');
const sourcemaps = require('gulp-sourcemaps');
const imagemin = require('gulp-imagemin');
const imageminMozjpeg = require('imagemin-mozjpeg');
const webpack = require('webpack-stream');
const named = require('vinyl-named');
const browserSync = require('browser-sync').create();
const notifier = require('node-notifier'); // show Growl

const proxyUrl = 'http://babyreport.local';
const developFolder = '';
const publicFolder = '../public/';
const assetsFolder = 'assets/';
const additionalyWatchFiles = ['**/*.yml', '**/*.php'];

// Static Server + watching scss/html files
gulp.task('watch', () => {
  browserSync.init({
    host: 'localhost',
    port: 3000,
    proxy: proxyUrl,
    ghostMode: false, // enable to sync scroll and click events
    open: false, // enable to automatically open browser
    // server: {
    //   baseDir: "./public/"
    // },
    serveStatic: [{
      route: assetsFolder,
      dir: `${publicFolder}${assetsFolder}`,
    }],
  });
  gulp.watch(`${developFolder}js/**/*.js`, gulp.parallel('js-dev'));
  gulp.watch(`${developFolder}css/**/*.scss`, gulp.parallel('sass-dev'));
  gulp.watch(`${developFolder}images/**/*`, gulp.parallel('copy-images'));
  gulp.watch(additionalyWatchFiles)
    .on('change', browserSync.reload) // reload browser on changes in html directory
    .on('error', function handleError(error) {
      console.log(error);
      notifier.notify({
        title: 'Error',
        message: JSON.stringify(error),
      });
      this.emit('end'); // Recover from errors
    });
});


// Compile sass into CSS & auto-inject into browsers
gulp.task('sass-dev', () => gulp.src(`${developFolder}css/*.scss`)
  .pipe(sourcemaps.init())
  .pipe(sass().on('error', function handleError(error) {
    console.log(error);
    notifier.notify({
      title: 'SASS Error',
      message: error.formatted,
    });
    this.emit('end'); // Recover from errors
  }))
  .pipe(autoprefixer({
    browsers: 'Safari 12',
  }))
  .pipe(sourcemaps.write())
  .pipe(gulp.dest(`${publicFolder}${assetsFolder}css`))
  .pipe(browserSync.stream()));

// Compile sass into CSS & auto-inject into browsers
gulp.task('sass', () => gulp.src(`${developFolder}css/*.scss`)
  .pipe(sass({ outputStyle: 'compressed' }))
  .pipe(autoprefixer())
  .pipe(gulp.dest(`${publicFolder}${assetsFolder}css`)));


// Compile with Webpack with source map
gulp.task('js-dev', () => gulp.src(`${developFolder}js/*.js`)
  .pipe(named())
  .pipe(webpack({
    mode: 'development',
    devtool: 'cheap-module-eval-source-map',
  }).on('error', function handleError(error) {
    console.log(error);
    notifier.notify({
      title: 'JS Error',
      message: JSON.stringify(error.message),
    });
    this.emit('end'); // Recover from errors
  }))
  .pipe(gulp.dest(`${publicFolder}${assetsFolder}js`))
  .pipe(browserSync.stream()));

// Do babel, then compile with webpack
gulp.task('js', () => gulp.src(`${developFolder}js/*.js`)
  .pipe(named())
  .pipe(webpack({
    mode: 'production',
    module: {
      rules: [
        {
          test: /\.m?js$/,
          exclude: /(node_modules|bower_components)/,
          use: [{
            loader: 'babel-loader',
          }],
        },
      ],
    },
  }))
  .pipe(gulp.dest(`${publicFolder}${assetsFolder}js`)));


// Optimize all images in develop/images and save them in {assetsFolder}/images
gulp.task('optimize-images', () => gulp.src(`${developFolder}images/**/*`)
  .pipe(imagemin([
    imagemin.gifsicle(),
    imageminMozjpeg(),
    imagemin.optipng(),
    imagemin.svgo({
      plugins: [
        { removeViewBox: false },
      ],
    }),
  ], {
    verbose: true,
  }).on('error', function handleError(error) {
    console.log(error);
    notifier.notify({
      title: 'Optimize Images Error',
      message: JSON.stringify(error),
    });
    this.emit('end'); // Recover from errors
  }))
  .pipe(gulp.dest(`${publicFolder}${assetsFolder}images`)));


// Just copy images from develop/images to {assetsFolder}/images
gulp.task('copy-images', () => gulp.src(`${developFolder}images/**/*`)
  .pipe(gulp.dest(`${publicFolder}${assetsFolder}images`))
  .pipe(browserSync.stream()));


gulp.task('default', gulp.parallel('watch'));
gulp.task('build', gulp.parallel('sass', 'js', 'optimize-images'), () => {
  notifier.notify({
    title: 'Build complete!',
    message: 'Alles fertig gebaut.',
  });
});
