EasyBlog.ready(function($){

	// Prevent closing
	$(document).on('click.toolbar', '[data-eb-toolbar-dropdown]', function(event) {
		event.stopPropagation();
	});

	// Logout
	$(document).on('click', '[data-blog-toolbar-logout]', function(event) {
		$('[data-blog-logout-form]').submit();
	});

	// Search
	$(document)
		.off('click.search.toggle')
		.on('click.search.toggle', '[data-eb-toolbar-search-toggle]', function() {
			var searchBar = $('[data-eb-toolbar-search]');
			var ebToolBar = $('[data-eb-toolbar]');

			ebToolBar.toggleClass('eb-toolbar--search-on');
		});

});
