<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * LajvIT Model.
 */
class LajvITModelGroupModel extends JModel {

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
    $group = JTable::getInstance('lit_groups', 'Table');
    if (!$group->load($groupId)) {
      return FALSE;
    }
    return $group->getProperties();
  }

  /**
   * @param object $data
   * @return boolean
   */
  public function updateGroup($data) {
    $group = JTable::getInstance('lit_groups', 'Table');
    $group->bind($data);
    $result = $group->store();
    echo "Error: " . print_r($group->getErrors()) . "<br>\n";
    return $result;
  }
}
