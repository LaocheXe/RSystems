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
e107::meta('keywords', 'leave, of, absence, loa');

$sql  = e107::getDB();
$tp = e107::getParser();
$ns = e107::getRender();
$text = '';

// LOA Checks - eXe
//if(!USERID) // If Not Logged In - eXe
//{
	// If Not Logged In, Redirect to Login Page - eXe
//	header('Location:'.e_BASE.'/login.php');
//	exit;
//}
if(USERID || !USERID) // If Logged In - eXe
{
	// Create Query to scna service records - eXe
	//$srU = $sql->retrieve("service_records_sys", "user_id", "WHERE user_id = ".USERID);
	// If $srU == USERID then display form - eXe
	//if($srU == USERID)
	//{
		// The LOA List - eXe
		new loaListView;
	//}
	//elseif($srU == !USERID)
	//{
	/*	$text .= '<b><i><u>Error Code: 00-253</b></i></u> <b>-</b> <i>No Service Record Found for</i> <b>'.USERNAME.'</b>.
		<br />
		The system has detected that you are logged in! However, the system has found an error. <br />
		You are not qualified to fill out an Leave of Absence Form.<br />
		If you believe this error code is false, please contact the C-4 Website Support Team.<br />
		<br />
		&nbsp;&nbsp;&nbsp;- Automated System Message
		<br />';
		
		$ns->tablerender('Error - Service Record', $text); // TODO: Lan
	}*/
}


class loaListView
{
	function __construct()
	{
		$mes = e107::getMessage();
		$sql  = e107::getDB();
		// Create Query to scna service records - eXe
		$srU = $sql->retrieve("service_records_sys", "user_id", "WHERE user_id = ".USERID);
		// If $srU == USERID then display form - eXe
		if($srU == USERID)
		{
			if(isset($_GET['loa_form']) || varset($_GET['form'])=='loa')
			{
				$this->form();
			}
			elseif(isset($_POST['submitloa_submit']) && !empty($_POST['effective_date']) && !empty($_POST['expected_date']))
			{
				$this->process();
			}
			elseif(isset($_GET['loa_id']) || varset($_GET['rssID'])==$id)
			{
				$this->rssID($_GET['loa_id']);
			}
			else
			{
				$this->loa_list();
			}
		}
		elseif($srU == !USERID)
		{
			// Lets make a default user friendly loa screen - eXe
			$this->loa_list();
		}
		
		echo $mes->render();
	}
	
