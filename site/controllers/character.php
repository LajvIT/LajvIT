<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class LajvITControllerCharacter extends LajvITController {
	function create() {
		$errlink = 'http://emil.djupfeldt.se/kh_anmalan/index.php?option=com_lajvit&view=character&layout=create';
		$errlink.= '&Itemid='.JRequest::getInt('Itemid', 0);
		
    	$model = &$this->getModel();
		$db = &JFactory::getDBO();
    	
    	$person = &$model->getPerson();

		$eventid = JRequest::getInt('eid', -1);
		if ($eventid > 0) {
			$errlink.= '&eid='.$eventid;
		}

		$data = new stdClass;
		$data->created = date('Y-m-d H:i:s');
		$data->updated = $data->created;
//		$data->main = false;
		$name = JRequest::getString('fullname');
		$data->fullname = $name;
		$data->knownas = $name;
		$data->factionid = JRequest::getInt('factionid', -1);
		$data->cultureid = JRequest::getInt('cultureid', -1);
		$data->conceptid = JRequest::getInt('conceptid', -1);
		$concepttext = trim(JRequest::getString('concepttext'));
		if (strlen($concepttext) > 0) {
			$data->concepttext = $concepttext;
		}
		
		if (!is_null($data->fullname) && strlen($data->fullname) > 0) {
			$errlink.= '&fullname='.$data->fullname;
		}
		if ($data->factionid > 0) {
			$errlink.= '&factionid='.$data->factionid;
		}
		if ($data->cultureid > 0) {
			$errlink.= '&cultureid='.$data->cultureid;
		}
		if ($data->conceptid > 0) {
			$errlink.= '&conceptid='.$data->conceptid;
		}
		
		
		if (is_null($data->fullname) || strlen($data->fullname) == 0 ||
			is_null($data->knownas) || strlen($data->knownas) == 0 ||
			$data->factionid == 0 || $data->cultureid == 0 || $data->conceptid == 0) {
			$errlink.= '&failed=1';
			$this->setRedirect($errlink);
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
		$errlink = 'http://emil.djupfeldt.se/kh_anmalan/index.php?option=com_lajvit&view=character&layout=edit';
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
	
	function delete() {
		$errlink = 'http://emil.djupfeldt.se/kh_anmalan/index.php?option=com_lajvit&view=event';
		$errlink.= '&Itemid='.JRequest::getInt('Itemid', 0);

		
    	$model = &$this->getModel();
    	
    	$person = &$model->getPerson();
    	
		$charid = JRequest::getInt('cid', -1);
    	$character = $model->getCharacterExtended($charid);
    	
		$eventid = JRequest::getInt('eid', -1);
		$event = &$model->getEvent($eventid);
		
		
		$reg = $model->getRegistration($person->id, $eventid, $charid);
		if (!$reg) {
			echo '<h1>not registered</h1>';
//			$this->setRedirect($errlink, 'Not registered';
			return;
		}
		
		
		$db = &JFactory::getDBO();
		
		$query = 'DELETE FROM #__lit_registrationchara WHERE personid='.$person->id.' AND eventid='.$db->getEscaped($eventid).' AND charaid='.$db->getEscaped($charid).' LIMIT 1;';
		$db->setQuery($query);
		
		if (!$db->query()) {
			echo '<h1>'.$db->getErrorMsg().'</h1>';
//			$this->setRedirect($errlink, $db->getErrorMsg());
			return;
		}
		
		
		$oklink = 'http://emil.djupfeldt.se/kh_anmalan/index.php?option=com_lajvit&view=event';
		$oklink.= '&Itemid='.JRequest::getInt('Itemid', 0);
		$this->setRedirect($oklink);
	}
}
