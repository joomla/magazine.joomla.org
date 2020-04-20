<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) 2010 - 2020 Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<div id="eb" class="eb-mod mod_easyblogmostpopularpost<?php echo $modules->getWrapperClass();?>" data-eb-module-most-popular-post>

	<h2 class="jmv-title mb-4">
		<i class="fa fa-star"></i> Popular
	</h2>

	<?php if ($posts) { ?>
	<div class="eb-mod <?php echo $layout == 'horizontal' ? " mod-items-grid clearfix" : '';?>">
		<?php $column = 1; ?> 
		<?php foreach ($posts as $post) { ?>
			<div class="jmv-side-featured-post">
				<div class="d-block d-lg-flex align-items--c">
					<div class="flex-grow--1">
						<div class="jmv-side-featured-post__date mb-2">
							<?php echo $post->getCreationDate(true)->format($params->get('dateformat', JText::_('DATE_FORMAT_LC3'))); ?>
						</div>
						<h2 class="jmv-side-featured-post__title mb-2">
							<a href="<?php echo $post->getPermalink(); ?>" class="eb-mod-media-title"><?php echo $post->title;?></a>
						</h2>
					</div>
					
					<?php if ($params->get('photo_show', true) && $post->cover) { ?>
					<div class="pl-lg-2">
						<div class="jmv-side-featured-post__cover">
							<div class="embed-responsive embed-responsive-16by9">
								<a href="<?php echo $post->getPermalink(); ?>">
									<div class="embed-responsive-item" style="
									background-image: url('<?php echo $post->cover;?>');
									background-position: center;
									" alt="<?php echo EB::themes()->escape($post->getImageTitle());?>">
									</div>
								</a>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
			</div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if ($params->get('allentrieslink', false)) { ?>
	<div>
		<a href="<?php echo EBR::_('index.php?option=com_easyblog');?>">
			<?php echo JText::_('MOD_EASYBLOG_VIEW_ALL_ENTRIES'); ?>
		</a>
	</div>
	<?php } ?>
</div>

<?php if ($modules->config->get('main_ratings')) { ?>
<script type="text/javascript">
EasyBlog.require()
.script('site/vendors/ratings')
.done(function($) {
	$('[data-eb-module-most-popular-post] [data-rating-form]').implement(EasyBlog.Controller.Ratings);
});
</script>
<?php } ?>