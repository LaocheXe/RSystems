<?php

// Generated e107 Plugin Admin Area 

require_once('../../class2.php');
if (!getperms('P')) 
{
	e107::redirect('admin');
	exit;
}
// This will be uncommented out once one has been made
// e107::lan('roster',true);


class roster_adminArea extends e_admin_dispatcher
{

	protected $modes = array(	
	
		'main'	=> array(
			'controller' 	=> 'service_records_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'service_records_sys_form_ui',
			'uipath' 		=> null
		),
		
		'pending'	=> array(
			'controller' 	=> 'sr_pending_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'sr_pending_sys_form_ui',
			'uipath' 		=> null
		),
		
		'discharges'	=> array(
			'controller' 	=> 'sr_discharges_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'sr_discharges_sys_form_ui',
			'uipath' 		=> null
		),


	);	
	
	
	protected $adminMenu = array(
												// TODO - Generate The LAN's - eXe
		'main/list'			=> array('caption'=> 'Service Records', 'perm' => 'P'),
		'main/create'		=> array('caption'=> 'Add Service Record', 'perm' => 'P'),
		'opt1'              => array('divider'=> true),
		// Pending
		'pending/list'		=> array('caption'=> 'Pending', 'perm' => 'P'),
		'opt2'              => array('divider'=> true),
		// Discharges
		'discharges/list'	=> array('caption'=> 'Discharges', 'perm' => 'P'),
		'opt3'              => array('divider'=> true),
		// Back To Roster
		'main/back'	  		=> array('caption'=> 'Roster System', 'perm' => 'P'),
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'			
	);	
	
	protected $menuTitle = 'Roster System';
}
/////////////////////////////////////////////  ^^^^^ TOP ^^^^^  /////////////////////////////////////////////
				
