<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class LajvITControllerRegistrations extends LajvITController {
	function save() {
		$errlink = 'index.php?option=com_lajvit&view=registrations';
		$errlink.= '&Itemid='.JRequest::getInt('Itemid', 0);

		$model = &$this->getModel();
		$db = &JFactory::getDBO();

		$eventid = JRequest::getInt('eid', -1);
		$role = $model->getRoleForEvent($eventid);

		$characterlist = split(',', JRequest::getString('cid', ''));

		foreach ($characterlist as $charidstr) {
			$charid = (int) $charidstr;
			if (is_null($charid) || $charid <= 0) {
				continue;
			}

			$personid = JRequest::getInt('pid_'.$charid, -1);
			if ($personid <= 0) {
				continue;
			}


			$statusid = JRequest::getInt('characterstatus_'.$charid, -1);
			if ($role->character_setstatus && $statusid > 0) {
				$query = 'UPDATE #__lit_registrationchara SET statusid='.$db->getEscaped($statusid).' WHERE eventid='.$db->getEscaped($eventid).' AND personid='.$db->getEscaped($personid).' AND charaid='.$db->getEscaped($charid).";\n";

				$db->setQuery($query);

				if (!$db->query()) {
					echo '<h1>'.$db->getErrorMsg().'</h1>';
					//				$this->setRedirect($errlink, $db->getErrorMsg());
					return;
				}
			}

			$payment = JRequest::getInt('payment_'.$charid, -1);
			if ($role->registration_setstatus && $payment >= 0) {
				$query = 'UPDATE #__lit_registration SET payment='.$db->getEscaped($payment).', timeofpayment=NOW() WHERE eventid='.$db->getEscaped($eventid).' AND personid='.$db->getEscaped($personid).";\n";

				$db->setQuery($query);

				if (!$db->query()) {
					echo '<h1>'.$db->getErrorMsg().'</h1>';
					//				$this->setRedirect($errlink, $db->getErrorMsg());
					return;
				}
			}

			$confirmationid = JRequest::getInt('confirmationid_'.$charid, -1);
			if ($role->registration_setstatus && $confirmationid > 0) {
				$query = 'UPDATE #__lit_registration SET confirmationid='.$db->getEscaped($confirmationid).', timeofconfirmation=NOW() WHERE eventid='.$db->getEscaped($eventid).' AND personid='.$db->getEscaped($personid).";\n";

				$db->setQuery($query);

				if (!$db->query()) {
					echo '<h1>'.$db->getErrorMsg().'</h1>';
					//				$this->setRedirect($errlink, $db->getErrorMsg());
					return;
				}
			}

			echo '<h1>'.$charid.'</h1>';
			echo $personid.' '.$statusid.' '.$payment.' '.$confirmationid.'<br>';
		}

		$oklink = 'index.php?option=com_lajvit&view=registrations&eid='.$eventid;
		$oklink.= '&Itemid='.JRequest::getInt('Itemid', 0);
		$this->setRedirect($oklink);
	}
}
