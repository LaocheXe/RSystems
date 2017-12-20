<?php
	

// roster Shortcodes file

if (!defined('e107_INIT')) { exit; }

class plugin_roster_roster_shortcodes extends e_shortcode
{
	
	public function __construct()
	{
		
	}
		// Count the number of leave of absence that are pending in the database - {LOA_P} - eXe
	function sc_loa_p()
	{
		//TODO
		$sql  = e107::getDB();
		
		$query = "SELECT * FROM #loa_sys WHERE auth_status = 0";
		
		$result = $sql->count($query, true);
		
		return $result;
	}
	
	// Count the number of leave of absence that are approved in the database - {LOA_A} - eXe
	function sc_loa_a()
	{
		$sql  = e107::getDB();
		
		$query = "SELECT * FROM #loa_sys WHERE auth_status = 1";
		
		$result = $sql->count($query, true);
		
		return $result;
	}
	
	// Count the number of after action reports in the database - {AAR_COUNTER} - eXe
	function sc_aar_counter()
	{
		//TODO	
	}
	
	// Count the number of awards in the database - {AWARDS_COUNTER} - eXe
	function sc_awards_counter()
	{
		//TODO	
	}
	
	////////////////////////////////////
	//////// Next set is for Time Zones
	// Pacific Standard Time - {PACIFIC_TIME} - eXe
	function sc_pacific_time()
	{
		// Set PST
		date_default_timezone_set("US/Pacific");
		//$this->times['pacific'] = strftime($this->settings['clock_long']);
		$dateTime = date('M d, Y - h:I');
		
		return $dateTime;
		
		
		
		// Set MST
//		date_default_timezone_set("US/Mountain");
//		$this->times['mountain'] = strftime($this->settings['clock_long']);

		// Set CST
//		date_default_timezone_set("US/Central");
//		$this->times['central'] = strftime($this->settings['clock_long']);

		// Set EST
//		date_default_timezone_set("US/Eastern");
//		$this->times['eastern'] = strftime($this->settings['clock_long']);
	}
}