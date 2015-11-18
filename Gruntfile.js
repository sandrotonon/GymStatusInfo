module.exports = function(grunt) {

    grunt.initConfig({

        connect: {
            server: {
                options: {
                    port: 9001,
                    base: '.'
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
            }
        }

    });

    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-jshint');
    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-connect');

    grunt.registerTask('default', ['less', 'cssmin', 'connect:server', 'watch']);
    grunt.registerTask('build', ['uglify', 'less', 'cssmin']);

};