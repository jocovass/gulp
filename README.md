## Dependencies
- `@babel/core` Core Babel Compiler
- `@babel/present-env` Tells Babel how to transpile your code for browser support
- `gulp` The build toolkit
- `gulp-babel` Gulp plugin for working with Babel
- `gulp-plumber` Error handeling for Gulp
- `gulp-concat` Concatenating multiple source files into a single build file
- `gulp-uglify` is a Gulp plugin that helps us use `UglifyJS` to minify JS code
- `del` for deleting files
- `newer` will pass through only those source files that are newer than corresponding destination files
- `imagemin` compress images
- `sass` process your sass files and creates css
- `postcss` a tool for transforming styles, it takes a CSS file and provides an API to analyze and modify its rules, this API can then be used by other `plugins` to do a lot of useful things.
- `concat` concatenate multiple files
- `stripdebug` strips console, alert and debugger statements from JS
- `gulp-uglify` minifies JS with UglifyJS3
- `sourcemaps` creates a 'map' file that maps from the transformed source to the original source enabling the browser to reconstruct the original source and present the reconstructed original in the debugger
- `merge` merges an arbitrary number of streams

gulp manages filse in memory using streams this allows us to pipe tasks together efficiently without having to wait for gulp to write anythig to the disk