<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Controller for a user to register to an event and to manage events (add, remove, modify).
 */
class LajvITControllerEvent extends LajvITController {
  private static $eventTableName = '#__lit_event';
  private $model = NULL;
  const ADMINISTRATOR = "Super Administrator";

  public function register() {
    $errlink = 'index.php?option=com_lajvit&view=event';
    $errlink .= '&Itemid='.JRequest::getInt('Itemid', 0);

    $this->model = &$this->getModel();
    $db = &JFactory::getDBO();

    $person = &$this->model->getPerson();
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
    $this->model = &$this->getModel();
    $db = &JFactory::getDBO();
    $person = &$this->model->getPerson();
    $data = $this->getEventDataFromPostedForm();
    if (!$this->verifyEventData($data)) {
      return;
    }
    $db->insertObject(LajvITControllerEvent::$eventTableName, $data);
    $eventId = $db->insertid();
    $this->setRedirect($this->addEventCompletedLink($eventId));
  }

  public function delete() {
    $this->model = &$this->getModel();
    $db = &JFactory::getDBO();
    $person = &$this->model->getPerson();
    $eventId = JRequest::getInt('eid', -1);
    $deleteConfirmed = JRequest::getBool('confirmed', FALSE);
    if (!$this->allowedToDeleteEvent($eventId)) {
      $this->setRedirect($this->listEventsLink());
    }

    if ($deleteConfirmed) {
      $this->model->deleteEvent($eventId);
    }
    $this->setRedirect($this->listEventsLink());
  }

  private function allowedToDeleteEvent($eventId) {
    $user = &JFactory::getUser($userid);
    if ($eventId == -1) {
      return FALSE;
    }
    if ($user->usertype == $this->ADMINISTRATOR) {
      return TRUE;
    }
    return FALSE;
  }

  private function getEventDataFromPostedForm() {
    $db =& JFactory::getDBO();
    $eventName = JRequest::getString('eventName', "");
    $eventShortName = JRequest::getString('eventShortName', "");
    $eventStartDate = JRequest::getString('eventStartDate', "");
    $eventEndDate = JRequest::getString('eventEndDate', "");
    $eventUrl = JRequest::getString('eventUrl', "");
    $eventStatus = JRequest::getInt('eventStatus', -1);
    $data = new stdClass();
    $data->name = $db->quote($eventName);
    $data->shortname = $db->quote($eventShortName);
    $data->startdate = $db->quote($eventStartDate);
    $data->enddate = $db->quote($eventEndDate);
    $data->url = $db->quote($eventUrl);
    return $data;
  }

  private function verifyEventData($data) {
    if ($data->name == '') {
      return FALSE;
    }
    return TRUE;
  }

  private function registrationForEventCompletedLink($eventId) {
    $link = 'index.php?option=com_lajvit&view=event&layout=registered&eid=' . $eventId;
    $link .= '&Itemid='.JRequest::getInt('Itemid', 0);
    return $link;
  }

  private function addEventCompletedLink($eventId) {
    return $this->listEventsLink();
  }
  private function listEventsLink() {
    $link = 'index.php?option=com_lajvit&view=event';
    $link .= '&Itemid='.JRequest::getInt('Itemid', 0);
    return $link;
  }
}
