<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

class LajvITControllerPlot extends LajvITController {
	var $model = null;
	var $db = null;
	var $person = null;


	function save() {
		$errlink = 'index.php?option=com_lajvit&view=plot';

		$this->model = &$this->getModel();
		$this->db = &JFactory::getDBO();

		$plotId = JRequest::getInt('pid', -1);
		$this->getPlotData($plotId);

		$eventrole = $this->model->getRoleForEvent($this->eventId);
		$this->person = &$this->model->getPerson();

		if ($plotId > 0) {
			if ($role->character_setstatus || $this->plotCreator == $person->id) {
				if (!$this->savePlot($plotId, $this->heading, $this->description, $this->statusId)) {
					return;
				}
			} else {
				// doesn't have rights to save plot
			}
		} else {
			$plotId = $this->createPlot($this->heading, $this->description, $this->statusId, $this->person->id);
			if ($plotId <= 0) {
				return;
			}
		}

		$oklink = 'index.php?option=com_lajvit&view=plot&eid='.$this->eventId.'&pid='.$plotId;
		echo $oklink;
		$this->setRedirect($oklink);

	}

	private function getPlotData($plotId) {
		$this->eventId = JRequest::getInt('eid', -1);
		$this->heading = JRequest::getString('heading', "");
		$this->description = JRequest::getString('description', "");
		$this->statusId = JRequest::getInt('statusId', -1);
		$this->plotCreator = $this->getPlotCreator($plotId);
	}

	private function getPlotCreator($plotId) {
		return $this->model->getPlotCreator($plotId);
	}

	private function savePlot($plotId, $heading, $description, $statusId) {
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

	private function createPlot($heading, $description, $statusId, $personId) {
/*
		$query = 'INSERT INTO #__lit_plot SET heading = "' . $this->db->getEscaped($heading) . '",
							description = "' . $this->db->getEscaped($description) . '",
		  				statusid=' . $this->db->getEscaped($statusId) . ',
		   				creatorpersonid = ' . $this->person->id . ',
		   				created = NOW()';
		$this->db->setQuery($query);
		*/
		$data = new stdClass();
		$data->heading = $heading;
		$data->description = $description;
		$data->statusId = $statusId;
		$data->creatorPersonId = $personId;

		$this->db->insertObject('#__lit_plot', $data);
		if ($this->db->getErrorNum() != 0) {
			echo '<h1>'.$this->db->getErrorMsg().'</h1>';
			//			$this->setRedirect($errlink, $db->getErrorMsg());
			return;
		}
		return $this->db->insertid();
	}

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
}
