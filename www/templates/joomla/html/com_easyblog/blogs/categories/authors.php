<?php
/**
* @package      EasyBlog
* @copyright    Copyright (C) 2010 - 2018 Stack Ideas Sdn Bhd. All rights reserved.
* @license      GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Restricted access');
?>
<?php $i = 0; ?>
<?php foreach ($authors as $author) { ?>
	<div class="eb-stats-author row-table<?php echo $i >= $limitAuthor ? ' hide' : '';?>" data-author-item data-src="<?php echo $author->getAvatar(); ?>">
		<?php if ($this->config->get('layout_avatar')) { ?>
		<a class="col-cell" href="<?php echo $author->getProfileLink(); ?>" title="<?php echo $author->getName(); ?>" class="eb-avatar">
			<img
				<?php if ($i <= $limitAuthor) { ?>
				src="<?php echo $author->getAvatar(); ?>"
				<?php } ?>
				alt="<?php echo $this->html('string.escape', $author->getName()); ?>"
				width="64"
				height="64"
				alt="<?php echo $author->getName(); ?>"
			/>
		</a>
		<?php } ?>

		<div class="col-cell">
			<a href="<?php echo $author->getProfileLink(); ?>">
				<b><?php echo $author->getName(); ?></b>
			</a>
			<div>
				<?php echo $this->getNouns('COM_EASYBLOG_AUTHOR_POST_COUNT', $author->getTotalPosts(), true); ?>
			</div>
		</div>
	</div>
	<?php $i++; ?>
<?php } ?>
<?php if (count($authors) > $limitAuthor) { ?>
	<a href="javascript:void(0);" class="btn btn-block btn-default mt-10" data-show-all-authors>
		<?php echo JText::sprintf('COM_EASYBLOG_SHOW_ALL_BLOGGERS', count($authors)); ?> &raquo;
	</a>
<?php } ?>

