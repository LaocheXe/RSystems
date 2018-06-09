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

$sc = e107::getScBatch('roster', true); // loads e107_plugins/myplugin/roster_shortcodes.php
//var_dump($sc); // For debugging Shortcode

$sql  = e107::getDB();
$tp = e107::getParser();
$ns = e107::getRender();
$text = '';

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
								<span class='row_data'>".$sc->sc_active_members()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Pending on Leave</span>
								<span class='row_data'>".$sc->sc_loa_p()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Approved on Leave</span>
								<span class='row_data'>".$sc->sc_loa_a()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Reserve Clones</span>
								<span class='row_data'>".$value."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total After Action Reports</span>
								<span class='row_data'>".$value."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Ranks</span>
								<span class='row_data'>".$sc->sc_rank_counter()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Awards</span>
								<span class='row_data'>".$sc->sc_awards_counter()."</span>
							</li>
						</ul>
					</td>
					<div class='banner'>
					<td style='width: 33%;'>
						<ul class='rList_data r-clearfix'>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Eastern Time</span>
								<span class='row_data'>".$sc->sc_eastern_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Central Time</span>
								<span class='row_data'>".$sc->sc_central_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Pacific Time</span>
								<span class='row_data'>".$sc->sc_pacific_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Mountain Time</span>
								<span class='row_data'>".$sc->sc_mountain_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>London Time</span>
								<span class='row_data'>".$sc->sc_london_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Rome Time</span>
								<span class='row_data'>".$sc->sc_rome_time()."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'></span>
								<span class='row_data'></span>
							</li>
						</ul>
					</td>
					</div>
				</tr>
			</tbody>
		</table>
		</div>
		</div>";

$text .= '<div class="r-title">Active Clones on Leave</div>';
// Current Users on LOA, and Schedual LOA's	
$text .="<div class='ninePad'><div class='r_container ninePad'><div id='table_container' class='clearfix'>";
// Tables
$text .= "<table class='table_tpr table_overflow information'>
			<thead>
				<tr>
					<th width='15%'>#</th>
					<th width='20%'>Name</th>
					<th width='45%'>Explanation</th>
					<th width='20%'>Expiration</th>
				</tr>
			</thead>
			<tbody>
			".$sc->sc_loa_pending_list(); 

			$text .= "</tbody>
				</table>
				<table class='table_loa table_overflow information'>
					<thead>
						<tr>
							<th width='15%'>#</th>
							<th width='20%'>Name</th>
							<th width='15%'>PAR</th>
							<th width='40%'>Dates</th>
							<th width='10%'>Status</th>
						</tr>
					</thead>
					<tbody>
					".$sc->sc_loa_active_list();
			
$text .= "</tbody></table></div></div></div>";

$text .= '<div class="r-title">Latest Logs</div>';

$text .= "<div class='ninePad'>
			<div class='r_container ninePad'>
				<table class='information'>
					<tbody>
						<tr>
							<td style='width: 50%; vertical-align: top;'>
								<h3 class='bar altar'>5 Recent Promotions</h3>
								<br />
								<table class='table_overflow information'>
							<thead>
								<tr>
									<th width='20%'>Name</th>
									<th width='50%'>Rank</th>
									<th width='30%'>Date</th>
								</tr>
							</thead>
							<tbody>";
// TODO - Values
foreach($aResults as $resultsA)
{
$text .= "<tr>
			<td>".$value."</td>
			<td>".$value."</td>
			<td>".$value."</td>
		</tr>";
}
$text .= "</tbody>
			</table>
				</td>
				<td></td>
				<td style='width: 50%; vertical-align: top;'>
					<h3 class='bar altar'>5 Recent Awards/Commendations</h3>
					<br />
						<table class='table_overflow information'>
							<thead>
								<tr>
									<th width='20%'>Name</th>
									<th width='50%'>Award/Commendation</th>
									<th width='30%'>Date</th>
								</tr>
							</thead>
							<tbody>";
// TODO - Values
//foreach($aResults as $resultsA)
//{
$text .= "".$sc->sc_recent_awards()."";
//}
$text .= "</tbody></table></td></tr></table>
	</div></div>";


$ns->tablerender('<h3>Operation Hub</h3><br /><h6>All unit operations may be viewed here.</h6>', $text); // TODO: LANS
require_once(FOOTERF);
exit; 

?>