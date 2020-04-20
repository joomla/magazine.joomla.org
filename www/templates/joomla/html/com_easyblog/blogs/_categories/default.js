
EasyBlog.ready(function($){

	$('[data-more-categories-link]').on('click', function() {
		$(this).hide();
		$('[data-more-categories]').css('display', 'inline');
	});

	$('[data-tab-author]').on('click', function() {
		var categoryId = $(this).data('category-id');

		// check if content already loaded or not.
		var authors = $(this).closest('[data-category-wrapper]').find('[data-author-item]').length;
		if (authors > 0) {
			return;
		}

		EasyBlog.ajax('site/views/categories/getAuthors', {
			"id" : categoryId
		})
		.done(function(output) {
			// hide loader
			$('#authors-' + categoryId + ' i').addClass('hidden');

			if (output != '') {
				$('#authors-' + categoryId).html(output);
			}
		});
	});

	// Simulate click when recent posts disabled but authors enabled
	<?php if (!$this->params->get('category_posts', true) && $this->params->get('category_authors', true)) { ?>
		$('[data-tab-author]').click();
	<?php } ?>
	
});
