"use strict";

const { src, dest, watch } = require("gulp");
const gulp = require("gulp");
const sass = require("gulp-sass")(require("sass"));
const concat = require("gulp-concat");
const rename = require("gulp-rename");
const cssmin = require("gulp-css");
const uglify = require("gulp-uglify");

function compileSass() {
  return src("assets/src/scss/main.scss")
    .pipe(sass().on("error", sass.logError))
    .pipe(dest("assets/src/css"));
}

function compileCSS(done) {
  // Use a return or done() to handle the async task correctly
  src(["assets/src/css/main.css"])
    .pipe(concat("app.css"))
    .pipe(rename({ suffix: ".min" }))
    .pipe(cssmin())
    .pipe(dest("assets/dist/css"));
  done();
}

function compileJS() {
  return src(["assets/src/js/main.js"])
    .pipe(concat("app.js"))
    .pipe(rename({ suffix: ".min" }))
    .pipe(uglify())
    .pipe(dest("assets/dist/js/"));
}

function watchAll() {
  watch("assets/src/scss/**/*.scss", gulp.series(compileSass, compileCSS));
  watch("assets/src/js/*.js", compileJS);
}

exports.compileSass = compileSass;
exports.compileCSS = compileCSS;
exports.compileJS = compileJS;
exports.watchAll = watchAll;

gulp.task("default", gulp.series(compileSass, compileCSS, compileJS));
