<?php
/*
 * e107 Bootstrap CMS
 *
 * Copyright (C) 2008-2015 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 * 
 * IMPORTANT: Make sure the redirect script uses the following code to load class2.php: 
 * 
 * 	if (!defined('e107_INIT'))
 * 	{
 * 		require_once("../../class2.php");
 * 	}
 * 
 */
 
if (!defined('e107_INIT')) { exit; }

// v2.x Standard  - Simple mod-rewrite module. 

class roster_url // plugin-folder + '_url'
{
	function config() 
	{
		$config = array();

//		$config['other'] = array(
//			'alias'         => 'roster',                            // default alias 'roster'. {alias} is substituted with this value below. Allows for customization within the admin area.
//			'regex'			=> '^{alias}/?$', 						// matched against url, and if true, redirected to 'redirect' below.
//			'sef'			=> '{alias}', 							// used by e107::url(); to create a url from the db table.
//			'redirect'		=> '{e_PLUGIN}roster/roster.php', 		// file-path of what to load when the regex returns true.
//
//		);


//		$config['index'] = array(
//			'regex'			=> '^roster/?$', 						// matched against url, and if true, redirected to 'redirect' below.
//			'sef'			=> 'roster', 							// used by e107::url(); to create a url from the db table.
//			'redirect'		=> '{e_PLUGIN}roster/roster.php', 		// file-path of what to load when the regex returns true.
//
//		);
		
		$config['ranks'] = array(
			'alias'         => 'ranks',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/ranks',
			'redirect'		=> '{e_PLUGIN}roster/ranks.php'			
		);
			
		$config['postistions'] = array(
			'alias'         => 'postistions',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/postistions',
			'redirect'		=> '{e_PLUGIN}roster/postistions.php'			
		);
		
		$config['application'] = array(
			'alias'         => 'application',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/application',
			'redirect'		=> '{e_PLUGIN}roster/application.php'			
		);
		
		$config['leaveofabsence'] = array(
			'alias'         => 'leave-of-absence',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/leave-of-absence',
			'redirect'		=> '{e_PLUGIN}roster/loa.php'			
		);
		
		$config['afteractionreport'] = array(
			'alias'         => 'after-action-report',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/after-action-reports',
			'redirect'		=> '{e_PLUGIN}roster/aar.php'			
		);
		
		$config['operationhub'] = array(
			'alias'         => 'operation-hub',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/operation-hub',
			'redirect'		=> '{e_PLUGIN}roster/opcenter.php'			
		);
		
		$config['orbat'] = array(
			'alias'         => 'orbat',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/ORBAT',
			'redirect'		=> '{e_PLUGIN}roster/roster.php'			
		);
		
		$config['qualifications'] = array(
			'alias'         => 'qualifications',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/qualifications',
			'redirect'		=> '{e_PLUGIN}roster/qualifications.php'			
		);
		
		$config['applicants'] = array(
			'alias'         => 'applicants',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/applicant-process',
			'redirect'		=> '{e_PLUGIN}roster/jua.php'			
		);
		
		$config['recruitercenter'] = array(
			'alias'			=> 'recruitercenter',
			'regex'			=> '^{alias}(.*)$',
			'sef'			=> '{alias}/recruiter-center',
			'redirect'		=> '{e_PLUGIN}roster/rcenter.php'
		);

		return $config;
	}
	

	
}