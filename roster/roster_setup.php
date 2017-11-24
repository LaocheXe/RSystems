<?php
/*
* e107 website system
*
* Copyright (C) 2008-2013 e107 Inc (e107.org)
* Released under the terms and conditions of the
* GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
*
* Custom install/uninstall/update routines for roster plugin
**
*/




//////////////////////. Won't be needing this File - but don't delete just yet .//////////////////////////////////////////
if(!class_exists("roster_setup"))
{
	class roster_setup
	{

	    function install_pre($var)
		{
			// print_a($var);
			// echo "custom install 'pre' function<br /><br />";
		}

		/**
		 * For inserting default database content during install after table has been created by the roster_sql.php file.
		 */
		function install_post($var)
		{
			$sql = e107::getDb();
			$mes = e107::getMessage();

			$e107roster = array(
				'roster_id'				=>'1',
				'roster_icon'			=>'{e_PLUGIN}roster/images/roster_32.png',
				'roster_type'			=>'type_1',
				'roster_name'			=>'My Name',
				'roster_folder'			=>'Folder Value',
				'roster_version'			=>'1',
				'roster_author'			=>'bill',
				'roster_authorURL'		=>'http://e107.org',
				'roster_date'			=>'1352871240',
				'roster_compatibility'	=>'2',
				'roster_url'				=>'http://e107.org'
			);

			if($sql->insert('roster',$e107roster))
			{
				$mes->add("Custom - Install Message.", E_MESSAGE_SUCCESS);
			}
			else
			{
				$mes->add("Custom - Failed to add default table data.", E_MESSAGE_ERROR);
			}

		}

		function uninstall_options()
		{

			$listoptions = array(0=>'option 1',1=>'option 2');

			$options = array();
			$options['mypref'] = array(
					'label'		=> 'Custom Uninstall Label',
					'preview'	=> 'Preview Area',
					'helpText'	=> 'Custom Help Text',
					'itemList'	=> $listoptions,
					'itemDefault'	=> 1
			);

			return $options;
		}


		function uninstall_post($var)
		{
			// print_a($var);
		}

		function upgrade_post($var)
		{
			// $sql = e107::getDb();
		}

	}

}