<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class LajvITControllerPerson extends LajvITController {
	function edit() {
		JRequest::setVar('view', 'person');
		JRequest::setVar('layout', 'edit');
//		JRequest::setVar('hidemainmenu', 1);
		
		parent::display();
	}
	
	function save() {
		$oklink = 'index.php?option=com_lajvit&view=event';
		$errlink = 'http://emil.djupfeldt.se/kh_anmalan/index.php?option=com_lajvit&controller=person&task=edit';
		//$oklink = $errlink;
		
    	$model = &$this->getModel();
    	
    	$person = &$model->getPerson();
    	
		$data = JRequest::get('post');
		// Bind the form fields to the record
		if (!$person->bind($data)) {
			echo '<h1>bind</h1>'.$person->getDBO()->getErrorMsg();
//			$this->setRedirect($errlink, 'Database bind error: ' . $person->getDBO()->getErrorMsg());
			return;
		}
		
		// Make sure the record is valid
		if (!$person->check()) {
			echo '<h1>check</h1>'.$person->getDBO()->getErrorMsg();
//			$this->setRedirect($errlink, 'Database check error: ' . $person->getDBO()->getErrorMsg());
			return;
		}
		
		// Store the record to the database
		if (!$person->store()) {
			echo '<h1>store</h1>'.$person->getDBO()->getErrorMsg();
//			$this->setRedirect($errlink, 'Database store error: ' . $person->getDBO()->getErrorMsg());
			return;
		}

		$this->setRedirect($oklink);
	}
	
}
