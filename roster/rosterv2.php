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
e107::css('roster','roster.css');
e107::js('roster','js/roster.js');
require_once(HEADERF);



if(USERID || !USERID)
{
	new listRoster;
}

class listRoster
{
	function __construct()
	{	
		$mes = e107::getMessage();
		$this->rosterGenerate();
	}
	
	function rosterGenerate()
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
		LEFT JOIN `#postition_sys` AS p ON s.post_id = p.post_id";
		$SRecords = $sql->retrieve($servicePost, true);
		
		/*$text .= "
			<div id='roster'>
				<table class='table table-border'>
					<colgroup>
						<col>
					</colgroup>				
		";*/
		
		foreach($pRosters as $poro)
		{
			foreach($Posts as $pos)
			{
				// If Statement
				if($poro['post_id'] == $pos['post_parent'])
				{
					$billet .= "
					<div class='content'>
						<p>".$pos['post_name']."
						";
				}
				
				foreach($SRecords as $record)
				{
					if($pos['post_id'] == $record['post_id'])
					{
						// Image Code
						$rankATT = array('w'=> 50, 'h' => 50, 'class' => $record['rank_name'], 'alt' => $record['rank_shortname'].' - '.$record['rank_description'].'', 'x' => 0, 'crop' => 0);
						$rankImg = $tp->toImage($record['rank_image'], $rankATT);
						
						$serviceRecord .= "<table>
									<tr>
										<td></td>
										<td>".$rankImg."</td>
										<td><a href=''>".$record['user_name']."</a></td>
										<td>".$record['clone_number']."</td>
										<td>".$tp->toDate($record['tis_date'], 'short')."</td>
										<td>".$tp->toDate($record['tig_date'], 'short')."</td>
										<td></td>
										<td></td>
									</tr>
									</table>
									</p>
									</div>";
					}
				}
			}
		}
		
		$text .= "
				<div id='roster'>
					<colgroup>
						<col>
					</colgroup>";
		
		// For eachs their own
		foreach($Parents as $parent)
		{
			$text .= "
					<button class='collapsible'>".$parent['ros_name']."</button>
					
						".$billet."
						".$serviceRecord."
					";
			// Foreach
			foreach($RosterSet as $roster)
			{
				if($parent['ros_id'] == $roster['ros_parent'])
				{
					$text .= "
					<button class='collapsible'>".$roster['ros_name']."</button>
					".$billet."
						".$serviceRecord."
					";
				}
				
				// Foreach
				foreach($Subs as $sub)
				{
					if($roster['ros_id'] == $sub['ros_sub'] && $parent['ros_id'] == $roster['ros_parent'] )
					{
						$text .="
							<button class='collapsible'>".$sub['ros_name']."</button>
							".$billet."
						".$serviceRecord."
							";
					}
				}
			}
		}
		
		$text .= "</div>";
		
		$ns->tablerender(LAN_RSYS_ROSTER, $text);
	}
}



require_once(FOOTERF);
exit; 
?>