	function loa_list()
	{
		$tp = e107::getParser();
		$frm = e107::getForm();
		$ns = e107::getRender();
		$sql = e107::getDb();
		$text .= e107::getForm()->token();
		$srU = $sql->retrieve("service_records_sys", "user_id", "WHERE user_id = ".USERID);
		// If $srU == USERID then display form - eXe
		if(USERID)
		{
		if($srU == USERID)
		{
			$loaCheck = $sql->retrieve("loa_sys", "*", "WHERE user_id = ".USERID);
			// Counting - eXe
			$qT = $sql->count("loa_sys", "(*)", "WHERE user_id = ".USERID);
			$qP = $sql->count("loa_sys", "(*)", "WHERE auth_status = 0 AND user_id = ".USERID);
			$qA = $sql->count("loa_sys", "(*)", "WHERE auth_status = 1 AND user_id = ".USERID);
			$qD = $sql->count("loa_sys", "(*)", "WHERE auth_status = 2 AND user_id = ".USERID);
			$qC = $sql->count("loa_sys", "(*)", "WHERE return_status = 1 AND user_id = ".USERID);

			// List - eXe
			$text .= "<div>
						<table>
							<tr>
								<th>Total LOA's</th>
								<th>Pending</th>
								<th>Active</th>
								<th>Denied</th>
								<th>Complete</th>
							</tr>
							<tr>
								<td>".$qT."</td>
								<td>".$qP."</td>
								<td>".$qA."</td>
								<td>".$qD."</td>
								<td>".$qC."</td>
							</tr>
						</table>
					</div><br />";
				if($qT >= 1)
				{
					$text .= "<div>
							<table>
								<tr>
									<th>Submitted On</th>
									<th>Effective</th>
									<th>Expective</th>
									<th>Approvaed</th>
									<th>Status</th>
									<th>Returned</th>
									<th>Explination</th>
									<th>&nbsp;</th>
									<th>Options</th>
								</tr>";
							
					if($allRows = $sql->retrieve('loa_sys', '*', 'WHERE user_id = '.USERID, true))
					{
						foreach($allRows as $row)
						{
							if($row['auth_id'] == 0)
							{
								$auth_id = "---"; // TODO LAN
							}
							else
							{
								$auth_id = ""; // TODO - Get User Name	
							}
							if($row['auth_status'] == 0)
							{
								$auth_status = "Pending"; // TODO LAN
							}
							else
							{
								$auth_status = ""; // TODO - Get User Name	
							}
							if($row['return_status'] == 0)
							{
								$return_status = "Pending"; // TODO LAN
							}
							else
							{
								$return_status = ""; // TODO - Get User Name	
							}
							$getOptions = '<div class="btn-group pull-right">
										<button aria-expanded="false" class="btn btn-default btn-secondary btn-user-action dropdown-toggle" data-toggle="dropdown">
											<span class="user-action-indicators" id="user-action-indicator-'.$row['loa_id'].'">'.e107::getParser()->toGlyph('cog').'</span>
											<span class="caret"></span>
										</button>
										<ul class="dropdown-menu">
										
											<!-- dropdown menu links -->
											<li class="user-action-edit">
												<a class="user-action text-right" data-action-user="3385" data-action-type="edit">Edit</a>
											</li>
											<li class="user-action-delete">
												<a class="user-action text-right" data-action-user="3385" data-action-type="delete">Delete</a>
											</li>
											<li class="user-action-returned">
												<a class="user-action text-right" data-action-user="3385" data-action-type="returned">Returned</a>
											</li>
										</ul>
									</div>';
							$text .= "<tr>
								<td>".$tp->toDate($row['submit_date'], 'long')."</td>
								<td>".$tp->toDate($row['effective_date'], 'long')."</td>
								<td>".$tp->toDate($row['expected_date'], 'long')."</td>
								<td>".$auth_id."</td>
								<td>".$auth_status."</td>
								<td>".$return_status."</td>
								<td>".$row['explanation']."</td>
								<td>&nbsp;</td>
								<td class='left options'>".$getOptions."</td>
							</tr>";
						}
					}
				}
			
				$text .= "</table></div><br />";
				
				$text .="<div>
						<form method='get' action='".e_SELF."' onsubmit='return frmVerify()'>
							<center><input class='btn btn-success button' type='submit' name='loa_form' value='Create LOA' />
							</center>
						</form>
					</div>";	
		}
		elseif($srU == !USERID)
		{
			// Lets make a default user friendly loa screen - eXe
			$text .= '<b><i><u>Error Code: 00-253</b></i></u> <b>-</b> <i>No Service Record Found for</i> <b>'.USERNAME.'</b>.
			<br />
			The system has detected that you are logged in! However, the system has found an error. <br />
			You are not qualified to fill out an Leave of Absence Form.<br />
			If you believe this error code is false, please contact the C-6 Holosite Support Team.<br />
			<br />
			&nbsp;&nbsp;&nbsp;- Automated System Message
			<br />';
		}
		}
		else
		{
		$loaCheck = $sql->retrieve("loa_sys", "*");
		// Counting - eXe
		$qT = $sql->count("loa_sys", "(*)");
		$qP = $sql->count("loa_sys", "(*)", "WHERE auth_status = 0");
		$qA = $sql->count("loa_sys", "(*)", "WHERE auth_status = 1");
		$qD = $sql->count("loa_sys", "(*)", "WHERE auth_status = 2");
		$qC = $sql->count("loa_sys", "(*)", "WHERE return_status = 1");
		$text .= "<div>
					<table>
						<tr>
							<th>Total LOA's</th>
							<th>Pending</th>
							<th>Active</th>
							<th>Denied</th>
							<th>Complete</th>
						</tr>
						<tr>
							<td>".$qT."</td>
							<td>".$qP."</td>
							<td>".$qA."</td>
							<td>".$qD."</td>
							<td>".$qC."</td>
						</tr>
					</table>
				</div><br />";
		}
		$ns->tablerender('Leave of Absence - Records', $text);
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
		$getSR = $sql->retrieve("service_records_sys", "sr_id, user_id, rank_id, post_id", "WHERE user_id = ".USERID);
		$srID = $tp -> filter($getSR['sr_id']);
		$rankID = $tp -> filter($getSR['rank_id']);
		$postID = $tp -> filter($getSR['post_id']);
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
				'sr_id'						=> $srID,
				'rank_id'          			=> $rankID,
				'post_id'			 	    => $postID,
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
		$effDp .= $frm->datepicker('effective_date',time(), 'type=date');
		$expDp .= $frm->datepicker('expected_date',time(), 'type=date');
		$srU = $sql->retrieve("service_records_sys", "user_id", "WHERE user_id = ".USERID);
		if(USERID)
		{
		// If $srU == USERID then display form - eXe
		if($srU == USERID)
		{
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
			
			$text .= "<tr>
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
	
			//$ns->tablerender('Leave of Absence - Form', $text);
			$tableTop .= "Leave of Absence - Form";
		}
		elseif($srU == !USERID)
		{
			// Lets make a default user friendly loa screen - eXe
			$text .= '<b><i><u>Error Code: 00-253</b></i></u> <b>-</b> <i>No Service Record Found for</i> <b>'.USERNAME.'</b>.
			<br />
			The system has detected that you are logged in! However, the system has found an error. <br />
			You are not qualified to fill out an Leave of Absence Form.<br />
			If you believe this error code is false, please contact the C-6 Holosite Support Team.<br />
			<br />
			&nbsp;&nbsp;&nbsp;- Automated System Message
			<br />';
		
			//$ns->tablerender('Error - Service Record', $text); // TODO: Lan
			$tableTop .= "Error - Service Record";
		}
		}
		else
		{
			// Lets make a default user friendly loa screen - eXe
			$text .= '<b><i><u>Error Code: 01-666</b></i></u> <b>-</b> <i>Hello, <b>Sir hijacker</b></i>.
			<br />
			The system has detected that you are trying to submit an LOA! However, the system has checked, and you are not logged in. <br />
			You are not qualified to fill out an Leave of Absence Form.<br />
			If you believe this error code is false, please contact the C-6 Holosite Support Team.<br />
			<br />
			&nbsp;&nbsp;&nbsp;- Automated System Message
			<br />';
		
			//$ns->tablerender('Error - System Hijack', $text); // TODO: Lan
			$tableTop .= "Error - System Hijack";
		}
		
		$ns->tablerender($tableTop, $text);
	}
	
