// Gulp and plugins
const gulp = require("gulp");
const babelify = require("babelify");
const browserify = require("browserify");
const source = require("vinyl-source-stream");
const buffer = require("vinyl-buffer");
const plumber = require("gulp-plumber");
const gutil = require("gulp-util");
const newer = require("gulp-newer");
const imagemin = require("gulp-imagemin");
const sass = require("gulp-sass");
const postcss = require("gulp-postcss");
const stripdebug = require("gulp-strip-debug");
const uglify = require("gulp-uglify");
const sourcemaps = require("gulp-sourcemaps");
const merge = require("merge-stream");

// The hash is the timestamp when the task runs.
const hash = new Date().getTime();

// Browser-sync
var browsersync = false;
// // source and build folders
const dir = {
  src: "src/",
  build: "dist/",
};

// image settings
const images = {
  src: dir.src + "images/**/*",
  build: dir.build + "images/",
};
// image processing
gulp.task("images", () => {
  return (
    gulp
      .src(images.src)
      .pipe(plumber())
      .pipe(newer(images.build))
      // Compress (JPEG, PNG, GIF, SVG, JPG)
      .pipe(
        imagemin([
          imagemin.gifsicle({
            interlaced: true,
          }),
          imagemin.mozjpeg({
            quality: 75,
            progressive: true,
          }),
          imagemin.optipng({
            optimizationLevel: 5,
          }),
          imagemin.svgo({
            plugins: [
              {
                removeViewBox: true,
              },
              {
                cleanupIDs: false,
              },
            ],
          }),
        ])
      )
      .pipe(gulp.dest(images.build))
  );
});

// CSS settings
var css = {
  src: dir.src + "scss/main.scss",
  build: dir.build + "css/",
  sassOpts: {
    outputStyle: "compressed",
    imagePath: images.build,
    precision: 3,
    errLogToConsole: true,
  },
  processors: [
    require("postcss-assets")({
      loadPaths: ["images/"],
      basePath: dir.build,
      baseUrl: dir.build,
    }),
    require("autoprefixer")({
      overrideBrowserslist: ["last 2 versions", "> 2%"],
    }),
    require("css-mqpacker"),
    require("cssnano"),
  ],
};
// CSS processing
gulp.task(
  "css",
  gulp.series(["images"], () => {
    return gulp
      .src(css.src)
      .pipe(plumber())
      .pipe(sourcemaps.init())
      .pipe(sass(css.sassOpts))
      .on("error", console.error.bind(console))
      .pipe(postcss(css.processors))
      .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest(css.build))
      .pipe(browsersync ? browsersync.stream() : gutil.noop());
  })
);

// JavaScript settings
const jsConfigs = [
  {
    filename: "main.min.js",
    src: `${dir.src}js/index.js`,
    build: dir.build + "js/",
  },
];
// JavaScript processing
gulp.task("js", () => {
  const streams = jsConfigs.map((config) =>
    browserify({
      entries: [config.src],
      debug: true,
    })
      .transform(
        babelify.configure({
          presets: ["@babel/preset-env"],
          plugins: ["@babel/plugin-proposal-class-properties"],
        })
      )
      .bundle()
      .pipe(source(config.filename))
      .pipe(buffer())
      .pipe(sourcemaps.init())
      .pipe(stripdebug())
      .pipe(uglify())
      .pipe(sourcemaps.write("./"))
      .pipe(gulp.dest(config.build))
      .pipe(browsersync ? browsersync.stream() : gutil.noop())
  );

  return merge(streams);
});

// // run all tasks
gulp.task("build", gulp.series("css", "js"));

function watch() {
  if (browsersync === false) {
    browsersync = require("browser-sync").create();
    browsersync.init({ proxy: "blazemedia.local/" });
  }
  // page changes
  gulp.watch("./**/*.php").on("change", browsersync.reload);
  // image changes
  // gulp.watch(images.src, gulp.series("images"));
  // CSS changes
  gulp.watch("./src/scss/**/*.scss", gulp.series("css"));
  // JavaScript main change
  gulp.watch("./src/js/**/*.js", gulp.series("js"));
}
gulp.task("watch", watch);
