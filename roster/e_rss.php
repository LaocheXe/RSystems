<?php

if (!defined('e107_INIT')) { exit; }


// v2.x Standard
// being used for LOA
class roster_rss // plugin-folder + '_rss'
{
	/**
	 * Admin RSS Configuration
	 */
	function config()
	{
		$config = array();

		$config[] = array(
			'name'			=> 'Leave of Absence',
			'url'			=> 'roster',
			'topic_id'		=> '',
			'description'	=> 'this is the rss feed for leave of absence', // that's 'description' not 'text'
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
		$myQuery = "SELECT l.loa_id,l.user_id,l.sr_id,l.rank_id,l.post_id,l.submit_date,l.effective_date,l.expected_date,l.explanation,l.auth_id,l.auth_status,l.return_status,u.user_id,u.user_name,u.user_image FROM `#loa_sys` AS l
		LEFT JOIN `#user` AS u ON l.user_id = u.user_id
		WHERE l.sr_id > 0 ORDER BY loa_id DESC LIMIT 0,".$parms['limit'];
		//if($items = $sql->select('loa_sys', "*", "ORDER BY `loa_id` DESC LIMIT 0,".$parms['limit']))
		if($items = $sql->retrieve($myQuery))
		{

			while($row = $sql->fetch())
			{

				$rss[$i]['author']			.= $row['user_name'];
				$rss[$i]['author_email']	.= "";
				$rss[$i]['link']			.= "roster/loa.php?rssID=".$row['loa_id'];
				$rss[$i]['linkid']			.= $row['loa_id'];
				$rss[$i]['title']			.= "".$tp->toDate($row['effective_date'], 'short')." - ".$tp->toDate($row['expected_date'], 'short')."";
				$rss[$i]['description']		.= $row['roster_message'];
				$rss[$i]['category_name']	.= '';
				$rss[$i]['category_link']	.= '';
				$rss[$i]['datestamp']		.= $tp->toDate($row['submit_date'], 'short');
				$rss[$i]['enc_url']			.= "";
				$rss[$i]['enc_leng']		.= "";
				$rss[$i]['enc_type']		.= "";
				$i++;
			}

		}

		return $rss;
	}
}
