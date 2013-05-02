
// Basically we are setting the view up like this:
// <div class="bookContainer">
//   <img src="img/placeholder.png"/>
//   <ul>
//     <li>Title</li>
//     <li>Author</li>
//     <li>Release Date</li>
//     <li>Keywords</li>
//   </ul>
//
//   <button class="delete">Delete</button>
// </div>

// Where the div with className is built by el and the template below is injected into it:
// <script id="bookTemplate" type="text/template">
// 	<img src="<%= coverImage %>"/>
// 	<ul>
// 		<li><%= title %></li>
// 		<li><%= author %></li>
// 		<li><%= releaseDate %></li>
// 		<li><%= keywords %></li>
// 	</ul>
//
// 	<button class="delete">Delete</button>
// </script>

define(['backbone', 'text!templates/bookView.html'], function(Backbone, bookView) {
	
	var BookView = Backbone.View.extend({
    tagName: 'div',
    className: 'bookContainer',
    
    // template: _.template( $( '#bookTemplate' ).html() ),
    template: _.template( bookView ),

    render: function() {
      //this.el is what we defined in tagName. use $el to get access to jQuery html() function
      this.$el.html( this.template( this.model.toJSON() ) );

      return this;
    },
    
    events: {
      'click .delete': 'deleteBook'
    },

    deleteBook: function() {
      //Delete model
      this.model.destroy();

      //Delete view
      this.remove();
    }
	});
	return BookView;
});