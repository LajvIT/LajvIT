<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Controller for a user to register to an event and to manage events (add, remove, modify).
 */
class LajvITControllerGroup extends LajvITController {
  /**
   * @var LajvITModelGroupModel
   */
  private $groupModel = NULL;
  /**
   * @var LajvITModelLajvIT
   */
  private $lajvitModel = NULL;
  private $person = NULL;
  const ADMINISTRATOR = "Super Administrator";

  public function create() {
    $this->groupModel = &$this->getModel('groupmodel');
    $this->lajvitModel =&$this->getModel('lajvit');
    $this->person = &$this->lajvitModel->getPerson();
    $data = $this->getGroupDataFromPostedForm();
    if (!$this->verifyGroupData($data)) {
      return;
    }
    $groupId = $this->groupModel->createGroup($data);
    if (is_int($groupId) && $groupId > 0) {
      echo "Group created<br>\n";
      $this->setRedirect($this->createGroupCompletedLink($groupId));
    } else {
      echo "Group creation failed<br>\n";
      $this->setRedirect($this->listGroupsLink());
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
    $groupId = JRequest::getInt('groupId', NULL);
    $groupName = JRequest::getString('groupName', '');
    $groupDescription = JRequest::getString('groupDescription', '');
    $groupUrl = JRequest::getString('groupUrl', '');
    $groupAdminInfo = JRequest::getString('groupAdminInfo', '');
    $groupMaxParticipants = JRequest::getInt('groupMaxParticipants', 0);
    $groupStatus = JRequest::getString('groupStatus', 'created');
    $groupEventId = JRequest::getInt('eventId', -1);
    $groupLeaderPersonId = JRequest::getInt('groupLeaderId', $this->person->id);
    if (!preg_match('/http:\/\/|https:\/\//', $groupUrl)) {
      $groupUrl = 'http://' . $groupUrl;
    }
    $data = new stdClass();
    $data->name = $db->getEscaped($groupName);
    $data->description = $db->getEscaped($groupDescription);
    $data->url = $db->getEscaped($groupUrl);
    $data->adminInformation = $db->getEscaped($groupAdminInfo);
    $data->maxParticipants = $db->getEscaped($groupMaxParticipants);
    $data->status = $db->getEscaped($groupStatus);
    $data->eventId = $db->getEscaped($groupEventId);
    $data->id = $db->getEscaped($groupId);
    $data->grouLeaderPersonId = $db->getEscaped($groupLeaderPersonId);
    return $data;
  }

  private function verifyGroupData($data) {
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

  private function createGroupCompletedLink($groupId) {
    return $this->listGroupsLink();
  }
  private function listGroupsLink() {
    $link = 'index.php?option=com_lajvit&view=group';
    $link .= '&Itemid='.JRequest::getInt('Itemid', 0);
    return $link;
  }
}
