<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Controller class for Characters.
 */
class LajvITControllerCharacter extends LajvITController {
  function create() {
    $errlink = 'index.php?option=com_lajvit&view=character&layout=create';
    $errlink .= '&Itemid='.JRequest::getInt('Itemid', 0);

    $model = &$this->getModel();
    $db = &JFactory::getDBO();

    $person = &$model->getPerson();

    $eventid = JRequest::getInt('eid', -1);
    if ($eventid > 0) {
      $errlink .= '&eid='.$eventid;
    }

    $factionid = JRequest::getInt('factionid', -1);

    $data = new stdClass;
    $data->created = date('Y-m-d H:i:s');
    $data->updated = $data->created;
    //    $data->main = false;
    $name = JRequest::getString('fullname');
    $data->fullname = $name;
    $data->knownas = $name;
    $data->factionid = $factionid;
    $data->cultureid = JRequest::getInt('cultureid', -1);
    $data->conceptid = JRequest::getInt('conceptid', -1);
    $concepttext = trim(JRequest::getString('concepttext'));
    if (strlen($concepttext) > 0) {
      $data->concepttext = $concepttext;
    }

    if (!is_null($data->fullname) && strlen($data->fullname) > 0) {
      $errlink .= '&fullname='.$data->fullname;
    }
    if ($data->factionid > 0) {
      $errlink .= '&factionid='.$data->factionid;
    }
    if ($data->cultureid > 0) {
      $errlink .= '&cultureid='.$data->cultureid;
    }
    if ($data->conceptid > 0) {
      $errlink .= '&conceptid='.$data->conceptid;
    }
    if (is_null($data->fullname) || strlen($data->fullname) == 0) {
      $name = "Inget namn angett";
      $data->fullname = $name;
      $data->knownas = $name;
    }

    if ($data->factionid == 0 || $data->cultureid == 0 || $data->conceptid == 0) {
      $errlink .= '&failed=1';
      $this->setRedirect($errlink);
      return;
    }

    $db->insertObject('#__lit_chara', $data);
    if ($db->getErrorNum() != 0) {
      echo '<h1>'.$db->getErrorMsg().'</h1>';
      //      $this->setRedirect($errlink, $db->getErrorMsg());
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
      //      $this->setRedirect($errlink, $db->getErrorMsg());
      return;
    }

    $froleid = $model->getDefaultFactionRoleId();
    $x = $model->addFactionRole($person->id, $eventid, $factionid, $froleid);

    $oklink = 'index.php?option=com_lajvit&view=character&layout=updated&eid=' .
        $eventid.'&cid='.$charid;
    $oklink .= '&Itemid='.JRequest::getInt('Itemid', 0);
    $this->setRedirect($oklink);
  }

  function save() {
    $errlink = 'index.php?option=com_lajvit&view=character&layout=edit';
    $errlink .= '&Itemid='.JRequest::getInt('Itemid', 0);

    $model = $this->getModel();
    $this->groupModel = $this->getModel('group');

    $charid = JRequest::getInt('cid', -1);
    $character = &$model->getCharacter($charid);
    $oldcharacter = $model->getCharacterExtended($charid);

    $eventid = JRequest::getInt('eid', -1);
    $event = &$model->getEvent($eventid);

    $personId = $model->getPersonIdOwningCharacterOnEvent($charid, $eventid);
    $reg = $model->getRegistration($personId, $eventid, $charid);
    if (!$reg) {
      echo '<h1>not registered</h1>';
      //      $this->setRedirect($errlink, 'Not registered';
      return;
    }

    $data = JRequest::get('post');

    if (key_exists('fullname', $data)) {
      if (is_null($data['fullname']) || strlen($data['fullname']) == 0) {
        $name = "Inget namn angett";
        $data['fullname'] = $name;
      }
      $data['knownas'] = $data['fullname'];
    }

    if (key_exists('age', $data) && strlen($data['age']) > 0 && (int) $data['age'] > 0) {
      $data['bornyear'] = $event->ingameyear - (int) $data['age'];
    }

    // Bind the form fields to the record
    if (!$character->bind($data)) {
      echo '<h1>bind</h1>'.$character->getDBO()->getErrorMsg();
      //$this->setRedirect($errlink, 'Database bind error: ' . $character->getDBO()->getErrorMsg());
      return;
    }

    $photo = JRequest::getVar('photo', NULL, 'files', 'array');
    if ($photo['size'] > 0) {
      $photo = $this->saveimage('photo');
      if ($photo) {
        $character->image = $photo;
      }
    }

    // Make sure the record is valid
    if (!$character->check()) {
      echo '<h1>check</h1>'.$character->getDBO()->getErrorMsg();
      //$this->setRedirect($errlink, 'Database check error:' . $character->getDBO()->getErrorMsg());
      return;
    }

    // Store the record to the database
    if (!$character->store()) {
      echo '<h1>store</h1>'.$character->getDBO()->getErrorMsg();
      //$this->setRedirect($errlink, 'Database store error:' . $character->getDBO()->getErrorMsg());
      return;
    }

    $this->storeGroupInfo($charid, $data);

    $oklink = 'index.php?option=com_lajvit&view=character&layout=updated&eid=' .
        $eventid.'&cid='.$charid;
    $oklink .= '&Itemid='.JRequest::getInt('Itemid', 0);
    $this->setRedirect($oklink);
  }

