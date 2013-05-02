require.config({
	baseUrl: 'themes/library/js/',
  paths: {
  	'jquery': 'lib/jquery',
    'underscore': 'lib/underscore',
    'backbone': 'lib/backbone',
    'ui': 'lib/jquery-ui-1.10.2.custom',
    'dateformat': 'lib/jquery.dateFormat-1.0',
    'text': 'lib/text',
  },
  shim: {
	  'underscore': {
	    exports: '_',
	    init: function () {
	    	//Alter underscore so that templateSettings are changed
        this._.templateSettings = {
				  evaluate    : /\{\{([\s\S]+?)\}\}/g,  // {{ console.log('blah') }}
				  interpolate : /\{\{=([\s\S]+?)\}\}/g, // {{= title }}
				  escape      : /\{\{-([\s\S]+?)\}\}/g  // {{- title }} with < > & etc. escaped
				};
        return _;
      }
	  },
	  'backbone': {
      deps: ['underscore', 'jquery'],
      exports: 'Backbone'
	  }
  }
});

require(
  ["jquery",
    "underscore",
    "backbone",
    "views/library",
    "ui",
    "dateformat"
  ],
  function($, _, Backbone, LibraryView) {

    $(function() {

      $( '#releaseDate' ).datepicker();
			new LibraryView();

			// var books = [
			//     { title: 'JavaScript: The Good Parts', author: 'Douglas Crockford', releaseDate: '2008', keywords: 'JavaScript Programming' },
			//     { title: 'The Little Book on CoffeeScript', author: 'Alex MacCaw', releaseDate: '2012', keywords: 'CoffeeScript Programming' },
			//     { title: 'Scala for the Impatient', author: 'Cay S. Horstmann', releaseDate: '2012', keywords: 'Scala Programming' },
			//     { title: 'American Psycho', author: 'Bret Easton Ellis', releaseDate: '1991', keywords: 'Novel Splatter' },
			//     { title: 'Eloquent JavaScript', author: 'Marijn Haverbeke', releaseDate: '2011', keywords: 'JavaScript Programming' }
			// ];
			// new app.LibraryView( books );
    });
  }
);
