<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * LajvIT Model.
 */
class LajvITModelGroupModel extends JModel {

  function createGroup($data) {
    echo 'creating table';
    $db = &JFactory::getDBO();
    $group = JTable::getInstance('lit_groups', 'Table');
    $group->bind($data);
    $creationSuccess = $group->store();
    if ($creationSuccess) {
      echo "success";
      return $group->id;
    } else {
      echo "fail";
      return $group->getErrors();
    }
  }

}
