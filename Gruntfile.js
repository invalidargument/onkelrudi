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
                    'build/onkelrudi/public/js/underscore.js': [
                        'public/bower_components/underscore/underscore.js'
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
                    ],
                    'build/onkelrudi/public/templates/wordpressCategoryOverview.html': [
                        'public/templates/wordpressCategoryOverview.html'
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
                        from: '/public/css/',
                        to: '/css/'
                    },
                    {
                        from: '/public/bower_components/jquery/dist/',
                        to: '/js/'
                    },
                    {
                        from: '/public/',
                        to: '/'
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
                        from: '/public/bower_components/pickadate/lib/compressed/themes/',
                        to: '/css/pickadate/'
                    },
                    {
                        from: '/public/bower_components/underscore/',
                        to: '/js/'
                    },
                    {
                        from: '/public/bower_components/pickadate/lib/compressed/',
                        to: '/js/pickadate/'
                    },
                    {
                        from: '/public/bower_components/moment/min/',
                        to: '/js/'
                    },
                    {
                        from: '/public/css/',
                        to: '/css/'
                    },
                    {
                        from: '/public/bower_components/jquery/dist/',
                        to: '/js/'
                    },
                    {
                        from: '/public/',
                        to: '/'
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
                        from: '/public/css/',
                        to: '/css/'
                    },
                    {
                        from: '/public/bower_components/jquery/dist/',
                        to: '/js/'
                    },
                    {
                        from: '/public/',
                        to: '/'
                    }
                ]
            },
            wordpressCategoryHtmlPaths: {
                src: ['build/onkelrudi/public/templates/wordpressCategoryOverview.html'],
                dest: 'build/onkelrudi/public/templates/wordpressCategoryOverview.html',
                replacements: [
                    {
                        from: '/public/bower_components/pure/',
                        to: '/css/'
                    },
                    {
                        from: '/public/css/',
                        to: '/css/'
                    },
                    {
                        from: '/public/bower_components/jquery/dist/',
                        to: '/js/'
                    },
                    {
                        from: '/public/',
                        to: '/'
                    }
                ]
            },
            htaccessPaths: {
                src: ['build/onkelrudi/public/.htaccess'],
                dest: 'build/onkelrudi/public/.htaccess',
                replacements: [
                    {
                        from: '#RewriteBase /',
                        to: 'RewriteBase /'
                    }
                ]
            }
        }
    });

    grunt.registerTask('copyCssFiles', 'Copy all relevant CSS files.', function() {
        var sourceDir = 'public/bower_components/';
        var targetDir = 'build/onkelrudi/public/';

        /* pure css */
        grunt.file.copy(sourceDir + 'pure/pure-min.css', targetDir + 'css/pure-min.css');
        grunt.file.copy(sourceDir + 'pure/grids-responsive-old-ie-min.css', targetDir + 'css/grids-responsive-old-ie-min.css');
        grunt.file.copy(sourceDir + 'pure/grids-responsive-min.css', targetDir + 'css/grids-responsive-min.css');

        /* pickadate css */
        grunt.file.copy(sourceDir + 'pickadate/lib/compressed/themes/default.css', targetDir + 'css/pickadate/default.css');
        grunt.file.copy(sourceDir + 'pickadate/lib/compressed/themes/default.date.css', targetDir + 'css/pickadate/default.date.css');
        grunt.file.copy(sourceDir + 'pickadate/lib/compressed/themes/default.time.css', targetDir + 'css/pickadate/default.time.css');
        grunt.log.ok();
    });

    grunt.registerTask('copyJsFiles', 'Copy all relevant JS files.', function() {
        var sourceDir = 'public/bower_components/';
        var targetDir = 'build/onkelrudi/public/';

        grunt.file.copy(sourceDir + 'moment/min/moment-with-locales.min.js', targetDir + 'js/moment-with-locales.min.js');
        grunt.file.copy(sourceDir + 'pickadate/lib/compressed/picker.js', targetDir + 'js/pickadate/picker.js');
        grunt.file.copy(sourceDir + 'pickadate/lib/compressed/picker.date.js', targetDir + 'js/pickadate/picker.date.js');
        grunt.file.copy(sourceDir + 'pickadate/lib/compressed/picker.time.js', targetDir + 'js/pickadate/picker.time.js');
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
        grunt.task.run('copyJsFiles');
        grunt.task.run('cssmin');
        grunt.task.run('uglify');
        grunt.task.run('htmlmin');
        grunt.task.run('replace');
        grunt.log.ok();
    });
};