class service_records_sys_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Roster System';
		protected $pluginName		= 'roster';
	//	protected $eventName		= 'testing-service_records_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'service_records_sys';
		protected $pid				= 'sr_id';
		protected $perPage			= 50; 
		protected $batchDelete		= true;
		protected $batchExport     = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'sr_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'sr_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'user_id' =>   array ( 'title' => 'User', 'type' => 'user', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'clone_number' =>   array ( 'title' => 'Clone Number', 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'arma_id' =>   array ( 'title' => 'Arma ID', 'type' => 'text', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'ts_guid' =>   array ( 'title' => 'TS Guid', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'battleeye_guid' =>   array ( 'title' => 'BattleEye Guid', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'recruiter_id' =>   array ( 'title' => 'Recruiter', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'application_id' =>   array ( 'title' => 'Application ID', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'date_join' =>   array ( 'title' => 'Join Date', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'qual_id' =>   array ( 'title' => 'Qualifications', 'type' => 'method', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'awards_id' =>   array ( 'title' => 'Awards', 'type' => 'method', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rank_id' =>   array ( 'title' => 'Rank', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'awol_status' =>   array ( 'title' => 'AWOL Status', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'discharge_id' =>   array ( 'title' => 'Discharged ID', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'post_id' =>   array ( 'title' => 'Position', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'tis_date' =>   array ( 'title' => 'Time In Service', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'tig_date' =>   array ( 'title' => 'Time In Grade', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'player_portrate' =>   array ( 'title' => 'Portrate', 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => 'thumb=80x80', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('user_id', 'clone_number', 'rank_id', 'awol_status', 'tis_date', 'tig_date');
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(); 

	
		public function init()
		{	
//////////////////////////////////////////////////////////////////////////////////////////////
			// Will Change Later - For Now User	
			//$this->recruiter_id[0] = 'Select Recruiter';
			//if($sql2->select("user", "*")) { while ($row = $sql2->fetch()) {
			//	$this->recruiter_id[$row['user_id']] = $row['user_name']; } 	} 
        	//	$this->fields['user_id']['writeParms'] = $this->recruiter_id;
			//$cShopq = "SELECT cshop_id, cshop_name, userclass_id FROM `#cshops_cats_sys` WHERE cshop_id = 10";
			//$sqlR1 = e107::getDB()->retrieve($cShopq);
			//$rClass = $sqlR1['userclass_id']; // TODO
			//$rqey = "SELECT user_id, user_name, user_class FROM `#user` WHERE FIND_IN_SET(".$rClass.", user_class) OR user_class = ".$rClass." ORDER by user_name";
			//$sql2 = e107::getDB()->retrieve('user', 'user_id,user_name,user_class', 'user_class = '.$uClass.'',true);
			$sql2 = e107::getDB()->retrieve('user', 'user_id,user_name', 'user_name != 0',true);
			//$sql2 = e107::getDB()->retrieve($rqey);
			$this->user_id[0] = 'Select Recruiter';
			$this->user_id[00] = 'Other';
			foreach($sql2 as $val2)
			{
				$id2 = $val2['recruiter_id'];
			}
			$this->fields['recruiter_id']['writeParms'] = $this->user_id;
//////////////////////////////////////////////////////////////////////////////////////////////
			$laQuery = "SELECT rank_id,rank_name,rank_parent,rank_order FROM `#ranks_sys` WHERE rank_id != 0 ORDER BY rank_order ASC";
			$sql3 = e107::getDB()->retrieve($laQuery, true);
			//$sql3 = e107::getDB()->retrieve('ranks_sys', 'rank_id,rank_name,rank_parent', 'rank_id != 0',true);
			$this->rank_id[0] = 'Select Rank';
			foreach($sql3 as $val)
			{
				$id = $val['rank_id'];

				if($val['rank_parent'] >= 1)
				{
					$this->rank_id[$id] = $val['rank_name'];
				}
			}
			$this->fields['rank_id']['writeParms'] = $this->rank_id;
//////////////////////////////////////////////////////////////////////////////////////////////	
			// maybe in the future, make ur own types of discharge
			$this->discharge_id[0] = 'None';
			$this->discharge_id[1] = 'Transfer';
			$this->discharge_id[2] = 'General Discharge';
			$this->discharge_id[4] = 'Honorable Discharge';
			
			$this->fields['discharge_id']['writeParms'] = $this->discharge_id;
//////////////////////////////////////////////////////////////////////////////////////////////

			$this->awol_status[0] = 'Active';
			$this->awol_status[1] = 'Simi-Active';
			$this->awol_status[2] = 'Inactive';
			$this->awol_status[3] = 'LOA';
			$this->awol_status[4] = 'ELOA';
			
			$this->fields['awol_status']['writeParms'] = $this->awol_status;
//////////////////////////////////////////////////////////////////////////////////////////////

			$sqlP1 = e107::getDB();
			$this->post_id[0] = 'Select Posistion';
			if($sqlP1->select("postition_sys", "*"))
			{
				while ($rowP1 = $sqlP1->fetch())
				{
					$this->post_id[$rowP1['post_id']] = $rowP1['post_name'];
				}
			} 

			$this->fields['post_id']['writeParms'] = $this->post_id;
//////////////////////////////////////////////////////////////////////////////////////////////
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
		
		// ------- Delete Update --------
		
	//	public function beforeDelete($new_data, $old_date, $id)
	//	{
			// TODO ASAP
			// make a copy to discharge section
	//		$sqlQ1 = "INSERT INTO user_id,clone_number,arma_id,ts_guid,battleeye_guid,recruiter_id,application_id,date_join,qual_id,awards_id,rank_id,awol_status,discharge_id,post_id,tis_date,tig_date,player_portrate `#sr_discharged_sys` SELECT user_id,clone_number,arma_id,ts_guid,battleeye_guid,recruiter_id,application_id,date_join,qual_id,awards_id,rank_id,awol_status,discharge_id,post_id,tis_date,tig_date,player_portrate FROM `#service_records_sys` WHERE sr_id=".$id."";
	//	}
		
		// left-panel help menu area. 
		public function renderHelp()
		{
			$caption = 'Information';
			$text = 'When Adding a new service record:<br /><br />
			•User - User Name<br />
			•Clone Number - Up to 8 Digit Number<br />
			•Arma ID - Their Arma 3 ID<br />
			•TS GUID - TeamSpeak GUID<br />
			•BattleEye GUID - BattleEye GUID<br />
			•Recruiter - Who Recruited Them<br />
			•Application ID - If they submitted an Application<br />
			•Join Date - When they joined the website<br />
			•Qualification - WIP<br />
			•Awards - WIP<br />
			•Rank - What is their current rank<br />
			•AWOL Status - Are the active, etc...<br />
			•Discharge ID - WIP (None)<br />
			•Position - Their MOS/Role<br />
			•Time in Service - TiS<br />
			•Time in Grade - TiG<br />
			•Portrate - Their own Picture if they want it';

			return array('caption'=>$caption,'text'=> $text);

		}
		
		public function backPage()
    	{
     		$mainadmin = e_SELF.'/../admin_config.php';
     		header("location:".$mainadmin); exit; 
    	} 
}
				


class service_records_sys_form_ui extends e_admin_form_ui
{
	
	function user_id($curVal,$mode)
	{
		switch($mode)
		{
			case 'read':
				$userIDsr = "SELECT u.user_id, u.user_name FROM `#user` AS u
							LEFT JOIN `#service_records_sys` AS sr ON sr.user_id = u.user_id";
				$sqlSRui = e107::getDB();
				$curVal = $sqlSRui->retrieve($userIDsr);
				return $curVal;
			break;
			
			case 'write':
				$filterQuery = "SELECT u.user_id, u.user_name FROM `#user` AS u
								LEFT JOIN `#service_records_sys` AS sr ON sr.user_id = u.user_id
								WHERE sr.user_id IS NULL";
				$sql = e107::getDB();
				if($sql->retrieve($filterQuery))
				{
					while ($row = $sql->fetch())
					//while ($row = $sqlUser)
					{
						$this->user_id[$row['user_id']] = $row['user_name'];
					}
				//foreach($row as $sqlUser)
				//{
				//	$this->user_id[$row['user_id']] = $row['user_name'];
				//}
				} 
        		$this->fields['user_id']['writeParms'] = $this->user_id;
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;

		}
	}
}			

class sr_pending_sys_ui extends e_admin_ui
{
	
		protected $pluginTitle		= 'Pending Applicant System';
		protected $pluginName		= 'roster';
	//	protected $eventName		= 'testing-service_records_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'sr_pending_sys';
		protected $pid				= 'srp_id';
		protected $perPage			= 25; 
		protected $batchDelete		= true;
		protected $batchExport      = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent       = 'somefield_parent';
	//	protected $treePrefix       = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'srp_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'srp_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'user_id' =>   array ( 'title' => 'User', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'clone_number' =>   array ( 'title' => 'Number', 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'arma_id' =>   array ( 'title' => 'ArmA ID', 'type' => 'text', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'recruiter_id' =>   array ( 'title' => 'Recruiter', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'application_id' =>   array ( 'title' => 'Application ID', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'c_date' =>   array ( 'title' => 'Creation Date', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('user_id', 'clone_number', 'arma_id', 'recruiter_id', 'c_date');
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(
		); 

	
		public function init()
		{	
			// Drop down menu for user_id -> User
			// TODO: Filter current Service Record Users with no-service record users
			$sql = e107::getDb();
			$this->user_id[0] = 'Select User';
			if($sql->select("user", "*")) { while ($row = $sql->fetch()) {
				$this->user_id[$row['user_id']] = $row['user_name']; } 	} 
        		$this->fields['user_id']['writeParms'] = $this->user_id;
				
			// Will Change Later - For Now User	
			//$this->recruiter_id[0] = 'Select Recruiter';
			//if($sql2->select("user", "*")) { while ($row = $sql2->fetch()) {
			//	$this->recruiter_id[$row['user_id']] = $row['user_name']; } 	} 
        	//	$this->fields['user_id']['writeParms'] = $this->recruiter_id;
			$sql2 = e107::getDB()->retrieve('user', 'user_id,user_name', 'user_name != 0',true);
			$this->user_id[0] = 'Select Recruiter';
			foreach($sql2 as $val2)
			{
				$id2 = $val2['recruiter_id'];
			}
			$this->fields['recruiter_id']['writeParms'] = $this->user_id;
			
		//	$sql3 = e107::getDB()->retrieve('ranks_sys', 'rank_id,rank_name,rank_parent', 'rank_id != 0',true);
		//	$this->rank_id[0] = 'Select Rank';
		//	foreach($sql3 as $val)
		//	{
		//		$id = $val['rank_id'];

		//		if($val['rank_parent'] >= 1)
		//		{
		//			$this->rank_id[$id] = $val['rank_name'];
		//		}
		//	}
		//	$this->fields['rank_id']['writeParms'] = $this->rank_id;
			
			
			// Set drop-down values (if any). 
		//	$this->fields['application_status']['writeParms']['optArray'] = array('application_status_0','application_status_1', 'application_status_2'); // Example Drop-down array. 
		//	$this->fields['rank_id']['writeParms']['optArray'] = array('rank_id_0','rank_id_1', 'rank_id_2'); // Example Drop-down array. 
		//	$this->fields['awol_status']['writeParms']['optArray'] = array('awol_status_0','awol_status_1', 'awol_status_2'); // Example Drop-down array. 
		//	$this->fields['transfer_status']['writeParms']['optArray'] = array('transfer_status_0','transfer_status_1', 'transfer_status_2'); // Example Drop-down array. 
		//	$this->fields['post_id']['writeParms']['optArray'] = array('post_id_0','post_id_1', 'post_id_2'); // Example Drop-down array. 
	
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
		public function renderHelp()
		{
			$caption = LAN_HELP;
			$text = 'Some help text';

			return array('caption'=>$caption,'text'=> $text);

		}			
}

class sr_pending_sys_form_ui extends e_admin_form_ui
{
	
	function user_id($curVal,$mode)
	{
		switch($mode)
		{
			case 'read':
				$userIDsr = "SELECT u.user_id, u.user_name FROM `#user` AS u
							LEFT JOIN `#sr_pending_sys` AS sr ON sr.user_id = u.user_id";
				$sqlSRui = e107::getDB();
				$curVal = $sqlSRui->retrieve($userIDsr);
				return $curVal;
			break;
			
			case 'write':
				$filterQuery = "SELECT u.user_id, u.user_name FROM `#user` AS u
								LEFT JOIN `#sr_pending_sys` AS sr ON sr.user_id = u.user_id
								WHERE sr.user_id IS NULL";
				$sql = e107::getDB();
				if($sql->retrieve($filterQuery))
				{
					while ($row = $sql->fetch())
					//while ($row = $sqlUser)
					{
						$this->user_id[$row['user_id']] = $row['user_name'];
					}
				//foreach($row as $sqlUser)
				//{
				//	$this->user_id[$row['user_id']] = $row['user_name'];
				//}
				} 
        		$this->fields['user_id']['writeParms'] = $this->user_id;
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;

		}
	}
}

class sr_discharges_sys_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Roster System';
		protected $pluginName		= 'roster';
	//	protected $eventName		= 'testing-sr_discharged_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'sr_discharged_sys';
		protected $pid				= 'srd_id';
		protected $perPage			= 50; 
		protected $batchDelete		= true;
		protected $batchExport      = true;
		protected $batchCopy		= true;

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent       = 'somefield_parent';
	//	protected $treePrefix       = 'somefield_title';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
	
		protected $listOrder		= 'srd_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'sr_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'user_id' =>   array ( 'title' => 'User', 'type' => 'user', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'clone_number' =>   array ( 'title' => 'Clone Number', 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'arma_id' =>   array ( 'title' => 'Arma ID', 'type' => 'text', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'ts_guid' =>   array ( 'title' => 'TS Guid', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'battleeye_guid' =>   array ( 'title' => 'BattleEye Guid', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'recruiter_id' =>   array ( 'title' => 'Recruiter', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'application_id' =>   array ( 'title' => 'Application ID', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'date_join' =>   array ( 'title' => 'Join Date', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'qual_id' =>   array ( 'title' => 'Qualifications', 'type' => 'method', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'awards_id' =>   array ( 'title' => 'Awards', 'type' => 'method', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rank_id' =>   array ( 'title' => 'Rank', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'awol_status' =>   array ( 'title' => 'AWOL Status', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'discharge_id' =>   array ( 'title' => 'Discharged', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'post_id' =>   array ( 'title' => 'Position', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'tis_date' =>   array ( 'title' => 'Time In Service', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'tig_date' =>   array ( 'title' => 'Time In Grade', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'tod_date' =>   array ( 'title' => 'Time Of Discharge', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'dreason' =>	array( 'title' => 'Discharge Reason', 'type' => 'textarea', 'data' => 'str', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'player_portrate' =>   array ( 'title' => 'Portrate', 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => 'thumb=80x80', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('user_id', 'clone_number', 'discharge_id', 'tod_date');
		

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(); 

	
		public function init()
		{	
//////////////////////////////////////////////////////////////////////////////////////////////
			$sql2 = e107::getDB()->retrieve('user', 'user_id,user_name', 'user_name != 0',true);
			//$sql2 = e107::getDB()->retrieve($rqey);
			$this->user_id[0] = 'Select Recruiter';
			$this->user_id[00] = 'Other';
			foreach($sql2 as $val2)
			{
				$id2 = $val2['recruiter_id'];
			}
			$this->fields['recruiter_id']['writeParms'] = $this->user_id;
//////////////////////////////////////////////////////////////////////////////////////////////
			$laQuery = "SELECT rank_id,rank_name,rank_parent,rank_order FROM `#ranks_sys` WHERE rank_id != 0 ORDER BY rank_order ASC";
			$sql3 = e107::getDB()->retrieve($laQuery, true);
			//$sql3 = e107::getDB()->retrieve('ranks_sys', 'rank_id,rank_name,rank_parent', 'rank_id != 0',true);
			$this->rank_id[0] = 'Select Rank';
			foreach($sql3 as $val)
			{
				$id = $val['rank_id'];

				if($val['rank_parent'] >= 1)
				{
					$this->rank_id[$id] = $val['rank_name'];
				}
			}
			$this->fields['rank_id']['writeParms'] = $this->rank_id;
//////////////////////////////////////////////////////////////////////////////////////////////	
			
			$this->discharge_id[0] = 'None';
			$this->discharge_id[1] = 'Honorable';
			$this->discharge_id[2] = 'Dis-honorable';
			
			$this->fields['discharge_id']['writeParms'] = $this->discharge_id;
//////////////////////////////////////////////////////////////////////////////////////////////

			$this->awol_status[0] = 'Active';
			$this->awol_status[1] = 'Simi-Active';
			$this->awol_status[2] = 'Inactive';
			$this->awol_status[3] = 'LOA';
			$this->awol_status[4] = 'ELOA';
			
			$this->fields['awol_status']['writeParms'] = $this->awol_status;
//////////////////////////////////////////////////////////////////////////////////////////////

			$sqlP1 = e107::getDB();
			$this->post_id[0] = 'Select Posistion';
			if($sqlP1->select("postition_sys", "*"))
			{
				while ($rowP1 = $sqlP1->fetch())
				{
					$this->post_id[$rowP1['post_id']] = $rowP1['post_name'];
				}
			} 

			$this->fields['post_id']['writeParms'] = $this->post_id;
//////////////////////////////////////////////////////////////////////////////////////////////
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
		public function renderHelp()
		{
			$caption = 'Information';
			$text = 'When Adding a new service record:<br /><br />
			•User - User Name<br />
			•Clone Number - Up to 8 Digit Number<br />
			•Arma ID - Their Arma 3 ID<br />
			•TS GUID - TeamSpeak GUID<br />
			•BattleEye GUID - BattleEye GUID<br />
			•Recruiter - Who Recruited Them<br />
			•Application ID - If they submitted an Application<br />
			•Join Date - When they joined the website<br />
			•Qualification - WIP<br />
			•Awards - WIP<br />
			•Rank - What is their current rank<br />
			•AWOL Status - Are the active, etc...<br />
			•Discharge ID - WIP (None)<br />
			•Position - Their MOS/Role<br />
			•Time in Service - TiS<br />
			•Time in Grade - TiG<br />
			•Portrate - Their own Picture if they want it';

			return array('caption'=>$caption,'text'=> $text);

		}
		
		public function backPage()
    	{
     		$mainadmin = e_SELF.'/../admin_config.php';
     		header("location:".$mainadmin); exit; 
    	} 
}
				


class sr_discharges_sys_form_ui extends e_admin_form_ui
{
	
	function user_id($curVal,$mode)
	{
		switch($mode)
		{
			case 'read':
				$userIDsr = "SELECT u.user_id, u.user_name FROM `#user` AS u
							LEFT JOIN `#sr_discharged_sys` AS sr ON sr.user_id = u.user_id";
				$sqlSRui = e107::getDB();
				$curVal = $sqlSRui->retrieve($userIDsr);
				return $curVal;
			break;
			
			case 'write':
				$filterQuery = "SELECT u.user_id, u.user_name FROM `#user` AS u
								LEFT JOIN `#sr_discharged_sys` AS sr ON sr.user_id = u.user_id
								WHERE sr.user_id IS NULL";
				$sql = e107::getDB();
				if($sql->retrieve($filterQuery))
				{
					while ($row = $sql->fetch())
					//while ($row = $sqlUser)
					{
						$this->user_id[$row['user_id']] = $row['user_name'];
					}
				//foreach($row as $sqlUser)
				//{
				//	$this->user_id[$row['user_id']] = $row['user_name'];
				//}
				} 
        		$this->fields['user_id']['writeParms'] = $this->user_id;
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;

		}
	}
}		
		
new roster_adminArea();

require_once(e_ADMIN."auth.php");
e107::getAdminUI()->runPage();

require_once(e_ADMIN."footer.php");
exit;

?>