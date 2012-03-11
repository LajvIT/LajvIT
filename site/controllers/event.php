<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Controller for a user to register to an event and to manage events (add, remove, modify).
 */
class LajvITControllerEvent extends LajvITController {
  private static $eventTableName = '#__lit_event';

  public function register() {
    $errlink = 'index.php?option=com_lajvit&view=event';
    $errlink .= '&Itemid='.JRequest::getInt('Itemid', 0);

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

    $this->setRedirect(registrationForEventCompletedLink($eventid));
  }

  public function add() {
    $model = &$this->getModel();
    $db = &JFactory::getDBO();
    $person = &$model->getPerson();
    $data = $this->getEventDataFromPostedForm();
    if (!$this->verifyEventData($data)) {
      return;
    }
    $db->insertObject(LajvITControllerEvent::$eventTableName, $data);
    $eventId = $db->insertid();
    $this->setRedirect($this->addEventCompletedLink($eventId));
  }

  private function getEventDataFromPostedForm() {
    $eventName = JRequest::getString('eventName', "");
    $eventShortName = JRequest::getString('eventShortName', "");
    $eventStartDate = JRequest::getString('eventStartDate', "");
    $eventEndDate = JRequest::getString('eventEndDate', "");
    $eventUrl = JRequest::getString('eventUrl', "");
    $eventStatus = JRequest::getInt('eventStatus', -1);
    $data = new stdClass();
    $data->name = $eventName;
    $data->shortname = $eventShortName;
    $data->startdate = $eventStartDate;
    $data->enddate = $eventEndDate;
    $data->url = $eventUrl;
    return $data;
  }

  private function verifyEventData($data) {
    return TRUE;
  }

  private function registrationForEventCompletedLink($eventId) {
    $link = 'index.php?option=com_lajvit&view=event&layout=registered&eid=' . $eventId;
    $link .= '&Itemid='.JRequest::getInt('Itemid', 0);
    return $link;
  }

  private function addEventCompletedLink($eventId) {
    $link = 'index.php?option=com_lajvit&view=event';
    $link .= '&Itemid='.JRequest::getInt('Itemid', 0);
    return $link;
  }
}
