<?php
/*************************************/
//       www.defiantz.org            // 
//          roster.php              //
//		   For RSystem             //
//		   created by             //
//          LaocheXe             //
/********************************/
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

$sql = e107::getDB();
$id = $_GET['cat-id'];


if(USERID || !USERID) // MIGHT NEED TO CHANGE THIS IF STATEMENT
{
	new listRoster;
}
/*
elseif(!$id)
{
	new rosterGenerate;
}
*/

//else
//{
//	new listRoster;
//}

// CLASSES START HERE
class listRoster
{
	function __construct()
	{	
		$mes = e107::getMessage();
		$sql  = e107::getDB();
		$id = $_GET['cat-id'];
		if(!$sql->count('roster_sys'))
		{
		  $text = "No roster created.";
		  e107::getRender()->tablerender(LAN_RSYS_PAGE_ROSTER, $text);
		  require_once(FOOTERF);
		  exit;
		}
		elseif(!empty($id))
		{
			$this->rosterGenerate();
		}
		else
		{
			$this->rostercatagories();
		}
		
		echo $mes->render();
	}
	
	function rostercatagories()
	{	
		$sql  = e107::getDB();
		$tp = e107::getParser();
		$ns = e107::getRender();
		$text .= '';

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
						<th class='roster-parent-head'><a href='./roster.php?cat-id=".$parent['ros_id']."'>".$parent['ros_name']."</a></th>
					</tr>";
			foreach($RosterSet as $roster)
			{
				// Make Some Links to show whos on the rosters (new php page is required)
				if($parent['ros_id'] == $roster['ros_parent'])
				{
					$text .= "
					<tr class='roster-rest'>
						<td><a href='./roster.php?cat-id=".$roster['ros_id']."'>".$roster['ros_name']."</a></td>
					</tr>";
				}
				foreach($Subs as $sub)
				{
					if($roster['ros_id'] == $sub['ros_sub'] && $parent['ros_id'] == $roster['ros_parent'] )
					{
						$text .="
						<tr class='roster-subs'>
							<td><a href='./roster.php?cat-id=".$sub['ros_id']."'>".$sub['ros_name']."</a></td>
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
		// Render Table
		//e107::getRender()->tablerender(LAN_RSYS_ROSTER, $text);
		$ns->tablerender(LAN_RSYS_ROSTER, $text);
	}
	
	function rosterGenerate()
	{
		$id = $_GET['cat-id'];
		$sql  = e107::getDB();
		$tp = e107::getParser();
		$ns = e107::getRender();
		$text .= '';
		
		if(!empty($id))
		{
			//$rostID = $sql->select("roster_sys", "ros_id, ros_name", "ros_id LIKE '".$id."%'");
			// MAKE THE LEFT JOINS TOGETHER
			// Services Records - post_id
			$postRosterQ = "SELECT ro.ros_id, ro.userclass_id, ro.ros_name, ro.ros_parent, ro.ros_sub, ro.ros_order, ro.ros_show, po.post_id, po.post_name, po.post_order, po.post_parent 
			FROM `#roster_sys` AS ro
			LEFT JOIN `#postition_sys` AS po ON ro.ros_id = po.ros_id
			WHERE ro.ros_show != 0 AND po.ros_id = ".$id." ORDER BY po.post_order";
			$pRosters = $sql->retrieve($postRosterQ, true);
			$postQuery = "SELECT post_id, post_name, post_description, post_image, post_order, post_parent, post_sub, ros_id
			FROM `#postition_sys` 
			ORDER BY post_order";
			$Posts = $sql->retrieve($postQuery, true);
			$postSubQuery = "SELECT post_id, post_name, post_description, post_image, post_order, post_parent, post_sub, ros_id
			FROM `#postition_sys` 
			WHERE post_sub != 0 ORDER BY post_order";
			$PostSubs = $sql->retrieve($postSubQuery, true);
			// Need Service Records - May need to add more LEFT JOIN's
			$servicePost = "SELECT s.sr_id, s.user_id, s.clone_number, s.arma_id, s.ts_guid, s.battleeye_guid, s.recruiter_id, s.date_join, s.qual_id, s.awards_id, s.rank_id, s.awol_status, s.post_id, s.tis_date, s.tig_date, s.player_portrate, r.rank_id, r.rank_name, r.rank_shortname, r.rank_description, r.rank_image, u.user_id, u.user_name, p.post_id
			FROM `#service_records_sys` AS s
			LEFT JOIN `#ranks_sys` AS r ON s.rank_id = r.rank_id
			LEFT JOIN `#user` AS u ON s.user_id = u.user_id
			LEFT JOIN `#postition_sys` AS p ON s.post_id = p.post_id
			";
			$SRecords = $sql->retrieve($servicePost, true);
			// If something is something then lets show that something
			$text .= "
			<div id='roster'>
				<table class='table table-border'>
					<colgroup>
						<col>
					</colgroup>
					<tbody>";
			// Foreach Testing Area
			foreach($pRosters as $poro)
			{
				$text .= "<tr>
							<th>".$poro['post_name']."</th>
						</tr>";
				foreach($Posts as $pos)
				{
					// If Statement
					if($poro['post_id'] == $pos['post_parent'])
					{
						$text .= "<tr>
								<td>".$pos['post_name']."</td>
							</tr>";
					}
					
					// Next for Service Records
					foreach($SRecords as $record)
					{
						//if($pos['post_id'] == $record['post_id'])
						if($record['post_id'] == $pos['post_id'])
						{
							//$tp->toDate($row['expected_date'], 'short')
							// Image Code
							$rankATT = array('w'=> 50, 'h' => 50, 'class' => $record['rank_name'], 'alt' => $record['rank_shortname'].' - '.$record['rank_description'].'', 'x' => 0, 'crop' => 0);
							$rankImg = $tp->toImage($record['rank_image'], $rankATT);
							// Rank(Image)(Alt-Text=[Name])/User Name/
							$text .= "<tr>
										<td></td>
										<td>".$rankImg."</td>
										<td><a href=''>".$record['user_name']."</a></td>
										<td>".$record['clone_number']."</td>
										<td>".$tp->toDate($record['tis_date'], 'short')."</td>
										<td>".$tp->toDate($record['tig_date'], 'short')."</td>
										<td></td>
										<td></td>
									</tr>";
						}
					}
					
				}
			}
			
			$text .= "</tbody>
				</table>
			</div>";
		}
		
		$text .= "Work In Progress";
		
		$ns->tablerender(LAN_RSYS_ROSTER, $text);
	}
}
require_once(FOOTERF);
exit; 
?>