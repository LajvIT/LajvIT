<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Controller for a user to register to an event and to manage events (add, remove, modify).
 */
class LajvITControllerGroup extends LajvITController {
  /**
   * @var LajvITModelGroup
   */
  private $groupModel = NULL;
  /**
   * @var LajvITModelLajvIT
   */
  private $lajvitModel = NULL;
  /**
   * @var LajvITModelPerson
   */
  private $personModel = NULL;
  private $person = NULL;
  const ADMINISTRATOR = "Super Administrator";

  public function create() {
    $this->initModels();
    $data = $this->getGroupDataFromPostedForm();
    if (!$this->verifyGroupData($data)) {
      $this->setRedirect($this->showGroupList());
      return;
    }
    $groupId = $this->groupModel->createGroup($data);
    if (is_int($groupId) && $groupId > 0) {
      $this->setRedirect($this->showEditGroupLink($groupId));
    } else {
      $this->setRedirect($this->showGroupList());
    }
  }

  public function edit() {
    $this->initModels();
    $data = $this->getGroupDataFromPostedForm();
    if (!$this->verifyGroupData($data)) {
      $this->setRedirect($this->showGroupList());
      return;
    }
    $updateResult = $this->groupModel->updateGroup($data);
    //echo "updateResult: " . print_r($updateResult) . "<br>\n";
    //echo $updateResult . "<br>\n";
    if ($updateResult === NULL || $updateResult == "" || $updateResult == 1) {
      $this->setRedirect($this->showEditGroupLink($data->id));
    } else {
      $this->setRedirect($this->defaultViewGroupLink($data->id));
    }
  }

  public function delete() {
    $this->initModels();
    $data = $this->getGroupDataFromRequest();
    $eventId = $this->groupModel->getEventForGroup($data->groupId);
    JRequest::setVar('eid', $eventId);
    JRequest::setVar('option', 'com_lajvit');
    if (!$this->allowedToEditGroup($data->groupId)) {
      JRequest::setVar('view', 'groups');
      JRequest::setVar('errorMsg', 'Not allowed to delete group');
      parent::display();
      return;
    }
    $groupMemberId = $this->groupModel->deleteGroup($data->groupId);
    JRequest::setVar('message', 'COM_LAJVIT_REMOVED_GROUP');
    JRequest::setVar('view', 'groups');
    JRequest::setVar('layout', 'default');
    parent::display();
  }

  public function addCharacterToGroup() {
    $this->initModels();
    $data = $this->getGroupDataFromRequest();
    JRequest::setVar('option', 'com_lajvit');
    if (!$this->allowedToAddOrRemoveCharacterInGroup($data)) {
      JRequest::setVar('view', 'event');
      JRequest::setVar('errorMsg', 'Not allowed to update group');
      $this->setRedirect($this->defaultViewGroupLink($data->groupId), 'Not allowed');
      return;
    }
    JRequest::setVar('groupId', $data->groupId);
    JRequest::setVar('view', 'group');
    JRequest::setVar('layout', 'edit');
    $groupMemberId = $this->groupModel->addCharacterToGroup($data);

    if (is_int($groupMemberId) && $groupMemberId > 0) {
      JRequest::setVar('message', 'COM_LAJVIT_ADDED_CHARACTER');
      JRequest::setVar('character', $this->lajvitModel->getCharacter($data->characterId)->knownas);
      parent::display();
    } else {
      JRequest::setVar('errorMsg', 'COM_LAJVIT_COULD_NOT_ADD_CHARACTER');
      parent::display();
    }
  }

  public function removeCharacterFromGroup() {
    $this->initModels();
    $data = $this->getGroupDataFromRequest();
    $characterId = $data->characterId;
    $groupId = $data->groupId;
    JRequest::setVar('option', 'com_lajvit');
    if (!$this->allowedToAddOrRemoveCharacterInGroup($data)) {
      JRequest::setVar('view', 'event');
      JRequest::setVar('errorMsg', 'Not allowed to update group');
      $this->setRedirect($this->defaultViewGroupLink($groupId), 'Not allowed');
      return;
    }
    JRequest::setVar('groupId', $groupId);
    JRequest::setVar('view', 'group');
    JRequest::setVar('layout', 'edit');
    $outcome = $this->groupModel->removeCharFromGroup($characterId, $groupId);

    if ($outcome === TRUE) {
      JRequest::setVar('message', 'COM_LAJVIT_REMOVED_CHARACTER');
      JRequest::setVar('character', $this->lajvitModel->getCharacter($characterId)->knownas);
      parent::display();
    } else {
      JRequest::setVar('errorMsg', 'COM_LAJVIT_COULD_NOT_REMOVE_CHARACTER');
      parent::display();
    }
  }

