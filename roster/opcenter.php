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
								<span class='row_title' style='width: 45%;'>Berlin Time</span>
								<span class='row_data'>".$sc->sc_german_time()."</span>
							</li>
						</ul>
					</td>
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
			<tbody>";
			
$queryLOA_S = "SELECT l.user_id, l.effective_date, l.expected_date, l.explanation, l.auth_status FROM `#loa_sys` AS l
LEFT JOIN `#service_records_sys` AS sr ON l.user_id = sr.user_id";
// Is User on LOA - eXe			
$queryLOA_A = "SELECT l.user_id, l.effective_date, l.expected_date, l.explanation, l.auth_status FROM `#loa_sys` AS l
LEFT JOIN `#service_records_sys` AS sr ON l.user_id = sr.user_id
LEFT JOIN `#user` AS u ON l.user_id = u.user_id
WHERE l.effective_date < ".time();

$queryName = "SELECT l.user_id FROM `#loa_sys` AS l
LEFT JOIN `#user` AS u ON l.user_id = u.user_id";
/*
// Query the DB to look for a possible active LOA where it has not been returned
		$loa = $this->DB->buildAndFetch( array( 'select' => '*', 
				'from' => $this->settings['perscom_database_loa'], 
				'where' => 'member_id="' .  $this->memberData['member_id'] .'" AND returned="false" AND status="Approved"' ) );

		// If we get a LOA back, return it
		if ($loa) {

			// Return the LOA
			return $loa;
		}

		// Return false, which means the user is not on LOA
		return false;
*/

//$cwriter_where = "WHERE cw_challenge_starttime = '' OR cw_challenge_starttime < ".time();
			// Requires Foreach loop
			$resultsA = $sql->retrieve($queryLOA_A, true);
			$resultsN = $sql->retrieve($queryName, true);
			$disableE = "disable";
			foreach($aResults as $resultsA)
			{
				if($disableE == 'enable')
				{
			/*	$text .="
				<tr>
					<td>".$sc->sc_active_loa_clonenumber()."</td>
					<td>".$sc->sc_active_loa_name()."</td>
					<td><u>".$sc->sc_active_loa_explanation()."</u></td>
					<td>".$sc->sc_active_loa_returndate()."</td>
				</tr>
				";
				*/
				
				$text .="
				<tr>
					<td>".$aResults['sr.clone_number']."</td>
					<td>".$resultsN['u.user_name']."</td>
					<td><u>".$aResults['l.explanation']."</u></td>
					<td>".$aResults['l.effective_date']."</td>
				</tr>
				";
				}
				else
				{
				//	$text .= "<tr></tr>";
					$text .= "<tr>
					<td>Currently Under Construction</td></tr>";
				}
			}
			
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
					<tbody>";
		
			$resultsU = $sql->retrieve($queryLOA_S, true);
			
			foreach($uResults as $resultsU)
			{
				if($disableE == 'enable')
				{
					$text .= "<tr>
								<td>".$value."</td>
								<td>".$value."</td>
								<td>".$value."</td>
								<td>".$value."</td>
								<td>".$value."</td>
							</tr>";
				}
				else
				{
					$text .= "<tr>
					<td>Currently Under Construction</td>
					</tr>";	
				}
			}
			
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
foreach($aResults as $resultsA)
{
$text .= "<tr>
			<td>".$value."</td>
			<td>".$value."</td>
			<td>".$value."</td>
		</tr>";
}
$text .= "</tbody></table></td></tr></table>
	</div></div>";


$ns->tablerender('<h3>Operation Hub</h3><br /><h6>All unit operations may be viewed here.</h6>', $text); // TODO: LANS
require_once(FOOTERF);
exit; 

?>