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

// To Get Page Title To Display
define('PAGE_NAME', LAN_RSYS_PAGE_QUAL);

require_once(HEADERF);

e107::lan('roster');
//e107::js('roster','js/roster.js','jquery');	// Load Plugin javascript and include jQuery framework
//e107::css('roster','css/roster.css');		// load css file
e107::meta('keywords', 'qualifications');

$sql  = e107::getDB();
$tp = e107::getParser();
$text = '';

$theQualifications = $sql->retrieve('qualifications_sys', 'qual_id, qual_name, qual_description, qual_image', false, true);
// TODO: LAN Files LAN_Awards
$text .= "<table border='0' style='width:100%'>
<tr>
	<th><center>Qualification</center></th>
	<th>&nbsp;&nbsp;</th>
	<th>Name</th>
	<th>&nbsp;&nbsp;</th>
	<th>Description</th>
</tr>";


foreach($theQualifications as $qualification)
{
	// TODO: Add Pref for Awards Hight and Width - Award Name
	$att = array('w' => 75, 'h' => 75, 'class' => 'Qualifications', 'alt' => $qualification['qual_name'], 'x' => 0, 'crop' => 0);

	$imageCode = $tp->toImage($qualification['qual_image'], $att);
	
	$text .= '
	<tr>
		<td>'.$imageCode.'</td>
		<td>&nbsp;&nbsp;</td>
		<td>'.$qualification['qual_name'].'</td>
		<td>&nbsp;&nbsp;</td>
		<td>'.$qualification['qual_description'].'</td>
	</tr>
	<tr>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
		<td>&nbsp;&nbsp;</td>
	</tr>
	';
}

$text .= "</table>";


e107::getRender()->tablerender(LAN_RSYS_QUAL, $text);
require_once(FOOTERF);
exit; 
?>