  public function approveMembership() {
    $this->initModels();
    $data = $this->getGroupDataFromRequest();
    $characterId = $data->characterId;
    $groupId = $data->groupId;
    JRequest::setVar('option', 'com_lajvit');
    if (!$this->allowedToAddOrRemoveCharacterInGroup($data)) {
      JRequest::setVar('view', 'event');
      JRequest::setVar('errorMsg', 'Not allowed to update group');
      $this->setRedirect($this->defaultViewGroupLink($groupId), 'Not allowed');
      return;
    }
    JRequest::setVar('groupId', $groupId);
    JRequest::setVar('view', 'group');
    JRequest::setVar('layout', 'edit');
    $outcome = $this->groupModel->approveMemberInGroup($characterId, $groupId);

    if ($outcome === TRUE) {
      JRequest::setVar('message', 'COM_LAJVIT_GROUP_APPROVED_CHARACTER');
      JRequest::setVar('character', $this->lajvitModel->getCharacter($characterId)->knownas);
      parent::display();
    } else {
      JRequest::setVar('errorMsg', 'COM_LAJVIT_GROUP_COULD_NOT_APPROVE_CHARACTER');
      parent::display();
    }
  }

  public function addLeaderToGroup() {
    $this->initModels();
    $data = $this->getGroupDataFromRequest();
    if (!$this->allowedToEditGroup($data->groupId)) {
      JRequest::setVar('view', 'event');
      $errorMessage = JText::_('COM_LAJVIT_NOT_AUTHORIZED_TO_ADD_LEADER_TO_GROUP');
      JRequest::setVar('errorMsg', $errorMessage);
      $this->setRedirect($this->defaultViewGroupLink(), 'Not allowed');
      return;
    }
    JRequest::setVar('groupId', $data->groupId);
    JRequest::setVar('view', 'group');
    JRequest::setVar('layout', 'edit');
    $success = $this->groupModel->addGroupLeaderToGroup($data->personId, $data->groupId);

    if ($success) {
      JRequest::setVar('message', 'COM_LAJVIT_GROUP_ADDED_LEADER');
      JRequest::setVar('name', $this->personModel->getPersonNameFromId($data->personId));
      parent::display();
    } else {
      JRequest::setVar('errorMsg', 'COM_LAJVIT_COULD_NOT_ADD_CHARACTER');
      parent::display();
    }
  }

  public function removeLeaderFromGroup() {
    $this->initModels();
    $data = $this->getGroupDataFromRequest();
    if (!$this->allowedToEditGroup($data->groupId)) {
      JRequest::setVar('view', 'event');
      JRequest::setVar('errorMsg', JText::_('COM_LAJVIT_NOT_AUTHORIZED_TO_REMOVE_LEADER_FROM_GROUP'));
      $this->setRedirect($this->defaultViewGroupLink($data->groupId), 'Not allowed');
      return;
    }
    JRequest::setVar('groupId', $data->groupId);
    JRequest::setVar('view', 'group');
    JRequest::setVar('layout', 'edit');
    $success = $this->groupModel->removeGroupLeaderFromGroup($data->personId, $data->groupId);

    if ($success) {
      JRequest::setVar('message', 'COM_LAJVIT_GROUP_REMOVED_LEADER');
      JRequest::setVar('name', $this->personModel->getPersonNameFromId($data->personId));
      parent::display();
    } else {
      JRequest::setVar('errorMsg', 'COM_LAJVIT_GROUP_COULD_NOT_REMOVE_LEADER');
      parent::display();
    }
  }

  private function allowedToAddOrRemoveCharacterInGroup($data) {
    $canDo = GroupHelper::getActions($data->groupId);
    $characterId = $data->characterId;
    $groupId = $data->groupId;
    $personId = $this->person->id;
    $eventId = $this->groupModel->getEventForGroup($groupId);
    if ($canDo->get('core.edit')) {
      return TRUE;
    }
    if ($canDo->get('core.edit.own') &&
        $this->groupModel->isPersonGroupLeaderForGroup($personId, $groupId)) {
      return TRUE;
    }
    if ($this->lajvitModel->isCharacterOwnedByPerson($characterId, $personId) &&
        $this->lajvitModel->isCharacterRegisteredOnEvent($characterId, $eventId) &&
        $this->groupModel->isGroupVisible($groupId)) {
      return TRUE;
    }
    return FALSE;
  }

