<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla view library
jimport('joomla.application.component.view');

/**
 * LajvIT View.
 */
class LajvITViewEvent extends JViewLegacy {
  /**
   * display method of Event view
   * @return void
   */
  public function display($tpl = NULL) {
    // get the Data
    $form = $this->get('Form');
    $item = $this->get('Item');
    $script = $this->get('Script');
    // Check for errors.
    if (count($errors = $this->get('Errors'))) {
      JError::raiseError(500, implode('<br />', $errors));
      return FALSE;
    }
    // Assign the Data
    $this->form = $form;
    $this->item = $item;
    $this->script = $script;
    $this->canDo = LajvITHelper::getEventActions();

    // Set the toolbar
    $this->addToolBar();

    // Display the template
    parent::display($tpl);

    // Set the document
    $this->setDocument();
  }

  /**
   * Setting the toolbar
   */
  protected function addToolBar() {
    JRequest::setVar('hidemainmenu', TRUE);
    $user = JFactory::getUser();
    $userId = $user->id;
    $isNew = $this->item->id == 0;
    $canDo = LajvITHelper::getEventActions($this->item->id);
    JToolBarHelper::title($isNew ? JText::_('COM_LAJVIT_MANAGER_LAJVIT_NEW') : JText::_('COM_LAJVIT_MANAGER_LAJVIT_EDIT'), 'lajvit');
    // Built the actions for new and existing records.
    if ($isNew) {
      // For new records, check the create permission.
      if ($canDo->get('core.create')) {
        JToolBarHelper::apply('event.save', 'JTOOLBAR_APPLY');
        JToolBarHelper::save('event.save', 'JTOOLBAR_SAVE');
        JToolBarHelper::custom('event.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', FALSE);
      }
      JToolBarHelper::cancel('event.cancel', 'JTOOLBAR_CANCEL');
    } else {
      if ($canDo->get('core.edit')) {
        // We can save the new record
        JToolBarHelper::apply('event.apply', 'JTOOLBAR_APPLY');
        JToolBarHelper::save('event.save', 'JTOOLBAR_SAVE');

        // We can save this record, but check the create permission to see if we can return to make a new one.
        if ($canDo->get('core.create')) {
          JToolBarHelper::custom('event.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', FALSE);
        }
      }
      if ($canDo->get('core.create')) {
        JToolBarHelper::custom('event.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', FALSE);
      }
      JToolBarHelper::cancel('event.cancel', 'JTOOLBAR_CLOSE');
    }
  }
  /**
   * Method to set up the document properties
   *
   * @return void
   */
  protected function setDocument() {
    $isNew = $this->item->id == 0;
    $document = JFactory::getDocument();
    $document->setTitle($isNew ? JText::_('COM_LAJVIT_LAJVIT_CREATING') : JText::_('COM_LAJVIT_LAJVIT_EDITING'));
    $document->addScript(JURI::root() . $this->script);
    $document->addScript(JURI::root() . "/administrator/components/com_lajvit/views/event/submitbutton.js");
    JText::script('COM_LAJVIT_LAJVIT_ERROR_UNACCEPTABLE');
  }
}
