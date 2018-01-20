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
			'controller' 	=> 'cshops_cats_sys_ui',
			'path' 			=> null,
			'ui' 			=> 'cshops_cats_sys_form_ui',
			'uipath' 		=> null
		),
	);	
	
	
	protected $adminMenu = array(
												// TODO - Generate The LAN's - eXe
		'main/list'			=> array('caption'=> 'C-Shops Manager', 'perm' => 'P'),
		'main/create'		=> array('caption'=> 'Create C-Shop', 'perm' => 'P'),
		'main/back'	  		=> array('caption'=> 'Roster System', 'perm' => 'P'),

	);

	protected $adminMenuAliases = array(
		'main/edit'	=> 'main/list'				
	);	
	
	protected $menuTitle = 'Roster System';
}

class cshops_cats_sys_ui extends e_admin_ui
{		
		protected $pluginTitle		= 'Roster System';
		protected $pluginName		= 'roster';
	//	protected $eventName		= 'roster-roster_sys'; // remove comment to enable event triggers in admin. 		
		protected $table			= 'cshops_cats_sys';
		protected $pid				= 'cshop_id';
		protected $perPage			= 15; 
		protected $batchDelete		= true;
		protected $sortField		= 'cshop_order';
		protected $sortParent       = 'cshop_parent';
		protected $batchExport     = true;
		protected $batchCopy		= true;
		protected $orderStep		= 10;
		protected $listQry          = "SELECT a. *, CASE WHEN a.cshop_parent = 0 THEN a.cshop_order ELSE b.cshop_order + (( a.cshop_order)/1000) END AS Sort FROM `#cshops_cats_sys` AS a LEFT JOIN `#cshops_cats_sys` AS b ON a.cshop_parent = b.cshop_id ";
		protected $listOrder		= 'Sort,cshop_order ';

