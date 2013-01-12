<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_lajvit')) {
        return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}
// require helper file
JLoader::register('LajvITHelper', dirname(__FILE__) . DS . 'helpers' . DS . 'lajvit.php');

jimport('joomla.application.component.controller');

$controller = JController::getInstance('LajvIT');

// Perform the Request task
//$input = JFactory::getApplication()->input;

// $controller->execute($input->getCmd('task'));
$controller->execute(JRequest::getCmd('task'));

// Redirect if set by the controller
$controller->redirect();
