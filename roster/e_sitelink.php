<?php
/*
 * e107 website system
 *
 * Copyright (C) 2008-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 * Sitelinks configuration module - gsitemap
 *
 * $Source: /cvs_backup/e107_0.8/e107_plugins/roster/e_sitelink.php,v $
 * $Revision$
 * $Date$
 * $Author$
 *
*/

if (!defined('e107_INIT')) { exit; }
/*if(!e107::isInstalled('roster'))
{ 
	return;
}*/



class roster_sitelink // include plugin-folder in the name.
{
	function config()
	{
		global $pref;
		
		$links = array();
			
//		$links[] = array(
//			'name'			=> "Drop-Down Links",
//			'function'		=> "myCategories"
//		);

		$links[]  = array(

			'name'          => 'Drop-Down Starcom',
			'function'      => 'starCom'
		);
		
		
		return $links;
	}
	

	function starCom() // http://bootsnipp.com/snippets/33gmp
	{
		$text = '<div class="dropdown-menu">
                    <div class="container-fluid2">
                            <ul class="nav-list list-inline">
                                <li><a href="#"><span>Personnel Data</span></a></li>
                                <li><a href="/ranks/"><span>Ranks and Insignia</span></a></li>
                                <li><a href="/awards/"><span>Awards and Commendations</span></a></li>
                                <li><a href="#"><span>Operations Center</span></a></li>
                            </ul>
                    </div>
				</div>			';

		return $text;

	}







//	function myCategories()
//	{
//		$sql = e107::getDb();
//		$tp = e107::getParser();
//		$sublinks = array();
		
//		$sql->select("roster","*","roster_id != '' ");
		
//		while($row = $sql->fetch())
//		{
//			$sublinks[] = array(
//				'link_name'			=> $tp->toHtml($row['roster_name'],'','TITLE'),
//				'link_url'			=> e107::url('roster', 'other', $row),
//				'link_description'	=> '',
//				'link_button'		=> $row['roster_icon'],
//				'link_category'		=> '',
//				'link_order'		=> '',
//				'link_parent'		=> '',
//				'link_open'			=> '',
//				'link_class'		=> e_UC_PUBLIC
//			);
//		}
		
//		return $sublinks;
	    
//	}
	
}
?>