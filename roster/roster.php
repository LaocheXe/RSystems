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
e107::lan('roster');
require_once(HEADERF);

$sql  = e107::getDB();
$tp = e107::getParser();
$ns = e107::getRender();
$text .= '';

if(!$sql->count('roster_sys'))
{
  $text = "No roster created.";
  e107::getRender()->tablerender(LAN_RSYS_PAGE_ROSTER, $text);
  require_once(FOOTERF);
  exit;
}
// Lets get the Catagories first and list them in order.
/* Notes:
	DB Name - roster_system - entities - ros_id | userclass_id | ros_name | ros_parent | ros_order | ros_show
	if ros_show = 1 then display on page.
*/
// First - make db query (old or new?)
$catParent = "SELECT ros_id, userclass_id, ros_name, ros_parent, ros_order, ros_show 
FROM `#roster_sys` 
WHERE ros_parent = 0 AND ros_show != 0 ORDER BY ros_order";
$Parents = $sql->retrieve($catParent, true);
// Next query
$catRest = "SELECT r.ros_id, r.userclass_id, r.ros_name, r.ros_parent, r.ros_sub, r.ros_order, r.ros_show FROM `#roster_sys` AS r
LEFT JOIN `#roster_sys` AS rp ON r.ros_parent = rp.ros_id
WHERE r.ros_parent != 0 AND r.ros_sub = 0 AND rp.ros_show != 0 ORDER BY r.ros_order";
$RosterSet = $sql->retrieve($catRest, true);
// Next
$catSubs = "SELECT r.ros_id, r.userclass_id, r.ros_name, r.ros_parent, r.ros_sub, r.ros_order, r.ros_show FROM `#roster_sys` AS r
LEFT JOIN `#roster_sys` AS rp ON r.ros_parent = rp.ros_id
WHERE r.ros_parent != 0 AND rp.ros_show != 0 AND r.ros_sub != 0 ORDER BY r.ros_order";
$Subs = $sql->retrieve($catSubs, true);

// Get the html side done ish
$text .= "
	<div id='roster'>
		<table class='table table-border'>
			<colgroup>
				<col>
			</colgroup>
			<tbody>
";


// Foreach Parents
foreach($Parents as $parent)
{
	$text .= "
			<tr class='roster-parent'>
				<th class='roster-parent-head'>".$parent['ros_name']."</th>
			</tr>";
	foreach($RosterSet as $roster)
	{
		// Make Some Links to show whos on the rosters (new php page is required)
		if($parent['ros_id'] == $roster['ros_parent'])
		{
			$text .= "
			<tr class='roster-rest'>
				<td>".$roster['ros_name']."</td>
			</tr>";
		}
		foreach($Subs as $sub)
		{
			if($roster['ros_id'] == $sub['ros_sub'])
			{
				$text .="
				<tr class='roster-subs'>
					<td>".$sub['ros_name']."</td>
				</tr>";
			}
		}
	}
}

// Closer
$text .= "
			</tbody>
		</table>
	</div>
";



e107::getRender()->tablerender(LAN_RSYS_ROSTER, $text);
require_once(FOOTERF);
exit; 
?>