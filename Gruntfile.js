module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        uglify: {
            build: {
                files: {
                    'build/onkelrudi/public/js/jquery.js': [
                        'public/bower_components/jquery/dist/jquery.js'
                    ],
                    'build/onkelrudi/public/js/onkelrudi.js': [
                        'public/js/onkelrudi.js'
                    ]
                }
            }
        },
        cssmin: {
            build: {
                files: {
                    'build/onkelrudi/public/css/onkelrudi.css': [
                        'public/css/onkelrudi.css'
                    ],
                    'build/onkelrudi/public/css/onkelrudi-old-ie.css': [
                        'public/css/onkelrudi-old-ie.css'
                    ]
                }
            }
        },
        htmlmin: {
            build: {
                options: {
                    removeComments: true,
                    collapseWhitespace: true,
                    minifyJS: true
                },
                files: {
                    'build/onkelrudi/public/templates/index.html': [
                        'public/templates/index.html'
                    ]
                }
            },
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-htmlmin');

    // Default task(s).
    grunt.registerTask('default', 'Deploy onkelrudi frontend.', function() {
        grunt.log.write('Starting build of frontend...');
        grunt.task.run('cssmin');
        grunt.task.run('uglify');
        grunt.task.run('htmlmin');
        grunt.log.ok();
    });
};