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
			'controller' 	=> 'roster_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'roster_sys_form_ui',
			'uipath' 		=> null
		),
		
		'other1'	=> array(
			'controller' 	=> 'postition_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'postition_sys_form_ui',
			'uipath' 		=> null
		),
		
		'other2'	=> array(
			'controller' 	=> 'ranks_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'ranks_sys_form_ui',
			'uipath' 		=> null
		),
		
		'opt2'	=> array(
			'controller'	=> 'opt2_ui',
			'path'			=> null,
			'ui'			=> 'opt2_form_ui',
			'uiPath'				=> null
		),
		
	);	
	
	
	protected $adminMenu = array(
												// TODO - Generate The LAN's - eXe
		'main/list'			=> array('caption'=> 'Roster Manager', 'perm' => 'P'),
		'main/create'		=> array('caption'=> 'Create Roster', 'perm' => 'P'),

		'other1/list'			=> array('caption'=> 'Postition Manager', 'perm' => 'P'),
		'other1/create'		=> array('caption'=> 'Create Postition', 'perm' => 'P'),
		
		'other2/list'			=> array('caption'=> 'Ranks Manager', 'perm' => 'P'),
		'other2/create'		=> array('caption'=> 'Create Ranks', 'perm' => 'P'),
		
		'opt1'              => array('divider'=> true),
		
		'main/back'			=> array('caption'=> 'Service Records', 'perm' => 'P'),
		'other1/back'		=> array('caption'=> 'C-Shops', 'perm' => 'P'),
		'other2/back'		=> array('caption'=> 'Awards', 'perm' => 'P'),
		'opt2/back'		=> array('caption'=> 'Qualifications', 'perm' => 'P'),
		

		// 'main/custom'		=> array('caption'=> 'Custom Page', 'perm' => 'P')
	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'Roster System';
}

				
class roster_sys_ui extends e_admin_ui
{		
		protected $pluginTitle		= 'Roster System';
		protected $pluginName		= 'roster';
	//	protected $eventName		= 'roster-roster_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'roster_sys';
		protected $pid				= 'ros_id';
		protected $perPage			= 15; 
		protected $batchDelete		= true;
		protected $sortField		= 'ros_order';
		protected $sortParent       = 'ros_parent';
		protected $batchExport     = true;
		protected $batchCopy		= true;
		protected $orderStep		= 50;
		protected $listQry          = "SELECT a. *, CASE WHEN a.ros_parent = 0 THEN a.ros_order ELSE b.ros_order + (( a.ros_order)/1000) END AS Sort FROM `#roster_sys` AS a LEFT JOIN `#roster_sys` AS b ON a.ros_parent = b.ros_id ";
		protected $listOrder		= 'Sort,ros_order ';

