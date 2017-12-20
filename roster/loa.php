<?php
//////////// HEADER SECTION //////////////////////////////////
////////// For e107 Security ////////////////////////////////
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
define('PAGE_NAME', 'Leave of Absence'); // TODO: LAN

require_once(HEADERF);
//////////////////////////////////////////////////////////
e107::lan('roster');
//e107::js('roster','js/my.js','jquery');	// Load Plugin javascript and include jQuery framework
//e107::css('roster','css/my.css');		// load css file
e107::meta('keywords', 'leave, of, absence, loa');

$sql  = e107::getDB();
$tp = e107::getParser();
$ns = e107::getRender();
$text = '';

// LOA Checks - eXe
if(!USERID) // If Not Logged In - eXe
{
	// If Not Logged In, Redirect to Login Page - eXe
	header('Location:'.e_BASE.'/login.php');
	exit;
}
elseif(USERID) // If Logged In - eXe
{
	// Create Query to scna service records - eXe
	$query = "SELECT user_id FROM #service_records_sys";
	// $srU - SQL Retreve user_id from service records table - eXe
	$srU = $sql->retrieve($query, true);
	// If $srU['user_id'] == USERID then display form - eXe
	if(USERID == $srU['user_id'])
	{
		// The LOA Form - eXe
		//show_loa_form();
		new submitLOA;
	}
	elseif(ADMIN) // For Debug - eXe
	{
		//show_loa_form();
		new submitLOA;
	}
	else
	{
		$text = '<b><i><u>Error Code: 00-254</b></i></u> <b>-</b> <i>No Personnel Data Found for</i> <b>'.USERNAME.'</b>.
		<br />
		The system has detected that you are logged in! However, the system has found an error. <br />
		You are not qualified to fill out an Leave of Absence Form.<br />
		If you believe this error code is false, please contact the C-4 Website Support Team.<br />
		<br />
		&nbsp;&nbsp;&nbsp;- Automated System Message
		<br />';
		
		$tp->tablerender('Error - Service Record', $text); // TODO: Lan
	}
}

class submitLOA
{
	
	function __construct()
	{
		$mes = e107::getMessage();

		if(isset($_POST['submitloa_submit']) && !empty($_POST['effective_date']) && !empty($_POST['expected_date']))
		{
			$this->process();
		}

		echo $mes->render();

		$this->form();
	}
	
	function process()
	{
		//$ip = e107::getIPHandler()->getIP(FALSE);
		$tp = e107::getParser();
		$sql = e107::getDb();
		$mes = e107::getMessage();
		
		$fp = new floodprotect;
		
		if ($fp->flood("loa_sys", "submit_date") == false)
		{
			e107::redirect();
			exit;
		}
		
		$user_id  = (USER ? USERID  : trim($tp->toDB($_POST['user_id'])));
		$effective_date = $tp->filter($_POST['effective_date']);
		$expected_date  = $tp->filter($_POST['expected_date']);
		$explanation  = $tp->filter($_POST['explanation']);
		$submitloa_error = false;

		if (!$effective_date || !$expected_date || !$explanation)
		{
			$message = "You need to select a Effective Date, Expected Date, and give an Explanation for the Leave of Absence."; // TODO: LAN
			$submitloa_error = TRUE;
		}

		if ($submitloa_error === false)
		{
			$insertQry = array(
				'loa_id'            		=> 0,
				'user_id'          			=> USERID,
				'sr_id'						=> '0',
				'rank_id'          			=> '0',
				'post_id'			 	    => '0',
				'submit_date'      			=> time(),
				'effective_date'            => $effective_date,
				'expected_date'           	=> $expected_date,
				'explanation'           	=> $explanation,
				'auth_id'       			=> '0',
                'auth_status'    			=> '0',
			);

			if(!$sql->insert("loa_sys", $insertQry))
			{
				$mes->addError('Leave of Absence has been filed, and is currently pending for approval.'); // TODO: LAN
				return false;
			}

			// This below is for event triggers - eXe
			$edata_sn = array("user" => $user_id, "effective_date" => $effective_date, "expected_date" => $expected_date, "explanation" => $explanation);

			e107::getEvent()->trigger("subloa", $edata_sn); // bc
			e107::getEvent()->trigger("user_loa_submit", $edata_sn);


			$mes->addSuccess('Leave of Absence has been filed, and is currently pending for approval.'); // TODO: LAN
		//	echo $mes->render();
			unset($_POST);

			// $ns->tablerender(LAN_THANK_YOU, "<div style='text-align:center'>".LAN_134."</div>");

		}
		else
		{
		//	message_handler("P_ALERT", $message);
			$mes->addWarning($message);
		}

	}
	
	function form()
	{
		$tp = e107::getParser();
		$frm = e107::getForm();
		$ns = e107::getRender();
		$text .= e107::getForm()->token();
		$effDp .= $frm->datepicker('effective_date',time(), 'type=date');
		$expDp .= $frm->datepicker('expected_date',time(), 'type=date');
		$text .= "All fields are required, Please fill out all fields below.<br /><br />";
		$text .= "
			<div>
			  <form id='dataform' method='post' action='".e_SELF."' enctype='multipart/form-data' onsubmit='return frmVerify()'>
			    <table class='table fborder'>";
				
		$text .= "
			<tr>
			  <td style='width:20%' class='forumheader3'>Effective Date</td>
				<td style='width:80%' class='forumheader3'>".e107::getForm()->datepicker('effective_date',time(), 'type=date')."
				</td>
			</tr>";
			
		$text .= "
			<tr>
			  <td style='width:20%' class='forumheader3'>Expected Date</td>
				<td style='width:80%' class='forumheader3'>".e107::getForm()->datepicker('expected_date',time(), 'type=date')."
				</td>
			</tr>";
				
		$text .= "
			<tr>
			  <td style='width:20%' class='forumheader3'>Explanation</td>
				<td style='width:80%' class='forumheader3'>".e107::getForm()->text('explanation',$tp->toHTML(vartrue($_POST['explanation']),TRUE,'explanation'),400, array('required'=>1))."
			    </td>
			</tr>
			";
	
		$text .= "
			      <tr>
			        <td colspan='2' style='text-align:center' class='forumheader'>
			          <input class='btn btn-success button' type='submit' name='submitloa_submit' value='Submit' />
			           <input type='hidden' name='e-token' value='".e_TOKEN."' />
			        </td>
			      </tr>
			    </table>
			  </form>
			</div>";
	
		$ns->tablerender('Leave of Absence - Form', $text);
	}
}



// Footer Area //
require_once(FOOTERF);
exit;
?>