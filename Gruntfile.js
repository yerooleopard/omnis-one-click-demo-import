module.exports = function(grunt){

	// Configuration
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		compress: {
		  	main: {
			    options: {
			      	archive: '_zip/<%= pkg.name %>.zip'
			    },
				files: [{
	                expand: true,
	                src: ['**/**', 
	                	'!node_modules/**',
	                	'!.sass-cache',
						'!.vscode',
						'!.gitignore',
						'!.git',
	                	'!<%= pkg.name %>.zip',
						'!package-lock.json',
	                	'!_zip/**',
	                	'!_toRemove/**'
	                ],
	                dest: '<%= pkg.name %>/'
                }]
		  	}
		},		

	});

	// Load plugins
	grunt.loadNpmTasks('grunt-contrib-compress');

	// Register Task
	grunt.registerTask('default', ['compress']);
	grunt.registerTask('zip', ['compress']);


};	