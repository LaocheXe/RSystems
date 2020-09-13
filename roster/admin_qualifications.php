<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('awards',true);


class qualifications_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'qualifications_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'qualifications_sys_form_ui',
			'uipath' 		=> null
		),
		
	);	
	
	
	protected $adminMenu = array(

		'main/list'			=> array('caption'=> "Qualification List", 'perm' => 'P'),
		'main/create'		=> array('caption'=> "Create Qualification", 'perm' => 'P'),
		
		'opt1'              => array('divider'=> true),
		
		'main/back'	  	=> array('caption'=> 'Roster System', 'perm' => 'P'),

		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'Qualifications';
}




				
class qualifications_sys_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Roster System';
		protected $pluginName		= 'roster';
	//	protected $eventName		= 'awards-awards_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'qualifications_sys';
		protected $pid				= 'qual_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'qual_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		  'qual_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'qual_name' =>   array ( 'title' => LAN_TITLE, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'qual_description' =>   array ( 'title' => LAN_DESCRIPTION, 'type' => 'textarea', 'data' => 'str', 'width' => '40%', 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'qual_image' =>   array ( 'title' => LAN_IMAGE, 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => 'thumb=80x80', 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		);		
		
		protected $fieldpref = array('qual_name', 'qual_image');
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		); 

	
		public function init()
		{
			// Set drop-down values (if any). 
	
		}

		
		// ------- Customize Create --------
		
		public function beforeCreate($new_data,$old_data)
		{
			return $new_data;
		}
	
		public function afterCreate($new_data, $old_data, $id)
		{
			// do something
		}

		public function onCreateError($new_data, $old_data)
		{
			// do something		
		}		
		
		
		// ------- Customize Update --------
		
		public function beforeUpdate($new_data, $old_data, $id)
		{
			return $new_data;
		}

		public function afterUpdate($new_data, $old_data, $id)
		{
			// do something	
		}
		
		public function onUpdateError($new_data, $old_data, $id)
		{
			// do something		
		}

		public function backPage()
    	{
     		$mainadmin = e_SELF.'/../admin_config.php';
     		header("location:".$mainadmin); exit; 
    	} 
}
				


class qualifications_sys_form_ui extends e_admin_form_ui
{

}		
				
		
new qualifications_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>