  public function saveConcept() {
    $model = $this->getModel();
    $user = JFactory::getUser();
    $charid = JRequest::getInt('cid', -1);
    $eventid = JRequest::getInt('eid', -1);
    $canDo = EventHelper::getActions($eventid);
    $personId = $model->getPersonIdOwningCharacterOnEvent($charid, $eventid);

    $reg = $model->getRegistration($personId, $eventid, $charid);
    if (!$reg) {
      echo '<h1>not registered</h1>';
      return;
    }

    if ($personId != $user->id &&
        !$canDo->get('core.edit')) {
      echo '<h1>Not Allowed</h1>';
      return;
    } elseif ($personId == $user->id) {
      $success = $model->setRegistrationStatusToNotApproved($charid, $eventid);
      if (!$success) {
        echo '<h1>Error resetting approval status</h1>';
        return;
      }
    }

    $data = JRequest::get('post');

    if (key_exists('factionid', $data) && $data['factionid'] == 0 ||
        key_exists('cultureid', $data) && $data['cultureid'] == 0 ||
        key_exists('conceptid', $data) && $data['conceptid'] == 0) {
      echo '<h1>' . JText::_('COM_LAJVIT_CHARACTER_EDIT_FAILED_MISSING_FACTION_CULTURE_CONCEPT') . '</h1>';
      return;
    }

    $this->save();
  }

  private function storeGroupInfo($characterId, $data) {
    foreach ($data as $key => $value) {
      $groupIdPosition = strpos($key, "groupMemberInfo");
      if ($groupIdPosition !== FALSE) {
        $groupId = intval(substr($key, strlen("groupMemberInfo") ));
        $this->groupModel->storeGroupMemberInfo($characterId, $groupId, $value);
      }
      $groupIdPosition = strpos($key, "groupLeaderInfo");
      if ($groupIdPosition !== FALSE) {
        $groupId = intval(substr($key, strlen("groupLeaderInfo")));
        $this->groupModel->storeGroupLeaderInfo($characterId, $groupId, $value);
      }
    }
  }

  function delete() {
    $errlink = 'index.php?option=com_lajvit&view=event';
    $errlink .= '&Itemid='.JRequest::getInt('Itemid', 0);

    $model = &$this->getModel();

    $person = &$model->getPerson();

    $charid = JRequest::getInt('cid', -1);
    $character = $model->getCharacterExtended($charid);

    $eventid = JRequest::getInt('eid', -1);
    $event = &$model->getEvent($eventid);

    $erole = &$model->getRoleForEvent($eventid);
    $crole = $model->getRoleForChara($eventid, $charid);
    $role = $model->mergeRoles($erole, $crole);

    $redirect = JRequest::getString('redirect', '');

    $reg = $model->getRegistration($person->id, $eventid, $charid);
    $db = &JFactory::getDBO();
    if (!$reg) {
      if ($role->character_delete) {
        echo '<h1>admin</h1>';
        $query = 'DELETE FROM #__lit_registrationchara WHERE eventid='.$db->getEscaped($eventid) .
          ' AND charaid='.$db->getEscaped($charid).' LIMIT 1;';
      } else {
        echo 'Access denied';
        //      $this->setRedirect($errlink, 'Not registered';
        return;
      }
    } else {
      $query = 'DELETE FROM #__lit_registrationchara WHERE personid='.$person->id.' AND eventid=' .
          $db->getEscaped($eventid).' AND charaid='.$db->getEscaped($charid).' LIMIT 1;';
    }

    $db->setQuery($query);

    if (!$db->query()) {
      echo '<h1>'.$db->getErrorMsg().'</h1>';
      //      $this->setRedirect($errlink, $db->getErrorMsg());
      return;
    }

    if ($redirect == 'registrations' && $eventid > 0) {
      $oklink = 'index.php?option=com_lajvit&view=registrations';
      $oklink .= '&Itemid='.JRequest::getInt('Itemid', 0);
      $oklink .= '&eid=' . $eventid;
    } else {
      $oklink = 'index.php?option=com_lajvit&view=event';
      $oklink .= '&Itemid='.JRequest::getInt('Itemid', 0);
    }
    $this->setRedirect($oklink);
  }
}
