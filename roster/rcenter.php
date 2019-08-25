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

// WIP
// NEEDS:
// First - Make Sure They Have Permission To View This Page
// Second - Page List Current Applicants That Are Pending Approval
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