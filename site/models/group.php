<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * LajvIT Model.
 */
class LajvITModelGroup extends JModelItem {

  /**
   * @param object $data
   * @return int|array
   */
  public function createGroup($data) {
    $db = &JFactory::getDBO();
    $group = JTable::getInstance('lit_groups', 'Table');
    $group->bind($data);
    $creationSuccess = $group->store();
    if ($creationSuccess) {
      return $group->id;
    } else {
      return $group->getErrors();
    }
  }

  /**
   *
   * @param int $groupId
   * @return boolean|array
   */
  public function getGroup($groupId) {
    $personModel =& JModel::getInstance('person', 'lajvitmodel');
    $user = JFactory::getUser();
    $canDo = GroupHelper::getActions($groupId);
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      return FALSE;
    }
    $groupData = $group->getProperties();
    $visible = $groupData['visible'];
    $groupId = $groupData['id'];
    if ($visible == 1 &&
        (!$this->canEditGroup($groupId) &&
          !$user->authorise('lajvit.view.visible', 'com_lajvit.group.' . $groupId))) {
      return FALSE;
    }
    if ($visible == 0 &&
        ( !$this->canEditGroup($groupId) &&
          !$user->authorise('lajvit.view.hidden', 'com_lajvit.group.' . $groupId)) ) {
      return FALSE;
    }
    $personId = $groupData['groupLeaderPersonId'];
    $groupData['groupLeaderPersonName'] = $personModel->getPersonNameFromId($personId);
    return $groupData;
  }

  /**
   * @param object $data
   * @return boolean
   */
  public function updateGroup($data) {
    $user = JFactory::getUser();
    $canDo = GroupHelper::getActions($data->id);
    if ($this->canEditGroup($data->id)) {
      $group = JTable::getInstance('lit_groups', 'Table');
      $group->bind($data);
      $result = $group->store();
      return $result;
    } else {
      return FALSE;
    }
  }

  public function getGroupOwner($groupId) {
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      return FALSE;
    }
    $groupData = $group->getProperties();
    return $groupData['groupLeaderPersonId'];
  }

  public function addCharacterToGroup($data) {
    if ($this->canAddCharacterToGroup($data->groupId, $data->characterId)) {
      $db = &JFactory::getDBO();
      $groupMember = JTable::getInstance('lit_groupmembers', 'Table');
      $groupMember->bind($data);
      $creationSuccess = $groupMember->store();
      if ($creationSuccess) {
        return $groupMember->id;
      } else {
        return $groupMember->getErrors();
      }
    }
    return FALSE;
  }

  public function getEventForGroup($groupId) {
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      return FALSE;
    }
    $groupData = $group->getProperties();
    return $groupData['eventId'];
  }

  public function isGroupVisible($groupId) {
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      return FALSE;
    }
    $groupData = $group->getProperties();
    $visible = $groupData['visible'];
    if ($visible == 1) {
      return TRUE;
    }
    return FALSE;
  }

  public function isGroupOpen($groupId) {
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      return FALSE;
    }
    $groupData = $group->getProperties();
    $status = $groupData['status'];
    if ($status == 'open') {
      return TRUE;
    }
    return FALSE;
  }

  /**
   *
   * @param int $groupId
   * @return array characterObjects
   */
  public function getCharactersInGroup($groupId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT chara.* FROM #__lit_chara AS chara
    INNER JOIN #__lit_group_members ON characterId = chara.id
    WHERE groupId = '.$db->getEscaped($groupId).';';
    $db->setQuery($query);

    return $db->loadObjectList();
  }

  /**
   *
   * @param int $groupId
   * @return array int
   */
  public function getCharacterIdsInGroup($groupId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT chara.id FROM #__lit_chara AS chara
    INNER JOIN #__lit_group_members ON characterId = chara.id
    WHERE groupId = '.$db->getEscaped($groupId).';';
    $db->setQuery($query);

    return $db->loadResultArray(0);
  }

  private function canEditGroup($groupId) {
    $user = JFactory::getUser();
    $canDo = GroupHelper::getActions($groupId);
    if ($canDo->get('core.edit')) {
      return TRUE;
    }
    if ($canDo->get('core.edit.own') &&
        $this->getGroupOwner($groupId) == $user->id) {
      return TRUE;
    }
    return FALSE;
  }

  private function canAddCharacterToGroup($groupId, $characterId) {
    $user = JFactory::getUser();
    $canDo = GroupHelper::getActions($groupId);
    if ($canDo->get('core.edit')) {
      return TRUE;
    }
    if ($canDo->get('core.edit.own') &&
        $this->getGroupOwner($groupId) == $user->id) {
      return TRUE;
    }
    $lajvitModel = JModel::getInstance('lajvit', 'lajvitmodel');
    if ($this->isGroupOpen($groupId) && $this->isGroupVisible($groupId) &&
        $lajvitModel->isCharacterOwnedByPerson($characterId, $user->id)) {
      return TRUE;
    }
    return FALSE;
  }

  public function hasPersonApprovedCharacterInSameFaction($userId, $groupId) {
    $eventId = $this->getEventForGroup($groupId);
    $groupData = $this->getGroup($groupId);
    if ($groupData == FALSE) {
      return FALSE;
    }
    $groupFaction = $groupData['factionId'];
    $lajvitModel = JModel::getInstance('lajvit', 'lajvitmodel');
    $charactersOnEvent = $lajvitModel->getCharactersOnEventForPerson($eventId, $userId->id);
    foreach ($charactersOnEvent as $character) {
      $faction = $character->factionid;
      if ($faction == $groupFaction &&
          ($character->statusid == 101 || $character->statusid == 102)) {
        return TRUE;
      } else {
      }
    }
      return FALSE;
  }
}
