<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2015 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *
*/

if (!defined('e107_INIT')) { exit; }

//v2.x Standard for extending menu configuration within Menu Manager. (replacement for v1.x config.php)
	
class rsystems_menu
{
	function __construct()
	{
		// e107::lan('rsystems','menu',true); // English_menu.php or {LANGUAGE}_menu.php
	}

	/**
	 * Configuration Fields.
	 * @return array
	 */
	public function config($menu='')
	{

		$fields = array();
		$fields['rsystemsCaption']      = array('title'=> "Caption", 'type'=>'text', 'multilan'=>true, 'writeParms'=>array('size'=>'xxlarge'));
		$fields['rsystemsCount']        = array('title'=> "Enabled", 'type'=>'number');
		$fields['rsystemsCustom']       = array('title'=> "Enabled", 'type'=>'method'); // see below.

        return $fields;

	}

}

// optional - for when using custom methods above.

class rsystems_menu_form extends e_form
{

	function rsystemsCustom($curVal)
	{

		$frm = e107::getForm();
		$opts = array(1,2,3,4);
		$frm->select('rsystemsCustom', $opts, $curVal);


	}


}


?>