const { src, dest, watch, series } = require('gulp');

const terser = require('gulp-terser');
const plumber = require('gulp-plumber');


const paths = {
    js: 'src/**/*.js',
};


function js(done) {
    src(paths.js)
        .pipe(plumber())
        .pipe(terser())
        .pipe(dest('./assets/js/build'));
    done();
}

function dev() {
    
    watch(paths.js, js);
}

module.exports = {
    js,
    dev,
    default: series(js, dev),
};