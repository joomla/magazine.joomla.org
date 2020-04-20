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
<?php if ($modules->config->get('main_ratings')) { ?>
<script type="text/javascript">
EasyBlog.require()
.script('site/vendors/ratings')
.done(function($) {
	$('[data-eb-module-showcase] [data-rating-form]').implement(EasyBlog.Controller.Ratings);
});
</script>
<?php } ?>