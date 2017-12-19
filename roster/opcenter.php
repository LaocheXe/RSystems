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



class roster_front
{

	function __construct()
	{
		e107::js('roster','js/my.js','jquery');	// Load Plugin javascript and include jQuery framework
		e107::css('roster','css/my.css');		// load css file
		e107::lan('roster'); 					// load language file ie. e107_plugins/roster/languages/English.php
		e107::meta('keywords','some words');	// add meta data to <HEAD>

	}


	public function run()
	{

		$sql = e107::getDB(); 					// mysql class object
		$tp = e107::getParser(); 				// parser for converting to HTML and parsing templates etc.
		$frm = e107::getForm(); 				// Form element class.
		$ns = e107::getRender();				// render in theme box.


		$text = '';


	//	$sc = e107::getScBatch('roster',true, 'roster');
	//	$template = e107::getTemplate('roster','roster','default');

	//	$text = $tp->parseTemplate($template['start'],true, $sc);

		if($rows = $sql->retrieve('roster','*',false,'',true)) 	// combined select and fetch function - returns an array.
		{
			// print_a($rows);
			foreach($rows as $key=>$value)		// loop throug
			{

			//	$sc->setVars($value); // if shortcodes are enabled.
			//	$text .= $tp->parseTemplate($template['item'],true, $sc);

				$text .=  $tp->toHtml($value['roster_type'])."<br />";
			}

		//	$text .= $tp->parseTemplate($template['end'],true, $sc);

			$ns->tablerender("My Caption", $text);

		}



	}


}


$rosterFront = new roster_front;
require_once(HEADERF); 					// render the header (everything before the main content area)
$rosterFront->run();
require_once(FOOTERF);					// render the footer (everything after the main content area)
exit; 

// For a more elaborate plugin - please see e107_plugins/gallery

?>