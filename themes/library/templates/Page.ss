<!DOCTYPE html>

<html lang="$ContentLocale">

<head>
	<% base_tag %>
	<title>$Title - $SiteConfig.Title</title>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<link rel="stylesheet" href="{$ThemeDir}/css/screen.css">
	<link rel="stylesheet" href="{$ThemeDir}/css/cupertino/jquery-ui-1.10.2.custom.css">
</head>

<body>

	<div id="books">
		<form id="addBook" action="#">
			<div>
				<!-- <label for="coverImage">CoverImage: </label><input id="coverImage" type="file" /> -->
				<label for="title">Title: </label><input id="title" type="text" />
				<label for="author">Author: </label><input id="author" type="text" />
				<label for="releaseDate">Release date: </label><input id="releaseDate" type="text" />
				<label for="keywords">Keywords: </label><input id="keywords" type="text" />
				<button id="add">Add</button>
			</div>
		</form>
		
		<!-- 			
		<div class="bookContainer">
		    <img src="img/placeholder.png"/>
		    <ul>
		        <li>Title</li>
		        <li>Author</li>
		        <li>Release Date</li>
		        <li>Keywords</li>
		    </ul>

		    <button class="delete">Delete</button>
		</div> 
		-->
	</div>
	
	<script id="bookTemplate" type="text/template">
		<img src="{{= coverImage }}"/>
		<ul>
			<li>{{= title }}</li>
			<li>{{= author }}</li>
			<li>{{= releaseDate }}</li>
			<li>{{ _.each( keywords, function( keyobj ) { }} {{= keyobj.Keyword }} {{ } ); }}</li>
		</ul>

		<button class="delete">Delete</button>
	</script>
	
	
	<script src="{$ThemeDir}/js/lib/jquery.js"></script>
	<script src="{$ThemeDir}/js/lib/underscore.js"></script>
	<script src="{$ThemeDir}/js/lib/backbone.js"></script>
	<script src="{$ThemeDir}/js/lib/jquery.dateFormat-1.0.js"></script>
	<script src="{$ThemeDir}/js/lib/jquery-ui-1.10.2.custom.js"></script>
	
	<script src="{$ThemeDir}/js/app.js"></script>
	<script src="{$ThemeDir}/js/models/book.js"></script>
	<script src="{$ThemeDir}/js/collections/library.js"></script>
	<script src="{$ThemeDir}/js/views/book.js"></script>
	<script src="{$ThemeDir}/js/views/library.js"></script>

</body>
</html>
