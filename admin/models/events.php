<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.modellist');

/**
 * Events Model.
 */
class LajvItModelEvents extends JModelList {
  /**
   * Method to build an SQL query to load the list data.
   *
   * @return	string	An SQL query
   */
  protected function getListQuery() {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select('id,name');

    $query->from('#__lit_event');
    return $query;
  }
}
