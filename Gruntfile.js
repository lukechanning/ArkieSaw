module.exports = function(grunt) {

  grunt.initConfig({
    //Makepot
    makepot: {
        target: {
            options: {
                include: [
                    'arkiesaw.pot'
                ],
                type: 'wp-plugin',
            }
        }
    },
    
    //Uglify
    uglify: {
        dist: {
            options: {
            },
            files: {
                'assets/arkiesaw.min.js' : [
                    'assets/js/*.js'
                ]
            }
        }
    },
    
    //Handle SCSS
    sass: {
        dist: {
            options: {
                outputStyle: 'compressed',
                sourceMap: true,
            },
            files: {
                'assets/arkiesaw.css': 'assets/scss/*.scss',
            }
        }
    },
    
    //Who watches the watchmmen?
     watch: {
        grunt: {
            options: {
                reload: true
            },
            files: ['Gruntfile.js']
        },

        sass: {
            files: 'assets/scss/*.scss',
            tasks: ['sass']
        }, 
        uglify: {
            files: 'assets/js/*.js',
            tasks: ['uglify']
        }
    },

 });

grunt.loadNpmTasks( 'grunt-wp-i18n' );
grunt.loadNpmTasks('grunt-contrib-uglify');
grunt.loadNpmTasks('grunt-sass');
grunt.loadNpmTasks('grunt-contrib-watch');

//To use Compass instead of lib-sass, uncomment this line and comment out the one below it:
//grunt.registerTask('style', ['compass']);
grunt.registerTask('style', ['sass']);

grunt.registerTask('build', ['style', 'uglify', 'copy']);
grunt.registerTask('default', ['style', 'uglify', 'watch']);

};