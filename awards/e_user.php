<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

if (!defined('e107_INIT')) { exit; }

// v2.x Standard 
class awards_user // plugin-folder + '_user'
{		
		
	function profile($udata)  // display on user profile page.
	{
		//$sqlSR = e107::getDB();
		//$tp = e107::getParser();
		//$count = $sql->retrieve('user_extended', 'user_plugin_forum_posts', 'user_extended_id = '.$udata['user_id']);
		//$service_records = $sql->retrieve('service_records_sys', '*', true);
		//$sr = $sqlSR->retrieve('service_records_sys', '*', 'WHERE user_id = ' .$udata['user_id']);
		//$srRI = $sqlSR->retrieve('ranks_sys', '*', 'WHERE rank_id = '  .$sr['rank_id']);
		//$srPO = $sqlSR->retrieve('postition_sys', '*', 'WHERE post_id = ' .$sr['post_id']);
		//$att = array('w' => 50, 'h' => 50, 'class' => $srRI['rank_name'], 'alt' => $srRI['rank_name'], 'x' => 0, 'crop' => 0);
		//$imageCode = $tp->toImage($srRI['rank_image'], $att);
		//$now = time();
		//$tIs = $sr['tis_date'];
		//$tIg = $sr['tig_date'];
		/*$query1 = "
SELECT r.rank_id, r.rank_parent, r.rank_shortname, r.rank_name, r.rank_description, r.rank_image FROM `#ranks_sys` AS r
LEFT JOIN `#ranks_sys` AS rp ON r.rank_parent = rp.rank_id
WHERE r.rank_parent != 0 AND rp.rank_id IS NOT NULL ORDER BY r.rank_order
";*/
		$sql = e107::getDB();
		$tp = e107::getParser();
		$awardsQuery = "SELECT ar.award_id,ar.award_name,ar.award_image FROM `#awards_sys` AS ar
		LEFT JOIN `#awarded_sys` AS ad ON ar.award_id = ad.award_id
		WHERE ad.user_id = ".$udata['user_id']."";
		$awards = $sql->retrieve($awardsQuery, true);
		$att = array('w' => 50, 'h' => 50, 'class' => $awards['award_name'], 'alt' => $awards['award_name'], 'x' => 0, 'crop' => 0);
		$imageCode = $tp->toImage($awards['award_image'], $att);
		if(!empty($awards))
		{
			$var = array(
			1 => array('label' => "Awards", 'text' => $imageCode, 'url' => "/awards")
			);
		}
		else
		{
			$var = "";
		}
		
		return $var;
	}



	function fields()
	{

		$fields = array(



		);


	}


	
}