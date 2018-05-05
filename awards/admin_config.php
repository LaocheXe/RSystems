<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}

// e107::lan('awards',true);


class awards_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'awards_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'awards_sys_form_ui',
			'uipath' 		=> null
		),
		

		'other1'	=> array(
			'controller' 	=> 'awarded_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'awarded_sys_form_ui',
			'uipath' 		=> null
		),
		

	);	
	
	
	protected $adminMenu = array(

		'main/list'			=> array('caption'=> "Awards List", 'perm' => 'P'),
		'main/create'		=> array('caption'=> "Add Award", 'perm' => 'P'),

		'other1/list'			=> array('caption'=> "Awarded List", 'perm' => 'P'),
		'other1/create'		=> array('caption'=> "Award User", 'perm' => 'P'),

		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'Awards';
}




				
class awards_sys_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Awards';
		protected $pluginName		= 'awards';
	//	protected $eventName		= 'awards-awards_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'awards_sys';
		protected $pid				= 'award_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'award_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		  'award_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'award_name' =>   array ( 'title' => LAN_TITLE, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'award_description' =>   array ( 'title' => LAN_DESCRIPTION, 'type' => 'textarea', 'data' => 'str', 'width' => '40%', 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'award_image' =>   array ( 'title' => LAN_IMAGE, 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => 'thumb=80x80', 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		);		
		
		protected $fieldpref = array('award_name', 'award_image');
		

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
					
	/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			$otherField  = $this->getController()->getFieldVar('other_field_name');
			return $text;
			
		}
		
	
		
		
	*/
			
}
				


class awards_sys_form_ui extends e_admin_form_ui
{

}		
		

				
class awarded_sys_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Awards';
		protected $pluginName		= 'awards';
	//	protected $eventName		= 'awards-awarded_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'awarded_sys';
		protected $pid				= 'awarded_id';
		protected $perPage			= 10; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'awarded_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		 'awarded_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		 'award_id' =>   array ( 'title' => LAN_RSYS_PAGE_AWARDS, 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		 'user_id' =>   array ( 'title' => LAN_USER, 'type' => 'user', 'data' => 'int', 'width' => '5%', 'filter' => true, 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		 'awarded_date' =>	array (	'title' => LAN_AWARDED_DATE, 'type' => 'datestamp', 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1', 'readParms' =>  array ( ),
		 'writeParms' =>  array ( ),
		  ),
		);		
		
		protected $fieldpref = array('award_id','user_id');
		
	
		public function init()
		{
			// Set drop-down values (if any).
			$sql = e107::getDb();
			$this->award_id[0] = 'Select Award';
			if($sql->select("awards_sys", "*"))
			{
				while ($row = $sql->fetch())
				{
					$this->award_id[$row['award_id']] = $row['award_name'];
				}
			} 
        	$this->fields['award_id']['writeParms'] = $this->award_id;

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
		
		// left-panel help menu area. 			
	/*	
		// optional - a custom page.  
		public function customPage()
		{
			$text = 'Hello World!';
			$otherField  = $this->getController()->getFieldVar('other_field_name');
			return $text;
			
		}
		
	
		
		
	*/
			
}
				


class awarded_sys_form_ui extends e_admin_form_ui
{

	
	// Custom Method/Function 
	function awards($curVal,$mode)
	{

		 		
		switch($mode)
		{
			case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
				return $this->text('awards',$curVal, 255, 'size=large');
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}

}		
		
		
new awards_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>