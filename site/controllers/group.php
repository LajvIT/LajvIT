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
  private $person = NULL;
  const ADMINISTRATOR = "Super Administrator";

  public function create() {
    $this->initModels();
    $data = $this->getGroupDataFromPostedForm();
    if (!$this->verifyGroupData($data)) {
      $this->setRedirect($this->defaultGroupsLink());
      return;
    }
    $groupId = $this->groupModel->createGroup($data);
    if (is_int($groupId) && $groupId > 0) {
      //$this->setRedirect($this->showEditGroupLink($groupId));
    } else {
      $this->setRedirect($this->defaultGroupsLink());
    }
  }

  public function edit() {
    $this->initModels();
    $data = $this->getGroupDataFromPostedForm();
    echo "group: <br>" . print_r($data, TRUE) . "<br>";
    if (!$this->verifyGroupData($data)) {
      $this->setRedirect($this->showEditGroupLink());
      return;
    }
    $updateResult = $this->groupModel->updateGroup($data);
    //echo "updateResult: " . print_r($updateResult) . "<br>\n";
    //echo $updateResult . "<br>\n";
    if ($updateResult === NULL || $updateResult == "" || $updateResult == 1) {
      //echo "Updated group<br>\n";
      //$this->setRedirect($this->showEditGroupLink($data->id));
    } else {
      //echo "Failed to update group<br>\n";
      $this->setRedirect($this->defaultGroupsLink());
    }
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

  private function getGroupDataFromPostedForm() {
    $db =& JFactory::getDBO();
    $groupId = JRequest::getInt('groupId', -1);
    if ($groupId <= 0) {
      $groupId = NULL;
    }
    $groupName = JRequest::getString('groupName', '');
    $groupDescription = JRequest::getString('groupDescription', '');
    $groupUrl = JRequest::getString('groupUrl', '');
    $groupAdminInfo = JRequest::getString('groupAdminInfo', '');
    $groupMaxParticipants = JRequest::getInt('groupMaxParticipants', 0);
    $groupExpectedParticipants = JRequest::getInt('groupExpectedParticipants', 0);
    $groupStatus = JRequest::getString('groupStatus', 'created');
    $groupEventId = JRequest::getInt('eventId', -1);
    $groupLeaderPersonId = JRequest::getInt('groupLeaderId', 0);
    if ($groupLeaderPersonId == 0 ) {
      $groupLeaderPersonId = $this->person->id;
    }
    $visible = JRequest::getInt('groupVisible', 0);
    if (!preg_match('/http:\/\/|https:\/\//', $groupUrl)) {
      $groupUrl = 'http://' . $groupUrl;
    }
    $data = new stdClass();
    $data->name = $db->getEscaped($groupName);
    $data->description = $db->getEscaped($groupDescription);
    $data->url = $db->getEscaped($groupUrl);
    $data->adminInformation = $db->getEscaped($groupAdminInfo);
    $data->maxParticipants = $db->getEscaped($groupMaxParticipants);
    $data->expectedParticipants = $db->getEscaped($groupExpectedParticipants);
    $data->status = $db->getEscaped($groupStatus);
    $data->eventId = $db->getEscaped($groupEventId);
    $data->id = $db->getEscaped($groupId);
    $data->groupLeaderPersonId = $db->getEscaped($groupLeaderPersonId);
    $data->visible = $db->getEscaped($visible);
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
    $link = $this->defaultGroupsLink();
    $link .= '&layout=edit&groupId=' . $groupId;
    return $link;
  }

  private function defaultGroupsLink() {
    $link = 'index.php?option=com_lajvit&view=group';
    $link .= '&Itemid='.JRequest::getInt('Itemid', 0);
    return $link;
  }

  private function initModels() {
    $this->groupModel = &$this->getModel('group');
    $this->lajvitModel =&$this->getModel('lajvit');
    $this->person = &$this->lajvitModel->getPerson();
  }
}
