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
		$sql = e107::getDB();
		$tp = e107::getParser();
		//$getAwards = $sql->retrieve('awards_sys', '(*)', true);
		$awardsQuery = "SELECT ar.award_id,ar.award_name,ar.award_image FROM `#awards_sys` AS ar
		LEFT JOIN `#awarded_sys` AS ad ON ar.award_id = ad.award_id
		WHERE ad.user_id = ".$udata['user_id']."";
		
		$awards = $sql->retrieve($awardsQuery, true);
		foreach ($awards as $award)
		{
			$att = array('w' => 75, 'h' => 25, 'class' => $award['award_name'], 'alt' => $award['award_name'], 'x' => 0, 'crop' => 0);
			$imageCode .= $tp->toImage($award['award_image'], $att);
			//$text = "<marquee>".$imageCode."</marquee>";
		}
		
		if(!empty($awards))
		{
			$var = array(
			1 => array('label' => "Awards", 'text' => $imageCode)
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