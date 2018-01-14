<?php
// Setup for Recruiters to view, accept denie any applications - eXe
// Also to add the applicant into the service records - eXe
// Allow for certain Recruiter's to allow people to a certain rank - eXe

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('');
	exit;
}



require_once(e_ADMIN."footer.php");
exit;
?>