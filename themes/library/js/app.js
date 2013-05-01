var app = app || {};

//Change template tags so underscore does not clash with SilverStripe
// _.templateSettings = { 
// 	interpolate : /\{\{(.+?)\}\}/g  // {{ title }}
// };
// _.templateSettings = {
//   evaluate:    /\{\{#([\s\S]+?)\}\}/g,            // {{# console.log("blah") }}
//   interpolate: /\{\{[^#\{]([\s\S]+?)[^\}]\}\}/g,  // {{ title }}
//   escape:      /\{\{\{([\s\S]+?)\}\}\}/g,         // {{{ title }}}
// }
_.templateSettings = {
  evaluate    : /\{\{([\s\S]+?)\}\}/g,  // {{ console.log('blah') }}
  interpolate : /\{\{=([\s\S]+?)\}\}/g, // {{= title }}
  escape      : /\{\{-([\s\S]+?)\}\}/g  // {{- title }} with < > & etc. escaped
};


// TODO: Is there a problem with this, once DOM is loaded are other JS files and objects created always?
$(function() {
	
	$( '#releaseDate' ).datepicker();
	new app.LibraryView();

	// var books = [
	//     { title: 'JavaScript: The Good Parts', author: 'Douglas Crockford', releaseDate: '2008', keywords: 'JavaScript Programming' },
	//     { title: 'The Little Book on CoffeeScript', author: 'Alex MacCaw', releaseDate: '2012', keywords: 'CoffeeScript Programming' },
	//     { title: 'Scala for the Impatient', author: 'Cay S. Horstmann', releaseDate: '2012', keywords: 'Scala Programming' },
	//     { title: 'American Psycho', author: 'Bret Easton Ellis', releaseDate: '1991', keywords: 'Novel Splatter' },
	//     { title: 'Eloquent JavaScript', author: 'Marijn Haverbeke', releaseDate: '2011', keywords: 'JavaScript Programming' }
	// ];

	// new app.LibraryView( books );
});