	function rssID()
	{
		$id = $_GET['id'];
		$sql  = e107::getDB();
		$tp = e107::getParser();
		$ns = e107::getRender();
		
		$thisQuery = "SELECT l.loa_id,l.user_id,l.sr_id,l.rank_id,l.post_id,l.submit_date,l.effective_date,l.expected_date,l.explanation,l.auth_id,l.auth_status,l.return_status,u.user_id,u.user_name,u.user_image,r.rank_id,r.rank_name,r.rank_image,p.post_id,p.post_name FROM `#loa_sys` AS l
		LEFT JOIN `#user` AS u ON l.user_id = u.user_id
		LEFT JOIN `#ranks_sys` AS r ON l.rank_id = r.rank_id
		LEFT JOIN `#postition_sys` AS p ON l.post_id = p.post_id";
		
		
		$text .= '<table>
						<tr>
							<th>Submission Date</th>
							<th>Service Record</th>
							<th></th>
							<th>User</th>
							<th>Rank</th>
							<th>Posistion</th>
							<th>Effective Date</th>
							<th>Expective Date</th>
							<th>Reason</th>
						</tr>';
		if($sql->select($thisQuery, true, "loa_id LIKE '". $id."%'"))
		{
			while($row = $sql->db_Fetch())
			{
				$userImage .= array('w' => 75, 'h' => 75, 'class' => $row['user_name'], 'alt' => $row['user_name'], 'x' => 0, 'crop' => 0);
				$userAvatar .= $tp->toImage($row['user_image'], $userImage);
				$att .= array('w' => 75, 'h' => 75, 'class' => $row['rank_name'], 'alt' => $row['rank_name'], 'x' => 0, 'crop' => 0);
				$imageCode .= $tp->toImage($row['rank_image'], $att);
				$text .= "<tr>
							<td>".$row['submit_date']."</td>
							<td>".$row['sr_id']."</td>
							<td>".$userAvatar."</td>
							<td>".$row['user_name']."</td>
							<td>".$imageCode."</td>
							<td>".$row['post_name']."</td>
							<td>".$row['effective_date']."</td>
							<td>".$row['expected_date']."</td>
							<td>".$row['explanation']."</td>
						</tr>
					</table>";
				$tableTop = "Leave of Absence - Record ID =".$row['loa_id']."";
			}
		}
		$ns->tablerender($tableTop, $text); // TODO: Lan
	}
}

// Footer Area //
require_once(FOOTERF);
exit;
?>