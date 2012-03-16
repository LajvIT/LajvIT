<?php
defined('_JEXEC') or die('Restricted access');
jimport('joomla.application.component.view');

/**
 * View for anmalan.
 */
class LajvITViewAnmalan extends JView {
  function display($tpl = NULL) {
    $model = &$this->getModel();
    $greeting = $model->getGreeting();
    $this->assignRef( 'greeting', $greeting );
    $this->assignRef('itemid', JRequest::getInt('Itemid', 0));

    parent::display($tpl);
  }
}
