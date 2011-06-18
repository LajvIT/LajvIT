<?php
/**
 * @package    Joomla.Tutorials
 * @subpackage Components
 * @link http://docs.joomla.org/Developing_a_Model-View-Controller_Component_-_Part_1
 * @license    GNU/GPL
 */

// no direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');


class LajvITViewPlot extends JView {
	function display($tpl = null) {
		$model = &$this->getModel();

		$eventid = JRequest::getInt('eid', -1);
		$this->assignRef('eventid', $eventid);
		$event = $model->getEvent($eventid);
		$this->assignRef('event', $event);

		$plotId = JRequest::getInt('pid', -1);
		$this->assignRef('plotId', $plotId);

		$role = $model->getRoleForEvent($eventid);
		$this->assignRef('role', $role);

		$mergedrole = $role;
		$this->assignRef('mergedrole', $mergedrole);

		$heading = $model->getPlotHeading($plotId);
		$description = $model->getPlotDescription($plotId);
		// TODO: get statusid from database
		$statusId = 100;
		$this->assignRef('heading', $heading);
		$this->assignRef('description', $description);
		$this->assignRef('statusId', $statusId);

		$plotObjects = $model->getPlotObjectsForPlot($plotId);
		$this->assignRef('plotObjects', $plotObjects);

		parent::display($tpl);
	}
}
