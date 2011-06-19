<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class LajvITControllerPlot extends LajvITController {
	var $model = null;
	var $db = null;
	var $person = null;
	var $eventId = 1;
	var $heading = 2;
	var $description = 3;
	var $statusId = 4;
	var $plotCreator = 5;
	var $plotObjectId = 7;
	var $plotId = null;

	function __construct()
	{
		parent::__construct();
		//Register Extra tasks
		$this->registerTask( 'savePlot', 'savePlot' );
		$this->registerTask( 'savePlotObject', 'savePlotObject' );
	}

	function savePlot() {
		$errlink = 'index.php?option=com_lajvit&view=plot&layout=editplot';

		$this->model = &$this->getModel();
		$this->db = &JFactory::getDBO();

		$plotId = JRequest::getInt('pid', -1);
		$this->getPlotData($plotId);

		$eventrole = $this->model->getRoleForEvent($this->eventId);
		$this->person = &$this->model->getPerson();

		if ($plotId > 0) {
			if ($this->isCreatedByUserAndEditableOrAdmin($eventrole, $this->person)) {
				if (!$this->updatePlot($plotId, $this->heading, $this->description, $this->statusId, $this->eventId)) {
					$redirect = 'index.php?option=com_lajvit&view=plot&layout=editplot&eid='.$this->eventId.'&pid='.$plotId;
				}
				$redirect = 'index.php?option=com_lajvit&view=plot&layout=editplot&eid='.$this->eventId.'&pid='.$plotId;
			} else {
				$redirect = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid='.$this->eventId;
			}
		} else {
			$plotId = $this->createPlot($this->heading, $this->description, $this->statusId, $this->person->id, $this->eventId);
			if ($plotId <= 0) {
				$redirect = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid='.$this->eventId;
			} else {
				$redirect = 'index.php?option=com_lajvit&view=plot&layout=editplot&eid='.$this->eventId.'&pid='.$plotId;
			}
		}
		$this->setRedirect($redirect);
	}

	function savePlotObject() {
		echo " savePlotObject ";
		$errlink = 'index.php?option=com_lajvit&view=plot';

		$this->model = &$this->getModel();
		$this->db = &JFactory::getDBO();

		$this->plotId = JRequest::getInt('pid', -1);
		$this->getPlotData($this->plotId);

		$this->plotObjectId = JRequest::getInt('poid', -1);
		if (plotObjectId > 0 ) { $this->getPlotObjectData($this->plotObjectId); }

		$eventrole = $this->model->getRoleForEvent($this->eventId);
		$this->person = &$this->model->getPerson();

		if ($this->plotObjectId > 0) {
			//echo "plotobjectid:" . $this->plotObjectId;
			if ($this->isCreatedByUserAndEditableOrAdmin($eventrole, $this->person)) {
				echo "may update ";
				if (!$this->updatePlotObject($this->plotObjectId, $this->heading, $this->description, $this->statusId)) {
					echo "update complete ";
					//return;
				}
				$redirect = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$this->eventId.'&pid='. $this->plotId . '&poid='. $this->plotObjectId;
			} else {
				echo "may not update ";
				$redirect = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid='.$this->eventId;
			}
		} else {
			echo " creating plotobject ";
			$this->plotObjectId = $this->createPlotObject($this->heading, $this->description, $this->plotId);
			if ($this->plotObjectId <= 0) {
				echo "creation complete ";
				//return;
				$redirect = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid='.$this->eventId;
			} else {
				$redirect = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$this->eventId.'&pid='. $this->plotId . '&poid='. $this->plotObjectId;
			}
		}

		$this->setRedirect($redirect);
	}

	private function isCreatedByUserAndEditableOrAdmin($eventRole, $person) {
		echo "isCreatedByUserAndEditableOrAdmin";
		echo $person->id . "," . $this->plotCreator .",(".$this->statusId.")";
		if ($eventRole->character_setstatus || $eventRole->registration_setstatus || $eventRole->registration_setrole) {
			return true;
		} elseif ($person->id == $this->plotCreator && ($this->statusId == 100 || $this->statusId == 101)) {
			return true;
		}
		return false;
	}

	private function getPlotData($plotId) {
		echo " getPlotData ";
		$this->eventId = JRequest::getInt('eid', -1);
		$this->heading = JRequest::getString('heading', "");
		$this->description = JRequest::getString('description', "");
		$this->statusId = JRequest::getInt('statusId', -1);
		$this->plotCreator = $this->getPlotCreator($plotId);
	}

	private function getPlotCreator($plotId) {
		echo " getPlotCreator ";
		return $this->model->getPlotCreator($plotId);
	}

	private function updatePlot($plotId, $heading, $description, $statusId) {
		echo " updatePlot ";
		$query = 'UPDATE #__lit_plot SET heading = "' . $this->db->getEscaped($heading) . '",
							description = "' . $this->db->getEscaped($description) . '",
		  				statusid=' . $this->db->getEscaped($statusId) . ',
		   				updated = NOW(), lockedbypersonid = NULL, lockedat = NULL
		    			WHERE id=' . $this->db->getEscaped($plotId) . ';';

		$this->db->setQuery($query);

		if (!$this->db->query()) {
			echo '<h1>'.$this->db->getErrorMsg().'</h1>';
			// TODO: fix redirect
			//				$this->setRedirect($errlink, $db->getErrorMsg());
			return false;
		}
		return true;
	}


	private function setPlotUpdatedTime($plotId) {
		echo " setPlotUpdateTime ";
		$query = 'UPDATE #__lit_plot SET updated = NOW()
		    			WHERE id=' . $this->db->getEscaped($plotId) . ';';

		//echo $query;
		$this->db->setQuery($query);
		$this->db->query();
	}

	private function createPlot($heading, $description, $statusId, $personId, $eventid) {
		echo " createPlot ";
		$data = new stdClass();
		$data->heading = $heading;
		$data->description = $description;
		$data->statusId = $statusId;
		$data->creatorPersonId = $personId;
		$data->eventid = $eventid;
		$data->created = date('Y-m-d H:i:s');

		$this->db->insertObject('#__lit_plot', $data);
		if ($this->db->getErrorNum() != 0) {
			echo '<h1>'.$this->db->getErrorMsg().'</h1>';
			//			$this->setRedirect($errlink, $db->getErrorMsg());
			return;
		}
		return $this->db->insertid();
	}

	private function createPlotObject($heading, $description, $plotId) {
		echo " createPlotObject  ";
		$data = new stdClass();
		$data->heading = $heading;
		$data->description = $description;
		$data->plotid = $plotId;
		print_r($data);
		$this->db->insertObject('#__lit_plotobject', $data);
		if ($this->db->getErrorNum() != 0) {
			echo '<h1>'.$this->db->getErrorMsg().'</h1>';
			//			$this->setRedirect($errlink, $db->getErrorMsg());
			return;
		}
		return $this->db->insertid();
	}

	private function updatePlotObject($plotObjectId, $heading, $description) {
		echo " updatePlotObject  ";
		$this->getPlotObjectData($plotObjectId);
		$query = 'UPDATE #__lit_plotobject SET heading = "' . $this->db->getEscaped($heading) . '",
							description = "' . $this->db->getEscaped($description) . '"
		    			WHERE id=' . $this->db->getEscaped($plotObjectId) . ';';

		$this->db->setQuery($query);

		if (!$this->db->query()) {
			echo '<h1>'.$this->db->getErrorMsg().'</h1>';
			// TODO: fix redirect
			//				$this->setRedirect($errlink, $db->getErrorMsg());
			return false;
		}
		$this->setPlotUpdatedTime($this->plotId);
		return true;
	}

	private function getPlotObjectData($plotObjectId) {
		echo " getPlotObjectData  ";
		$plotObject = $this->model->getPlotObject($plotObjectId);
		$this->plotId = $plotObject->plotid;
		$this->plotObjectHeading = $plotObject->heading;
		$this->plotObjectDescription = $plotObejct->description;
	}
/*
	function foo() {

	if ($role->character_setstatus && $statusid > 0) {
		$query = 'UPDATE #__lit_registrationchara SET statusid='.$db->getEscaped($statusid).' WHERE eventid='.$db->getEscaped($eventid).' AND personid='.$db->getEscaped($personid).' AND charaid='.$db->getEscaped($charid).";\n";

		$db->setQuery($query);

		if (!$db->query()) {
			echo '<h1>'.$db->getErrorMsg().'</h1>';
			//				$this->setRedirect($errlink, $db->getErrorMsg());
			return;
		}
	}
	}
	*/
}
