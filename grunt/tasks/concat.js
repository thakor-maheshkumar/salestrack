/**
 * concat.js
 *
 * Concats all the javascripts into single file
 *
 * @package grunt
 * @subpackage tasks
 */

module.exports = function(grunt) {
    grunt.config('concat', {
        options: {
            separator: ';',
        },
        dist: {
            files: {
                '<%=paths.js%>/build.js': [
                    '<%=paths.bower%>jquery/dist/jquery.js',
                    '<%=paths.bower%>jquery-ui/jquery-ui.js',
                    '<%=paths.bower%>moment/moment.js',
                    '<%=paths.bower%>popper.js/dist/umd/popper.js',
                    '<%=paths.bower%>bootstrap/dist/js/bootstrap.js',
                    '<%=paths.bower%>jquery-validation/dist/jquery.validate.js',
                    '<%=paths.js_source%>library/**/*.js',
                    '<%=paths.js_source%>theme/**/*.js',
                    '<%=paths.js_source%>app/*.js'
                ]
            },
        }
    });

    grunt.loadNpmTasks('grunt-contrib-concat');
};
