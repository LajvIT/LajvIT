<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component.
 */
class LajvITViewEvent extends JView {
  function display($tpl = NULL) {
    $model = &$this->getModel();

    $person = &$model->getPerson();

    $incomplete = !$person->check();
    $this->assignRef('incomplete_person', $incomplete);

    $this->assignRef('givenname', $person->givenname);
    $this->assignRef('surname', $person->surname);
    $this->assignRef('pnumber', $person->pnumber);
    $this->assignRef('sex', $person->sex);
    $this->assignRef('email', $person->email);
    $this->assignRef('publicemail', $person->publicemail);
    $this->assignRef('phone1', $person->phone1);
    $this->assignRef('phone2', $person->phone2);
    $this->assignRef('street', $person->street);
    $this->assignRef('zip', $person->zip);
    $this->assignRef('town', $person->town);
    $this->assignRef('icq', $person->icq);
    $this->assignRef('msn', $person->msn);
    $this->assignRef('skype', $person->skype);
    $this->assignRef('facebook', $person->facebook);
    $this->assignRef('illness', $person->illness);
    $this->assignRef('allergies', $person->allergies);
    $this->assignRef('medicine', $person->medicine);
    $this->assignRef('info', $person->info);

    $events = $model->getEventsForPerson();

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

    $eventid = JRequest::getInt('eid', -1);
    $this->assignRef('eventid', $eventid);
    $this->assignRef('eventId', $eventid);
    // TODO: Check eid in case of action

    $this->assignRef('itemid', JRequest::getInt('Itemid', 0));
    $this->assignRef('itemId', JRequest::getInt('itemId', JRequest::getInt('Itemid', 0)));

    parent::display($tpl);
  }
}
