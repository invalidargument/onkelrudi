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
                    ],
                    'build/onkelrudi/public/templates/admin.html': [
                        'public/templates/admin.html'
                    ],
                    'build/onkelrudi/public/templates/fleaMarketDate.html': [
                        'public/templates/fleaMarketDate.html'
                    ]
                }
            },
        },
        replace: {
            indexHtmlPaths: {
                src: ['build/onkelrudi/public/templates/index.html'],
                dest: 'build/onkelrudi/public/templates/index.html',
                replacements: [
                    {
                        from: '/public/bower_components/pure/',
                        to: '/css/'
                    },
                    {
                        from: '/public/bower_components/jquery/dist/',
                        to: '/js/'
                    }
                ]
            },
            adminHtmlPaths: {
                src: ['build/onkelrudi/public/templates/admin.html'],
                dest: 'build/onkelrudi/public/templates/admin.html',
                replacements: [
                    {
                        from: '/public/bower_components/pure/',
                        to: '/css/'
                    },
                    {
                        from: '/public/bower_components/jquery/dist/',
                        to: '/js/'
                    }
                ]
            },
            fleaMarketDateHtmlPaths: {
                src: ['build/onkelrudi/public/templates/fleaMarketDate.html'],
                dest: 'build/onkelrudi/public/templates/fleaMarketDate.html',
                replacements: [
                    {
                        from: '/public/bower_components/pure/',
                        to: '/css/'
                    },
                    {
                        from: '/public/bower_components/jquery/dist/',
                        to: '/js/'
                    }
                ]
            }
        }
    });

    grunt.registerTask('copyCssFiles', 'Copy all relevant CSS files.', function() {
        var sourceDir = 'public/bower_components/';
        var targetDir = 'build/onkelrudi/public/';

        grunt.file.copy(sourceDir + 'pure/pure-min.css', targetDir + 'css/pure-min.css');
        grunt.file.copy(sourceDir + 'pure/grids-responsive-old-ie-min.css', targetDir + 'css/grids-responsive-old-ie-min.css');
        grunt.file.copy(sourceDir + 'pure/grids-responsive-min.css', targetDir + 'css/grids-responsive-min.css');
        grunt.log.ok();
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.loadNpmTasks('grunt-contrib-htmlmin');
    grunt.loadNpmTasks('grunt-text-replace');

    // Default task(s).
    grunt.registerTask('default', 'Deploy onkelrudi frontend.', function() {
        grunt.log.write('Starting build of frontend...');
        grunt.task.run('copyCssFiles');
        grunt.task.run('cssmin');
        grunt.task.run('uglify');
        grunt.task.run('htmlmin');
        grunt.task.run('replace');
        grunt.log.ok();
    });
};