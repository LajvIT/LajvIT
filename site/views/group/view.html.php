<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component.
 */
class LajvITViewGroup extends JView {

  /**
   * @var LajvITModelGroupModel
   */
  private $model;

  function display($tpl = NULL) {
    $this->model =& JModel::getInstance('groupmodel', 'lajvitmodel');
    $layout = $this->getLayout();
    $user = &JFactory::getUser();
    $eventId = JRequest::getInt('eid', -1);
    $groupId = JRequest::getInt('groupId', -1);
    $minusOne = -1;

    $this->assignRef('eventId', $eventId);
    $this->assignRef('groupId', $groupId);
    $this->assignRef('itemId', JRequest::getInt('Itemid', 0));
    if ($layout == 'edit' && $groupId > 0) {
      $group = $this->model->getGroup($groupId);
      if (!$group) {
        echo "Failed fetching group<br>\n";
        $this->assignRef('groupId', $minusOne);
      } else {
        $currentGroupStatus = '';
        $currentGroupStatus = $group['status'];
        $this->setEditData($group);
      }
    }
    parent::display($tpl);
  }

  private function setEditData($group) {
    $this->assignRef('groupName', $group['name']);
    $this->assignRef('groupDescription', $group['description']);
    $this->assignRef('groupMaxParticipants', $group['maxParticipants']);
    $this->assignRef('groupExpectedParticipants', $group['expectedParticipants']);
    $this->assignRef('groupAdminInfo', $group['adminInformation']);
    $this->assignRef('groupUrl', $group['url']);
    $this->assignRef('groupVisible', $group['visible']);
    $this->assignRef('groupStatus', $group['status']);
    $this->assignRef('groupLeaderPersonId', $group['groupLeaderPersonId']);
  }
}
