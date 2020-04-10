EasyBlog.ready(function($){
	$('[data-show-all-authors]').on('click', function() {

		$('[data-author-item]').each(function() {
			$(this).find('img').attr('src', $(this).data('src'));

			$(this).removeClass('hide');
		});

		// Hide the button block
		$(this).addClass('hide');
	});
});