		protected $fields 		= array (  'checkboxes' =>   array ( 'title' => '', 'type' => null, 'data' => null, 'width' => '5%', 'thclass' => 'center', 'forced' => '1', 'class' => 'center', 'toggle' => 'e-multiselect',  ),
		  'cshop_id' =>   array ( 'title' => LAN_ID, 'data' => 'int', 'width' => '5%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'userclass_id' => array ( 'title' => 'User Class', 'type' => 'userclass', 'data' => 'int', 'width' => 'auto', 'batch' => true, 'filter' => true, 'inline' => true, 'help' => '', 'readParms' => array('classlist'=>'public,guest,nobody,member,admin,main,new,mods,classes'), 'writeParms' => array('classlist'=>'public,guest,nobody,member,admin,main,new,mods,classes'), 'class' => 'left', 'thclass' => 'left',  ),
		  'cshop_name' =>   array ( 'title' => LAN_TITLE, 'type' => 'text', 'inline'=>true,  'data' => 'str', 'width' => '40%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'cshop_des' => array ( 'title' => LAN_DESCRIPTION, 'type' => 'textarea', 'data' => 'str', 'width' => '40%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'cshop_parent' =>   array ( 'title' => 'Parent', 'type' => 'dropdown', 'data' => 'int', 'width' => '10%', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'cshop_sub' =>   array ( 'title' => 'Sub-Parent', 'type' => 'dropdown', 'data' => 'int', 'width' => 'auto', 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'center', 'thclass' => 'center',  ),
		  'cshop_order' =>   array ( 'title' => LAN_ORDER, 'type' => 'number', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'cshop_show' =>   array ( 'title' => 'Show', 'type' => 'boolean', 'data' => 'int', 'width' => 'auto', 'inline' => true, 'help' => '', 'readParms' => '', 'writeParms' => '', 'class' => 'left', 'thclass' => 'left',  ),
		  'options' =>   array ( 'title' => LAN_OPTIONS, 'type' => null, 'data' => null, 'width' => '10%', 'thclass' => 'center last', 'class' => 'center last', 'forced' => '1',  ),
		);		
		
		protected $fieldpref = array('cshop_name', 'cshop_parent', 'cshop_sub', 'cshop_order', 'cshop_show');
		
		public $forumParents = array();
		
		private function checkOrder()
		{
			$sql = e107::getDb();
			$sql2 = e107::getDb('sql2');
			$count = $sql->select('cshops_cats_sys', 'cshop_id', 'cshop_order = 0');

			if($count > 1)
			{
				$sql->gen("SELECT cshop_id,cshop_name,cshop_parent,cshop_sub,cshop_order FROM `#cshops_cats_sys` ORDER BY COALESCE(NULLIF(cshop_parent,0), cshop_id), cshop_parent > 0, cshop_order ");
				$c = 0;
				while($row = $sql->fetch())
				{
					if($row['cshop_parent'] == 0)
					{
						$c = $c + 100;
					}
					else
					{
						$c = $c+1;
					}

					$sql2->update('cshops_cats_sys', 'cshop_order = '.$c.' WHERE cshop_id = '.$row['cshop_id'].' LIMIT 1');
				}
			}
		}

		protected $prefs = array(); 
	
		public function init()
		{
			
			$sql = e107::getDb();
			$this->checkOrder();
			if($this->getAction() == 'edit')
			{
				$this->fields['cshop_order']['noedit'] = true;
			}
			$data = e107::getDb()->retrieve('cshops_cats_sys', 'cshop_id,cshop_name,cshop_parent,cshop_sub', 'cshop_id != 0',true);
			$this->cshopParents[0] = "(New Parent)";
			$cshopSubParents = array();

			foreach($data as $val)
			{
				$id = $val['cshop_id'];

				//if($val['cshop_parent'] == 0)
				//{
					$this->cshopParents[$id] = $val['cshop_name'];
				//}
				//else
				//{
					$cshopSubParents[$id] = $val['cshop_name'];
				//}

			}

			$this->fields['cshop_parent']['writeParms'] = $this->cshopParents;
			$this->fields['cshop_sub']['writeParms']['optArray'] = $cshopSubParents;
			$this->fields['cshop_sub']['writeParms']['default'] = 'blank';	
		}

		// ------- Customize Create --------		
		public function afterSort($result, $selected)
		{

			return;

			$sql = e107::getDb();

			$data2 = $sql->retrieve('cshops_cats_sys','cshop_id,cshop_parent,cshop_name,cshop_order','cshop_parent = 0',true);
			foreach($data2 as $val)
			{
				$id = $val['cshop_id'];
				$parent[$id] = $val['cshop_order'];

			}

			$previous = 0;

			$data = $sql->retrieve('cshops_cats_sys','*','cshop_parent != 0 ORDER BY cshop_order',true);
			foreach($data as $row)
			{
				$p = $row['cshop_parent'];

				if($p != $previous)
				{
					$c = $parent[$p];
				}

				$c++;
				$previous = $p;
				
				$sql->update('cshops_cats_sys','cshop_order = '.$c.' WHERE cshop_id = '.intval($row['cshop_id']).' LIMIT 1');
			}
		}
		
		public function beforeCreate($new_data,$old_data)
		{
			$sql = e107::getDb();
			$parentOrder = $sql->retrieve('cshops_cats_sys','cshop_order','cshop_id='.$new_data['cshop_parent']." LIMIT 1");

			$new_data['cshop_order'] = $parentOrder + 50;
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
     		$mainadmin = e_SELF.'/../admin_config.php';
     		header("location:".$mainadmin); exit; 
    	}
}
				
class cshops_cats_sys_form_ui extends e_admin_form_ui
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
	
	function cshop_name($curVal,$mode,$parm)
	{
			$frm = e107::getForm();

			if($mode == 'read')
			{
				$parent 	= $this->getController()->getListModel()->get('cshop_parent');
				$id			= $this->getController()->getListModel()->get('cshop_id');
				$sub     = $this->getController()->getListModel()->get('cshop_sub');



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
				return $frm->text('cshop_name',$curVal,255,'size=xxlarge');
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
				$parent 	= $this->getController()->getListModel()->get('cshop_parent');
				$sub     = $this->getController()->getListModel()->get('cshop_sub');
				
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
		function cshop_parent($curVal,$mode)
		{
			$frm = e107::getForm();

			switch($mode)
			{
				case 'read': // List Page
					return $curVal;
					break;

				case 'write': // Edit Page
					return $frm->text('cshop_parent',$curVal);
					break;

				case 'filter':
				case 'batch':
				//	return  $array;
					break;
			}
		}


		// Custom Method/Function
		function cshop_sub($curVal,$mode)
		{
			$frm = e107::getForm();

			switch($mode)
			{
				case 'read': // List Page
					return $curVal;
					break;

				case 'write': // Edit Page
					return $frm->text('cshop_sub',$curVal);
					break;

				case 'filter':
				case 'batch':
				//	return  $array;
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