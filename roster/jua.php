<?php
///////////////////////////////////////////////////////////////
////////////////////Join Us Application///////////////////////
/////////////////////Work IN Progress////////////////////////
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
define('PAGE_NAME', 'Joining the 501st'); // TODO: LAN

require_once(HEADERF);
//////////////////////////////////////////////////////////
e107::lan('roster');
e107::meta('keywords', 'join, application, joining501st, recruiter');

$sql  = e107::getDB();
$tp = e107::getParser();
$ns = e107::getRender();
$text = '';


if(USERID || !USERID) // If Logged In - eXe
{
		new juaList;
}

class juaList
{
	function __construct()
	{
		$mes = e107::getMessage();
		$sql  = e107::getDB();
		$srU = $sql->retrieve("service_records_sys", "user_id", "WHERE user_id = ".USERID);
		// First thing, check if user is logged in
		if(!USERID) // If Not Login (Display Login Message)
		{
			// Make Message To Display To Login
			$this->loginPlz();
		}
		elseif(USERID)
		{
			// Check if user has service record
			if($srU == USERID)
			{
				// You are already a member
				$this->member501st();
			}
			else
			{
				// Not a member, give them access to form
				if(isset($_GET['ju_applicant_form']) || varset($_GET['form'])=='jua')
				{
					$this->form();
				}
				elseif(isset($_POST['submitjua_submit']) && !empty($_POST['arma_id']))
				{
					$this->process();
				}
				else
				{
					$this->futurePending();
				}
			}
		}
		echo $mes->render();
	}
	
	function member501st()
	{
		// re-direct to operation hub
		$url = e_BASE."/operation-hub";
		header("Location: ".$url);
		exit();
	}
	
	function loginPlz()
	{
		$url = e_BASE."/login.php";
		header("Location: ".$url);
		exit();
	}
	
	function process()
	{
		$tp = e107::getParser();
		$sql = e107::getDb();
		$mes = e107::getMessage();
		$fp = new floodprotect;
		if ($fp->flood("sr_pending_sys", "c_date") == false)
		{
			e107::redirect();
			exit;
		}
		$user_id  = (USER ? USERID  : trim($tp->toDB($_POST['user_id'])));
		$armaID = $tp->filter($_POST['arma_id']);
		$submitjua_error = false;
		if(!$armaID)
		{
			$message  = "You need to add you'r arma 3 ID";
			$submitjua_error = TRUE;
		}
		if($submitjua_error == false)
		{
			$insertQry = array(
			'srp_id'		=> 0,
			'user_id'		=> USERID,
			'clone_number'	=> '0',
			'arma_id'		=> $armaID,
			'recruiter_id'	=> '0',
			'application_id'=> '0',
			'c_date'		=> time(),
			);
			
			if(!$sql->insert("sr_pending_sys", $insertQry))
			{
				$mes->addError('Your service record is pending for approval.'); // TODO: LAN
				return false;
			}
			
			// This below is for event triggers - eXe
			$edata_sn = array("user" => $user_id, "arma_id" => $armaID);

			e107::getEvent()->trigger("subjua", $edata_sn); // bc
			e107::getEvent()->trigger("user_jua_submit", $edata_sn);


			$mes->addSuccess('Your application has been filed, and is currently pending for approval.'); // TODO: LAN
			$mes->addSuccess($redirect);
			unset($_POST);

			$redirect = header('Refresh: 10; URL='.e_SELF.'');
		}
		else
		{
			$mes->addWarning($message);
		}
	}
	
	function form()
	{
		$sql  = e107::getDB();
		$tp = e107::getParser();
		$frm = e107::getForm();
		$ns = e107::getRender();
		$text .= e107::getForm()->token();
		$srU = $sql->retrieve("service_records_sys", "user_id", "WHERE user_id = ".USERID);
		if(USERID)
		{
			// If $srU == USERID then display form - eXe
			if($srU == !USERID)
			{
				$text .= "All fields are required, Please fill out all fields...... field below.<br /><br />
							If you don't know how to find your ArmA 3 ID, then >> <a href='LINK GOES HERE' target='_blank'>Click Right Here To Learn How</a> <<";
				$text .= "
					<div>
					  <form id='dataform' method='post' action='".e_SELF."' enctype='multipart/form-data' onsubmit='return frmVerify()'>
					    <table class='table fborder'>";
						
				$text .= "
					<tr>
					  <td style='width:20%' class='forumheader3'>ArmA 3 ID</td>
						<td style='width:80%' class='forumheader3'>".e107::getForm()->text('arma_id',$tp->toHTML(vartrue($_POST['arma_id']),TRUE,'arma_id'),100, array('required'=>1))."
						</td>
					</tr>";
	
				$text .= "
				    	  <tr>
				      	  <td colspan='2' style='text-align:center' class='forumheader'>
				     	     <input class='btn btn-success button' type='submit' name='submitjua_submit' value='Submit' />
				       	    <input type='hidden' name='e-token' value='".e_TOKEN."' />
				    	    </td>
					      </tr>
				   	 </table>
					  </form>
					</div>";
	
				//$ns->tablerender('Leave of Absence - Form', $text);
				$tableTop .= "Joining The 501st - Form";
			}
			elseif($srU == USERID)
			{
				// Lets make a default user friendly loa screen - eXe
				$text .= '<b><i><u>Error Code: 00-254</b></i></u> <b>-</b> <i>You are listed in the Server Records,</i> <b>'.USERNAME.'</b>.
				<br />
				The system has detected that you are logged in! However, the system has found an error. <br />
				You are not qualified to fill out this form.<br />
				If you believe this error code is false, please contact the C-6 Holosite Support Team.<br />
				<br />
				&nbsp;&nbsp;&nbsp;- Automated System Message
				<br />';
		
				//$ns->tablerender('Error - Service Record', $text); // TODO: Lan
				$tableTop .= "Error - Service Records";
			}
		}
		elseif(!USERID)
		{
			// Lets make a default user friendly loa screen - eXe
			$text .= '<b><i><u>Error Code: 01-666</b></i></u> <b>-</b> <i>Hello, <b>Sir hijacker</b></i>.
			<br />
			The system has detected that you are trying to submit an JUA  Form! However, the system has checked, and you are not logged in. <br />
			You are not qualified to fill out an Join Us Applicant Form.<br />
			If you believe this error code is false, please contact the C-6 Holosite Support Team.<br />
			<br />
			&nbsp;&nbsp;&nbsp;- Automated System Message
			<br />';
		
			//$ns->tablerender('Error - System Hijack', $text); // TODO: Lan
			$tableTop .= "Error - System Hijack";
		}
		
		$ns->tablerender($tableTop, $text);
	}
	
	function futurePending()
	{
		$ns = e107::getRender();
		$text .= 'Currently your application is in the middle of being process, which means you are pending... autherization';
		$tableTop .= "Status - Pending";
		$ns->tablerender($tableTop, $text);
	}
}
// Footer Area //
require_once(FOOTERF);
exit;
?>