<?php

if (!defined('e107_INIT')) { exit; }


// v2.x Standard

class rsystems_rss // plugin-folder + '_rss'
{
	/**
	 * Admin RSS Configuration
	 */
	function config()
	{
		$config = array();

		$config[] = array(
			'name'			=> 'Feed Name',
			'url'			=> 'rsystems',
			'topic_id'		=> '',
			'description'	=> 'this is the rss feed for the rsystems plugin', // that's 'description' not 'text'
			'class'			=> e_UC_MEMBER,
			'limit'			=> '9'
		);

		return $config;
	}

	/**
	 * Compile RSS Data
	 * @param array $parms
	 * @param string $parms['url']
	 * @param int $parms['limit']
	 * @param int $parms['id']
	 * @return array
	 */
	function data($parms=array())
	{
		$sql = e107::getDb();

		$rss = array();
		$i=0;

		if($items = $sql->select('rsystems', "*", "rsystems_field = 1 LIMIT 0,".$parms['limit']))
		{

			while($row = $sql->fetch())
			{

				$rss[$i]['author']			= $row['rsystems_user_id'];
				$rss[$i]['author_email']	= $row['rsystems_user_email'];
				$rss[$i]['link']			= "rsystems/rsystems.php?";
				$rss[$i]['linkid']			= $row['rsystems_id'];
				$rss[$i]['title']			= $row['rsystems_title'];
				$rss[$i]['description']		= $row['rsystems_message'];
				$rss[$i]['category_name']	= '';
				$rss[$i]['category_link']	= '';
				$rss[$i]['datestamp']		= $row['rsystems_datestamp'];
				$rss[$i]['enc_url']			= "";
				$rss[$i]['enc_leng']		= "";
				$rss[$i]['enc_type']		= "";
				$i++;
			}

		}

		return $rss;
	}



}
