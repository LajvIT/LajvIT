<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component.
 */
class LajvITViewEvent extends JView {
  function display($tpl = NULL) {
    $model = &$this->getModel();
    $layout = $this->getLayout();
    $user = &JFactory::getUser($userid);
    $events = $model->getEventsForPerson();
    $eventId = JRequest::getInt('eid', -1);
    $currentEventStatus = $events[$eventId]->status;
    $this->assignRef('eventid', $eventId);
    $this->assignRef('eventId', $eventId);

    if ($layout == 'register' && $currentEventStatus != 'open') {
      $this->setLayout('default');
    } else if ($layout == 'register') {
      $this->setRegisterData($model);
    } else if ($layout == 'add' && $user->usertype != 'Super Administrator') {
      $this->setLayout('default');
    } else if ($layout == 'edit') {
      $this->setEditData($events[$eventId]);
    }

    foreach ($events as $event) {
      if (is_null($event->roleid)) {
        $event->registered = FALSE;
      } else {
        $event->registered = TRUE;
        $event->characters = $model->getCharactersForEvent($event->id, $event->personid);
        $event->role = $model->getAllRolesMerged($event->id);
      }
    }

    $this->assignRef('events', $events);
    $this->assignRef('userType', $user->usertype);
    $this->assignRef('itemid', JRequest::getInt('Itemid', 0));
    $this->assignRef('itemId', JRequest::getInt('itemId', JRequest::getInt('Itemid', 0)));
    parent::display($tpl);
  }

  private function setRegisterData($model) {
    $person = &$model->getPerson();
    $incomplete = !$person->check();;
    $this->assignRef('incomplete_person', $incomplete);;
    $this->assignRef('givenname', $person->givenname);;
    $this->assignRef('surname', $person->surname);;
    $this->assignRef('pnumber', $person->pnumber);;
    $this->assignRef('sex', $person->sex);;
    $this->assignRef('email', $person->email);;
    $this->assignRef('publicemail', $person->publicemail);;
    $this->assignRef('phone1', $person->phone1);;
    $this->assignRef('phone2', $person->phone2);;
    $this->assignRef('street', $person->street);;
    $this->assignRef('zip', $person->zip);;
    $this->assignRef('town', $person->town);;
    $this->assignRef('icq', $person->icq);;
    $this->assignRef('msn', $person->msn);;
    $this->assignRef('skype', $person->skype);;
    $this->assignRef('facebook', $person->facebook);;
    $this->assignRef('illness', $person->illness);;
    $this->assignRef('allergies', $person->allergies);;
    $this->assignRef('medicine', $person->medicine);;
    $this->assignRef('info', $person->info);
  }

  private function setEditData($event) {
    $this->assignRef('eventName', $event->name);
    $this->assignRef('eventShortName', $event->shortname);
    $this->assignRef('eventStartDate', $event->startdate);
    $this->assignRef('eventEndDate', $event->enddate);
    $this->assignRef('eventUrl', $event->url);
    $this->assignRef('eventStatus', $event->status);
  }
}
