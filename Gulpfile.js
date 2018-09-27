'use strict';

var gulp = require('gulp'),
    toolkit = require('gulp-wp-plugin-toolkit');

toolkit.extendConfig({
    project: {
        name: 'Display Related Posts for Genesis',
        version: '1.0.0',
        textdomain: 'display-related-posts-genesis'
    },
    scss: {
        'style': {
            src: 'assets/scss/front-end.scss',
            dest: 'assets/css/',
            outputStyle: 'compressed'
        }
    },
});

toolkit.extendTasks(gulp, { /* Gulp task overrides. */ });