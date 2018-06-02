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
			'url'			=> 'awards',
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
		$tp = e107::getParser();

		$rss = array();
		$i=0;
		
		$Query = "SELECT ad.awarded_id,ad.award_id,ad.user_id,ad.awarded_date,ar.award_id,ar.award_name,ar.award_description,ar.award_image,u.user_id,u.user_name,u.user_image FROM `#awarded_sys` AS ad
		LEFT JOIN `#awards_sys` AS ar ON ad.award_id = ar.award_id
		LEFT JOIN `#user` AS u ON ad.user_id = u.user_id
		ORDER BY awarded_id DESC LIMIT 0,".$parms['limit'];

		//if($items = $sql->select('awarded_sys', "*", "ORDER BY awarded_id DESC LIMIT 0,".$parms['limit']))
		if($items = $sql->retrieve($Query))
		{

			while($row = $sql->fetch())
			{
				$att = array('w' => 75, 'h' => 25, 'class' => $row['award_name'], 'alt' => $row['award_name'], 'x' => 0, 'crop' => 0);
				$imageCode = $tp->toImage($row['award_image'], $att);
				$ahh = array('w' => 75, 'h' => 75, 'class' => $row['user_name'], 'alt' => $row['user_name'], 'x' => 0, 'crop' => 0);

				$rss[$i]['author']			= $row['user_name'];
				$rss[$i]['author_email']	= '';
				$rss[$i]['link']			= "awards";
				$rss[$i]['linkid']			= $row['award_id'];
				$rss[$i]['title']			= "".$row['user_name']." recieved the ".$row['award_name'];
				$rss[$i]['description']		= $row['award_description'];
				$rss[$i]['category_name']	= '';
				$rss[$i]['category_link']	= '';
				$rss[$i]['datestamp']		= $row['awarded_date'];
				$rss[$i]['enc_url']			= "";
				$rss[$i]['enc_leng']		= "";
				$rss[$i]['enc_type']		= "";
				$i++;
			}

		}

		return $rss;
	}



}
