<?php

if (!defined('e107_INIT')) { exit; }


// v2.x Standard

class awards_rss // plugin-folder + '_rss'
{
	
	private $showImages         = true;
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
		

		$this->showImages = true;

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
				$rss[$i]['link']			= "awards/index.php";
				$rss[$i]['linkid']			= $row['award_id'];
				$rss[$i]['title']			= "".$row['user_name']." recieved the ".$row['award_name'];
				$rss[$i]['description']		= "".$this->getMedia($row['award_image'])." ".$row['award_description'];
				$rss[$i]['datestamp']		= $row['awarded_date'];
				//$rss[$i]['media']            = $this->getMedia($row);
				$i++;
			}

		}

		return $rss;
	}

	function getMedia($row)
	{
		$tp = e107::getParser();
		
		if(empty($this->showImages) ||  empty($row['award_image']))
		{
			return '';
		}
		
		$tmp = explode(",", $row['award_image']);

		$ret = array();
		
				foreach($tmp as $v)
		{

			if($tp->isImage($v))
			{
				$ret[] =  array(
					'media:content'   => array(
						'url'=>$tp->thumbUrl($v,array('w'=>75,'h'=>25), true, true),
						'medium'=>'image',
						'value' => array('media:title'=> array('type'=>'html', 'value'=>basename($v)))

					)
				);
			}
			elseif($tp->isVideo($v))
			{
				list($code,$type) = explode(".",$v);

				if($type == 'youtube')
				{

					//TODO Needs to be verified as working.
					$ret[] = array(
						'media:player'  => array('url'=>"http://www.youtube.com/embed/".$code, 'height'=>"560", 'width'=>"315" )
					);

				}
			}
		}

		return $ret;
	}


}
