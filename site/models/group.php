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
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      return FALSE;
    }
    $groupData = $group->getProperties();
    $visible = $groupData['visible'];
    $groupId = $groupData['id'];
    if ($visible == 1 && !$user->authorise('lajvit.view.visible', 'com_lajvit.group.' . $groupId)) {
      return FALSE;
    }
    if ($visible == 0 && !$user->authorise('lajvit.view.hidden', 'com_lajvit.group.' . $groupId)) {
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
    if ($canDo->get('core.edit')) {
      echo "LajvITModelGroup.updateGroup can edit ";
    } elseif ($canDo->get('core.edit.own') && $this->getGroupOwner($data->id) == $user->id) {
      echo "LajvITModelGroup.updateGroup can edit own ";
    }
    $group = JTable::getInstance('lit_groups', 'Table');
    $group->bind($data);
    $result = $group->store();
    //echo "Result after store: " . $result . "<br>";
    //echo "Error: " . print_r($group->getErrors(), TRUE) . "<br>\n";
    return $result;
  }

  public function getGroupOwner($groupId) {
    echo "LajvITModelGroup.getGroupOwner " . $groupId . "<br>";
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      echo "LajvITModelGroup.getGroupOwner could not load <br>";
      return FALSE;
    }
    $groupData = $group->getProperties();
    echo "LajvITModelGroup.getGroupOwner returning: " . $groupData['groupLeaderPersonId'] . "<br>";
    return $groupData['groupLeaderPersonId'];
  }
}
