<?php
/**
* @package		EasyBlog
* @copyright	Copyright (C) Stack Ideas Sdn Bhd. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* EasyBlog is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/
defined('_JEXEC') or die('Unauthorized Access');
?>
<?php echo EB::renderModule('easyblog-before-toolbar'); ?>

<?php if ($heading || $showHeader || ($showToolbar && $canAccessToolbar)) { ?>
<div class="eb-header">
	<?php if ((!empty($title) || !empty($desc)) && ($heading || $showHeader)) { ?>
	<div class="eb-brand">
		<?php if ($view == 'entry' && !empty($title)) { ?>
			<h2 class="eb-brand-name reset-heading"><?php echo JText::_($title);?></h2>
		<?php } ?>

		<?php if ($view != 'entry' && !empty($title)) { ?>
			<h2 class="eb-brand-name reset-heading"><?php echo JText::_($title);?></h2>
		<?php } ?>

		<?php if ($this->config->get('layout_header_description') && !empty($desc)) { ?>
			<div class="eb-brand-bio"><?php echo JText::_($desc);?></div>
		<?php } ?>
	</div>
	<?php } ?>

	<?php if ($showToolbar && $canAccessToolbar) { ?>

	<div class="eb-toolbar" data-eb-toolbar>

		<?php if ($showHome) { ?>
		<div class="eb-toolbar__item eb-toolbar__item--home">
			<nav class="o-nav eb-toolbar__o-nav">
				<div class="o-nav__item <?php echo $view == 'latest' ? 'is-active' : '' ?>">
					<a href="<?php echo EBR::_('index.php?option=com_easyblog');?>" class="o-nav__link eb-toolbar__link">
						<i class="fa fa-home"></i>
					</a>
				</div>
			</nav>
		</div>
		<?php } ?>

		<div class="eb-toolbar__item eb-toolbar__item--home-submenu">
			<nav class="o-nav eb-toolbar__o-nav">
				<?php if ($showCategories) { ?>
				<div class="o-nav__item <?php echo $view == 'categories' ? 'is-active' : '' ?>">
					<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=categories');?>" class="o-nav__link eb-toolbar__link">
						<span><?php echo JText::_('COM_EASYBLOG_TOOLBAR_CATEGORIES');?></span>
					</a>
				</div>
				<?php } ?>

				<?php if ($showTags) { ?>
				<div class="o-nav__item <?php echo $view == 'tags' ? 'is-active' : '' ?>">
					<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=tags');?>" class="o-nav__link eb-toolbar__link">
						<span><?php echo JText::_('COM_EASYBLOG_TOOLBAR_TAGS');?></span>
					</a>
				</div>
				<?php } ?>

				<?php if ($showBloggers && !$bloggerMode) { ?>
				<div class="o-nav__item <?php echo $view == 'blogger' ? 'is-active' : '' ?>">
					<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=blogger');?>" class="o-nav__link eb-toolbar__link">
						<span><?php echo JText::_('COM_EASYBLOG_TOOLBAR_BLOGGERS');?></span>
					</a>
				</div>
				<?php } ?>

				<?php if ($showTeamblog) { ?>
				<div class="o-nav__item <?php echo $view == 'teamblog' ? 'is-active' : '' ?>">
					<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=teamblog');?>" class="o-nav__link eb-toolbar__link">
						<span><?php echo JText::_('COM_EASYBLOG_TOOLBAR_TEAMBLOGS');?></span>
					</a>
				</div>
				<?php } ?>

				<?php if ($showArchives) { ?>
				<div class="o-nav__item <?php echo $view == 'archive' ? 'is-active' : '' ?>">
					<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=archive');?>" class="o-nav__link eb-toolbar__link">
						<span><?php echo JText::_('COM_EASYBLOG_TOOLBAR_ARCHIVES');?></span>
					</a>
				</div>
				<?php } ?>

				<?php if ($showCalendar) { ?>
				<div class="o-nav__item <?php echo $view == 'calendar' ? 'is-active' : '' ?>">
					<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=calendar&layout=calendarView');?>" class="o-nav__link eb-toolbar__link">
						<span><?php echo JText::_('COM_EASYBLOG_TOOLBAR_CALENDAR');?></span>
					</a>
				</div>
				<?php } ?>
			</nav>
		</div>


		<?php if ($showSearch) { ?>
		<div class="eb-toolbar__item eb-toolbar__item--search" data-eb-toolbar-search-wrapper>
			<div id="eb-toolbar-search" class="eb-toolbar__search">
				<form class="eb-toolbar__search-form" method="post" action="<?php echo JRoute::_('index.php');?>">

					<div class="eb-toolbar__search-filter">
						<div class="eb-filter-select-group">
							<?php echo $categoryDropdown; ?>
							<div class="eb-filter-select-group__drop"></div>
						</div>
					</div>

					<input type="text" name="query" class="eb-toolbar__search-input" autocomplete="off" placeholder="<?php echo JText::_('COM_EASYBLOG_TOOLBAR_PLACEHOLDER_SEARCH');?>" value="<?php echo $this->html('string.escape', $query);?>" />
					<?php echo $this->html('form.action', 'search.query');?>

					<div class="eb-toolbar__search-submit-btn">
						<button class="btn btn-primary btn-search-submit" type="submit">
							<?php echo JText::_('COM_EASYBLOG_SEARCH_BUTTON'); ?>
						</button>
					</div>


					<div class="eb-toolbar__search-close-btn">
						<a href="javascript:void(0);" class="" data-eb-toolbar-search-toggle><i class="fa fa-times"></i></a>
					</div>
				</form>
			</div>
		</div>
		<?php } ?>

		<div class="eb-toolbar__item eb-toolbar__item--action">
			<nav class="o-nav eb-toolbar__o-nav">

				<?php if ($this->acl->get('add_entry')) { ?>
					<div class="o-nav__item" data-eb-provide="tooltip" data-placement="top" data-original-title="<?php echo JText::_('COM_EASYBLOG_TOOLBAR_NEW_POST_TIPS');?>">
						<a class="o-nav__link eb-toolbar__link has-composer" href="<?php echo EB::composer()->getComposeUrl(); ?>">
							<i class="fa fa-pencil"></i>
							<span class="eb-toolbar__link-text"><?php echo JText::_('COM_EASYBLOG_TOOLBAR_NEW_POST');?></span>
						</a>
					</div>
				<?php } ?>

				<?php if ($this->acl->get('add_entry') && $this->config->get('main_microblog')) { ?>
					<div class="o-nav__item <?php echo $view == 'dashboard' && $layout == 'quickpost' ? 'is-active' : '';?>"
						data-original-title="<?php echo JText::_('COM_EASYBLOG_TOOLBAR_QUICK_POST');?>"
						data-placement="top"
						data-eb-provide="tooltip"
					>
						<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=quickpost'); ?>">
							<i class="fa fa-bolt"></i>
						</a>
					</div>
				<?php } ?>

				<?php if ($this->config->get('main_sitesubscription') && $this->acl->get('allow_subscription')) { ?>
					<div class="o-nav__item <?php echo $subscription->id ? 'hide' : ''; ?>"
						data-blog-subscribe
						data-type="site"
						data-original-title="<?php echo JText::_('COM_EASYBLOG_SUBSCRIPTION_SUBSCRIBE_TO_SITE');?>"
						data-placement="top"
						data-eb-provide="tooltip"
					>
						<a class="o-nav__link eb-toolbar__link" href="javascript:void(0);">
							<i class="fa fa-envelope"></i>
							<span class="eb-toolbar__link-text"><?php echo JText::_('COM_EASYBLOG_SUBSCRIPTION_SUBSCRIBE_TO_SITE');?></span>
						</a>
					</div>
					<div class="o-nav__item <?php echo $subscription->id ? '' : 'hide'; ?>"
						data-blog-unsubscribe
						data-subscription-id="<?php echo $subscription->id;?>"
						data-return="<?php echo base64_encode(EBFactory::getURI(true));?>"
						data-original-title="<?php echo JText::_('COM_EASYBLOG_SUBSCRIPTION_UNSUBSCRIBE_TO_SITE');?>"
						data-placement="top"
						data-eb-provide="tooltip"
					>
						<a class="o-nav__link eb-toolbar__link" href="javascript:void(0);">
							<i class="fa fa-envelope"></i>
							<span class="eb-toolbar__link-text"><?php echo JText::_('COM_EASYBLOG_SUBSCRIPTION_UNSUBSCRIBE_TO_SITE');?></span>
						</a>
					</div>
				<?php } ?>

				<?php if ($showSearch) { ?>
					<div class="o-nav__item"
						data-original-title="<?php echo JText::_('COM_EASYBLOG_TOOLBAR_SEARCH');?>"
						data-placement="top"
						data-eb-provide="tooltip"
					>
						<a href="javascript:void(0);" class="o-nav__link eb-toolbar__link" data-eb-toolbar-search-toggle><i class="fa fa-search"></i></a>
					</div>
				<?php } ?>

				<?php if (($this->isMobile() || $this->isTablet()) && $showHamburgerIcon) { ?>
					<div class="o-nav__item dropdown_">
						<a href="#eb-canvas" class="o-nav__link eb-toolbar__link">
							<i class="fa fa-bars"></i>
						</a>
					</div>

					<nav id="eb-canvas">
						<ul>
							<li class="mm-divider">
								<?php echo JText::_("COM_EASYBLOG_TOOLBAR_MENU_TITLE", true);?>
							</li>

							<?php if ($showCategories) { ?>
							<li>
								<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=categories');?>">
									<?php echo JText::_('COM_EASYBLOG_TOOLBAR_CATEGORIES');?>
								</a>
							</li>
							<?php } ?>

							<?php if ($showTags) { ?>
							<li>
								<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=tags');?>">
									<?php echo JText::_('COM_EASYBLOG_TOOLBAR_TAGS');?>
								</a>
							</li>
							<?php } ?>

							<?php if ($showBloggers && !$bloggerMode) { ?>
							<li class="o-nav__item <?php echo $view == 'blogger' ? 'is-active' : '' ?>">
								<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=blogger');?>">
									<?php echo JText::_('COM_EASYBLOG_TOOLBAR_BLOGGERS');?>
								</a>
							</li>
							<?php } ?>

							<?php if ($showTeamblog) { ?>
							<li class="o-nav__item <?php echo $view == 'teamblog' ? 'is-active' : '' ?>">
								<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=teamblog');?>">
									<?php echo JText::_('COM_EASYBLOG_TOOLBAR_TEAMBLOGS');?>
								</a>
							</li>
							<?php } ?>

							<?php if ($showArchives) { ?>
							<li class="o-nav__item <?php echo $view == 'archive' ? 'is-active' : '' ?>">
								<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=archive');?>">
									<?php echo JText::_('COM_EASYBLOG_TOOLBAR_ARCHIVES');?>
								</a>
							</li>
							<?php } ?>

							<?php if ($showCalendar) { ?>
							<li class="o-nav__item <?php echo $view == 'calendar' ? 'is-active' : '' ?>">
								<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=calendar&layout=calendarView');?>">
									<?php echo JText::_('COM_EASYBLOG_TOOLBAR_CALENDAR');?>
								</a>
							</li>
							<?php } ?>

							<?php if ($this->my->id) { ?>
							<li>
								<span><?php echo JText::_('COM_EB_MANAGE');?></span>

								<ul>
									<?php if ($this->acl->get('add_entry')) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=entries&filter=drafts');?>">
											<i class="fa fa-file-text t-sm-visible"></i>
											<?php echo JText::_('COM_EB_TOOLBAR_DRAFTS');?>
										</a>
									</li>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=entries');?>">
											<i class="fa fa-file-text t-sm-visible"></i>
											<?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_POSTS');?>
										</a>
									</li>
									<?php } ?>

									<?php if ($this->acl->get('create_post_templates')) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=templates');?>">
											<i class="fa fa-window-maximize t-sm-visible"></i>
											<?php echo JText::_('COM_EASYBLOG_DASHBOARD_HEADING_POST_TEMPLATES');?>
										</a>
									</li>
									<?php } ?>

									<?php if (EB::isSiteAdmin() || ($this->acl->get('moderate_entry') || ($this->acl->get('manage_pending') && $this->acl->get('publish_entry')))) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=moderate');?>">
											<i class="fa fa-ticket"></i>
											<?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_PENDING');?>
											<?php if ($totalPending) { ?>
											<div class="eb-toolbar__indicator-counter"><?php echo $totalPending;?></div>
											<?php } ?>
										</a>
									</li>
									<?php } ?>

									<?php if (EB::isSiteAdmin() || ($this->acl->get('moderate_entry') || ($this->acl->get('manage_pending') && $this->acl->get('publish_entry')))) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=reports');?>">
											<i class="fa fa-exclamation-triangle"></i>
											<?php echo JText::_('COM_EB_REPORT_POSTS');?>
											<?php if ($totalReportPosts) { ?>
											<div class="eb-toolbar__indicator-counter"><?php echo $totalReportPosts;?></div>
											<?php } ?>
										</a>
									</li>
									<?php } ?>

									<?php if ($this->acl->get('manage_comment') && EB::comment()->isBuiltin()) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=comments');?>">
											<i class="fa fa-comments"></i>
											<?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_COMMENTS');?>
											<?php if ($totalPendingComments) { ?>
											<div class="eb-toolbar__indicator-counter"><?php echo $totalPendingComments; ?></div>
											<?php } ?>
										</a>
									</li>
									<?php } ?>

									<?php if ($this->acl->get('create_category')) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=categories');?>">
											<i class="fa fa-folder-o"></i>
											<?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_CATEGORIES');?>
										</a>
									</li>
									<?php } ?>

									<?php if ($this->acl->get('create_tag')) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=tags');?>">
											<i class="fa fa-tags"></i>
											<?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_TAGS');?>
										</a>
									</li>
									<?php } ?>

									<?php if ($this->config->get('main_favourite_post')) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=favourites');?>">
											<i class="fa fa-star"></i>
											<?php echo JText::_('COM_EB_FAVOURITE_POSTS');?>
										</a>
									</li>
									<?php } ?>

									<?php if ($this->config->get('layout_teamblog') && $this->acl->get('create_team_blog')) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=teamblogs');?>">
											<i class="fa fa-users"></i>
											<?php echo JText::_('COM_EASYBLOG_TOOLBAR_TEAMBLOGS');?>
										</a>
									</li>
									<?php } ?>

									<?php if ((EB::isTeamAdmin() || EB::isSiteAdmin()) && $this->acl->get('create_team_blog')){ ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EBR::_('index.php?option=com_easyblog&view=dashboard&layout=requests');?>">
											<i class="fa fa-users"></i>
											<?php echo JText::_('COM_EASYBLOG_TOOLBAR_TEAM_REQUESTS');?>
											<?php if ($totalTeamRequests) { ?>
											<div class="eb-toolbar__indicator-counter"><?php echo $totalTeamRequests;?></div>
											<?php } ?>
										</a>
									</li>
									<?php } ?>

									<?php if ($this->acl->get('allow_subscription')) { ?>
									<li>
										<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=subscription');?>">
											<i class="fa fa-envelope t-sm-visible"></i>
											<?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_SUBSCRIPTIONS');?>
										</a>
									</li>
									<?php } ?>
								</ul>
							</li>

							<?php if (EB::easysocial()->exists() && $this->config->get('integrations_es_eb_toolbar') && ES::user()->hasCommunityAccess()) { ?>
								<?php echo EB::easysocial()->getToolbarDropdown();?>
							<?php } ?>

							<?php if (EB::easydiscuss()->exists() && $this->config->get('integrations_ed_eb_toolbar')) { ?>
								<?php echo EB::easydiscuss()->getToolbarDropdown();?>
							<?php } ?>

							<li class="mm-divider">
								<?php echo JText::_("COM_EB_ACCOUNT");?>
							</li>

							<?php if (($this->config->get('integrations_twitter') && $this->config->get('integrations_twitter_centralized_and_own')) || ($this->config->get('integrations_linkedin') && $this->config->get('integrations_linkedin_centralized_and_own'))) { ?>
							<li>
								<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=autoposting');?>">
									<i class="fa fa-share-square-o t-sm-visible"></i>
									<?php echo JText::_('COM_EASYBLOG_TOOLBAR_AUTOPOSTING');?>
								</a>
							</li>
							<?php } ?>

							<li>
								<a class="o-nav__link eb-toolbar__link" href="<?php echo EB::getEditProfileLink();?>">
									<i class="fa fa-pencil-square-o t-sm-visible"></i>
									<?php echo JText::_('COM_EASYBLOG_TOOLBAR_EDIT_PROFILE');?>
								</a>
							</li>

							<?php if ($this->config->get('gdpr_enabled') && $this->config->get('integrations_easysocial_editprofile') && EB::easysocial()->exists()) { ?>
							<li>
								<a class="o-nav__link eb-toolbar__link" href="javascript:void(0);" data-gdpr-download-link>
									<i class="fa fa-download t-sm-visible"></i>
									<?php echo JText::_('COM_EB_GDPR_DOWNLOAD_INFORMATION');?>
								</a>
							</li>
							<?php } ?>

							<li>
								<a class="o-nav__link eb-toolbar__link" href="javascript:void(0);" data-blog-toolbar-logout>
									<i class="fa fa-power-off t-sm-visible"></i>
									<?php echo JText::_('COM_EASYBLOG_TOOLBAR_SIGN_OUT');?>
								</a>
							</li>
							<?php } ?>
						</ul>
					</nav>
				<?php } ?>

				<?php if ($this->config->get('layout_login') && $this->my->guest) { ?>
				<div class="o-nav__item dropdown_">
					<a href="javascript:void(0);" class="o-nav__link eb-toolbar__link dropdown-toggle_" data-bp-toggle="dropdown">
						<i class="fa fa-lock"></i>
						<span class="eb-toolbar__link-text"><?php echo JText::_('COM_EASYBLOG_TOOLBAR_SETTINGS');?></span>
					</a>
					 <div class="eb-toolbar__dropdown-menu eb-toolbar__dropdown-menu--signin dropdown-menu pull-right" data-eb-toolbar-dropdown >
						<div class="eb-arrow"></div>
						<div class="popbox-dropdown">
							<div class="popbox-dropdown__hd">
								<div class="o-flag o-flag--rev">
									<div class="o-flag__body">
										<div class="popbox-dropdown__title"><?php echo JText::_('COM_EB_SIGN_IN');?></div>
										<?php if (EB::isRegistrationEnabled()) { ?>
										<div class="popbox-dropdown__meta">
											<?php echo JText::sprintf('COM_EB_TOOLBAR_IF_YOU_ARE_NEW_HERE',  '<a href="' . EB::getRegistrationLink() . '">' . JText::_('COM_EASYBLOG_REGISTER') . '</a>');?>
										</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<div class="popbox-dropdown__bd">
								<form class="popbox-dropdown-signin" action="<?php echo JRoute::_('index.php');?>" method="post">

									<?php echo $this->html('form.floatinglabel', 'COM_EASYBLOG_USERNAME', 'username', 'text'); ?>

									<?php echo $this->html('form.floatinglabel', 'COM_EASYBLOG_PASSWORD', 'password', 'password'); ?>

									<?php if (EB::hasTwoFactor()) { ?>
										<?php echo $this->html('form.floatinglabel', 'JGLOBAL_SECRETKEY', 'secretkey', 'text'); ?>
									<?php } ?>

									<div class="popbox-dropdown-signin__action">
										<div class="popbox-dropdown-signin__action-col">
											<?php if(JPluginHelper::isEnabled('system', 'remember')) { ?>
												<div class="eb-checkbox">
													<input id="remember-me" type="checkbox" name="remember" value="1" class="rip" tabindex="33"/>
													<label for="remember-me">
														<?php echo JText::_('COM_EASYBLOG_REMEMBER_ME') ?>
													</label>
												</div>
											<?php } ?>
										</div>
										<div class="popbox-dropdown-signin__action-col">
											<button class="btn btn-primary" tabindex="34"><?php echo JText::_('COM_EASYBLOG_LOGIN') ?></button>
										</div>
									</div>
									<input type="hidden" value="com_users"  name="option">
									<input type="hidden" value="user.login" name="task">
									<input type="hidden" name="return" value="<?php echo $return; ?>" />
									<?php echo $this->html('form.token'); ?>

									<?php if ($this->config->get('integrations_jfbconnect_login')) { ?>
										<?php echo EB::jfbconnect()->getTag();?>
									<?php } ?>
								</form>
							</div>
							<div class="popbox-dropdown__ft">
								<ul class=" popbox-dropdown-signin__ft-list g-list-inline g-list-inline--dashed t-text--center">
									<li>
										<a href="<?php echo EB::getRemindUsernameLink();?>"><?php echo JText::_('COM_EASYBLOG_FORGOTTEN_USERNAME');?></a>
									</li>
									<li>
										<a href="<?php echo EB::getResetPasswordLink();?>" class=""><?php echo JText::_('COM_EB_RESET_PASSWORD');?></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>




				<?php if (!$this->isMobile() && $showMoreSettings) { ?>
				<div class="o-nav__item is-signin dropdown_" data-original-title="<?php echo JText::_('COM_EB_TOOLBAR_MORE_SETTINGS');?>" data-placement="top" data-eb-provide="tooltip">

					<a href="javascript:void(0);" class="o-nav__link eb-toolbar__link has-avatar dropdown-toggle_" data-bp-toggle="dropdown">
						<div class="eb-toolbar__avatar">
							<img src="<?php echo $this->profile->getAvatar();?>" alt="<?php echo $this->html('string.escape', $this->profile->getName());?>" width="24" height="24" />
						</div>
					</a>

					<div class="eb-toolbar__dropdown-menu eb-toolbar__dropdown-menu--action dropdown-menu bottom-right has-eb
						<?php echo EB::easysocial()->exists() && $this->config->get('integrations_es_eb_toolbar') && ES::user()->hasCommunityAccess() ?  'has-es' : '';?>
						<?php echo EB::easydiscuss()->exists() && $this->config->get('integrations_ed_eb_toolbar') ?  'has-ed' : '';?>"
						data-eb-toolbar-dropdown
					>
						<div class="eb-arrow"></div>

						<div class="eb-toolbar-profile">
							<?php if (EB::easysocial()->exists() && $this->config->get('integrations_es_eb_toolbar')) { ?>
								<div class="eb-toolbar-profile__hd with-cover">
									<div class="eb-toolbar-profile__cover" style="background-image:url('<?php echo EB::easysocial()->getCover()->getSource();?>'); background-repeat: no-repeat; background-position: <?php echo EB::easysocial()->getCover()->getPosition();?>; background-size: cover;">
									</div>
								</div>
							<?php } ?>
							<div class="eb-toolbar-profile__bd">
								<div class="popbox-dropdown__hd-flag">

									<div class="popbox-dropdown__hd-body">
										<?php if ($this->acl->get('add_entry')) { ?>
											<a href="<?php echo $this->profile->getPermalink();?>" class="eb-user-name"><?php echo $this->profile->getName();?></a>
										<?php } else { ?>
											<?php echo $this->profile->getName();?>
										<?php } ?>

										<div class="popbox-dropdown__hd-menu">
											<ol class="popbox-dropdown-nav__meta-lists">
												<?php if ($this->acl->get('add_entry')) { ?>
												<li>
													<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard');?>" class="text-muted">
														<?php echo JText::_('COM_EASYBLOG_DASHBOARD_TOOLBAR_OVERVIEW');?>
													</a>
												</li>
												<?php } ?>

												<?php if (EB::easysocial()->exists() && $this->config->get('integrations_es_eb_toolbar')) { ?>
													<li>
														<a href="javascript:void(0);"><?php echo EB::easysocial()->user()->getProfile()->getTitle();?></a>
													</li>
												<?php } ?>
											</ol>
										</div>
									</div>

									<div class="popbox-dropdown__hd-image">
										<?php if ($this->acl->get('add_entry')) { ?>
										<a href="<?php echo $this->profile->getPermalink();?>" class="eb-toolbar__avatar">
											<img src="<?php echo $this->profile->getAvatar();?>" alt="<?php echo $this->html('string.escape', $this->profile->getName());?>" width="24" height="24" />
										</a>
										<?php } else { ?>
										<div class="eb-toolbar__avatar">
											<img src="<?php echo $this->profile->getAvatar();?>" alt="<?php echo $this->html('string.escape', $this->profile->getName());?>" width="24" height="24" />
										</div>
										<?php } ?>
									</div>
								</div>

								<?php if (EB::easysocial()->exists() && $this->config->get('integrations_es_eb_toolbar')) { ?>
									<?php echo EB::easysocial()->getToolbarBadges();?>
								<?php } ?>
							</div>
							<div class="eb-toolbar-profile__ft">
								<div class="popbox-dropdown">
									<div class="popbox-dropdown__hd">
										<div class="popbox-dropdown-nav__name"><?php echo JText::_('COM_EASYBLOG_DASHBOARD_TOOLBAR_MANAGE');?></div>
										<div class="popbox-dropdown__hd-flag">

											<div class="popbox-dropdown__hd-body">
												<?php if ($this->acl->get('add_entry')) { ?>
													<a href="<?php echo $this->profile->getPermalink();?>" class="eb-user-name"><?php echo $this->profile->getName();?></a>
												<?php } else { ?>
													<?php echo $this->profile->getName();?>
												<?php } ?>

												<?php if ($this->acl->get('add_entry')) { ?>
												<div class="mt-5">
													<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard');?>" class="text-muted">
														<?php echo JText::_('COM_EASYBLOG_DASHBOARD_TOOLBAR_OVERVIEW');?>
													</a>
												</div>
												<?php } ?>
											</div>

											<div class="popbox-dropdown__hd-image">
												<?php if ($this->acl->get('add_entry')) { ?>
												<a href="<?php echo $this->profile->getPermalink();?>" class="eb-toolbar__avatar">
													<img src="<?php echo $this->profile->getAvatar();?>" alt="<?php echo $this->html('string.escape', $this->profile->getName());?>" width="24" height="24" />
												</a>
												<?php } else { ?>
												<div class="eb-toolbar__avatar">
													<img src="<?php echo $this->profile->getAvatar();?>" alt="<?php echo $this->html('string.escape', $this->profile->getName());?>" width="24" height="24" />
												</div>
												<?php } ?>
											</div>
										</div>
									</div>

									<div class="popbox-dropdown__bd">
										<div class="popbox-dropdown-nav">
											<?php if ($showManage) { ?>
											<div class="popbox-dropdown-nav__item">
												<span class="popbox-dropdown-nav__link">

													<?php if ((!EB::easysocial()->exists() || !$this->config->get('integrations_es_eb_toolbar')) && (!EB::easydiscuss()->exists() || !$this->config->get('integrations_ed_eb_toolbar'))) { ?>
													<div class="popbox-dropdown-nav__name mb-10">
														<?php echo JText::_('COM_EASYBLOG_DASHBOARD_TOOLBAR_MANAGE');?>
													</div>
													<?php } ?>

													<ol class="popbox-dropdown-nav__meta-lists">

														<?php if ($this->acl->get('add_entry')) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=entries&filter=drafts');?>">
																<?php echo JText::_('COM_EB_TOOLBAR_DRAFTS');?>
															</a>
														</li>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=entries');?>">
																<?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_POSTS');?>
															</a>
														</li>
														<?php } ?>

														<?php if ($this->acl->get('create_post_templates')) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=templates');?>">
																<?php echo JText::_('COM_EASYBLOG_DASHBOARD_HEADING_POST_TEMPLATES');?>
															</a>
														</li>
														<?php } ?>

														<?php if (EB::isSiteAdmin() || ($this->acl->get('moderate_entry') || ($this->acl->get('manage_pending') && $this->acl->get('publish_entry')))) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=moderate');?>">
																<i class="fa fa-ticket"></i> <?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_PENDING');?>
																<?php if ($totalPending) { ?>
																<span class="popbox-dropdown-nav__indicator ml-5"></span>
																<span class="popbox-dropdown-nav__counter"><?php echo $totalPending;?></span>
																<?php } ?>
															</a>
														</li>
														<?php } ?>

														<?php if (EB::isSiteAdmin() || ($this->acl->get('moderate_entry') || ($this->acl->get('manage_pending') && $this->acl->get('publish_entry')))) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=reports');?>">
																<i class="fa fa-exclamation-triangle"></i> <?php echo JText::_('COM_EB_REPORT_POSTS');?>
																<?php if ($totalReportPosts) { ?>
																<span class="popbox-dropdown-nav__indicator ml-5"></span>
																<span class="popbox-dropdown-nav__counter"><?php echo $totalReportPosts;?></span>
																<?php } ?>
															</a>
														</li>
														<?php } ?>

														<?php if ($this->acl->get('manage_comment') && EB::comment()->isBuiltin()) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=comments');?>">
																<i class="fa fa-comments"></i> <?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_COMMENTS');?>
																<?php if ($totalPendingComments) { ?>
																<span class="popbox-dropdown-nav__indicator ml-5"></span>
																<span class="popbox-dropdown-nav__counter"><?php echo $totalPendingComments; ?></span>
																<?php } ?>
															</a>
														</li>
														<?php } ?>

														<?php if ($this->acl->get('create_category')) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=categories');?>">
																<i class="fa fa-folder-o"></i> <?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_CATEGORIES');?>
															</a>
														</li>
														<?php } ?>

														<?php if ($this->acl->get('create_tag')) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=tags');?>">
																<i class="fa fa-tags"></i> <?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_TAGS');?>
															</a>
														</li>
														<?php } ?>

														<?php if ($this->config->get('main_favourite_post')) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=favourites');?>">
																<?php echo JText::_('COM_EB_FAVOURITE_POSTS');?>
															</a>
														</li>
														<?php } ?>

														<?php if ($this->config->get('layout_teamblog') && $this->acl->get('create_team_blog')) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=teamblogs');?>">
																<?php echo JText::_('COM_EASYBLOG_TOOLBAR_TEAMBLOGS');?>
															</a>
														</li>
														<?php } ?>

														<?php if ((EB::isTeamAdmin() || EB::isSiteAdmin()) && $this->acl->get('create_team_blog')){ ?>
														<li>
															<a href="<?php echo EBR::_('index.php?option=com_easyblog&view=dashboard&layout=requests');?>">
																<i class="fa fa-users"></i> <?php echo JText::_('COM_EASYBLOG_TOOLBAR_TEAM_REQUESTS');?>
																<?php if ($totalTeamRequests) { ?>
																<span class="popbox-dropdown-nav__indicator ml-5"></span>
																<span class="popbox-dropdown-nav__counter"><?php echo $totalTeamRequests;?></span>
																<?php } ?>
															</a>
														</li>
														<?php } ?>
													</ol>
												</span>
											</div>
											<?php } ?>

											<div class="popbox-dropdown-nav__item">
												<span class="popbox-dropdown-nav__link">
													<div class="popbox-dropdown-nav__name mb-10">
														<?php echo JText::_('COM_EASYBLOG_YOUR_ACCOUNT'); ?>
													</div>

													<ol class="popbox-dropdown-nav__meta-lists">
														<?php if ($this->acl->get('allow_subscription')) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=subscription');?>">
																<i class="fa fa-envelope"></i> <?php echo JText::_('COM_EASYBLOG_TOOLBAR_MANAGE_SUBSCRIPTIONS');?>
															</a>
														</li>
														<?php } ?>

														<?php if (($this->config->get('integrations_twitter') && $this->config->get('integrations_twitter_centralized_and_own')) || ($this->config->get('integrations_linkedin') && $this->config->get('integrations_linkedin_centralized_and_own'))) { ?>
														<li>
															<a href="<?php echo EB::_('index.php?option=com_easyblog&view=dashboard&layout=autoposting');?>">
																<i class="fa fa-share-square-o"></i> <?php echo JText::_('COM_EASYBLOG_TOOLBAR_AUTOPOSTING');?>
															</a>
														</li>
														<?php } ?>

														<li>
															<a href="<?php echo EB::getEditProfileLink();?>">
																<?php echo JText::_('COM_EASYBLOG_TOOLBAR_EDIT_PROFILE');?>
															</a>
														</li>

														<?php if ($this->config->get('gdpr_enabled') && $this->config->get('integrations_easysocial_editprofile') && EB::easysocial()->exists()) { ?>
														<li>
															<a href="javascript:void(0);" data-gdpr-download-link>
																<?php echo JText::_('COM_EB_GDPR_DOWNLOAD_INFORMATION');?>
															</a>
														</li>
														<?php } ?>

														<li>
															<a href="javascript:void(0);" data-blog-toolbar-logout>
																<i class="fa fa-power-off"></i> <?php echo JText::_('COM_EASYBLOG_TOOLBAR_SIGN_OUT');?>
															</a>
														</li>
													</ol>
												</span>
											</div>
										</div>
									</div>
								</div>

								<?php if (EB::easysocial()->exists() && $this->config->get('integrations_es_eb_toolbar') && ES::user()->hasCommunityAccess()) { ?>
									<?php echo EB::easysocial()->getToolbarDropdown();?>
								<?php } ?>

								<?php if (EB::easydiscuss()->exists() && $this->config->get('integrations_ed_eb_toolbar')) { ?>
									<?php echo EB::easydiscuss()->getToolbarDropdown();?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<?php } ?>
			</nav>
		</div>

		<form action="<?php echo JRoute::_('index.php');?>" method="post" data-blog-logout-form class="hide">
			<input type="hidden" value="com_users"  name="option" />
			<input type="hidden" value="user.logout" name="task" />
			<input type="hidden" value="<?php echo $return; ?>" name="return" />
			<?php echo $this->html('form.token'); ?>
		</form>
	</div>
	<?php } ?>
</div>
<?php } ?>

<?php echo EB::renderModule('easyblog-after-toolbar'); ?>
