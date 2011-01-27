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
		$errlink = 'http://emil.djupfeldt.se/kh_anmalan/index.php?option=com_lajvit&controller=person&task=edit';
		$errlink.= '&Itemid='.JRequest::getInt('Itemid', 0);
		
    	$model = &$this->getModel();
		$db = &JFactory::getDBO();
    	
    	$person = &$model->getPerson();

		$eventid = JRequest::getInt('eid', -1);

		$data = new stdClass;
		$data->created = date('Y-m-d H:i:s');
		$data->updated = $data->created;
//		$data->main = false;
		$name = JRequest::getString('fullname');
		$data->fullname = $name;
		$data->knownas = $name;
		$data->cultureid = JRequest::getInt('cultureid', -1);
		$data->conceptid = JRequest::getInt('conceptid', -1);
		$concepttext = trim(JRequest::getString('concepttext'));
		if (strlen($concepttext) > 0) {
			$data->concepttext = $concepttext;
		}
		
		
		if (is_null($data->fullname) || strlen($data->fullname) == 0 ||
			is_null($data->knownas) || strlen($data->knownas) == 0 ||
			$data->cultureid == 0 || $data->conceptid == 0) {
			echo '<h1>Missing fields in form.</h1>';
//			$this->setRedirect($errlink, 'Missing fields in form.');
			return;
		}
		
		
		$db->insertObject('#__lit_chara', $data);
		if ($db->getErrorNum() != 0) {
			echo '<h1>'.$db->getErrorMsg().'</h1>';
//			$this->setRedirect($errlink, $db->getErrorMsg());
			return;
		}
		$charid = $db->insertid();
		
		
		$data = new stdClass;
		$data->personid = $person->id;
		$data->eventid = $eventid;
		$data->charaid = $charid;
		$data->statusid = $model->getDefaultStatusId();
		$data->groupleader = JRequest::getString('groupleader');
		
		$db->insertObject('#__lit_registrationchara', $data);
		if ($db->getErrorNum() != 0) {
			echo '<h1>'.$db->getErrorMsg().'</h1>';
//			$this->setRedirect($errlink, $db->getErrorMsg());
			return;
		}
		
		
		
		$oklink = 'index.php?option=com_lajvit&view=character&layout=updated&eid='.$eventid.'&cid='.$charid;
		$oklink.= '&Itemid='.JRequest::getInt('Itemid', 0);
		$this->setRedirect($oklink);
	}
	
	
	function save() {
		$errlink = 'http://emil.djupfeldt.se/kh_anmalan/index.php?option=com_lajvit&controller=person&task=edit';
		$errlink.= '&Itemid='.JRequest::getInt('Itemid', 0);

		
    	$model = &$this->getModel();
    	
    	$person = &$model->getPerson();
    	
		$charid = JRequest::getInt('cid', -1);
    	$character = &$model->getCharacter($charid);
    	$oldcharacter = $model->getCharacterExtended($charid);
    	
		$eventid = JRequest::getInt('eid', -1);
		$event = &$model->getEvent($eventid);
		
		
		$reg = $model->getRegistration($person->id, $eventid, $charid);
		if (!$reg) {
			echo '<h1>not registered</h1>';
//			$this->setRedirect($errlink, 'Not registered';
			return;
		}

		
    	
		$data = JRequest::get('post');
		
		if (strlen($data['age']) > 0 && (int) $data['age'] > 0) {
			$data['bornyear'] = $event->ingameyear - (int) $data['age'];
		}
		
		// Bind the form fields to the record
		if (!$character->bind($data)) {
			echo '<h1>bind</h1>'.$character->getDBO()->getErrorMsg();
//			$this->setRedirect($errlink, 'Database bind error: ' . $character->getDBO()->getErrorMsg());
			return;
		}
		
		$photo = $this->saveimage('photo');
		if ($photo) {
			$character->image = $photo;
		} else {
//			$character->image = $oldcharacter->image;
		}
		
		// Make sure the record is valid
		if (!$character->check()) {
			echo '<h1>check</h1>'.$character->getDBO()->getErrorMsg();
//			$this->setRedirect($errlink, 'Database check error: ' . $character->getDBO()->getErrorMsg());
			return;
		}
		
		// Store the record to the database
		if (!$character->store()) {
			echo '<h1>store</h1>'.$character->getDBO()->getErrorMsg();
//			$this->setRedirect($errlink, 'Database store error: ' . $character->getDBO()->getErrorMsg());
			return;
		}


		$oklink = 'index.php?option=com_lajvit&view=character&layout=updated&eid='.$eventid.'&cid='.$charid;
		$oklink.= '&Itemid='.JRequest::getInt('Itemid', 0);
		$this->setRedirect($oklink);
	}
	
}
