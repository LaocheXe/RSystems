<?php

if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

require_once(HEADERF);

//e107::lan('voice', true, true); // LAN
e107::css('roster','roster.css'); // CSS FIle

$sql  = e107::getDB();
$text = '';

if(!$sql->count('ranks_sys'))
{
  $text = "No ranks found.";
  e107::getRender()->tablerender('Ranks_WIP', $text);
  require_once(FOOTERF);
  exit;
}

// Figure it out Travis
//for ($i = 1; $i <= 4; $i++)
//{
	//$servers    = $sql->retrieve('voice_exesystem', 'voice_id, voice_name', 'voice_type = '.$i.'', true);
	//$qryList = array();
	//$qryList = "
	//	SELECT r.rank_id, r.rank_parent
	//	FROM `#ranks_sys` AS r
	//	LEFT JOIN `#ranks_sys` AS rp ON r.rank_parent = rp.rank_id
	//	WHERE r.rank_parent != 0 AND rp.rank_id IS NOT NULL
	//	";	
//}
// Debug - Show Qury Result
//$text .= $sql->retrieve($qryList);

$text .= "</ br>";
//$dbRanks = $sql->retrieve('ranks_sys', 'rank_id, rank_name, rank_shortname, rank_parent, rank_order, rank_image, rank_description', true);

//$text .= $sql->retrieve('ranks_sys', '*', true, true);
//if($dbRanks['rank_parent'] == 0)
//{
	//foreach($dbRanks as $dbRanks)
	//{
		//$text .= $dbRanks[''].' '.
	//}
	//$rankParent = $sql->retrieve('ranks_sys', 'rank_id, rank_order, rank_parent ORDER BY FIELD(rank_parent, '0')', true);
	//foreach()
	//{
		
	//}
function define_rParentName($rParent)
{
  switch ($rParent)
  {
    //case 0:
     // $sTypeName = LAN_VOI_TYPE_UNK;
     // break;
    case 0:
      $rParentName = "Debugging";
      break;
  }
 return $rParentName;
}

// FAQ Example - Testing
$filter = array(
		'all' => array(
			'ranks_category' => array('int', '0:'),
		),
	);

$tp = e107::getParser();

		$RANK_START = e107::getTemplate('roster', true, 'start');
		$RANK_END = e107::getTemplate('roster', true, 'end');
		$RANK_LISTALL = e107::getTemplate('roster', true, 'all');
		$RANK_CAPTION = e107::getTemplate('roster', true, 'caption');

//		$category = $this->getRequest()->getRequestParam('rank_category');
		$where = array();
		if($category)
		{
			$where[] = "r.rank_parent={$category}";
		}
		//$tag = $this->getRequest()->getRequestParam('tag');
		//if($tag)
		//{
		//	$where[] = "FIND_IN_SET ('".$tp->toDB($tag)."', r.rank_id)";
		//}
		
		if($where)
		{
			$where = ' AND '.implode(' AND ' , $where);
		}
		else $where = '';

		//$query = "
		//	SELECT f.*,cat.* FROM #faqs AS f 
		//	LEFT JOIN #faqs_info AS cat ON f.faq_parent = cat.faq_info_id 
		//	WHERE cat.faq_info_class IN (".USERCLASS_LIST."){$where} ORDER BY cat.faq_info_order,f.faq_order ";
		$query = "
			SELECT r.rank_id, r.rank_parent, r.rank_shortname, r.rank_name, r.rank_description, r.rank_image FROM `#ranks_sys` AS r
			LEFT JOIN `#ranks_sys` AS rp ON r.rank_parent = rp.rank_id
			{$where} r.rank_parent != 0 AND rp.rank_id IS NOT NULL ORDER BY r.rank_order
		";
		$sql->gen($query, false);
		
		$prevcat = "";
		$sc = e107::getScBatch('roster', true);
		//$sc->counter = 1;
		//$sc->tag = htmlspecialchars($tag, ENT_QUOTES, 'utf-8');
		$sc->category = $category;

		$text = $tp->parseTemplate($RANK_START, true, $sc);
		
		while ($rw = $sql->db_Fetch())
		{
			$sc->setVars($rw);	
			
			if($rw['rank_order'] != $prevcat)
			{
				if($prevcat !='')
				{
					$text .= $tp->parseTemplate($RANK_LISTALL['end'], true, $sc);
				}
				$text .= "\n\n<!-- Ranks Start ".$rw['rank_order']."-->\n\n";
				$text .= $tp->parseTemplate($RANK_LISTALL['start'], true, $sc);
				$start = TRUE;
			}

			$text .= $tp->parseTemplate($RANK_LISTALL['item'], true, $sc);
			$prevcat = $rw['rank_order'];
			$sc->counter++;
			if($category) $meta = $rw;
		}
		$text .= ($start) ? $tp->parseTemplate($RANK_LISTALL['end'], true, $sc) : "";
		$text .= $tp->parseTemplate($RANK_END, true, $sc);

