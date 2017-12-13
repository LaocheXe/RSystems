<?php

if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

require_once(HEADERF);

e107::lan('roster');
//e107::js('roster','js/my.js','jquery');	// Load Plugin javascript and include jQuery framework
//e107::css('roster','css/my.css');		// load css file
e107::meta('keywords', 'ranks, insignia');

$sql  = e107::getDB();
$tp = e107::getParser();
$text = '';

if(!$sql->count('ranks_sys'))
{
  $text = "No ranks found.";
  e107::getRender()->tablerender(LAN_RSYS_RANKS, $text);
  require_once(FOOTERF);
  exit;
}

// Should show the ranks in order under parents (parents do now show in the query test) - eXe
$query1 = "
SELECT r.rank_id, r.rank_parent, r.rank_shortname, r.rank_name, r.rank_description, r.rank_image FROM `#ranks_sys` AS r
LEFT JOIN `#ranks_sys` AS rp ON r.rank_parent = rp.rank_id
WHERE r.rank_parent != 0 AND rp.rank_id IS NOT NULL ORDER BY r.rank_order
";

// Should show the rank parents in order
$query2 = "
SELECT rank_id, rank_parent, rank_shortname, rank_name, rank_description, rank_image, rank_order 
FROM `#ranks_sys` 
WHERE rank_parent = 0 ORDER BY rank_order";

// For the rest of the ranks
$sqlRanks = $sql->retrieve($query1, true);

// For the Parents first
$sqlParents = $sql->retrieve($query2, true);

// Start the table
$text .= "<table border='0' style='width:100%'>
<tr>
	<th><center>Rank</center></th>
	<th>&nbsp;&nbsp;</th>
	<th>Name</th>
	<th>&nbsp;&nbsp;</th>
	<th>Abbreviation</th>
	<th>&nbsp;&nbsp;</th>
	<th>&nbsp;&nbsp;</th>
	<th>Description</th>
</tr>";

// For each parent - Table Header - eXe
foreach($sqlParents as $parent)
{
	$text .= '
			<tr>
				<td colspan="7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
			</tr>
			<tr>
				<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;</td>
				<td><b><i><u>'.$parent['rank_name'].'</u></i></b></td>
				<td>&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;</td>
				<td>&nbsp;&nbsp;</td>
				<td><i><u>'.$parent['rank_description'].'</u></i></td>
			</tr>';
	
	foreach($sqlRanks as $rank)
	{
		$att = array('w' => 50, 'h' => 50, 'class' => $rank['rank_name'], 'alt' => $awards['award_name'], 'x' => 0, 'crop' => 0);
		$imageCode = $tp->toImage($rank['rank_image'], $att);
		// Display ranks and Parents - if parent id equals rank parent then display under
		if($parent['rank_id'] == $rank['rank_parent'])
		{
			$text .='
				<tr>
					<td colspan="7">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
				</tr>
				<tr>
						<td><center>'.$imageCode.'</center></td>
						<td>&nbsp;&nbsp;</td>
						<td>'.$rank['rank_name'].'</td>
						<td>&nbsp;</td>
						<td><center>'.$rank['rank_shortname'].'</center></td>
						<td>&nbsp;&nbsp;</td>
						<td>&nbsp;&nbsp;</td>
						<td>'.$rank['rank_description'].'</td>
					</tr>';
		}
	}	
}

// Close the table off
$text .= "</table>";



e107::getRender()->tablerender(LAN_RSYS_RANKS, $text);
require_once(FOOTERF);
exit;
?>