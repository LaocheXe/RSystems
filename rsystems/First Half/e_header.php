<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Related configuration module - News
 *
 *
*/

if (!defined('e107_INIT')) { exit; }


if(USER_AREA) // prevents inclusion of JS/CSS/meta in the admin area.
{
	e107::js('rsystems', 'js/rsystems.js');      // loads e107_plugins/rsystems/js/rsystems.js on every page.
	e107::css('rsystems', 'css/rsystems.css');    // loads e107_plugins/rsystems/css/rsystems.css on every page
	e107::meta('keywords', 'rsystems,words');   // sets meta keywords on every page.
}



?>