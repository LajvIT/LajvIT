<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

/**
 * View for person.
 */
class LajvITViewPerson extends JView {
  function display($tpl = NULL) {
    $model = &$this->getModel();

    $eventid = JRequest::getInt('eid', -1);
    $role = $model->getRoleForEvent($eventid);
    $this->assignRef('role', $role);

    $personid = JRequest::getInt('pid', -1);

    if ($personid < 0 || $this->getLayout() == 'edit') {
      $person = &$model->getPerson();
    } else {
      $person = &$model->getPerson($personid);
    }

    $personid = $person->id;

    if ($eventid != -1) {
      $chars = &$model->getCharactersForEvent($eventid, $personid);
      foreach ($chars as $char) {
        $crole = $model->getRoleForChara($eventid, $char->id);
        $role = $model->mergeRoles($role, $crole);
      }
    }

    $incomplete = !$person->_nodata && !$person->check();
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

    $this->assignRef('username', $person->_username);

    if ($role->registration_list) {
      $personroles = $model->getAllRolesMerged($eventid, $personid);
      $this->assignRef('eventname', $personroles->eventname);
      $this->assignRef('personrolenames', $personroles->name);
    }

    $this->assignRef('itemid', JRequest::getInt('Itemid', 0));

    parent::display($tpl);
  }
}
