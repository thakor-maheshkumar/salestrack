/**
 * uglify.js
 *
 * Uglifies javascript files
 *
 * @package grunt
 * @subpackage tasks
 */

module.exports = function(grunt) {
    grunt.config('uglify', {
        options: {
            mangle: false
        },
        dist: {
            files: {
                '<%=paths.js%>build.js': '<%=paths.js%>build.js'
            }
        }
    });

    grunt.loadNpmTasks('grunt-contrib-uglify');
};
