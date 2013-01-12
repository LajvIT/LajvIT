<?php
defined('_JEXEC') or die('Restricted access');

// import Joomla modelform library
jimport('joomla.application.component.modeladmin');
JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * Event Model.
 */
class LajvITModelEvent extends JModelAdmin {
  /**
   * Method override to check if you can edit an existing record.
   *
   * @param	array	$data	An array of input data.
   * @param	string	$key	The name of the key for the primary key.
   *
   * @return	boolean
   * @since	1.6
   */
  protected function allowEdit($data = array(), $key = 'id') {
    // Check specific edit permission then general edit permission.
    return JFactory::getUser()->authorise('core.edit', 'com_lajvit.event.'.((int) isset($data[$key]) ? $data[$key] : 0)) or parent::allowEdit($data, $key);
  }
  /**
   * Returns a reference to the a Table object, always creating it.
   *
   * @param	type	The table type to instantiate
   * @param	string	A prefix for the table class name. Optional.
   * @param	array	Configuration array for model. Optional.
   * @return	JTable	A database object
   * @since	1.6
   */
  public function getTable($type = 'Event', $prefix = 'TableLIT_', $config = array()) {
    return JTable::getInstance($type, $prefix, $config);
  }
  /**
   * Method to get the record form.
   *
   * @param	array	$data		Data for the form.
   * @param	boolean	$loadData	True if the form is to load its own data (default case), FALSE if not.
   * @return	mixed	A JForm object on success, FALSE on failure
   * @since	1.6
   */
  public function getForm($data = array(), $loadData = TRUE) {
    // Get the form.
    $form = $this->loadForm('com_lajvit.lajvit', 'event', array('control' => 'jform', 'load_data' => $loadData));
    if (empty($form)) {
      return FALSE;
    }
    return $form;
  }
  /**
   * Method to get the script that have to be included on the form
   *
   * @return string	Script files
   */
  public function getScript() {
    return 'administrator/components/com_lajvit/models/forms/event.js';
  }
  /**
   * Method to get the data that should be injected in the form.
   *
   * @return	mixed	The data for the form.
   * @since	1.6
   */
  protected function loadFormData() {
    // Check the session for previously entered form data.
    $data = JFactory::getApplication()->getUserState('com_lajvit.edit.event.data', array());
    if (empty($data)) {
      $data = $this->getItem();
    }
    return $data;
  }
}
