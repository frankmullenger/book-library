
define(["backbone", "collections/library", "views/book"], function(Backbone, Library, BookView) {

	var LibraryView = Backbone.View.extend({
		el: '#books',

		initialize: function() {

			this.collection = new Library();
			
			//When backbone completes the fetch, fires the reset event
			this.collection.fetch({reset: true}); 

			this.listenTo( this.collection, 'add', this.renderBook );
			this.listenTo( this.collection, 'reset', this.render );
		},

		// initialize: function( initialBooks ) {
		//     this.collection = new Library( initialBooks );
		//     this.render();
				
		//     // When the collection is added to (see addBook()) we render the book
		//     this.listenTo( this.collection, 'add', this.renderBook );
		// },

		// render library by rendering each book in its collection
		render: function() {
			this.collection.each(function( item ) {
				this.renderBook( item );
			}, this );
		},

		// render a book by creating a BookView and appending the
		// element it renders to the library's element
		renderBook: function( item ) {
			
			// TODO: Where are we getting item from here? Bit magic getting the item from triggered event? or does that happen often for collections?
			
			var bookView = new BookView({
				model: item
			});
			this.$el.append( bookView.render().el );
		},
		
		events:{
			'click #add':'addBook'
		},
		
		addBook: function( e ) {
			e.preventDefault();

			var formData = {};

			// Loop over inputs in the form, if they have a value then use it as data
			$( '#addBook div' ).children( 'input' ).each( function( i, el ) {
				
				if( $( el ).val() != '' ) {
					
					if( el.id === 'keywords' ) {
						formData[ el.id ] = [];
						
						_.each( $( el ).val().split( ' ' ), function( keyword ) {
							formData[ el.id ].push({ 'keyword': keyword });
						});
					} 
					else if( el.id === 'releaseDate' ) {
						formData[ el.id ] = $( '#releaseDate' ).datepicker( 'getDate' ).getTime();
					} 
					else {
						formData[ el.id ] = $( el ).val();
					}
				}
			});

			// The data collected is used to create a book and add it to the library collection
			// this.collection.add( new Book( formData ) );
			
			// Using .add() doesn't automatically sync with the server, use .create() instead
			// Wait until server responds before adding new model to the collection so that properties named correctly
			// Alternatively, could alter the js that displays the model so that things are formatted correctly e.g using $.format.date
			this.collection.create( formData, {wait: true} );
		},
	});
	return LibraryView;
});