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
	e107::js('roster', 'js/roster.js');      // loads e107_plugins/roster/js/roster.js on every page.
	e107::css('roster', 'css/roster.css');    // loads e107_plugins/roster/css/roster.css on every page
	e107::meta('keywords', 'roster,words');   // sets meta keywords on every page.
}



?>