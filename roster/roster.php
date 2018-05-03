<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 Blank Plugin
 *
*/
if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

if(!e107::isInstalled('roster'))
{
	header('location:'.e_BASE.'index.php');
	exit;	
}

define('PAGE_NAME', LAN_RSYS_PAGE_ROSTER);

require_once(HEADERF);

$sql  = e107::getDB();
$text = '';

// Cutting Corners - Create Company | Platoons > Squads > Fire Teams





e107::getRender()->tablerender(LAN_RSYS_ROSTER, $text);
require_once(FOOTERF);
exit; 
?>