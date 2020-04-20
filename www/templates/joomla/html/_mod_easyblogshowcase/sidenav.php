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

// Hide in EB entry layout
$view = JRequest::getVar('view', '');
$option = JRequest::getVar('option', '');

if ($option == 'com_easyblog' && $view == 'entry') {
	return;
}
?>
<div id="eb" class="eb-mod mod-easyblogshowcase--sidenav st-5 mod-easyblogshowcase<?php echo $modules->getWrapperClass(); ?>  <?php echo $modules->isMobile() ? 'is-mobile' : '';?>">
	<div class="eb-gallery-stage" data-eb-module-showcase data-autoplay="<?php echo $autoplay;?>" data-interval="<?php echo $autoplayInterval;?>" data-direction="vertical">
		<div class="row-table">
			<div class="col-cell eb-gallery-main">
				<div class="swiper-container gallery-top" data-container>
					<div class="swiper-wrapper">
						<?php foreach ($posts as $post) { ?>
						<div class="eb-gallery-item swiper-slide">
							<div class="eb-gallery-box" style="background-image: url('<?php echo $post->postCover;?>') !important;">
								
							</div>
							<div class="eb-gallery-body">
								<div class="row-fluid">
									<div class="span3">
										<?php if ($params->get('authoravatar', true)) { ?>
											<a href="<?php echo $post->getAuthor()->getProfileLink(); ?>" class="eb-gallery-avatar mod-avatar mb-3">
												<img src="<?php echo $post->getAuthor()->getAvatar(); ?>" width="40" height="40" />
											</a>
										<?php } ?>
										<div class="">
											<?php if ($params->get('contentauthor', true)) { ?>
												<div class="mb-1">
													by <a href="<?php echo $post->getAuthor()->getProfileLink(); ?>" class="eb-mod-media-title"><?php echo $post->getAuthor()->getName(); ?></a>
												</div>
											<?php } ?>

											<?php if ($params->get('contentdate' , true)) { ?>
												<div class="mb-1">
													<?php echo $post->getCreationDate(true)->format($params->get('dateformat', JText::_('DATE_FORMAT_LC3'))); ?>
												</div>
											<?php } ?>

											<div>
												In
												<a href="<?php echo $post->getPrimaryCategory()->getPermalink();?>"><?php echo JText::_($post->getPrimaryCategory()->title);?></a>
											</div>
										</div>
									</div>
									<div class="span9">
										<div class="eb-gallery-body__content">
											<h3 class="eb-gallery-title">
												<a href="<?php echo $post->getPermalink();?>"><?php echo $post->title;?></a>
											</h3>

											<div class="eb-gallery-content">
												<?php echo $post->content; ?>
											</div>

											

											<?php if ($params->get('showreadmore', true)) { ?>
												<div class="eb-gallery-more">
													<a href="<?php echo $post->getPermalink();?>"><?php echo JText::_('MOD_SHOWCASE_READ_MORE');?></a>
												</div>
											<?php } ?>
										</div>
									</div>
								</div>
								<!-- <div class="eb-gallery-body__side">
									
								</div> -->
								
								
								
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
					
			</div>

			<div class="col-cell cell-tight eb-gallery-side">
				<div class="eb-gallery-side__title">
					<h2 class="jmv-title mb-4"><i class="fa fa-fire"></i> Featured</h2>
				</div>
				<div class="swiper-container gallery-thumbs swiper-container-vertical" data-thumbs
				data-free-mode="1"
				data-space-between="10"
				data-watch-slides-visibility="1"
				data-watch-slides-progress="1">

					<div class="swiper-wrapper">
					<?php $i = 0; ?>
					<?php foreach ($posts as $post) { ?>
						<div class="swiper-slide">
							<div class="jmv-side-featured-post">
								<div class="d-flex align-items--c">
									<div class="flex-grow--1">
										<div class="jmv-side-featured-post__date mb-2">
											<?php echo $post->getCreationDate(true)->format($params->get('dateformat', JText::_('DATE_FORMAT_LC3'))); ?>
										</div>
										<h2 class="jmv-side-featured-post__title">
											<?php echo $post->title;?>
										</h2>
									</div>
									
									<div class="pl-2">
										<div class="jmv-side-featured-post__cover">
											<div class="embed-responsive embed-responsive-16by9">
												<div>
													<div class="embed-responsive-item" style="
													background-image: url('<?php echo $post->postCover;?>');
													background-position: center;
													" alt="Joomla-Day-Brasil-2018-Recap">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php $i++; ?>
					<?php } ?>
					</div>
				</div>
			</div>
		</div>

		<?php if (count($posts) > 1) { ?>
		<div class="eb-gallery-foot">
			<div class="eb-gallery-foot__btn-group">
				<div class="eb-gallery-buttons">
					<div class="eb-gallery-button eb-gallery-prev-button" data-featured-previous>
						<i class="fa fa-angle-left"></i>
					</div>
					<div class="eb-gallery-button eb-gallery-prev-button" data-featured-next>
						<i class="fa fa-angle-right"></i>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
		
	</div>
</div>

<div class="jmv-cta mb-5">
	<div class="d-block d-lg-flex align-items--c">
		<div class="flex-grow--1">
			<h3 class="jmv-cta__title">The next generation of Joomla is coming. </h3>
			<p class="jmv-cta__desc mb-3 mb-md-0">Build your next project with Joomla.</p>
		</div>
		<div class="">
			<a href="" class="btn btn-warning p-2 px-4 mr-0 mr-md-2 mb-3 mb-md-0 ">Download Joomla</a>
			<a href="" class="btn btn-primary p-2 px-4">Preview Joomla</a>
		</div>
	</div>
</div>

<?php include_once(__DIR__ . '/default_scripts.php'); ?>