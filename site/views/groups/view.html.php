<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component.
 */
class LajvITViewGroup extends JView {
  function display($tpl = NULL) {
    $model = &$this->getModel('groups');
    $layout = $this->getLayout();
    $user = &JFactory::getUser($userid);

    $this->assignRef('eventId', JRequest::getInt('eid', 0));
    $this->assignRef('itemId', JRequest::getInt('Itemid', 0));
    parent::display($tpl);
  }
}
