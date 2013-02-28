<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the LajvITViewGroups Component.
 */
class LajvITViewGroups extends JViewLegacy {

  function getModel($name = NULL) {
    return parent::getModel($name);
  }

  function setModel($name, $default = FALSE) {
    return parent::setModel($name, $default);
  }

  function display($tpl = NULL) {
    $state = $this->get('State');
    $items = $this->get('Items');
    $model = $this->getModel();
    JHtml::stylesheet('com_lajvit/lajvit.css', array(), TRUE);
    $this->assignRef('items', $items);
    $groupModel = &JModel::getInstance('group', 'lajvitmodel');
    $this->assignRef('groupModel', $groupModel);

    $this->message = JRequest::getString('message', '');
    $this->group = JRequest::getString('group', '');
    $this->errorMsg = JRequest::getString('errorMsg', '');
    $this->assignRef('eventId', JRequest::getInt('eid', 0));
    $this->assignRef('itemId', JRequest::getInt('Itemid', 0));

    parent::display($tpl);
  }
}

