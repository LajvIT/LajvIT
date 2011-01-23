<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class LajvITControllerEvent extends LajvITController {
/*
	function edit() {
		JRequest::setVar('view', 'person');
		JRequest::setVar('layout', 'edit');
//		JRequest::setVar('hidemainmenu', 1);
		
		parent::display();
	}
*/
	
	function register() {
		//$oklink = 'http://emil.djupfeldt.se/kh_anmalan/index.php?option=com_lajvit';
		$errlink = 'index.php?option=com_lajvit&view=event';
		$oklink = $errlink;
		
    	$model = &$this->getModel();
		$db = &JFactory::getDBO();
    	
    	$person = &$model->getPerson();
		$eventid = JRequest::getInt('eid', -1);
		
		$data = new stdClass;
		$data->personid = $person->id;
		$data->eventid = $eventid;
		$data->roleid = $model->getDefaultRoleId();
		
		$db->insertObject('#__lit_registration', $data);
		
		$this->setRedirect($oklink);
	}
	
}
