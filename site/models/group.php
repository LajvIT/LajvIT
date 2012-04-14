<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * LajvIT Model.
 */
class LajvITModelGroup extends JModel {
  /**
   * Gets the greeting
   * @return string The greeting to be displayed to the user
   */
  function getGreeting() {
    return 'Hello, World!';
  }

  function createGroup($data) {
    echo 'creating table';
  }

}
