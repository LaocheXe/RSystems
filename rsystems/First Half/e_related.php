<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2014 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Related configuration module - News
 *
 *
*/

if (!defined('e107_INIT')) { exit; }



class rsystems_related // include plugin-folder in the name.
{


	function compile($tags,$parm=array()) 
	{
		$sql = e107::getDb();
		$items = array();
			
		$tag_regexp = "'(^|,)(".str_replace(",", "|", $tags).")(,|$)'";
		
		$query = "SELECT * FROM `#rsystems` WHERE rsystems_id != ".$parm['current']." AND rsystems_keywords REGEXP ".$tag_regexp."  ORDER BY rsystems_datestamp DESC LIMIT ".$parm['limit'];
			
		if($sql->gen($query))
		{		
			while($row = $sql->fetch())
			{

				$items[] = array(
					'title'			=> varset($row['rsystems_title']),
					'url'			=> e107::url('other',$row), // '{e_BASE}news.php?extend.'.$row['news_id'],
					'summary'		=> varset($row['rsystems_summary']),
					'image'			=> '{e_PLUGIN}rsystems/images/image.png'
				);
			}
			
			return $items;
	    }
		elseif(ADMIN)
		{
		//	return array(array('title'=>$query,'url'=>''));	
		}
	}
	
}



?>