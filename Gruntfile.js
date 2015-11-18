/* global module, require */
module.exports = function (grunt) {

    'use strict';

    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // Settings
        config: {
            app: '.'
        },

        connect: {
            options: {
                port: 9001,
                livereload: 35729,
                base: '<%= config.app %>'
            },
            livereload: {
                options: {
                    open: true,
                    base: [
                        '<%= config.app %>'
                    ]
                }
            }
        },

        uglify: {
            scripts: {
                expand: true,
                cwd: 'js',
                src: '**.js',
                dest: 'js/dist',
                ext: '.min.js'
            }
        },

        less: {
            styles: {
                options: {
                    paths: ['css/styles/']
                },
                files: {
                    'css/styles.css': 'less/styles.less'
                }
            }
        },

        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'css',
                    src: ['*.css', '!*.min.css'],
                    dest: 'css/dist',
                    ext: '.min.css'
                }]
            }
        },

        watch: {
            scripts: {
                files: 'js/custom/**.js',
                task: 'jshint:scripts'
            },

            styles: {
                files: 'less/**.less',
                tasks: ['less', 'cssmin']
            },

            livereload: {
                options: {
                    livereload: '<%= connect.options.livereload %>'
                },
                files: [
                    '<%= config.app %>/{,*/}*.html',
                    '<%= config.app %>/css/{,*/}*.css',
                    '<%= config.app %>/img/{,*/}*'
                ]
            }
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
                    'node_modules',
                    '.DS_Store',
                    '.gitignore',
                    '.ftppass'
                ]
            }
        },

    });

    grunt.registerTask('default', ['less', 'cssmin', 'connect:livereload', 'watch']);
    grunt.registerTask('build', ['uglify', 'less', 'cssmin']);
    grunt.registerTask('deploy', ['ftp-deploy']);

};