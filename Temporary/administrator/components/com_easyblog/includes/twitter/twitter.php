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

class EasyBlogTwitter extends EasyBlog
{
	/**
	 * Retrieves the blog image to be used as the twitter image
	 *
	 * @since	5.1
	 * @access	public
	 */
	public function getImage(EasyBlogPost &$blog)
	{
		// First, we try to search to see if there's a blog image. If there is already, just ignore the rest.
		if ($blog->image) {
			return $blog->getImage('large', false, true);
		}

		$fullcontent = $blog->getContent('entry', false, true, array('processAdsense' => false));
		$source = EB::string()->getImage($fullcontent);

		return $source;
	}

	/**
	 * Attaches the Twitter card into the page header
	 *
	 * @since	5.1
	 * @access	public
	 */
	public function addCard(EasyBlogPost &$blog)
	{
		// Check if the current settings would want to display the twitter cards
		if (!$this->config->get('main_twitter_cards')) {
			return;
		}

		// Get the absolute permalink for this blog item.
		$url = $blog->getExternalPermalink();

		// Get the image of the blog post.
		$image = $this->getImage($blog);

		if ($image) {
			$this->doc->setMetaData('twitter:image', $image);
		}

		// Convert double quotes to html entity in blog title.
		$title = htmlspecialchars($blog->title, ENT_QUOTES);

		// Get the twitter card type
		$cardType = $this->config->get('main_twitter_cards_type');

		// Add card definition.
		$this->doc->setMetaData('twitter:card', $cardType);
		$this->doc->setMetaData('twitter:url', $url);
		$this->doc->setMetaData('twitter:title', $title);

		// Retrieve the stored meta for the blog post
		$blog->loadMeta();

		// If there's a meta set for the blog, use the stored meta version
		$description = !empty($blog->meta->description) ? $blog->meta->description : $blog->getIntro();

		// Remove unwanted tags
		$description = EB::stripEmbedTags($description);

		// Remove any html tags
		$description = strip_tags($description);

		// Ensure that newlines wouldn't affect the header
		$description = trim($description);

		// Replace htmlentities with the counterpert
		// Perhaps we need to explicitly replace &nbsp; with a space?
		$description = html_entity_decode($description);

		// Remove any quotes (") from the content
		$description = str_ireplace('"', '', $description);

		// Twitter's card maximum length is only set to 137
		$maxLength = 137;

		if (EBString::strlen($description) > $maxLength) {
			$description = EBString::substr($description, 0, $maxLength) . JText::_('COM_EASYBLOG_ELLIPSES');
		}

		$this->doc->setMetaData('twitter:description', $description);

		return true;
	}

	/**
	 * Allows caller to import posts from twitter
	 *
	 * @since	5.1
	 * @access	public
	 */
	public function import()
	{
		$key = $this->config->get('integrations_twitter_api_key');
		$secret = $this->config->get('integrations_twitter_secret_key');

		// Ensure that the settings is enabled
		if (!$this->config->get('integrations_twitter_microblog')) {
			return EB::exception('Twitter import has been disabled.', EASYBLOG_MSG_ERROR);
		}

		// Get a list of hashtags
		$hashtags = $this->config->get('integrations_twitter_microblog_hashes');

		// If there are no hashtags, skip this
		if (!$hashtags) {
			return EB::exception('No hashtags provided to search. Skipping this.', EASYBLOG_MSG_INFO);
		}

		$hashtags = explode(',', $hashtags);
		$total = count($hashtags);

		// Get the list of accounts
		$model = EB::model('OAuth');
		$accounts = $model->getTwitterAccounts();

		if (!$accounts) {
			return EB::exception('No Twitter accounts associated on the site. Skipping this', EASYBLOG_MSG_INFO);
		}

		// Get the default category to save the tweets into
		$categoryId = $this->config->get('integrations_twitter_microblog_category');

		// Default state of the post
		$published = $this->config->get('integrations_twitter_microblog_publish');

		// Determines if the post should be available on the frontpage
		$frontpage = $this->config->get('integrations_twitter_microblog_frontpage');

		// Determines the total number of items imported
		$total = 0;

		// Go through each twitter accounts and search for the tags
		foreach ($accounts as $account) {
			$params = EB::registry($account->params);
			$screen = $params->get('screen_name');

			// If we can't get the screen name, do not try to process it.
			if (!$screen) {
				continue;
			}

			// Get the twitter consumer
			$consumer = EB::oauth()->getClient('Twitter');
			$consumer->setAccess($account->access_token);

			// Get the last tweet that has been imported so we don't try to search for anything prior to that
			$lastImport = $model->getLastTweetImport($account->id);

			// Prepare the search params
			$tweets = $consumer->search($hashtags, $lastImport);

			if (!$tweets) {
				return EB::exception('No tweets found. Skipping this.', EASYBLOG_MSG_INFO);
			}

			foreach ($tweets as $tweet) {
				$data = array();

				$data['title'] = EBString::substr($tweet->text, 0, 20) . JText::_('COM_EASYBLOG_ELLIPSES');
				$data['posttype'] = EBLOG_MICROBLOG_TWITTER;
				$data['created_by'] = $account->user_id;
				$data['created'] = EB::date()->toSql();
				$data['modified'] = EB::date()->toSql();
				$data['publish_up'] = EB::date()->toSql();
				$data['intro'] = $tweet->text;
				$data['published'] = $published;
				$data['frontpage'] = $frontpage;
				$data['source_id'] = '0';
				$data['source_type'] = EASYBLOG_POST_SOURCE_SITEWIDE;
				$data['category_id'] = $categoryId;
				$data['categories'] = array($categoryId);

				// we need to set this as legacy post as the post did not go through composer.
				$data['doctype'] = EASYBLOG_POST_DOCTYPE_LEGACY;

				$post = EB::post();

				$createOption = array(
								'overrideDoctType' => 'legacy',
								'checkAcl' => false,
								'overrideAuthorId' => $account->user_id
							);

				$post->create($createOption);
				$post->bind($data);

				$saveOptions = array(
								'applyDateOffset' => false,
								'validateData' => false,
								'useAuthorAsRevisionOwner' => true,
								'checkAcl' => false,
								'overrideAuthorId' => $account->user_id
								);

				// Save the post now
				try {
					$post->save($saveOptions);

				} catch(EasyBlogException $exception) {

					return $exception;
				}

				// We need to save some of these tweets
				$adapter = EB::quickpost()->getAdapter('twitter');

				if ($adapter) {
					$adapter->saveAsset($post->id, 'screen_name', $tweet->user->screen_name);
					$adapter->saveAsset($post->id, 'created_at', $tweet->created_at);
				}

				// Create a new history record
				$history = EB::table('TwitterMicroBlog');
				$history->id_str = $tweet->id_str;
				$history->post_id = $post->id;
				$history->oauth_id = $account->id;
				$history->created = $post->created;
				$history->tweet_author = $screen;
				$history->store();

				$total++;
			}
		}

		return EB::exception(JText::sprintf('%1$s tweets retrieved from twitter', $total), EASYBLOG_MSG_SUCCESS);
	}
}