	//	protected $sortField		= 'somefield_order';
	//	protected $sortParent      = 'somefield_parent';
	//	protected $treePrefix      = 'somefield_title';
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
	//	protected $listQry      	= "SELECT * FROM `#tableName` WHERE field != '' "; // Example Custom Query. LEFT JOINS allowed. Should be without any Order or Limit.
		//protected $listOrder		= 'ros_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'ros_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'userclass_id' => array ( 'title' => 'User Class', 'type' => 'userclass', 'data' => 'int', 'width' => 'auto', 'batch' => true, 'filter' => true, 'inline' => true, 'help' => '', 'readParms' => array('classlist'=>'public,guest,nobody,member,admin,main,new,mods,classes'), 'writeParms' => array('classlist'=>'public,guest,nobody,member,admin,main,new,mods,classes'), 'class' => 'left', 'thclass' => 'left',  ),
		  'ros_name' =>   array ( 'title' => LAN_TITLE, 'type' => 'text', 'inline'=>true,  'data' => 'str', 'width' => '40%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'ros_parent' =>   array ( 'title' => 'Parent', 'type' => 'dropdown', 'data' => 'int', 'width' => '10%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'ros_sub' =>   array ( 'title' => 'Sub-Parent', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'center', 'thclass' => 'center',  ),
		  'ros_order' =>   array ( 'title' => LAN_ORDER, 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'ros_show' =>   array ( 'title' => 'Show', 'type' => 'boolean', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('ros_name', 'ros_parent', 'ros_sub', 'ros_order', 'ros_show');
		
		public $forumParents = array();
		
		private function checkOrder()
		{
			$sql = e107::getDb();
			$sql2 = e107::getDb('sql2');
			$count = $sql->select('roster_sys', 'ros_id', 'ros_order = 0');

			if($count > 1)
			{
				$sql->gen("SELECT ros_id,ros_name,ros_parent,ros_sub,ros_order FROM `#roster_sys` ORDER BY COALESCE(NULLIF(ros_parent,0), ros_id), ros_parent > 0, ros_order ");
				$c = 0;
				while($row = $sql->fetch())
				{
					//print_a($row);
					if($row['ros_parent'] == 0)
					{
						$c = $c + 100;
					}
					else
					{
						$c = $c+1;
					}

					$sql2->update('roster_sys', 'ros_order = '.$c.' WHERE ros_id = '.$row['ros_id'].' LIMIT 1');
				}
			}
		}

	//	protected $preftabs        = array('General', 'Other' );
		protected $prefs = array(); 
	
		public function init()
		{	
			$sql = e107::getDb();

			$this->fields['userclass_id']['batch'] = false;
			$this->checkOrder();
			if($this->getAction() == 'edit')
			{
				$this->fields['ros_order']['noedit'] = true;
			}
			$data = e107::getDb()->retrieve('roster_sys', 'ros_id,ros_name,ros_parent', 'ros_id != 0',true);
			$this->rosParents[0] = "(New Parent)";
			$rosterSubParents = array();

			foreach($data as $val)
			{
				$id = $val['ros_id'];

				//if($val['ros_parent'] >= 0)
				//{
					$this->rosParents[$id] = $val['ros_name'];
				//}
				//elseif($val['ros_parent'] >= 0)
				//{
					$rosterSubParents[$id] = $val['ros_name'];
				//}

			}

			$this->fields['ros_parent']['writeParms'] = $this->rosParents;
			$this->fields['ros_sub']['writeParms']['optArray'] = $rosterSubParents;
			$this->fields['ros_sub']['writeParms']['default'] = 'blank';	
		}

		// ------- Customize Create --------		
		public function afterSort($result, $selected)
		{

			return;

			$sql = e107::getDb();

			$data2 = $sql->retrieve('roster_sys','ros_id,ros_parent,ros_name,ros_order','ros_parent = 0',true);
			foreach($data2 as $val)
			{
				$id = $val['ros_id'];
				$parent[$id] = $val['ros_order'];

			}

			$previous = 0;

			$data = $sql->retrieve('roster_sys','*','ros_parent != 0 ORDER BY ros_order',true);
			foreach($data as $row)
			{
				$p = $row['ros_parent'];

				if($p != $previous)
				{
					$c = $parent[$p];
				}

				$c++;
				$previous = $p;
				
				$sql->update('roster_sys','ros_order = '.$c.' WHERE ros_id = '.intval($row['ros_id']).' LIMIT 1');
			}
		}
		
		public function beforeCreate($new_data,$old_data)
		{
			$sql = e107::getDb();
			$parentOrder = $sql->retrieve('roster_sys','ros_order','ros_id='.$new_data['ros_parent']." LIMIT 1");

			$new_data['ros_order'] = $parentOrder + 50;
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
		
		public function backPage()
    	{
     		$mainadmin = e_SELF.'/../admin_sr.php';
     		header("location:".$mainadmin); exit; 
    	}
}
				
class roster_sys_form_ui extends e_admin_form_ui
{
	function userclass_id($curVal,$mode)
	{
		$frm = e107::getForm();
		$e_userclass = e107::getUserClass();
		//$pref = e107::getPref();
		//$user_data = $this->getParam('user_data');
		//if (!isset ($user_data['user_class'])) $user_data['user_class'] = varset($pref['initial_user_classes'])
		 		
		switch($mode)
		{
			case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
				$temp = $e_userclass->vetted_tree('class', array($e_userclass, 'checkbox_desc'), $this->userclass_id['userclass_id'], 'classes, no-excludes');

				if ($temp)
				{
					$text .= "<tr style='vertical-align:top'>
					<td>
						User Class (Select Only One):
					</td>
					<td>
						<a href='#set_class' class='btn btn-default e-expandit'>User Class</a>
						<div class='e-hideme' id='set_class'>
							{$temp}
						</div>
					</td>
					</tr>\n";
				}
				return $text;		
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}
	
	function roster_name($curVal,$mode,$parm)
	{
			$frm = e107::getForm();

			if($mode == 'read')
			{
				$parent 	= $this->getController()->getListModel()->get('ros_parent');
				$id			= $this->getController()->getListModel()->get('ros_id');
				$sub     = $this->getController()->getListModel()->get('ros_sub');



				$level = 1;

				if(!empty($sub))
				{
					$level = 3;
				}

				$linkQ = e_SELF."?searchquery=&filter_options=page_chapter__".$id."&mode=page&action=list";
				$level_image = $parent ? str_replace('level-x','level-'.$level, ADMIN_CHILD_ICON) : '';

				return ($parent) ?  $level_image.$curVal : $curVal;
			}

			if($mode == 'write')
			{
				return $frm->text('ros_name',$curVal,255,'size=xxlarge');
			}

			if($mode == 'filter')
			{
				return;
			}
			if($mode == 'batch')
			{
				return;
			}

			if($mode == 'inline')
			{
				$parent 	= $this->getController()->getListModel()->get('ros_parent');
				$sub     = $this->getController()->getListModel()->get('ros_sub');
				
				if(!empty($parent))
				{

					$level = 1;

					if(!empty($sub))
					{
						$level = 2;
					}

					$ret['inlineParms'] = array('pre'=> str_replace('level-x','level-'.$level, ADMIN_CHILD_ICON));
				}
				
				return $ret;
				
			}
		}


		// Custom Method/Function
		function ros_parent($curVal,$mode)
		{
			$frm = e107::getForm();

			switch($mode)
			{
				case 'read': // List Page
					return $curVal;
					break;

				case 'write': // Edit Page
					return $frm->text('ros_parent',$curVal);
					break;

				case 'filter':
				case 'batch':
				//	return  $array;
					break;
			}
		}


		// Custom Method/Function
		function ros_sub($curVal,$mode)
		{
			$frm = e107::getForm();

			switch($mode)
			{
				case 'read': // List Page
					return $curVal;
					break;

				case 'write': // Edit Page
					return $frm->text('ros_sub',$curVal);
					break;

				case 'filter':
				case 'batch':
				//	return  $array;
					break;
			}
		}
}		
				
class ranks_sys_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Roster System';
		protected $pluginName		= 'roster';
	//	protected $eventName		= 'unitexe-ranks_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'ranks_sys';
		protected $pid				= 'rank_id';
		protected $perPage			= 50; 
		protected $batchDelete		= true;
	//	protected $batchCopy		= true;		
		protected $sortField		= 'rank_order';
		protected $sortParent       = 'rank_parent';
		protected $orderStep		= 50;
	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
		protected $listQry          = "SELECT a. *, CASE WHEN a.rank_parent = 0 THEN a.rank_order ELSE b.rank_order + (( a.rank_order)/1000) END AS Sort FROM `#ranks_sys` AS a LEFT JOIN `#ranks_sys` AS b ON a.rank_parent = b.rank_id ";
	
		protected $listOrder		= 'Sort,rank_order ';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'rank_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rank_name' =>   array ( 'title' => LAN_TITLE, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rank_shortname' =>   array ( 'title' => LAN_TAGS, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rank_description' =>   array ( 'title' => LAN_DESCRIPTION, 'type' => 'textarea', 'data' => 'str', 'width' => '40%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rank_image' =>   array ( 'title' => LAN_IMAGE, 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => 'thumb=80x80', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rank_parent' =>   array ( 'title' => 'Parent', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rank_order' =>   array ( 'title' => LAN_ORDER, 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1', 'sort'=>1 ),
		);		
		
		protected $fieldpref = array('rank_name','rank_shortname', 'rank_image', 'rank_parent', 'Sort', 'rank_order');
		

	//	protected $preftabs        = array('General', 'Other' );
	//	protected $prefs = array();
		public $forumParents = array();
	
		private function checkOrder()
		{
			$sql = e107::getDb();
			$sql2 = e107::getDb('sql2');
			$count = $sql->select('ranks_sys', 'rank_id', 'rank_order = 0');

			if($count > 1)
			{
				$sql->gen("SELECT rank_id,rank_name,rank_parent,rank_order FROM `#ranks_sys` ORDER BY COALESCE(NULLIF(rank_parent,0), rank_id), rank_parent > 0, rank_order ");

				$c = 0;
				while($row = $sql->fetch())
				{
					//print_a($row);
					if($row['rank_parent'] == 0)
					{
						$c = $c + 100;
					}
					else
					{
						$c = $c+1;
					}

					$sql2->update('ranks_sys', 'rank_order = '.$c.' WHERE rank_id = '.$row['rank_id'].' LIMIT 1');
				}

			}
			
		}

		public function init()
		{
			// Set drop-down values (if any). 
			$this->checkOrder();
			if($this->getAction() == 'edit')
			{
				$this->fields['rank_order']['noedit'] = true;
			}
			$data = e107::getDb()->retrieve('ranks_sys', 'rank_id,rank_name,rank_parent', 'rank_id != 0',true);
			$this->rankParents[0] = "(New Parent)";

			foreach($data as $val)
			{
				$id = $val['rank_id'];

				if($val['rank_parent'] == 0)
				{
					$this->rankParents[$id] = $val['rank_name'];
				}
				else
				{
					$forumSubParents[$id] = $val['rank_name'];
				}

			}

			$this->fields['rank_parent']['writeParms'] = $this->rankParents;
		}

		
		// ------- Customize Create --------
		public function afterSort($result, $selected)
		{

			return;

			$sql = e107::getDb();

			$data2 = $sql->retrieve('ranks_sys','rank_id,rank_name,rank_parent,rank_order','rank_parent = 0',true);
			foreach($data2 as $val)
			{
				$id = $val['rank_id'];
				$parent[$id] = $val['rank_order'];

			}

			$previous = 0;

			$data = $sql->retrieve('ranks_sys','*','rank_parent != 0 ORDER BY rank_order',true);
			foreach($data as $row)
			{
				$p = $row['rank_parent'];

				if($p != $previous)
				{
					$c = $parent[$p];
				}

				$c++;
				$previous = $p;
				
				$sql->update('ranks_sys','rank_order = '.$c.' WHERE rank_id = '.intval($row['rank_id']).' LIMIT 1');

			}
		}
		
		public function beforeCreate($new_data,$old_data)
		{
			$sql = e107::getDb();
			$parentOrder = $sql->retrieve('ranks_sys','rank_order','rank_id='.$new_data['rank_parent']." LIMIT 1");

			$new_data['rank_order'] = $parentOrder + 50;
			
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
			return $text;
			
		}
	*/
			
}
				


class ranks_sys_form_ui extends e_admin_form_ui
{
	
	function rank_name($curVal,$mode,$parm)
	{

			$frm = e107::getForm();

			if($mode == 'read')
			{
				$parent 	= $this->getController()->getListModel()->get('rank_parent');
				$id			= $this->getController()->getListModel()->get('rank_id');
				//$sub     = $this->getController()->getListModel()->get('forum_sub');



				$level = 1;

				//if(!empty($sub))
				//{
				//	$level = 3;
				//}

				$linkQ = e_SELF."?searchquery=&filter_options=page_chapter__".$id."&mode=page&action=list";
				$level_image = $parent ? '<img src="'.e_IMAGE_ABS.'generic/branchbottom.gif" class="icon" alt="" style="margin-left: '.($level * 20).'px" />&nbsp;' : '';



				return ($parent) ?  $level_image.$curVal : $curVal;
			}

			if($mode == 'write')
			{
				return $frm->text('rank_name',$curVal,255,'size=xxlarge');
			}

			if($mode == 'filter')
			{
				return;
			}
			if($mode == 'batch')
			{
				return;
			}

			if($mode == 'inline')
			{
				$parent 	= $this->getController()->getListModel()->get('rank_parent');
				if(empty($parent))
				{
					return array('inlineType'=>'text');
				}

				return false;
			}
		}


		// Custom Method/Function
		function rank_parent($curVal,$mode)
		{
			$frm = e107::getForm();

			switch($mode)
			{
				case 'read': // List Page
					return $curVal;
					break;

				case 'write': // Edit Page
					return $frm->text('rank_parent',$curVal);
					break;

				case 'filter':
				case 'batch':
				//	return  $array;
					break;
		}
	}
}
				
class postition_sys_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Roster System';
		protected $pluginName		= 'roster';
	//	protected $eventName		= 'roster-postition_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'postition_sys';
		protected $pid				= 'post_id';
		protected $perPage			= 25; 
		protected $batchDelete		= true;
		protected $batchExport      = true;
		protected $batchCopy		= true;

		protected $sortField		= 'post_order';
		protected $sortParent       = 'post_parent';
	//	protected $treePrefix       = 'somefield_title';
		protected $orderStep		= 1;
		protected $listQry          = "SELECT a. *, CASE WHEN a.post_parent = 0 THEN a.post_order ELSE b.post_order + (( a.post_order)/1000) END AS Sort FROM `#postition_sys` AS a LEFT JOIN `#postition_sys` AS b ON a.post_parent = b.post_id ";
		protected $listOrder		= 'Sort,post_order ';

	//	protected $tabs				= array('Tabl 1','Tab 2'); // Use 'tab'=>0  OR 'tab'=>1 in the $fields below to enable. 
		
	//	protected $listQry      	= "SELECT * FROM `#postition_sys` WHERE field != '' ";
	
	//	protected $listOrder		= 'post_id DESC';
	
		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'post_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'post_name' =>   array ( 'title' => LAN_TITLE, 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'filter' => true, 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'post_description' =>   array ( 'title' => LAN_DESCRIPTION, 'type' => 'textarea', 'data' => 'str', 'width' => '40%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'post_image' =>   array ( 'title' => LAN_IMAGE, 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => 'thumb=80x80', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'post_order' =>   array ( 'title' => LAN_ORDER, 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'post_parent' =>   array ( 'title' => 'Parent', 'data' => 'int', 'width' => '10%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'post_sub' =>   array ( 'title' => 'Sub-Parent', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'center', 'thclass' => 'center',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('post_name', 'post_image', 'post_order');
		
		public $forumParents = array();
		
		private function checkOrder()
		{
			$sql = e107::getDb();
			$sql2 = e107::getDb('sql2');
			$count = $sql->select('postition_sys', 'post_id', 'post_order = 0');

			if($count > 1)
			{
				$sql->gen("SELECT post_id,post_name,post_order,post_parent,post_sub FROM `#postition_sys` ORDER BY COALESCE(NULLIF(post_parent,0), post_id), post_parent > 0, post_order ");
				$c = 0;
				while($row = $sql->fetch())
				{
					if($row['post_parent'] == 0)
					{
						$c = $c + 1;
					}
					else
					{
						$c = $c+1;
					}

					$sql2->update('postition_sys', 'post_order = '.$c.' WHERE post_id = '.$row['post_id'].' LIMIT 1');
				}
			}
		}
	
		public function init()
		{
			// Set drop-down values (if any). 
			$sql = e107::getDb();
			$this->checkOrder();
			if($this->getAction() == 'edit')
			{
				$this->fields['post_order']['noedit'] = true;
			}
			$data = e107::getDb()->retrieve('postition_sys', 'post_id,post_name,post_parent,post_sub', 'post_id != 0',true);
			$this->postiParents[0] = "(New Parent)";
			$postiSubParents = array();

			foreach($data as $val)
			{
				$id = $val['post_id'];

				//if($val['cshop_parent'] == 0)
				//{
					$this->postiParents[$id] = $val['post_name'];
				//}
				//else
				//{
					$postiSubParents[$id] = $val['post_name'];
				//}

			}

			$this->fields['post_parent']['writeParms'] = $this->postiParents;
			$this->fields['post_sub']['writeParms']['optArray'] = $postiSubParents;
			$this->fields['post_sub']['writeParms']['default'] = 'blank';	
		}

		
		// ------- Customize Create --------
		public function afterSort($result, $selected)
		{
			return;
			$sql = e107::getDb();
			$data2 = $sql->retrieve('postition_sys','post_id,post_parent,post_name,post_order','post_parent = 0',true);
			foreach($data2 as $val)
			{
				$id = $val['post_id'];
				$parent[$id] = $val['post_order'];

			}
			$previous = 0;
			$data = $sql->retrieve('postition_sys','*','post_parent != 0 ORDER BY post_order',true);
			foreach($data as $row)
			{
				$p = $row['post_parent'];

				if($p != $previous)
				{
					$c = $parent[$p];
				}

				$c++;
				$previous = $p;
				
				$sql->update('postition_sys','post_order = '.$c.' WHERE post_id = '.intval($row['post_id']).' LIMIT 1');
			}
		}
		
		public function beforeCreate($new_data,$old_data)
		{
			$sql = e107::getDb();
			$parentOrder = $sql->retrieve('postition_sys','post_order','post_id='.$new_data['post_parent']." LIMIT 1");

			$new_data['post_order'] = $parentOrder + 1;
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
		
		public function backPage()
    	{
     		$mainadmin = e_SELF.'/../admin_cshops.php';
     		header("location:".$mainadmin); exit; 
    	}
}
				

class postition_sys_form_ui extends e_admin_form_ui
{

}	

class service_records_sys_ui extends e_admin_ui
{
			
		protected $pluginTitle		= 'Roster System';
		protected $pluginName		= 'roster';
	//	protected $eventName		= 'testing-service_records_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'service_records_sys';
		protected $pid				= 'sr_id';
		protected $perPage			= 10; 
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
		  'user_id' =>   array ( 'title' => 'User', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'clone_number' =>   array ( 'title' => 'Number', 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'arma_id' =>   array ( 'title' => LAN_ID, 'type' => 'text', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'ts_guid' =>   array ( 'title' => 'Guid', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'battleeye_guid' =>   array ( 'title' => 'Guid', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'recruiter_id' =>   array ( 'title' => 'Recruiter', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'application_date' =>   array ( 'title' => 'Application Date', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'application_status' =>   array ( 'title' => 'Status', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'application_rep' =>   array ( 'title' => 'Rep', 'type' => 'user', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'application_reason' =>   array ( 'title' => 'Reason', 'type' => 'textarea', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'date_join' =>   array ( 'title' => 'Join Date', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'citations' =>   array ( 'title' => 'Citations', 'type' => 'textarea', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'awards_id' =>   array ( 'title' => LAN_ID, 'type' => 'method', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'rank_id' =>   array ( 'title' => 'Rank', 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'past_ranks' =>   array ( 'title' => 'Ranks', 'type' => 'method', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'awol_status' =>   array ( 'title' => 'Status', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'discharge_grade' =>   array ( 'title' => 'Grade', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'discharge_date' =>   array ( 'title' => 'Discharge Date', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'discharge_rep' =>   array ( 'title' => 'Rep', 'type' => 'user', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'transfer_from' =>   array ( 'title' => 'From', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'transfer_date_s' =>   array ( 'title' => 'Transfer Date Started', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'transfer_to' =>   array ( 'title' => 'To', 'type' => 'text', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'transfer_rep' =>   array ( 'title' => 'Rep', 'type' => 'user', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'transfer_status' =>   array ( 'title' => 'Status', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'transfer_date_a' =>   array ( 'title' => 'Transfer Date Accepted', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'trainings_attended' =>   array ( 'title' => 'Attended', 'type' => 'method', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'trainings_pass' =>   array ( 'title' => 'Pass', 'type' => 'method', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'past_cshops_id' =>   array ( 'title' => LAN_ID, 'type' => 'method', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'cshops_id' =>   array ( 'title' => LAN_ID, 'type' => 'method', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'past_post_id' =>   array ( 'title' => LAN_ID, 'type' => 'method', 'data' => 'str', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'post_id' =>   array ( 'title' => LAN_ID, 'type' => 'dropdown', 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'tis_date' =>   array ( 'title' => 'Time In Service', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'tig_date' =>   array ( 'title' => 'Time In Grade', 'type' => 'datestamp', 'data' => 'int', 'width' => 'auto', 'filter' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'player_portrate' =>   array ( 'title' => 'Portrate', 'type' => 'image', 'data' => 'str', 'width' => 'auto', 'help' => '', 'readParms' => 'thumb=80x80', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('user_id', 'clone_number', 'application_date', 'discharge_date', 'tis_date', 'tig_date');
		

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
			
			$sql3 = e107::getDB()->retrieve('ranks_sys', 'rank_id,rank_name,rank_parent', 'rank_id != 0',true);
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
			
			
			// Set drop-down values (if any). 
			$this->fields['application_status']['writeParms']['optArray'] = array('application_status_0','application_status_1', 'application_status_2'); // Example Drop-down array. 
			//$this->fields['rank_id']['writeParms']['optArray'] = array('rank_id_0','rank_id_1', 'rank_id_2'); // Example Drop-down array. 
			$this->fields['awol_status']['writeParms']['optArray'] = array('awol_status_0','awol_status_1', 'awol_status_2'); // Example Drop-down array. 
			$this->fields['transfer_status']['writeParms']['optArray'] = array('transfer_status_0','transfer_status_1', 'transfer_status_2'); // Example Drop-down array. 
			$this->fields['post_id']['writeParms']['optArray'] = array('post_id_0','post_id_1', 'post_id_2'); // Example Drop-down array. 
	
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

class opt2_ui extends e_admin_ui
{
	public function backPage()
	{
		$mainadmin = e_SELF.'/../admin_qualifications.php';
		header("location:".$mainadmin); exit;	
	}	
}

class opt2_form_ui extends e_admin_form_ui
{
	
}
				
class service_records_sys_form_ui extends e_admin_form_ui
{

	
	// Custom Method/Function 
	function awards_id($curVal,$mode)
	{

		 		
		switch($mode)
		{
			case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
				return $this->text('awards_id',$curVal, 255, 'size=large');
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}

	
	// Custom Method/Function 
	function past_ranks($curVal,$mode)
	{

		 		
		switch($mode)
		{
			case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
				return $this->text('past_ranks',$curVal, 255, 'size=large');
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}

	
	// Custom Method/Function 
	function trainings_attended($curVal,$mode)
	{

		 		
		switch($mode)
		{
			case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
				return $this->text('trainings_attended',$curVal, 255, 'size=large');
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}

	
	// Custom Method/Function 
	function trainings_pass($curVal,$mode)
	{

		 		
		switch($mode)
		{
			case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
				return $this->text('trainings_pass',$curVal, 255, 'size=large');
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}

	
	// Custom Method/Function 
	function past_cshops_id($curVal,$mode)
	{

		 		
		switch($mode)
		{
			case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
				return $this->text('past_cshops_id',$curVal, 255, 'size=large');
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}

	
	// Custom Method/Function 
	function cshops_id($curVal,$mode)
	{

		 		
		switch($mode)
		{
			case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
				return $this->text('cshops_id',$curVal, 255, 'size=large');
			break;
			
			case 'filter':
			case 'batch':
				return  array();
			break;
		}
	}

	
	// Custom Method/Function 
	function past_post_id($curVal,$mode)
	{

		 		
		switch($mode)
		{
			case 'read': // List Page
				return $curVal;
			break;
			
			case 'write': // Edit Page
				return $this->text('past_post_id',$curVal, 255, 'size=large');
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