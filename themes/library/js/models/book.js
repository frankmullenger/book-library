
define(["backbone"], function(Backbone) {

	var Book = Backbone.Model.extend({
    defaults: {
      coverImage: 'themes/library/img/placeholder.png',
      title: 'No title',
      author: 'Unknown',
      releaseDate: 'Unknown',
      keywords: 'None'
    },
    
    // Edit a server response before it is passed to the Model constructor
    parse: function( response ) {

    	// Map _id from server to id on model, so Backbone knows this is an existing model
    	// when actions like "delete" are done Backbone knows to sync with the server if id is present
	    response.id = response.ID;
	    response.title = response.Title;
	    response.author = response.Author;
	    response.releaseDate = response.ReleaseDate;
	    
	    return response;
		}
	});
	return Book;
});