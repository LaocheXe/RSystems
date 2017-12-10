<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2013 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * e107 Blank Plugin
 *
*/
if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

//if (!vartrue($RANKS_VIEW_TEMPLATE))
//{
//	if (file_exists(THEME."ranks_template.php"))
//	{
	//	require_once (THEME."faqs_template.php");
//	}
//	else
//	{
	//	require_once (e_PLUGIN."faqs/templates/faqs_template.php");
//	}
//}



class roster_ranks_front
{

	function __construct()
	{
		//e107::js('roster','js/my.js','jquery');	// Load Plugin javascript and include jQuery framework
		e107::css('roster','css/ranks.css');		// load css file
		//e107::lan('roster'); 					// load language file ie. e107_plugins/roster/languages/English.php
		//e107::meta('keywords','some words');	// add meta data to <HEAD>

	}


	public function run()
	{

		$sql = e107::getDB(); 					// mysql class object
		$tp = e107::getParser(); 				// parser for converting to HTML and parsing templates etc.
		$ns = e107::getRender();				// render in theme box.
		
		$rows = $sql->retrieve('ranks_sys', '*', false, '', true);
		$parent = $rows['rank_parent'];
		$order = $rows['rank_order'];

		$this->permList = array();
		$qryList = array();

		$qryList['view'] = "
		SELECT r.rank_id, r.rank_parent
		FROM `#ranks_sys` AS r
		LEFT JOIN `#ranks_sys` AS rp ON r.rank_parent = rp.rank_id
		WHERE r.rank_parent != 0 AND rp.rank_id IS NOT NULL
		";
		
		$text = '';
		
		foreach($qryList as $key => $qry)
		{
			if($sql->gen($qry))
			{
				$tmp = array();
				while($row = $sql->fetch())
				{
					$tmp[$row['rank_id']] = 1;
					$tmp[$row['rank_parent']] = 1;
				}
				$text .= $qryList;
			}
		}
		
		$ns->tablerender("Ranks", $text);
		//return (in_array('Ranks', $this->permList[$type]));

	/*	if($rows = $sql->retrieve('ranks_sys', 'rank_id, rank_name, rank_shortname, rank_description, rank_image, rank_parent, rank_order', false, '', true))
		{
			//$rows = $sql->select('ranks_exesystem', '*');
			//foreach($rows as $key=>$value)
			//{
			//	if($value['rank_parent'] == '0')
			//	{
					//$text .= $row['rank_name'].' '.$row['rank_id'];
			//		$text .= $tp->toHtml($value['rank_name'])."<br />";
					//$text .=  $tp->toHtml($value['roster_type'])."<br />";
					//$text .= $tp->parseTemplate($template['item'],true, $sc);
			//	}
			//	else if($value['rank_parent'] == '1')
			//	{
					//$text .= $row['rank_name'].' '.$row['rank_id'];
			//		$text .= $tp->toHtml($value['rank_name'])."<br />";
			//	}
			//	else if($value['rank_parent'] == '2')
			//	{
					//$text .= $row['rank_name'].' '.$row['rank_id'];
			//		$text .= $tp->toHtml($value['rank_name'])."<br />";
			//	}
			//}
			foreach ($rows['rank_parent'] == 0 as $parent)
			{
				$text .= $rows['rank_name'];
			//	foreach($parent =)
			//	{
					
			//	}
			}
			
			$ns->tablerender("My Caption", $text);
		}
 	*/

	}


/*	private function renderComments()
	{
		 // Returns a rendered commenting area. (html) v2.x
		 // This is the only method a plugin developer should require in order to include user comments.
		 // @param string $plugin - directory of the plugin that will own these comments.
		 // @param int $id - unique id for this page/item. Usually the primary ID of your plugin's database table.
		 // @param string $subject
		 // @param bool|false $rate true = will rendered rating buttons, false will not.
		 // @return null|string
		 //

		$plugin = 'roster';
		$id     = 3;
		$subject = 'My roster item subject';
		$rate   = true;

		$ret = e107::getComment()->render($plugin, $id, $subject, $rate);

		e107::getRender()->tablerender($ret['caption'],$ret['comment_form']. $ret['comment']);


	}
*/


}


$rosterFront = new roster_ranks_front;
require_once(HEADERF); 					// render the header (everything before the main content area)
$rosterFront->run();
require_once(FOOTERF);					// render the footer (everything after the main content area)
exit; 

// For a more elaborate plugin - please see e107_plugins/gallery

?>