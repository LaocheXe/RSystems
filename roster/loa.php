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
$frm = e107::getForm();
$effdp = e107::getForm()->datepicker();
$text = '';

// For debugging the form
$queryAdmin = "SELECT user_admin FROM user";

// Check USer Database for Admin
$isAdmin = $sql->retrieve($queryAdmin, true);

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
	$query = "SELECT sr_id, user_id FROM service_records_sys";
	// $srU - SQL Retreve user_id from service records table - eXe
	$srU = $sql->retrieve($query, true);
	// If $srU['user_id'] == USERID then display form - eXe
	if(USERID == $srU['user_id'])
	{
		// The LOA Form - eXe
		show_loa_form();
	}
	elseif(ADMIN) // For Debug - eXe
	{
		show_loa_form();
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

function show_loa_form()
{
	$text .= e107::getForm()->token();
	$text .= "All fields are required, Please fill out all fields below.<br /><br />";
	$text .= "
			<div>
			  <form id='dataform' method='post' action='".e_SELF."' enctype='multipart/form-data' onsubmit='return frmVerify()'>
			    <table class='table fborder'>";
				
	$text .= "
			<tr>
			  <td style='width:20%' class='forumheader3'>Effective Date</td>
				<td style='width:80%' class='forumheader3'>".$frm->datepicker()."</td>";
				
	
	
	$tp->tablerender('Leave of Absence - Form', $text);
}



// Footer Area //
require_once(FOOTERF);
exit;
?>