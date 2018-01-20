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
class roster_user // plugin-folder + '_user'
{		
	function dateDiff($time1, $time2, $precision = 6)
	{
		if (!is_int($time1)) 
		{
      		$time1 = strtotime($time1);
   		}
    	if (!is_int($time2))
		{
    		  $time2 = strtotime($time2);
   		}
		 
		if ($time1 > $time2)
		{
      		$ttime = $time1;
     		$time1 = $time2;
      		$time2 = $ttime;
		}
		
		$intervals = array('year','month','day','hour','minute','second');
    	$diffs = array();
		
		// Loop thru all intervals
		foreach ($intervals as $interval)
		{
      		// Create temp time from time1 and interval
      		$ttime = strtotime('+1 ' . $interval, $time1);
      		// Set initial values
      		$add = 1;
      		$looped = 0;
      		// Loop until temp time is smaller than time2
      		while ($time2 >= $ttime)
			{
        		// Create new temp time from time1 and interval
        		$add++;
        		$ttime = strtotime("+" . $add . " " . $interval, $time1);
        		$looped++;
      		}
 
      		$time1 = strtotime("+" . $looped . " " . $interval, $time1);
      		$diffs[$interval] = $looped;
    	}
		
		$count = 0;
   		$times = array();
   	 	// Loop thru all diffs
    	foreach ($diffs as $interval => $value)
		{
      		// Break if we have needed precission
      		if ($count >= $precision) {
        	break;
      	}
      	// Add value and interval 
      	// if value is bigger than 0
      	if ($value > 0)
		{
        	// Add s if value is not 1
        	if ($value != 1)
			{
          		$interval .= "s";
        	}
        	// Add value and interval to times array
        	$times[] = $value . " " . $interval;
        	$count++;
      	}
    }

    // Return string with times
    return implode(", ", $times);
		
	}
	
		
	function profile($udata)  // display on user profile page.
	{
		$sqlSR = e107::getDB();
		$tp = e107::getParser();
		//$count = $sql->retrieve('user_extended', 'user_plugin_forum_posts', 'user_extended_id = '.$udata['user_id']);
		//$service_records = $sql->retrieve('service_records_sys', '*', true);
		$sr = $sqlSR->retrieve('service_records_sys', '*', 'WHERE user_id = ' .$udata['user_id']);
		$srRI = $sqlSR->retrieve('ranks_sys', '*', 'WHERE rank_id = '  .$sr['rank_id']);
		$srPO = $sqlSR->retrieve('postition_sys', '*', 'WHERE post_id = ' .$sr['post_id']);
		$att = array('w' => 50, 'h' => 50, 'class' => $srRI['rank_name'], 'alt' => $srRI['rank_name'], 'x' => 0, 'crop' => 0);
		$imageCode = $tp->toImage($srRI['rank_image'], $att);
		$now = time();
		$tIs = $sr['tis_date'];
		$tIg = $sr['tig_date'];
		if(!empty($sr))
		{
			$var = array(
			0 => array('label' => "Clone Number", 'text' => $sr['clone_number'], 'url' => ""),
			1 => array('label' => "Rank", 'text' => $imageCode, 'url' => "/ranks"),
			2 => array('label' => "Position", 'text' => $srPO['post_name'], 'url' => ""),
			3 => array('label' => "Time in Service", 'text' => $this->dateDiff(time(),$tIs-1000000, 2), 'url' => ""),
			4 => array('label' => "Time in Grade", 'text' => $this->dateDiff(time(),$tIg-1000000, 2), 'url' => "")
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