/*
for ($i = 0; $i <= 0; $i++)
{
	$dbRankss    = $sql->retrieve('ranks_sys', 'rank_id, rank_name', 'rank_parent = '.$i.'', true);
	$rParentName  = define_rParentName($i); // call the define function to retrieve the appropriate sTypeName
	
	$text .= "<h3>".$rParentName."</h3>";
	//$text .= "<table border='1'>";
	
	foreach($dbRankss as $dbRanks)
	{
		$text .= '
    	<table border="1"><tr>
			<th>'.$dbRanks['rank_name'].'</th>
		</tr>';
//		for ($k = 1; $k >= 1; $k++)
//		{
			// Ranks Parents
			//$dbPRankss	= $sql->retrieve('ranks_sys', 'rank_id, rank_name', 'rank_parent = '.$k.'', true);
			//$dbFRankss	= $sql->retrieve('ranks_sys', 'rank_name, rank_shortname, rank_image', 'rank_parent = '.$k.'', true);
			$sqlRanks = "SELECT r.rank_id, r.rank_parent, r.rank_shortname, r.rank_name, r.rank_description, r.rank_image
		FROM `#ranks_sys` AS r
		LEFT JOIN `#ranks_sys` AS rp ON r.rank_parent = rp.rank_id
		WHERE r.rank_parent != 0 AND rp.rank_id IS NOT NULL";
			
			echo $sql->retrieve($sqlRanks);
			
			//$sql->gen($query, false);
			
			foreach($sql->gen($sqlRanks, false) as $dbFRank)
			{
				if($dbRanks['rank_id'] == 1)
				{
					$text .= '
					<tr>
						<td>'.$dbFRank['rank_image'].'</td>
						<td>'.$dbFRank['rank_id'].'</td>
						<td>'.$dbFRank['rank_shortname'].'</td>
						<td>'.$dbFRank['rank_name'].'</td>
					</tr>
					';
				}
				elseif($dbRanks['rank_id'] == 2)
				{
					$text .= '
					<tr>
						<td>'.$dbFRank['rank_image'].'</td>
						<td>'.$dbFRank['rank_id'].'</td>
						<td>'.$dbFRank['rank_shortname'].'</td>
						<td>'.$dbFRank['rank_name'].'</td>
					</tr>
					';
				}
				elseif($dbRanks['rank_id'] == 3)
				{
					$text .= '
					<tr>
						<td>'.$dbFRank['rank_image'].'</td>
						<td>'.$dbFRank['rank_id'].'</td>
						<td>'.$dbFRank['rank_shortname'].'</td>
						<td>'.$dbFRank['rank_name'].'</td>
					</tr>
					';
				}
				elseif($dbRanks['rank_id'] == 4)
				{
					$text .= '
					<tr>
						<td>'.$dbFRank['rank_image'].'</td>
						<td>'.$dbFRank['rank_id'].'</td>
						<td>'.$dbFRank['rank_shortname'].'</td>
						<td>'.$dbFRank['rank_name'].'</td>
					</tr>
					';
				}
			}
//		}
		//<td>'.$dbRanks['rank_image'].'</td>
		//<td>'.$dbRanks['rank_id'].'</td>
		//<td>'.$dbRanks['rank_shortname'].'</td>
		//<td>'.$dbRanks['rank_name'].'</td>
		$text .= '</table>';
	}
	
	$text .= "</table>";
}*/

//foreach($dbRanks as $dbRanks)
//{
//$rankImage = $dbRanks['rank_image'];
//$text .= $dbRanks['rank_id']."  ".$dbRanks['rank_name']."  ".$rankImage;
//}



e107::getRender()->tablerender('Ranks_WIP', $text);
require_once(FOOTERF);
exit;
?>