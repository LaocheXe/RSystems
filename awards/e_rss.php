<?php

if (!defined('e107_INIT')) { exit; }


// v2.x Standard

class awards_rss // plugin-folder + '_rss'
{
	/**
	 * Admin RSS Configuration
	 */
	function config()
	{
		$config = array();

		$config[] = array(
			'name'			=> 'Recent Awards',
			'url'			=> '/awards',
			'topic_id'		=> '',
			'description'	=> 'this is the rss feed for the awards plugin', // that's 'description' not 'text'
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

		if($items = $sql->select('awards', "*", "awards_field = 1 LIMIT 0,".$parms['limit']))
		{

			while($row = $sql->fetch())
			{

				$rss[$i]['author']			= $row['awards_user_id'];
				$rss[$i]['author_email']	= $row['awards_user_email'];
				$rss[$i]['link']			= "awards/awards.php?";
				$rss[$i]['linkid']			= $row['awards_id'];
				$rss[$i]['title']			= $row['awards_title'];
				$rss[$i]['description']		= $row['awards_message'];
				$rss[$i]['category_name']	= '';
				$rss[$i]['category_link']	= '';
				$rss[$i]['datestamp']		= $row['awards_datestamp'];
				$rss[$i]['enc_url']			= "";
				$rss[$i]['enc_leng']		= "";
				$rss[$i]['enc_type']		= "";
				$i++;
			}

		}

		return $rss;
	}



}
