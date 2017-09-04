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
                    ],
                    'build/onkelrudi/public/css/cookieconsent.css': [
                        'public/css/cookieconsent.css'
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
                    'build/onkelrudi/public/templates/createFleaMarket.html': [
                        'public/templates/createFleaMarket.html'
                    ],
                    'build/onkelrudi/public/templates/error.html': [
                        'public/templates/error.html'
                    ],
                    'build/onkelrudi/public/templates/about.html': [
                        'public/templates/about.html'
                    ],
                    'build/onkelrudi/public/templates/impressum.html': [
                        'public/templates/impressum.html'
                    ],
                    'build/onkelrudi/public/templates/fleaMarketDate.html': [
                        'public/templates/fleaMarketDate.html'
                    ],
                    'build/onkelrudi/public/templates/index.html': [
                        'public/templates/index.html'
                    ],
                    'build/onkelrudi/public/templates/password.html': [
                        'public/templates/password.html'
                    ],
                    'build/onkelrudi/public/templates/loginRegister.html': [
                        'public/templates/loginRegister.html'
                    ],
                    'build/onkelrudi/public/templates/logout.html': [
                        'public/templates/logout.html'
                    ],
                    'build/onkelrudi/public/templates/profile.html': [
                        'public/templates/profile.html'
                    ],
                    'build/onkelrudi/public/templates/unauthorized.html': [
                        'public/templates/unauthorized.html'
                    ],
                    'build/onkelrudi/public/templates/wordpressCategoryOverview.html': [
                        'public/templates/wordpressCategoryOverview.html'
                    ],
                    'build/onkelrudi/public/templates/wordpressPostDetail.html': [
                        'public/templates/wordpressPostDetail.html'
                    ]
                }
            },
        },
        replace: {
            createFleaMarketHtmlPaths: {
                src: ['build/onkelrudi/public/templates/createFleaMarket.html'],
                dest: 'build/onkelrudi/public/templates/createFleaMarket.html',
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
                        from: '/public/bower_components/mustache/',
                        to: '/js/'
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
            errorHtmlPaths: {
                src: ['build/onkelrudi/public/templates/error.html'],
                dest: 'build/onkelrudi/public/templates/error.html',
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
            aboutHtmlPaths: {
                src: ['build/onkelrudi/public/templates/about.html'],
                dest: 'build/onkelrudi/public/templates/about.html',
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
                        from: '/public/bower_components/cookieconsent2/build/',
                        to: '/js/'
                    },
                    {
                        from: '/public/',
                        to: '/'
                    }
                ]
            },
            impressumHtmlPaths: {
                src: ['build/onkelrudi/public/templates/impressum.html'],
                dest: 'build/onkelrudi/public/templates/impressum.html',
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
                        from: '/public/bower_components/cookieconsent2/build/',
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
                        from: '/public/bower_components/cookieconsent2/build/',
                        to: '/js/'
                    },
                    {
                        from: '/public/',
                        to: '/'
                    }
                ]
            },
            loginRegisterHtmlPaths: {
                src: ['build/onkelrudi/public/templates/loginRegister.html'],
                dest: 'build/onkelrudi/public/templates/loginRegister.html',
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
            passwordHtmlPaths: {
                src: ['build/onkelrudi/public/templates/password.html'],
                dest: 'build/onkelrudi/public/templates/password.html',
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
            logoutHtmlPaths: {
                src: ['build/onkelrudi/public/templates/logout.html'],
                dest: 'build/onkelrudi/public/templates/logout.html',
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
            profileHtmlPaths: {
                src: ['build/onkelrudi/public/templates/profile.html'],
                dest: 'build/onkelrudi/public/templates/profile.html',
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
            unauthorizedHtmlPaths: {
                src: ['build/onkelrudi/public/templates/unauthorized.html'],
                dest: 'build/onkelrudi/public/templates/unauthorized.html',
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
            wordpressPostDetailHtmlPaths: {
                src: ['build/onkelrudi/public/templates/wordpressPostDetail.html'],
                dest: 'build/onkelrudi/public/templates/wordpressPostDetail.html',
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
                        from: '#',
                        to: ''
                    },
                    {
                        from: 'XXX',
                        to: '#'
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
        grunt.file.copy(sourceDir + 'mustache/mustache.min.js', targetDir + 'js/mustache.min.js');
        grunt.file.copy(sourceDir + 'underscore/underscore-min.js', targetDir + 'js/underscore-min.js');
        grunt.file.copy(sourceDir + 'pickadate/lib/compressed/picker.js', targetDir + 'js/pickadate/picker.js');
        grunt.file.copy(sourceDir + 'pickadate/lib/compressed/picker.date.js', targetDir + 'js/pickadate/picker.date.js');
        grunt.file.copy(sourceDir + 'pickadate/lib/compressed/picker.time.js', targetDir + 'js/pickadate/picker.time.js');
        grunt.file.copy(sourceDir + 'cookieconsent2/build/cookieconsent.min.js', targetDir + 'js/cookieconsent.min.js');
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