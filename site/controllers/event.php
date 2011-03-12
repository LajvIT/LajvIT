<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class LajvITControllerEvent extends LajvITController {
	function register() {
		$errlink = 'index.php?option=com_lajvit&view=event';
		$errlink.= '&Itemid='.JRequest::getInt('Itemid', 0);
		
    	$model = &$this->getModel();
		$db = &JFactory::getDBO();
    	
    	$person = &$model->getPerson();
		$eventid = JRequest::getInt('eid', -1);
		
		if (!$person->check()) {
			echo 'Incomplete personal data.';
//			$this->setRedirect($errlink, 'Incomplete personal data.');
			return;
		}
		
		$data = new stdClass;
		$data->personid = $person->id;
		$data->eventid = $eventid;
		$data->roleid = $model->getDefaultRoleId();
		$data->confirmationid = $model->getDefaultConfirmationId();
		
		$db->insertObject('#__lit_registration', $data);
		
		
		$oklink = 'index.php?option=com_lajvit&view=event&layout=registered&eid='.$eventid;
		$oklink.= '&Itemid='.JRequest::getInt('Itemid', 0);
		$this->setRedirect($oklink);
	}
}
