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
		return $result;
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
		// Working On It
		$text .= "1138";
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