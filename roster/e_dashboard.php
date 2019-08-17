<?php
if (!defined('e107_INIT')) { exit; }


class roster_dashboard // include plugin-folder in the name.
{
	private $title; // dynamic title.
	
	function chart()
	{
		$config = array();


		$config[] = array(

			'text'		=> $this->activity(),
			'caption'	=> $this->title,
		);

		return $config;
	}


	/**
	 * Non-functional example.
	 * Chart of last 30 days.
	 * @return bool|string
	 */
	function activity()
	{
		$sql = e107::getDb();
		$cht = e107::getChart();
		$cht->setProvider('google');


		$id             = 'roster_activity_chart';

		$amt            = array();
		$ticks          = array();
		$data           = array();

		$width          = '100%';
		$height         = 450;

		$month_start    = strtotime('1 month ago');
		$month_end      = time()+7200;

		$label          = date('M Y', $month_start)." - ".date('M Y', $month_end);

		if(!$sql->gen("SELECT id,datestamp,referred FROM `#roster` WHERE datestamp BETWEEN ".$month_start." AND ".$month_end))
		{
			return false;
		}

		while($row = $sql->fetch())
		{

			$key = date('Y-n-j', $row['datestamp']);

			switch($row['referred'])
			{
				case "Facebook":
					$amt[$key]['facebook'] += 1;
					break;

				case "Google":
					$amt[$key]['google'] += 1;
					break;

				case "Bing":
					$amt[$key]['bing'] += 1;
					break;

				case "Friend":
					$amt[$key]['friend'] += 1;
				break;

				default:
					$amt[$key]['other'] += 1;

			}

			$dateName[$key] = date('jS', $row['datestamp']);
		}

		$sum = array_sum($amt);

		$data[] = array('Day', "Other", "Friend", "Bing", "Google", "Facebook" );


		$this->title = 'Referrals ('.$sum.')';

	//	$c = 0;
		foreach($amt as $k=>$v)
		{
			list($yearNumber,$monthNumber,$day) = explode('-',$k);
			$diz = date('D jS', mktime(1,1,1,$monthNumber,$day, $yearNumber));
			$data[] = array($diz, $amt[$k]['other'], $amt[$k]['friend'], $amt[$k]['bing'], $amt[$k]['google'], $amt[$k]['facebook']); //	$dateName[$i]
			$ticks[] = $k;
		//	$c++;
		}

		$options = array(
			'chartArea'	=>array('left'=>'40', 'right'=>20, 'width'=>'100%', 'top'=>'30'),
			'legend'	=> array('position'=> 'none', 'alignment'=>'center', 'textStyle' => array('fontSize' => 14, 'color' => '#ccc')),
			'vAxis'		=> array('title'=>null, 'minValue'=>0, 'maxValue'=>10, 'titleFontSize'=>16, 'titleTextStyle'=>array('color' => '#ccc'), 'gridlines'=>array('color'=>'#696969', 'count'=>5), 'format'=>'', 'textStyle'=>array('color' => '#ccc') ),
			'hAxis'		=> array('title'=>$label, 'slantedText'=>true, 'slantedTextAngle'=>60, 'ticks'=>$ticks, 'titleFontSize'=>14, 'titleTextStyle'=>array('color' => '#ccc'), 'gridlines' => array('color'=>'transparent'), 'textStyle'=>array('color' => '#ccc') ),
			'colors'	=> array('#999999', '#0D9071','#FEB801', '#DC493C', '#3B5999'),
			'animation'	=> array('duration'=>1000, 'easing' => 'out'),
			'areaOpacity'	=> 0.8,
			'isStacked' => true,

			'backgroundColor' => array('fill' => 'transparent' )
		);

		$cht->setType('column');
		$cht->setOptions($options);
		$cht->setData($data);


		return "<div>".$cht->render($id, $width, $height)."</div>";

	}
	
	
	function status() // Status Panel in the admin area
	{
		$sc = e107::getScBatch('roster', true); // loads e107_plugins/myplugin/roster_shortcodes.php

		$var[0]['icon'] 	= "<img src='".e_PLUGIN."roster/images/roster_16.png' alt='' />"; // TODO - Make Image
		$var[0]['title'] 	= "Active Members";
		$var[0]['url']		= e_PLUGIN_ABS."roster/admin_sr.php?mode=main&action=list&field=awol_status&asc=asc&from=0"; // TODO - Replace with correct page
		$var[0]['total'] 	= $sc->sc_active_members();
		
		$var[1]['icon'] 	= "<img src='".e_PLUGIN."roster/images/roster_16.png' alt='' />"; // TODO - Make Image
		$var[1]['title'] 	= "Inactive Members";
		$var[1]['url']		= e_PLUGIN_ABS."roster/admin_sr.php?mode=main&action=list&field=awol_status&asc=desc&from=0"; // TODO - Replace with correct page
		$var[1]['total'] 	= $sc->sc_inactive_members(); // TODO - Get Value
		
		$var[2]['icon'] 	= "<img src='".e_PLUGIN."roster/images/roster_16.png' alt='' />"; // TODO - Make Image
		$var[2]['title'] 	= "Active LOA's";
		$var[2]['url']		= e_PLUGIN_ABS."roster/roster.php"; // TODO - Replace with correct page
		$var[2]['total'] 	= $sc->sc_loa_active(); // TODO - Get Value
		
		$var[3]['icon'] 	= "<img src='".e_PLUGIN."roster/images/roster_16.png' alt='' />"; // TODO - Make Image
		$var[3]['title'] 	= "Pending Applicants";
		$var[3]['url']		= e_PLUGIN_ABS."roster/admin_sr.php?mode=pending&action=list&field=c_date&asc=desc&from=0"; // TODO - Replace with correct page (admin, or front end?)
		$var[3]['total'] 	= $sc->sc_jua_pending(); // TODO - Get Value
		
		return $var;
	}	
	
	
	function latest() // Latest panel in the admin area.
	{
		$sc = e107::getScBatch('roster', true); // loads e107_plugins/myplugin/roster_shortcodes.php
		
		$var[0]['icon'] 	= "<img src='".e_PLUGIN."roster/images/roster_16.png' alt='' />"; // TODO - Make Image
		$var[0]['title'] 	= "Pending Applications";
		$var[0]['url']		= e_PLUGIN_ABS."roster/roster.php"; // TODO - Replace with correct page
		$var[0]['total'] 	= 0; // TODO - Get Value
		
		$var[1]['icon'] 	= "<img src='".e_PLUGIN."roster/images/roster_16.png' alt='' />"; // TODO - Make Image
		$var[1]['title'] 	= "Promotion Request";
		$var[1]['url']		= e_PLUGIN_ABS."roster/roster.php"; // TODO - Replace with correct page
		$var[1]['total'] 	= 0; // TODO - Get Value
		
		$var[2]['icon'] 	= "<img src='".e_PLUGIN."roster/images/roster_16.png' alt='' />"; // TODO - Make Image
		$var[2]['title'] 	= "Transfer Request";
		$var[2]['url']		= e_PLUGIN_ABS."roster/roster.php"; // TODO - Replace with correct page
		$var[2]['total'] 	= 0; // TODO - Get Value
		
		$var[3]['icon'] 	= "<img src='".e_PLUGIN."roster/images/roster_16.png' alt='' />"; // TODO - Make Image
		$var[3]['title'] 	= "Discharge Request";
		$var[3]['url']		= e_PLUGIN_ABS."roster/roster.php"; // TODO - Replace with correct page
		$var[3]['total'] 	= 0; // TODO - Get Value
		
		$var[4]['icon'] 	= "<img src='".e_PLUGIN."roster/images/roster_16.png' alt='' />"; // TODO - Make Image
		$var[4]['title'] 	= "Pending LOA";
		$var[4]['url']		= e_PLUGIN_ABS."roster/roster.php"; // TODO - Replace with correct page
		$var[4]['total'] 	= $sc->sc_loa_p(); // TODO - Get Value

		return $var;
	}	
	
	
}
?>