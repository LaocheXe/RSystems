<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * 
 * rsystems e_search addon 
 */
 

if (!defined('e107_INIT')) { exit; }

// v2.x e_search addon.


class rsystems_search extends e_search // include plugin-folder in the name.
{
		
	function config()
	{	
		$search = array(
			'name'			=> "Blank Plugin",
			'table'			=> 'rsystems',

			'advanced' 		=> array(
								'date'	=> array('type'	=> 'date', 		'text' => LAN_DATE_POSTED),
								'author'=> array('type'	=> 'author',	'text' => LAN_SEARCH_61)
							),
							
			'return_fields'	=> array('rsystems_id', 'rsystems_nick', 'rsystems_message', 'rsystems_datestamp'),
			'search_fields'	=> array('rsystems_nick' => '1', 'rsystems_message' => '1'), // fields and weights.
			
			'order'			=> array('rsystems_datestamp' => 'DESC'),
			'refpage'		=> 'chat.php'
		);


		return $search;
	}



	/* Compile Database data for output */
	function compile($row)
	{
		$tp = e107::getParser();

		preg_match("/([0-9]+)\.(.*)/", $row['rsystems_nick'], $user);

		$res = array();
	
		$res['link'] 		= e_PLUGIN."rsystems_menu/rsystems.php?".$row['rsystems_id'].".fs";
		$res['pre_title'] 	= LAN_SEARCH_7;
		$res['title'] 		= $user[2];
		$res['summary'] 	= $row['rsystems_message'];
		$res['detail'] 		= $tp->toDate($row['rsystems_datestamp'], "long");

		return $res;
		
	}



	/**
	 * Optional - Advanced Where
	 * @param $parm - data returned from $_GET (ie. advanced fields included. in this case 'date' and 'author' )
	 */
	function where($parm='')
	{
		$tp = e107::getParser();

		$qry = "";
		
		if (vartrue($parm['time']) && is_numeric($parm['time'])) 
		{
			$qry .= " rsystems_datestamp ".($parm['on'] == 'new' ? '>=' : '<=')." '".(time() - $parm['time'])."' AND";
		}

		if (vartrue($parm['author'])) 
		{
			$qry .= " rsystems_nick LIKE '%".$tp -> toDB($parm['author'])."%' AND";
		}
		
		return $qry;
	}
	

}

