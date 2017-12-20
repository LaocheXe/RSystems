<?php
//////////// HEADER SECTION //////////////////////////////////
if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

// To Get Page Title To Display
define('PAGE_NAME', 'Operation Hub'); // TODO: LAN

require_once(HEADERF);
//////////////////////////////////////////////////////////
e107::lan('roster');
//e107::js('roster','js/my.js','jquery');	// Load Plugin javascript and include jQuery framework
//e107::css('roster','css/my.css');		// load css file
e107::meta('keywords', 'operation center, operation hub, hub, operation');

$sql  = e107::getDB();
$tp = e107::getParser();
$ns = e107::getRender();
$text = '';

$text .= "<table border='0' style='width:100%'>
			<tr>
				<th>Unit Statistics</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
			</tr>
		 ";
			
$text .= "
			<tr>
				<td>&nbsp;&nbsp;</td>
				<td><b>Total Active Clones</b></td>
				<td><i>".$valueChange."</i></td>
				<td>&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;</td>
				<td><b>Pacific Time</b>
				<td>".$valueChange_PacificTime."
				<td>&nbsp;&nbsp;</td>
			</tr>
		 ";
			
$text .= "
			<tr>
				<td>&nbsp;&nbsp;</td>
				<td><b>Total Clones on Leave</b></td>
				<td><i>".$valueChange."</i></td>
				<td>&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;</td>
				<td><b>Mountain Time</b>
				<td>".$valueChange_MountainTime."
				<td>&nbsp;&nbsp;</td>
			</tr>
		 ";
		 
$text .= "
			<tr>
				<td>&nbsp;&nbsp;</td>
				<td><b>Total After Action Reports</b></td>
				<td><i>".$valueChange."</i></td>
				<td>&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;</td>
				<td><b>Central Time</b>
				<td>".$valueChange_CentralTime."
				<td>&nbsp;&nbsp;</td>
			</tr>
		 ";
		 
$text .= "
			<tr>
				<td>&nbsp;&nbsp;</td>
				<td><b>Total Ranks</b></td>
				<td><i>".$valueChange."</i></td>
				<td>&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;</td>
				<td><b>Eastern Time</b>
				<td>".$valueChange_EasternTime."
				<td>&nbsp;&nbsp;</td>
			</tr>
		 ";

$text .= "
			<tr>
				<td>&nbsp;&nbsp;</td>
				<td><b>Total Awards</b></td>
				<td><i>".$valueChange."</i></td>
				<td>&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;</td>
				<td><b>Eurpeian Time</b>
				<td>".$valueChange_EurpeianTime."
				<td>&nbsp;&nbsp;</td>
			</tr>
		 ";
		 
$text .= "</table>
		  <table border='0' style='width:100%'>
			<tr>
				<th>Active Clones on Leave</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
				<th>&nbsp;&nbsp;</th>
			</tr>
		";

$text .= "</table>";

e107::getRender()->tablerender('<h4>Operation Hub</4><br /><h6>All unit operations may be viewed here.</h6>', $text); // TODO: LANS
require_once(FOOTERF);
exit; 

?>