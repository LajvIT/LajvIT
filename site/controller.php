<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
 */
 
// No direct access
 
defined( '_JEXEC' ) or die( 'Restricted access' );
 
jimport('joomla.application.component.controller');
 
/**
 * Hello World Component Controller
 *
 * @package    Joomla.Tutorials
 * @subpackage Components
 */
class LajvITController extends JController {
	/**
	* Method to display the view
	*
	* @access    public
	*/
	function display($cachable = false) {
		$document = &JFactory::getDocument();
		
		$viewType = $document->getType();
		$viewName = JRequest::getCmd('view', $this->getName());
		$viewLayout = JRequest::getCmd('layout', 'default');
		
		$user = &JFactory::getUser();
    	if (!$user || $user->guest) {
			$redirectUrl = 'index.php?option=com_lajvit&view=' . $viewName . '&layout=' . $viewLayout;
			$this->setRedirect('index.php?option=com_user&view=login&return=' . base64_encode($redirectUrl));
			return;
    	}
		
		$view = &$this->getView($viewName, $viewType, '', array('base_path' => $this->_basePath));
		
		// Get/Create the model
//		if ($model = &$this->getModel($viewName)) {
		if ($model = &$this->getModel($this->getName())) {
			// Push the model into the view (as default)
			$view->setModel($model, true);
		}
		
		// Set the layout
		$view->setLayout($viewLayout);
		
		// Display the view
		if ($cachable && $viewType != 'feed') {
			global $option;
			$cache =& JFactory::getCache($option, 'view');
			$cache->get($view, 'display');
		} else {
			$view->display();
		}
	}

}