  private function getGroupDataFromRequest() {
    $data = new stdClass();
    $groupId = JRequest::getInt('groupId', -1);
    if ($groupId <= 0) {
      $groupId = NULL;
    }
    $characterId = JRequest::getInt('characterId', '');
    if ($characterId <= 0) {
      $characterId = NULL;
    }
    $personId = JRequest::getInt('personId', '');
    if ($personId <= 0) {
      $personId = NULL;
    }
    $data->groupId = $groupId;
    $data->characterId = $characterId;
    $data->personId = $personId;
    return $data;
  }

  private function allowedToEditGroup($groupId) {
    $user = JFactory::getUser();
    $canDo = GroupHelper::getActions($groupId);
    if ($canDo->get('core.edit')) {
      return TRUE;
    }
    if ($canDo->get('core.edit.own') &&
        $this->groupModel->isPersonGroupLeaderForGroup($user->id, $groupId)) {
      return TRUE;
    }
    return FALSE;
  }

  private function getGroupDataFromPostedForm() {
    $db =& JFactory::getDBO();
    $groupId = JRequest::getInt('groupId', -1);
    if ($groupId <= 0) {
      $groupId = NULL;
    }
    $groupName = JRequest::getString('groupName', '');
    $groupPublicDescription = JRequest::getString('groupPublicDescription', '');
    $groupPrivateDescription = JRequest::getString('groupPrivateDescription', '');
    $groupUrl = JRequest::getString('groupUrl', '');
    $groupAdminInfo = JRequest::getString('groupAdminInfo', '');
    $groupMaxParticipants = JRequest::getInt('groupMaxParticipants', 0);
    $groupExpectedParticipants = JRequest::getInt('groupExpectedParticipants', 0);
    $groupStatus = JRequest::getString('groupStatus', 'created');
    $groupEventId = JRequest::getInt('eventId', -1);
    $groupLeaderPersonId = JRequest::getInt('groupLeaderPersonId', 0);
    $groupFactionId = JRequest::getInt('groupFaction', 0);
    if ($groupLeaderPersonId == 0 ) {
      $groupLeaderPersonId = $this->person->id;
    }
    $visible = JRequest::getInt('groupVisible', 0);
    if ($groupUrl != "" && !preg_match('/http:\/\/|https:\/\//', $groupUrl)) {
      $groupUrl = 'http://' . $groupUrl;
    }
    $data = new stdClass();
    $data->name = $db->getEscaped($groupName);
    $data->descriptionPublic = $db->getEscaped($groupPublicDescription);
    $data->descriptionPrivate = $db->getEscaped($groupPrivateDescription);
    $data->url = $db->getEscaped($groupUrl);
    $data->adminInformation = $db->getEscaped($groupAdminInfo);
    $data->maxParticipants = $db->getEscaped($groupMaxParticipants);
    $data->expectedParticipants = $db->getEscaped($groupExpectedParticipants);
    $data->status = $db->getEscaped($groupStatus);
    $data->eventId = $db->getEscaped($groupEventId);
    $data->id = $db->getEscaped($groupId);
    $data->groupLeaderPersonId = $db->getEscaped($groupLeaderPersonId);
    $data->visible = $db->getEscaped($visible);
    $data->factionId = $db->getEscaped($groupFactionId);
    return $data;
  }

  private function verifyGroupData($data) {
    if ($data->name == '') {
      return FALSE;
    }
    if (!is_numeric($data->visible) || !($data->visible >= 0 && $data->visible <= 1)) {
      return FALSE;
    }
    return TRUE;
  }

  private function showEditGroupLink($groupId) {
    $link = $this->defaultGroupLink();
    $link .= '&layout=edit&groupId=' . $groupId;
    return $link;
  }

  private function defaultGroupLink() {
    $link = 'index.php?option=com_lajvit&view=group';
    $link .= '&Itemid='.JRequest::getInt('Itemid', 0);
    return $link;
  }

  private function defaultViewGroupLink($groupId) {
    $link = $this->defaultGroupLink();
    $link .= '&groupId=' . $groupId;
    return $link;
  }

  private function showGroupList() {
    $link = 'index.php?option=com_lajvit&view=groups';
    $link .= '&Itemid='.JRequest::getInt('Itemid', 0);
    return $link;
  }

  private function initModels() {
    $this->groupModel = $this->getModel('group');
    $this->lajvitModel = $this->getModel('lajvit');
    $this->personModel = $this->getModel('person');
    //     JModel::getInstance('person', 'lajvitmodel');
    $this->person = &$this->lajvitModel->getPerson();
  }
}
