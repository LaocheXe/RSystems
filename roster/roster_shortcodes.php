<?php
	

// roster Shortcodes file

if (!defined('e107_INIT')) { exit; }

class plugin_roster_shortcodes extends e_shortcode
{
	
	function __construct()
	{
		
	}

	// Count the number of ranks in the database - {RANK_COUNTER} - eXe
	function sc_rank_counter()
	{	
		$sql  = e107::getDB();
		$result = '<a href="/ranks">'.$sql->count("ranks_sys", "(*)", "WHERE rank_parent != '0'").'</a>';
		return $result;
	}
	
	// Count the number of service records in the database - {ACTIVE_MEMBERS} - eXe
	function sc_active_members()
	{
		$sql  = e107::getDB();
		$result = $sql->count("service_records_sys", "(*)", "WHERE awol_status <= '1'");
		if(!empty($result))
		{
			return $result;
		}
		else
		{
			return "To many to count";
		}
	}
	
	// Count the number of leave of absence that are pending in the database - {LOA_P} - eXe
	function sc_loa_p()
	{
		$sql  = e107::getDB();
		$result = $sql->count("loa_sys", "(*)", "WHERE auth_status = '0'");
		return $result;
	}
	
	// Count the number of leave of absence that are approved in the database - {LOA_A} - eXe
	function sc_loa_a()
	{
		$sql  = e107::getDB();
		$result = $sql->count("loa_sys", "(*)", "WHERE auth_status = '1'");
		return $result;
	}
	
	// Count the number of after action reports in the database - {AAR_COUNTER} - eXe
	function sc_aar_counter()
	{
		//$resultLOAa = $sql->count("aar_sys", "(*)", "where auth_status = '1'");
		//return $resultLOAa;
	}
	
	// Count the number of awards in the database - {AWARDS_COUNTER} - eXe
	function sc_awards_counter()
	{
		$sql  = e107::getDB();
		$result = '<a href="/awards">'.$sql->count("awards_sys", "(*)").'</a>';
		return $result;	
	}
	
	function sc_active_loa_clonenumber()
	{
		$sql = e107::getDB();
		
		$text .= "";
		return $text;
	}
	
	function sc_active_loa_name()
	{
		$text .= "Cruisie";
		return $text;
	}
	
	function sc_active_loa_explanation()
	{
		$text .= "Still working on adding new bugs to the system";
		return $text;
	}
	
	function sc_active_loa_returndate()
	{
		$text .= "Sometime in 2018";
		return $text;
	}
	
	function sc_recent_awards()
	{
		$sql  = e107::getDB();
		$tp = e107::getParser();
		//$users = $sql->retrieve('user', true);
		//$countAwarded = $sql->count("awarded_sys", "(*)");
		$number_rows = $countAwarded - 5;
		$awardsQuery = "SELECT ar.award_id,ar.award_name,ar.award_image,ad.awarded_date,us.user_name FROM `#awards_sys` AS ar
		LEFT JOIN `#awarded_sys` AS ad ON ar.award_id = ad.award_id
		LEFT JOIN `#user` AS us ON ad.user_id = us.user_id
		ORDER BY ad.awarded_id DESC LIMIT 5";
		$results = $sql->retrieve($awardsQuery, true);
		foreach($results as $result)
		{
			$att = array('w' => 75, 'h' => 25, 'class' => $result['award_name'], 'alt' => $result['award_name'], 'x' => 0, 'crop' => 0);
			$imageCode = $tp->toImage($result['award_image'], $att);
			$theDate = $result['awarded_date'];
			
			$text .= "<tr>
						<td><a href='../user/".$result['user_name']."'>".$result['user_name']."</a></td>".//Name
						"<td>".$imageCode."</td>".//Award
						"<td>".$tp->toDate($theDate)."</td>".// Date
					"</tr>";
		}
		return $text;	
	}
	
	////////////////////////////////////
	//////// Next set is for Time Zones
	// Pacific Standard Time - {PACIFIC_TIME} - eXe
	function sc_pacific_time()
	{
		date_default_timezone_set("US/Pacific");
		$dateTime = date('F d, Y - h:i A');	
		return $dateTime;
	}
	// Moutain Standard Time - {MOUNTAIN_TIME} - eXe
	function sc_mountain_time()
	{
		date_default_timezone_set("US/Mountain");
		$dateTime = date('F d, Y - h:i A');	
		return $dateTime;	
	}
	// Central Standard Time - {CENTRAL_TIME} - eXe
	function sc_central_time()
	{
		date_default_timezone_set("US/Central");
		$dateTime = date('F d, Y - h:i A');	
		return $dateTime;
	}
	// Eastern Standard Time - {EASTERN_TIME} - eXe
	function sc_eastern_time()
	{
		date_default_timezone_set("US/Eastern");
		$dateTime = date('F d, Y - h:i A');	
		return $dateTime;
	}
	// London Standard Time - {LONDON_TIME} - eXe
	function sc_london_time()
	{
		date_default_timezone_set("Europe/London");
		$dateTime = date('F d, Y - h:i A');	
		return $dateTime;	
	}
	// Rome Standard Time - {ROME_TIME} - eXe
	function sc_rome_time()
	{
		date_default_timezone_set("Europe/Rome");
		$dateTime = date('F d, Y - h:i A');	
		return $dateTime;	
	}
	
	function sc_german_time()
	{
		date_default_timezone_set("Europe/Berlin");
		$dateTime = date('F d, Y - h:i A');	
		return $dateTime;
	}
	
	function sc_sf_time()
	{
		
	}
	
	function sc_sg_time()
	{
		
	}
	
	function sc_sh_time()
	{
		
	}
}

?>