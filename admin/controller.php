<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// import Joomla controller library
jimport('joomla.application.component.controller');

/**
 * General Controller of LajvIT component.
 */
class LajvITController extends JController
{
  /**
   * display task
   *
   * @return void
   */
  function display($cachable = FALSE) {
    JRequest::setVar('view', JRequest::getCmd('view', 'events'));
    parent::display($cachable);
    LajvitHelper::addSubmenu('events');
  }
}