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
var_dump($sc);

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
								<span class='row_data'>".$value."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Pending on Leave</span>
								<span class='row_data'>{LOA_P}</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Approved on Leave</span>
								<span class='row_data'>{LOA_A}</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total After Action Reports</span>
								<span class='row_data'>".$value."</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Ranks</span>
								<span class='row_data'>{RANK_COUNTER}</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 49%;'>Total Awards</span>
								<span class='row_data'>{AWARDS_COUNTER}</span>
							</li>
						</ul>
					</td>
					<td style='width: 33%;'>
						<ul class='rList_data r-clearfix'>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Eastern Time</span>
								<span class='row_data'>{EASTERN_TIME}</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Central Time</span>
								<span class='row_data'>{CENTRAL_TIME}</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Pacific Time</span>
								<span class='row_data'>{PACIFIC_TIME}</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Mountain Time</span>
								<span class='row_data'>{MOUNTAIN_TIME}</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>London Time</span>
								<span class='row_data'>{LONDON_TIME}</span>
							</li>
							<li class='clear r-clearfix'>
								<span class='row_title' style='width: 45%;'>Rome Time</span>
								<span class='row_data'>{ROME_TIME}</span>
							</li>
						</ul>
					</td>
				</tr>
			</tbody>
		</table>
		</div>
		</div>";

$text .= '<div class="r-title">Active Clones on Leave</div>';
// Coment	
//$text .="

//";

echo $sc->sc_central_time();

$ns->tablerender('<h3>Operation Hub</h3><br /><h6>All unit operations may be viewed here.</h6>', $text, $sc); // TODO: LANS
require_once(FOOTERF);
exit; 

?>