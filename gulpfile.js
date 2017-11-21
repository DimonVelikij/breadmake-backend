var gulp        = require('gulp'),
    sass        = require('gulp-sass'),
    concat      = require('gulp-concat'),
    uglify      = require('gulp-uglifyjs'),
    cssnano     = require('gulp-cssnano'),
    rename      = require('gulp-rename'),
    del         = require('del'),
    imagemin    = require('gulp-imagemin'),
    pngquant    = require('imagemin-pngquant'),
    cache       = require('gulp-cache'),
    autoprefixer= require('gulp-autoprefixer');

/*
собираем css из sass
 */
gulp.task('sass', function () {
    return gulp.src('src/Bread/ContentBundle/Resources/public/sass/**/*.sass')
        .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
        .pipe(autoprefixer(['last 15 versions', '> 1%', 'ie 8', 'ie 7'], {cascade: true}))
        .pipe(gulp.dest('src/Bread/ContentBundle/Resources/public/css'));
});

/*
переименование и сжатие css файла
 */
gulp.task('css-libs', ['sass'], function () {
    return gulp.src('src/Bread/ContentBundle/Resources/public/css/libs.css')
        .pipe(cssnano())
        .pipe(rename({suffix: '.min'}))
        .pipe(gulp.dest('src/Bread/ContentBundle/Resources/public/css'));
});

/*
собираем js в один файл и минифицируем его
 */
gulp.task('scripts', function () {
    return gulp.src([
            'src/Bread/ContentBundle/Resources/public/vendor/jquery/dist/jquery.min.js',
            'src/Bread/ContentBundle/Resources/public/vendor/jquery.easing/jquery.easing.min.js',
            'src/Bread/ContentBundle/Resources/public/vendor/fancybox/dist/jquery.fancybox.min.js',
            'src/Bread/ContentBundle/Resources/public/vendor/angular/angular.min.js',
            'src/Bread/ContentBundle/Resources/public/vendor/angular-resource/angular-resource.min.js',
            'src/Bread/ContentBundle/Resources/public/vendor/angular-sanitize/angular-sanitize.min.js',
            'src/Bread/ContentBundle/Resources/public/vendor/angular-messages/angular-messages.min.js',
            'src/Bread/ContentBundle/Resources/public/vendor/angular-ui-mask/dist/mask.min.js',
            'src/Bread/ContentBundle/Resources/public/vendor/lodash/dist/lodash.min.js',
            'src/Bread/ContentBundle/Resources/public/vendor/owl.carousel/dist/owl.carousel.min.js'
        ])
        .pipe(concat('libs.min.js'))
        .pipe(uglify())
        .pipe(gulp.dest('src/Bread/ContentBundle/Resources/public/js'));
});

/*
сжатие изображений c кэшем
 */
gulp.task('img', function () {
    return gulp.src('src/Bread/ContentBundle/Resources/public/images/**/*')
        .pipe(cache(imagemin({
            interlaced: true,
            progressive: true,
            svgoPlugins: [{removeViewBox: false}],
            une: [pngquant()]
        })))
        .pipe(gulp.dest('src/Bread/ContentBundle/Resources/public/images'));
});

/*
ожидание изменений sass
 */
gulp.task('watch', ['css-libs', 'scripts'], function () {
    gulp.watch('src/Bread/ContentBundle/Resources/public/sass/**/*.sass', ['sass']);
});

/*
таска по умолчанию, запускается gulp
 */
gulp.task('default', ['watch']);

/*
очистка кэша изображений, запускать отдельно
 */
gulp.task('clear', function () {
    return cache.clearAll();
});

/*
сборка файлов для прода
 */
gulp.task('build', ['css-libs', 'img', 'scripts'], function () {
    return del.sync([
        'src/Bread/ContentBundle/Resources/public/css/parts',
        'src/Bread/ContentBundle/Resources/public/css/**/*.css',
        '!src/Bread/ContentBundle/Resources/public/css/main.css',
        '!src/Bread/ContentBundle/Resources/public/css/libs.min.css',
        '!src/Bread/ContentBundle/Resources/public/css/bootstrap-grid-3.3.1.min.css'
    ]);
});
