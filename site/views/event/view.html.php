<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component.
 */
class LajvITViewEvent extends JView {
  function getModel($name = "LajvIT") {
    return parent::getModel($name);
  }

  function setModel($name, $default = FALSE) {
    return parent::setModel($name, $default);
  }

  function display($tpl = NULL) {
    $model = &$this->getModel();
    $eventModel =& JModel::getInstance('eventmodel', 'lajvitmodel');
    $layout = $this->getLayout();
    $user = &JFactory::getUser();
    $events = $model->getEventsForPerson();
    $eventId = JRequest::getInt('eid', -1);
    $currentEventStatus = '';
    $currentEventName = '';
    if ($eventId > 0) {
      $currentEventStatus = $events[$eventId]->status;
      $currentEventName = $events[$eventId]->name;
    }
    $this->assignRef('eventid', $eventId);
    $this->assignRef('eventId', $eventId);
    if ($layout == 'register' && $currentEventStatus != 'open') {
      $this->setLayout('default');
    } else if ($layout == 'register') {
      $this->setRegisterData($model);
    } else if ($layout == 'add' && $user->usertype != 'Super Administrator') {
      $this->setLayout('default');
    } else if ($layout == 'edit') {
      $isUserAllowedToEditEvent = $eventModel->isUserAllowedToEditEvent($user, $eventId);
      if ($isUserAllowedToEditEvent) {
        $this->setEditData($events[$eventId], $user);
      } else {
        $this->setLayout('default');
      }
    }

    $this->displayBreadcrumb($eventId);

    foreach ($events as $event) {
      if (is_null($event->roleid)) {
        $event->registered = FALSE;
        $event->role = $model->getRoleForEvent($event->id);
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
    JHtml::stylesheet('com_lajvit/lajvit.css', array(), TRUE);
    parent::display($tpl);
  }

  private function displayBreadcrumb($eventId) {
    $app = JFactory::getApplication();
    $pathway = $app->getPathway();
    $layout = $this->getLayout();
    $model = &$this->getModel();
    $events = $model->getEventsForPerson();
    if ($layout != 'default' && $eventId > 0) {
      $currentEventName = $events[$eventId]->name;
      $pathway->addItem($currentEventName, '');
    }
    switch ($layout) {
      case 'add':
        $pathway->addItem('Skapa', '');
        break;
      case 'delete':
        $pathway->addItem('Ta bort', '');
        break;
      case 'edit':
        $pathway->addItem('Redigera', '');
        break;
      case 'register':
        $pathway->addItem('Registrera', '');
        break;
      case 'registered':
        break;
      default:
        break;
    }
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

  private function setEditData($event, $isUserAllowedToEditEvent) {
    $this->assignRef('isUserAllowedToEditEvent', $isUserAllowedToEditEvent);
    $this->assignRef('eventName', $event->name);
    $this->assignRef('eventShortName', $event->shortname);
    $this->assignRef('eventStartDate', $event->startdate);
    $this->assignRef('eventEndDate', $event->enddate);
    $this->assignRef('eventUrl', $event->url);
    $this->assignRef('eventStatus', $event->status);
  }
}
