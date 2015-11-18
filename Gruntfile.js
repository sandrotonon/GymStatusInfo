/* global module, require */
module.exports = function (grunt) {

    'use strict';

    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // Settings
        config: {
            app: './public'
        },

        uglify: {
            scripts: {
                expand: true,
                cwd: '<%= config.app %>/js',
                src: '**.js',
                dest: '<%= config.app %>/js/dist',
                ext: '.min.js'
            }
        },

        less: {
            styles: {
                files: {
                    '<%= config.app %>/css/styles.css': '<%= config.app %>/less/styles.less'
                }
            }
        },

        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: '<%= config.app %>/css',
                    src: ['*.css', '!*.min.css'],
                    dest: '<%= config.app %>/css/dist',
                    ext: '.min.css'
                }]
            }
        },

        watch: {
            scripts: {
                files: '<%= config.app %>/js/custom/**.js',
                task: 'jshint:scripts'
            },

            styles: {
                files: '<%= config.app %>/less/**.less',
                tasks: ['less', 'cssmin']
            },
        },

        'ftp-deploy': {
            build: {
                auth: {
                    host: 'th9014-web495.vorschau.server15.tophoster.de',
                    port: 21,
                    authKey: 'user'
                },
                src: '<%= config.app %>/',
                dest: '/',
                exclusions: [
                    '.git',
                    '.DS_Store'
                ]
            }        },

    });

    grunt.registerTask('default', ['less', 'cssmin', 'watch']);
    grunt.registerTask('build', ['uglify', 'less', 'cssmin']);
    grunt.registerTask('deploy', ['ftp-deploy']);

};