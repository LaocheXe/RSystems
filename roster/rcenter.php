<?php
///////////////////////////////////////////////////////////////
////////////////////Recruiter Center//////////////////////////
/////////////////////Work IN Progress////////////////////////
///////////// NEED - ALOT
////////////////////////////////////////////////////////////
//////////// HEADER SECTION ///////////////////////////////
////////// For e107 Security /////////////////////////////
if(!empty($_POST) && !isset($_POST['e-token']))
{
	// set e-token so it can be processed by class2
	$_POST['e-token'] = '';
}

if (!defined('e107_INIT'))
{
	require_once("../../class2.php");
}

// To Get Page Title To Display
e107::lan('roster');
define('PAGE_NAME', LAN_PAGETITLE_RCC); // TODO: LAN
require_once(HEADERF);
//////////////////////////////////////////////////////////
e107::meta('keywords', 'rcenter,, recruiter, recruiter center');

$sql  = e107::getDB();
$tp = e107::getParser();
$ns = e107::getRender();
$text = '';

// NEED TO MAKE SURE LOGIN, HAVE User Class/Permission To View This Page
// Need To Create Preferences To Allow Admin To Select User Class to View Page
//if(USERID || !USERID) // If Logged In - eXe
//{
		// The LOA List - eXe
//		new rccPendingApplicantsLView;
//}
// First - Make Sure They Have Permission To View This Page
if (!isset($pref['rcc1']))
{
	$pref['rcc1'] = e_UC_MEMBER;
}

if (!check_class($pref['rcc1']))
{
	e107::getRender()->tablerender('Get Out', 'YOUR NOT ALLOWED!');
	require_once(FOOTERF);
	exit;
}

// WIP
// NEEDS:

// Second - Page List Current Applicants That Are Pending Approval
class pendingApplicants
{
	function __construct()
	{
		$mes = e107::getMessage();
		$sql  = e107::getDB();
		
		// Do Something Here
		$this->pending();
		
		echo $mes->render();
	}
	
	function pending()
	{
		$tp = e107::getParser();
		$frm = e107::getForm();
		$ns = e107::getRender();
		$sql = e107::getDb();
		
		$appPending = $sql->retrieve("sr_pending_sys", "*");
		
		if(!empty($appPending))
		{
			$text .= "<div>
					<table>
						<tr>
							<th>Applicant Name</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>ArmA 3 ID<</th>
							<th>&nbsp;</th>
							<th>&nbsp;</th>
							<th>Options</th>
						</tr>";
						
			$userQuery = "SELECT srp.*, u.user_id, u.user_name FROM #sr_pending_sys AS asp
						  LEFT JOIN #user AS u ON srp.user_id = u.user_id";
			// LIST APPLIED
			$sql->gen($userQuery);
			
			foreach($userQuery as $row)
			{
				// Options Section
				$getOpt = ' <div class="btn-group pull-right">
								<button aria-expanded="false" class="btn btn-default btn-secondary btn-user-action dropdown-toggle" data-toggle="dropdown">
									<span class="user-action-indicators" id="user-action-indicator-'.$row['srp_id'].'">'.e107::getParser()->toGlyph('cog').'</span>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu">
											
								<!-- dropdown menu links -->
									<li class="user-action-accept">
										<a class="user-action text-right" data-action-user="'.$row['srp_id'].'" data-action-type="accept">Accept</a>
									</li>
									<li class="user-action-denial">
										<a class="user-action text-right" data-action-user="'.$row['srp_id'].'" data-action-type="denial">Delete</a>
									</li>
									<li class="user-action-seekapproval">
										<a class="user-action text-right" data-action-user="'.$row['srp_id'].'" data-action-type="seekapproval">Seek Approval</a>
									</li>
								</ul>
							</div>
						';
				$text .="<tr>
							<td>".$row['user_name']."</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>".$row['arma_id']."</td>
							<td>&nbsp;</td>
							<td>&nbsp;</td>
							<td>".$getOpt."</td>
						</tr>
					";
			}
		}
		else
		{
			$text .= "<div>
						<table>
							<tr>
								<th>Currently No Pending Applicants To Display</th>
							</tr>";
		}
		
		$text .= "</table><</div><br />";
		$ns->tablerender('Pending Applicants', $text);
	}
	
	function accepted_form()
	{
		$tp = e107::getParser();
		$frm = e107::getForm();
		$ns = e107::getRender();
		$sql = e107::getDb();
		$text .= e107::getForm()->token();
	}
}
// Accept Button that takes the Recruiter into a form to fill out the rest of the service record
/*
		Recruiter filling the form out will be automatic selected as the recruiter_id
		Make sure to only display the lowest rank to give
*/
// Denial Button with a reason why
// Maybe Button to seek Bondoer approval
// What if the applicant has been discharged, but accepted back in? << good question


// Footer Area //
require_once(FOOTERF);
exit;
?>