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
require_once(HEADERF);

e107::css('roster','roster.css');

$sql  = e107::getDB();
$tp = e107::getParser();
$text = '';

$sparrowAwards = $sql->retrieve('awards_sys', 'award_id, award_name, award_description, award_image', false, true);
// TODO: LAN Files LAN_Awards
$text .= "<table border='0' style='width:100%'>
<tr>
	<th><center>Award</center></th>
	<th>&nbsp;&nbsp;</th>
	<th>Name</th>
	<th>&nbsp;&nbsp;</th>
	<th>Description</th>
</tr>";


foreach($sparrowAwards as $awards)
{
	// TODO: Add Pref for Awards Hight and Width - Award Name
	$att = array('w' => 250, 'h' => 75, 'class' => 'Awards', 'alt' => $awards['award_name'], 'x' => 0, 'crop' => 0);

	$imageCode = $tp->toImage($awards['award_image'], $att);
	
	$text .= '
	<tr>
		<td>'.$imageCode.'</td>
		<td>&nbsp;&nbsp;</td>
		<td>'.$awards['award_name'].'</td>
		<td>&nbsp;&nbsp;</td>
		<td>'.$awards['award_description'].'</td>
	</tr>
	';
}

$text .= "</table>";


e107::getRender()->tablerender('Awards', $text);
require_once(FOOTERF);
exit; 
?>