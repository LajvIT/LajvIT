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
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      return FALSE;
    }
    $groupData = $group->getProperties();
    $personId = $groupData['groupLeaderPersonId'];
    $groupData['groupLeaderPersonName'] = $personModel->getPersonNameFromId($personId);
    return $groupData;
  }

  /**
   * @param object $data
   * @return boolean
   */
  public function updateGroup($data) {
    $group = JTable::getInstance('lit_groups', 'Table');
    $group->bind($data);
    $result = $group->store();
    //echo "Result after store: " . $result . "<br>";
    //echo "Error: " . print_r($group->getErrors(), TRUE) . "<br>\n";
    return $result;
  }
}
