/**
 * sass.js
 *
 * Generates stylesheets using sass
 *
 * @package grunt
 * @subpackage tasks
 */
const sass = require('node-sass');

module.exports = function(grunt) {
    grunt.loadNpmTasks('grunt-sass');
    
    grunt.config('sass', {
        options: {
            implementation: sass,
            includePaths: [
            '<%=paths.bower%>bootstrap/scss',
            '<%=paths.bower%>font-awesome-sass/assets/stylesheets'
            ]
        },
        dist: {
            options: {
                outputStyle: 'nested',
                compass: true,
                cacheLocation: './cache/'
            },
            files: {
                '<%=paths.css%>style.css': '<%=paths.scss%>style.scss',
                '<%=paths.css%>pdf.css': '<%=paths.scss%>pdf/pdf_style.scss'
            }
        }
    });

};
