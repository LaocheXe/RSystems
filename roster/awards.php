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

$text .= "<table border='1'>";


foreach($sparrowAwards as $awards)
{
	
	$att = array('w' => '250px', 'h' => '250px', 'class' => 'Awards', 'alt' => $awards['award_name'], 'x' => 1, 'crop' => 1);

	$imageCode = $tp->toImage($awards['award_image'], $att);
	
	$text .= '
	<tr>
		<td><center>'.$awards['award_name'].'<br />'.$imageCode.'</center></td>
		<td></td>
	</tr>
	<tr>
		<td><center>'.$awards['award_description'].'</center></td>
		<td></td>
	</tr>
	';
}

$text .= "</table>";


e107::getRender()->tablerender('Awards', $text);
require_once(FOOTERF);
exit; 
?>