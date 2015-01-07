module.exports = function (grunt) {


    grunt.initConfig({


        browserify: {
            options: {
                transform: ['debowerify']
            },
            frontend: {
                options: {
                    debug: false
                },


                src: 'resources/scripts/frontend/main.js',
                dest: 'resources/scripts/frontend.js'
            },
            backend: {
                options: {
                    debug: false
                },
                src: 'resources/scripts/backend/main.js',
                dest: 'resources/scripts/backend.js'
            }
        },

        'images-convert': {
            'png-resize': {
                imageDirectory: 'resources/images/icons',
                files: 'resources/images/icons/hi-res/*.png',
                destination: 'resources/images/icons/low-res',
                outputSuffix: '_low-res',
                options: {
                    resize: '33.33%'
                }
            }
        },
        sprite: {
            distHiRes: {
                src: ['resources/images/icons/hi-res/*.png'],
                destImg: 'resources/images/icons-hi-res.png',
                destCSS: 'resources/styles/less/icons-hi-res.less',
                cssFormat: 'less',
                imgPath: '../images/icons-hi-res.png',
                algorithm: 'binary-tree',
                'algorithmOpts': {
                    // Skip sorting of images for algorithm (useful for sprite animations)
                    'sort': false
                }
            },
            distLowRes: {
                src: ['resources/images/icons/low-res/*.png'],
                destImg: 'resources/images/icons-low-res.png',
                destCSS: 'resources/styles/less/icons-low-res.less',
                cssFormat: 'less',
                imgPath: '../images/icons-low-res.png',
                algorithm: 'binary-tree',
                'algorithmOpts': {
                    // Skip sorting of images for algorithm (useful for sprite animations)
                    'sort': false
                }
            }
        },
        cssmin: {
            options: {
                processImport: true,
                root: ''
            },
            dist: {

                files: {
                    'resources/styles/frontend.min.css': 'resources/styles/frontend.css',
                    'resources/styles/backend.min.css': 'resources/styles/backend.css'
                }
            }
        },
        less: {
            options: {
                paths: ["resources/styles/less"]

            },
            dist: {
                files: {
                    "resources/styles/frontend.css": "resources/styles/less/frontend.less",
                    "resources/styles/backend.css": "resources/styles/less/backend.less"
                }
            }

        }
    });

    grunt.loadNpmTasks('grunt-browserify');
    grunt.loadNpmTasks('grunt-debug-task');
    grunt.loadNpmTasks('grunt-spritesmith');
    grunt.loadNpmTasks('grunt-contrib-less');
    grunt.loadNpmTasks('grunt-images');
    grunt.loadNpmTasks('grunt-contrib-cssmin');
    grunt.registerTask('default', ['images-convert', 'sprite', 'less', 'cssmin',  'browserify']);
    grunt.registerTask('styles', ['less', 'cssmin']);
    grunt.registerTask('scripts', ['browserify']);
    grunt.registerTask('resources', ['styles', 'scripts']);
};