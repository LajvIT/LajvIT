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
    $groupModel = JModel::getInstance('group', 'lajvitmodel');
    $this->assignRef('groupModel', $groupModel);
    $lajvitModel = JModel::getInstance('lajvit', 'lajvitmodel');
    $this->assignRef('lajvitModel', $lajvitModel);
    $eventId = JRequest::getInt('eid', 0);

    $this->message = JRequest::getString('message', '');
    $this->group = JRequest::getString('group', '');
    $this->errorMsg = JRequest::getString('errorMsg', '');
    $this->assignRef('eventId', $eventId);
    $this->assignRef('itemId', JRequest::getInt('Itemid', 0));

    $this->state = $this->get('State');
    $this->displayBreadcrumb($eventId);

    parent::display($tpl);
  }

  private function displayBreadcrumb($eventId) {
    $app = JFactory::getApplication();
    $pathway = $app->getPathway();
    $layout = $this->getLayout();
    $model = JModel::getInstance('lajvit', 'lajvitmodel');
    $events = $model->getEventsForPerson();
    if ($eventId > 0) {
      $currentEventName = $events[$eventId]->shortname;
      $pathway->addItem($currentEventName, '');
    }
    switch ($layout) {
      case 'add':
        $pathway->addItem('Skapa', '');
        break;
      case 'delete':
        $pathway->addItem('Ta bort', '');
        break;
      case 'edit':
        $pathway->addItem('Redigera', '');
        break;
      case 'register':
        $pathway->addItem('Registrera', '');
        break;
      case 'registered':
        break;
      default:
        break;
    }
  }
}

