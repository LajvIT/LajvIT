<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modelitem');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * LajvIT Model.
 */
class LajvITModelPerson extends JModelItem {

  /**
   * @param int $id
   * @return string
   */
  public function getPersonNameFromId($id) {
    $db = $this->getDbo();
    $query = $db->getQuery(TRUE);

    $query->select('givenname, surname');
    $query->from('#__lit_person');
    $query->where('id = ' . $id);
    $db->setQuery($query);
    $data = $db->loadObject();
    return $data->givenname . " " . $data->surname;

  }
}
