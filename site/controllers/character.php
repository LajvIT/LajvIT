<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class LajvITControllerCharacter extends LajvITController {
/*
	function edit() {
		JRequest::setVar('view', 'person');
		JRequest::setVar('layout', 'edit');
//		JRequest::setVar('hidemainmenu', 1);
		
		parent::display();
	}
*/

	function create() {
		$oklink = 'index.php?option=com_lajvit&view=event';
		$errlink = 'http://emil.djupfeldt.se/kh_anmalan/index.php?option=com_lajvit&controller=person&task=edit';
		//$oklink = $errlink;
		
    	$model = &$this->getModel();
		$db = &JFactory::getDBO();
    	
    	$person = &$model->getPerson();

		$eventid = JRequest::getInt('eid', -1);

		$data = new stdClass;
		$data->created = date('Y-m-d H:i:s');
		$data->updated = $data->created;
//		$data->main = false;
		$data->fullname = JRequest::getString('fullname');
		$data->knownas = $data->fullname;
		$data->cultureid = JRequest::getInt('cultureid', -1);
		$data->conceptid = JRequest::getInt('conceptid', -1);
		$concepttext = trim(JRequest::getString('concepttext'));
		if (strlen($concepttext) > 0) {
			$data->concepttext = $concepttext;
		}
		
		$db->insertObject('#__lit_chara', $data);
		if ($db->getErrorNum() != 0) {
			echo '<h1>'.$db->getErrorMsg().'</h1>';
			return;
		}
		$charaid = $db->insertid();
		
		
		$data = new stdClass;
		$data->personid = $person->id;
		$data->eventid = $eventid;
		$data->charaid = $charaid;
		$data->statusid = $model->getDefaultStatusId();
		$data->groupleader = JRequest::getString('groupleader')
		
		$db->insertObject('#__lit_registrationchara', $data);
		if ($db->getErrorNum() != 0) {
			echo '<h1>'.$db->getErrorMsg().'</h1>';
			return;
		}
		
		
		$this->setRedirect($oklink);
	}
	
}
