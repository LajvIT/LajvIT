<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * LajvIT View.
 */
class LajvITViewEvents extends JViewLegacy
{
  protected $items;
  protected $pagination;
  protected $canDo;

  /**
   * Events view display method
   * @return void
   */
  function display($tpl = NULL) {
    $items = $this->get('Items');

    $this->canDo = LajvITHelper::getEventActions();

    if (count($errors = $this->get('Errors'))) {
      JError::raiseError(500, implode('<br />', $errors));
      return FALSE;
    }

    $this->items = $items;

    $this->addToolBar();
    parent::display($tpl);
    $this->setDocument();
  }

  /**
   * Setting the toolbar
   */
  protected function addToolBar() {
    $canDo = LajvITHelper::getEventActions();
    JToolBarHelper::title(JText::_('COM_LAJVIT_MANAGER'), 'events');
    if ($canDo->get('core.create')) {
      JToolBarHelper::addNew('event.add', 'JTOOLBAR_NEW');
    }
    if ($canDo->get('core.edit')) {
      JToolBarHelper::editList('event.edit', 'JTOOLBAR_EDIT');
    }
    if ($canDo->get('core.delete')) {
      //JToolBarHelper::deleteList('', 'event.delete', 'JTOOLBAR_DELETE');
    }
    if ($canDo->get('core.admin')) {
      JToolBarHelper::divider();
      JToolBarHelper::preferences('com_lajvit');
    }
  }
  /**
   * Method to set up the document properties
   *
   * @return void
   */
  protected function setDocument() {
    $document = JFactory::getDocument();
    $document->setTitle(JText::_('COM_LAJVIT_ADMINISTRATION'));
  }
}