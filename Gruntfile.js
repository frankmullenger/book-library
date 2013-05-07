module.exports = function(grunt){
  grunt.initConfig({
    pkg: grunt.file.readJSON('package.json'),

    // custom task to minify the css
    cssmin: {
		  minify: {
		    expand: true,
		    cwd: 'themes/library/css/',
		    src: ['*.css', '!*.min.css'],
		    dest: 'themes/library/css/',
		    ext: '.min.css'
		  }
		}
  });

  // load contrib task files
  // note: these should be installed from npm
  grunt.loadNpmTasks('grunt-contrib-cssmin');

  // register what to do when using the default 'grunt' command
  grunt.registerTask('default', ['cssmin']);
};