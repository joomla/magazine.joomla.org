<?php
/**
* @package  EasyBlog
* @copyright Copyright (C) 2010 - 2018 Stack Ideas Sdn Bhd. All rights reserved.
* @license  GNU/GPL, see LICENSE.php
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

<div class="eb-posts <?php echo $this->isMobile() ? 'is-mobile' : '';?>" data-blog-posts>
	<!-- @module: easyblog-before-pagination -->
	<?php echo EB::renderModule('easyblog-before-entries');?>

	<?php if ($posts) { ?>
		<?php foreach ($posts as $post) { ?>

			<!-- Determine if post custom fields should appear or not in category listings -->
			<?php if (!$this->params->get('category_post_customfields')) { ?>
				<?php $post->fields = '';?>
			<?php } ?>

			<?php if (!EB::isSiteAdmin() && $this->config->get('main_password_protect') && !empty($post->blogpassword) && !$post->verifyPassword()) { ?>
				<?php echo $this->output('site/blogs/latest/default.protected', array('post' => $post, 'index' => 1, 'currentPageLink' => '')); ?>
			<?php } else { ?>
				<?php echo $this->output('site/blogs/latest/default.main', array('post' => $post, 'index' => 1, 'currentPageLink' => '')); ?>
			<?php } ?>
		<?php } ?>
	<?php } else { ?>

		<?php if ($this->my->guest && $category->private == 1) { ?>
			<div class="eb-empty">
				<i class="fa fa-info-circle"></i>
				<?php echo JText::_('COM_EASYBLOG_CATEGORIES_FOR_REGISTERED_USERS_ONLY');?>
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
</div>

<?php if($pagination) {?>
	<!-- @module: easyblog-before-pagination -->
	<?php echo EB::renderModule('easyblog-before-pagination'); ?>

	<!-- Pagination items -->
	<?php echo $pagination;?>

	<!-- @module: easyblog-after-pagination -->
	<?php echo EB::renderModule('easyblog-after-pagination'); ?>
<?php } ?>
