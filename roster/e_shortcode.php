<?php
/*
* Copyright (c) e107 Inc e107.org, Licensed under GNU GPL (http://www.gnu.org/licenses/gpl.txt)
* $Id: e_shortcode.php 12438 2011-12-05 15:12:56Z secretr $
*
* Featurebox shortcode batch class - shortcodes available site-wide. ie. equivalent to multiple .sc files.
*/

if(!defined('e107_INIT'))
{
	exit;
}



class roster_shortcodes extends e_shortcode
{
	//public $override = false; // when set to true, existing core/plugin shortcodes matching methods below will be overridden. 
	public $counter = 1;
	public $item = false;
	private $share = false;
	private $datestamp = false;
	private $questionCharLimit = 255;

	// Example: {_BLANK_CUSTOM} shortcode - available site-wide.
	//function sc_roster_custom($parm = null)  // Naming:  "sc_" + [plugin-directory] + '_uniquename'
	//{
	//	return "Hello World!";
	//}
	
	function sc_rank_counter($parm='')
	{
		return $this->counter;	
	}
	
	function sc_rank_category($parm = '')
	{		
		$tp = e107::getParser();
		$url = e107::url('roster','rank_category', $this->var); //@See faqs/e_url.php 
		return "<a href='".$url."'>".$tp->toHTML($this->var['rank_name'])."</a>";	
	}
	
	function sc_rank_caturl()
	{
		return e107::url('roster', 'ranks_category', $this->var);
	}
	
	function sc_rank_caption()
	{

		$customCaption = e107::pref('roster', 'page_title');

		if(!empty($customCaption))
		{
			return e107::getParser()->toHtml($customCaption,true);
		}

		return 'This is Caption';
	}
	
	

	
}