"use strict";

const { src, dest, watch } = require("gulp");
const gulp = require("gulp");
const sass = require("gulp-sass")(require("node-sass"));
const concat = require("gulp-concat");
const rename = require("gulp-rename");
const cssmin = require("gulp-css");
const uglify = require("gulp-uglify");

function compileSass(done) {
  src("assets/src/scss/main.scss")
    .pipe(sass().on("error", sass.logError))
    .pipe(dest("assets/src/css"));
  done();
}

exports.compileSass = compileSass;

function compileCSS(done) {
  setTimeout(function () {
    src(["assets/src/css/main.css"])
      .pipe(concat("app.css"))
      .pipe(rename({ suffix: ".min" }))
      .pipe(cssmin())
      .pipe(dest("assets/dist/css"));
    done();
  }, 300);
}

exports.compileCSS = compileCSS;

function compileJS(done) {
  src(["assets/src/js/main.js"])
    .pipe(concat("app.js"))
    .pipe(rename({ suffix: ".min" }))
    .pipe(uglify())
    .pipe(dest("assets/dist/js/"));
  done();
}

exports.compileJS = compileJS;

function watchAll() {
  watch("assets/src/scss/**/*.scss", gulp.series(compileSass, compileCSS));
  watch("assets/src/js/*.js", compileJS);
}

exports.watchAll = watchAll;

gulp.task("default", gulp.series(compileSass, compileCSS, compileJS));
