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
   * Deletes the group if the user has editing rights
   * @param int $groupId
   */
  public function deleteGroup($groupId) {
    if ($this->canEditGroup($groupId)) {
      $db = &JFactory::getDBO();
      $group = JTable::getInstance('lit_groups', 'Table');
      $group->delete($groupId);
    }
  }

  /**
   *
   * @param int $groupId
   * @return boolean|array
   */
  public function getGroup($groupId) {
    $personModel =& JModel::getInstance('person', 'lajvitmodel');
    $lajvitModel = JModel::getInstance('lajvit', 'lajvitmodel');
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
    $factionName = $lajvitModel->getFactionName($groupData['factionId']);
    $groupData['groupFactionName'] = $lajvitModel->getFactionName($groupData['factionId']);
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

  /**
   *
   * @param int $characterId
   * @param int $groupId
   * @param string $info
   */
  public function storeGroupLeaderInfo($characterId, $groupId, $info) {
    $lajvitModel = JModel::getInstance('lajvit', 'lajvitmodel');
    $user = JFactory::getUser();
    if ($lajvitModel->isCharacterOwnedByPerson($characterId, $user->id)) {
      $db = &JFactory::getDBO();
      $query = 'UPDATE #__lit_group_members
        SET groupLeaderInfo = "' . $db->getEscaped($info) .'"
        WHERE groupId = '.$db->getEscaped($groupId) .' AND
        characterId = ' . $db->getEscaped($characterId). ';';
      $db->setQuery($query);
      $db->query();
    }
  }

  /**
   *
   * @param int $characterId
   * @param int $groupId
   * @param string $info
   */
  public function storeGroupMemberInfo($characterId, $groupId, $info) {
    $lajvitModel = JModel::getInstance('lajvit', 'lajvitmodel');
    $user = JFactory::getUser();
    if ($lajvitModel->isCharacterOwnedByPerson($characterId, $user->id)) {
      $db = &JFactory::getDBO();
      $query = 'UPDATE #__lit_group_members
        SET groupMemberInfo = "' . $db->getEscaped($info) .'"
        WHERE groupId = '.$db->getEscaped($groupId) .' AND
        characterId = ' . $db->getEscaped($characterId). ';';
      $db->setQuery($query);
      $db->query();
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
    if ($this->canAddOrRemoveCharacterToGroup($data->groupId, $data->characterId)) {
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

  public function approveMemberInGroup($characterId, $groupId) {
    if ($this->canAddOrRemoveCharacterToGroup($groupId, $characterId)) {
      $db = &JFactory::getDBO();
      $query = 'UPDATE #__lit_group_members SET approvedMember = 1
          WHERE groupId = ' . $db->getEscaped($groupId) . ' AND
              characterId = ' . $db->getEscaped($characterId) . ';';
      $db->setQuery($query);

      $updateSuccess = $db->query();
      if ($updateSuccess) {
        return TRUE;
      } else {
        return $db->getErrors();
      }
    }
    return FALSE;
  }

  public function removeCharFromGroup($characterId, $groupId) {
    if (!is_int($characterId) || !is_int($groupId)) {
      return FALSE;
    }
    if ($this->canAddOrRemoveCharacterToGroup($groupId, $characterId)) {
      $db = &JFactory::getDBO();
      $groupMember = JTable::getInstance('lit_groupmembers', 'Table');
      $tableName = $groupMember->getTableName();
      $sql = 'DELETE FROM ' . $tableName . ' WHERE groupId = ' . $groupId .
      ' AND characterId = ' . $characterId;
      $db->setQuery($sql);
      if ($db->query()) {
        return TRUE;
      } else {
        return $db->getErrorMsg();
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
    $query = 'SELECT chara.*, concept.name AS conceptName,
        culture.name AS cultureName, approvedMember
    FROM #__lit_chara AS chara
    INNER JOIN #__lit_group_members ON characterId = chara.id
    INNER JOIN #__lit_characoncept AS concept ON concept.id = chara.conceptid
    INNER JOIN #__lit_characulture AS culture ON culture.id = chara.cultureid
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

  private function canAddOrRemoveCharacterToGroup($groupId, $characterId) {
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

  /**
   *
   * @param int $userId
   * @param int $groupId
   * @return boolean
   */
  public function hasPersonCharacterInGroup($userId, $groupId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT characterId FROM #__lit_group_members
      INNER JOIN #__lit_vcharacterregistrations AS charreg ON charreg.id = characterId
      WHERE groupId = '.$db->getEscaped($groupId).' AND
      personid = ' . $db->getEscaped($userId) . ';';
    $db->setQuery($query);
    if (count($db->loadObjectList()) > 0) {
      return TRUE;
    }
    return FALSE;
  }

  /**
   * Returns TRUE if person is a group leader for any of the groups the
   * character is registered in.
   * @param int $userId
   * @param int $characterId
   * @return boolean
   */
  public function isPersonGroupLeaderForCharacter($userId, $characterId) {
    $groupIds = $this->getGroupsThatCharacterIsRegisteredIn($characterId);
    foreach ($groupIds as $groupId) {
      if ($this->getGroupOwner($groupId) == $userId) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Returns TRUE if the person is the group leader for the group
   * @param int $userId
   * @param int $groupId
   * @return boolean
   */
  public function isPersonGroupLeaderForGroup($userId, $groupId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT groupLeaderPersonId FROM #__lit_groups
      WHERE id = '.$db->getEscaped($groupId) .';';
    $db->setQuery($query);
    $groupLeader = $db->loadResult();
    if ($groupLeader != NULL && $groupLeader == $userId) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   *
   * @param int $characterId
   * @return array of array(int, text)
   */
  public function getAllGroupLeaderInfoForCharacter($characterId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT groupId, groupLeaderInfo FROM #__lit_group_members
      WHERE characterId = '.$db->getEscaped($characterId) .';';
    $db->setQuery($query);
    $info = $db->loadObjectList();
    return $info;
  }

  /**
   *
   * @param int $characterId
   * @return array of array(int, text)
   */
  public function getAllGroupMemberInfoForCharacter($characterId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT groupId, groupMemberInfo FROM #__lit_group_members
      WHERE characterId = '.$db->getEscaped($characterId) .';';
    $db->setQuery($query);
    $info = $db->loadObjectList();
    return $info;
  }

  /**
   * Returns TRUE if person is a group member for any of the groups the
   * character is registered in.
   * @param int $userId
   * @param int $characterId
   * @return boolean
   */
  public function isPersonGroupMemberInAGroupOfCharacter($userId, $characterId) {
    $groupIds = $this->getGroupsThatCharacterIsRegisteredIn($characterId);
    foreach ($groupIds as $groupId) {
      if ($this->hasPersonCharacterInGroup($userId, $groupId)) {
        return TRUE;
      }
    }
    return FALSE;
  }

  /**
   * Returns an array of group id, or NULL
   * @param int $characterId
   * @return mixed: NULL, array(int)
   */
  public function getGroupsThatCharacterIsRegisteredIn($characterId) {
    $db = &JFactory::getDBO();
    $query = 'SELECT groupId FROM #__lit_group_members
    WHERE characterId = '.$db->getEscaped($characterId).';';
    $db->setQuery($query);

    return $db->loadResultArray(0);
  }
}
