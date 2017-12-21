<?php
//////////// HEADER SECTION //////////////////////////////////
if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

// To Get Page Title To Display
define('PAGE_NAME', 'Operation Hub'); // TODO: LAN

require_once(HEADERF);
//////////////////////////////////////////////////////////
e107::lan('roster');
//e107::js('roster','js/my.js','jquery');	// Load Plugin javascript and include jQuery framework
e107::css('roster','roster.css');		// load css file
e107::meta('keywords', 'operation center, operation hub, hub, operation');

$sql  = e107::getDB();
$tp = e107::getParser();
$ns = e107::getRender();
$text = '';

$resultLOAp = $sql->count("loa_sys", "(*)", "where auth_status = '0'");
$resultLOAa = $sql->count("loa_sys", "(*)", "where auth_status = '1'");
$resultRANKS = '<a href="/ranks">'.$sql->count("ranks_sys", "(*)", "where rank_parent != '0'").'</a>';
$resultAWARDS = '<a href="/awards">'.$sql->count("awards_sys", "(*)").'</a>';

function pacific_time()
{
	date_default_timezone_set("US/Pacific");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}

function mountain_time()
{
	date_default_timezone_set("US/Mountain");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}

function central_time()
{
	date_default_timezone_set("US/Central");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}

function eastern_time()
{
	date_default_timezone_set("US/Eastern");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}

function london_time()
{
	date_default_timezone_set("Europe/London");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}

function rome_time()
{
	date_default_timezone_set("Europe/Rome");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}
/*
function pacific_time()
{
	date_default_timezone_set("US/Pacific");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}

function pacific_time()
{
	date_default_timezone_set("US/Pacific");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}

function pacific_time()
{
	date_default_timezone_set("US/Pacific");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}

function pacific_time()
{
	date_default_timezone_set("US/Pacific");
	$dateTime = date('F d, Y - h:i A');	
	return $dateTime;	
}
*/


$text .= '<div class="r-title">Unit Statistics</div>';	 
// Count Total of sr_id in service_records table + Time
$value = "To many to count";
$text .= "<div class='ninePad'><div class='r_container ninePad'>
		  <table>
			<tbody>
				<tr>
					<td style='width: 33%;'>
						<ul class='rList_data r-clearfix'>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Active Clones</span>
								<span class='row_data'>".$value."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Pending on Leave</span>
								<span class='row_data'>".$resultLOAp."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Approved on Leave</span>
								<span class='row_data'>".$resultLOAa."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total After Action Reports</span>
								<span class='row_data'>".$value."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Ranks</span>
								<span class='row_data'>".$resultRANKS."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Awards</span>
								<span class='row_data'>".$resultAWARDS."</span>
							</li>
						</ul>
					</td>
					<td style='width: 33%;'>
						<ul class='rList_data r-clearfix'>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Eastern Time</span>
								<span class='row_data'>".eastern_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Central Time</span>
								<span class='row_data'>".central_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Pacific Time</span>
								<span class='row_data'>".pacific_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Mountain Time</span>
								<span class='row_data'>{MOUNTAIN_TIME}</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>London Time</span>
								<span class='row_data'>".london_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Rome Time</span>
								<span class='row_data'>".rome_time()."</span>
							</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
		</div>";

$text .= '<div class="r-title">Active </div>';
// Coment	
$text .="

";



$ns->tablerender('<h3>Operation Hub</3><br /><h6>All unit operations may be viewed here.</h6>', $text); // TODO: LANS
require_once(FOOTERF);
exit; 

?>