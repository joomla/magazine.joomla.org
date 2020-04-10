<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2019 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<?php if ($this->params->get('category_header', true)) { ?>
		<?php echo $this->html('headers.category', $category, array(
																	'title' => $this->params->get('category_title', true), 
																	'description' => $this->params->get('category_description', true), 
																	'avatar' => $this->params->get('category_avatar', true), 
																	'subcategories' => $this->params->get('category_subcategories', true),
																	'rss' => $this->params->get('category_subscribe_rss', true),
																	'subscription' => $this->params->get('category_subscribe_email', true)
															)
		); ?>
<?php } ?>

<div class="eb-posts eb-blog-grids">
	<!-- @module: easyblog-before-post -->
	<?php echo EB::renderModule('easyblog-before-entries');?>

	<?php if ($posts) { ?>
		<div class="eb-blog-grid">
				<?php foreach ($posts as $post) { ?>
				<div class="eb-blog-grid__item eb-blog-grid__item--<?php echo $gridLayout; ?>">
					<div class="eb-blog-grid__content">
						<?php if ($post->image && $this->params->get('post_image', true) || (!$post->image && $post->usePostImage() && $this->params->get('post_image', true))
		|| (!$post->image && !$post->usePostImage() && $this->params->get('post_image_placeholder', false) && $this->params->get('post_image', true))) { ?>
							<div class="eb-blog-grid__thumb">
								<?php if ($imageLib->isImage($post->getImage())) { ?>
									<a class="eb-blog-grid-image" href="<?php echo $post->getPermalink(); ?>" style="background-image: url('<?php echo $post->getImage('medium');?>');">
										<!-- Featured label -->
										<?php if ($post->isFeatured()) { ?>
										<span class="eb-blog-grid-label">
											<i class="fa fa-bookmark"></i>
										</span>
										<?php } ?>
									</a>
								<?php } else { ?>
									<?php echo $mediaLib->renderVideoPlayer($post->getImage(), $videoOptions, false); ?> 
								<?php } ?> 

							</div>
						<?php } ?>
						<div class="eb-blog-grid__title">
							<a href="<?php echo $post->getPermalink(); ?>"><?php echo $post->title; ?></a>
						</div>

						<!-- Grid meta -->
						<div class="eb-blog-grid__meta eb-blog-grid__meta--text">
							<?php if ($this->params->get('post_author', true)) { ?>
							<div class="eb-blog-grid-author">
								<a href="<?php echo $post->getAuthorPermalink(); ?>"><?php echo $post->getAuthorName(); ?></a>
							</div>
							<?php } ?>

							<?php if ($this->params->get('post_category', true)) { ?>
							<div class="eb-blog-grid-category">
								<a href="<?php echo $post->getPrimaryCategory()->getPermalink();?>"><?php echo $post->getPrimaryCategory()->title;?></a>
							</div>
							<?php } ?>
						</div>
						<div class="eb-blog-grid__body">
							<?php echo $post->getIntro(); ?>
						</div>
						<?php if ($this->params->get('post_date', true)) { ?>
						<div class="eb-blog-grid__foot">
							<time class="eb-blog-grid-meta-date">
								<?php echo $post->getDisplayDate()->format(JText::_('DATE_FORMAT_LC1')); ?>
							</time>
						</div>
						<?php } ?>
					</div>
				</div>
				<?php } ?>
		</div>
	<?php } else { ?>
			<?php if ($category->private == 2 && !$allowCat) { ?> 
			<div class="eb-empty">
				<i class="fa fa-info-circle"></i>
				<?php echo JText::_('COM_EASYBLOG_CATEGORIES_NOT_ALLOWED');?>
			</div>
		<?php } elseif ($category->private == 2 && !$allowCat) { ?>
			<div class="eb-empty">
				<i class="fa fa-info-circle"></i>
				<?php echo JText::_('COM_EASYBLOG_CATEGORIES_NOT_ALLOWED');?>
			</div>
		<?php } else { ?>
			<div class="eb-empty">
				<i class="fa fa-info-circle"></i>
				<?php echo JText::_('COM_EASYBLOG_NO_BLOG_ENTRY');?>
			</div>
		<?php } ?>
	<?php } ?> 
	<!-- @module: easyblog-after-entries -->
	<?php echo EB::renderModule('easyblog-after-entries'); ?>

	<?php if ($pagination) { ?>
	<!-- @module: easyblog-before-pagination -->
	<?php echo EB::renderModule('easyblog-before-pagination'); ?>

		<?php echo $pagination;?>

	<!-- @module: easyblog-after-pagination -->
	<?php echo EB::renderModule('easyblog-after-pagination'); ?>
	<?php } ?>
</div>