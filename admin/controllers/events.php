<?php
defined('_JEXEC') or die('Restricted access');

// import Joomla controllerform library
jimport('joomla.application.component.controllerform');

/**
 * Events Controller.
 */
class LajvITControllerEvents extends JControllerForm {
  /**
   * Proxy for getModel.
   * @since	1.6
   */
  public function getModel($name = 'Event', $prefix = 'LajvITModel') {
    $model = parent::getModel($name, $prefix, array('ignore_request' => TRUE));
    return $model;
  }
}
