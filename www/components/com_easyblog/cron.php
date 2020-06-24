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

########################################
##### Configuration options.
########################################

// Please enter the url with the prefix https://yourdomain.com
$host = 'https://magazine.joomla.org';

// If you have a passphrase set in the configuration of your cronjob, please set it here.
$phrase = '';

########################################

// In case the host name is not configured.
if ($host == 'https://site.com') {
	echo "Please change the \$host value in the cron.php file to your correct url";
	return;
}

function connect($host, $phrase, $task)
{
	if (!function_exists('curl_version')) {
		echo "cURL needs to be enabled with PHP. Please get in touch with your hosting provider.";
		return;
	}

	$url = 'index.php?option=com_easyblog&task=' . $task;

	if ($phrase) {
		$url .= '&phrase=' . $phrase;
	}

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $host . '/' . $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: close'));
	curl_setopt($ch, CURLOPT_TIMEOUT, 2);
	$response = curl_exec($ch);

	curl_close($ch);

	return $response;
}

$result = array();

$response = connect($host, $phrase, 'cron');
$result[] = json_decode($response);

$response = connect($host, $phrase, 'cronfeed');
$result[] = json_decode($response);

header('Content-type: text/x-json; UTF-8');

echo json_encode($result);
exit;
