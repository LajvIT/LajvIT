<?php

defined('_JEXEC') or die('Restricted access');

/**
 * Controller for Plot.
 */
class LajvITControllerPlot extends LajvITController {
  var $model = NULL;
  var $db = NULL;
  var $person = NULL;
  var $eventId = 1;
  var $heading = 2;
  var $description = 3;
  var $statusId = 4;
  var $plotCreator = 5;
  var $plotObjectId = 7;
  var $plotId = NULL;

  function __construct() {
    parent::__construct();
    //Register Extra tasks
    $this->registerTask('savePlot', 'savePlot');
    $this->registerTask('savePlotObject', 'savePlotObject');
  }

  function savePlot() {
    $errlink = 'index.php?option=com_lajvit&view=plot&layout=editplot&Itemid='.JRequest::getInt('Itemid', 0);

    $this->model = &$this->getModel();
    $this->db = &JFactory::getDBO();

    $plotId = JRequest::getInt('pid', -1);
    $this->getPlotData($plotId);

    $eventrole = $this->model->getRoleForEvent($this->eventId);
    $this->person = &$this->model->getPerson();

    if ($plotId > 0) {
      if ($this->isCreatedByUserAndEditableOrAdmin($eventrole, $this->person)) {
        if (!$this->updatePlot($plotId, $this->heading, $this->description, $this->statusId, $this->eventId)) {
          $redirect = 'index.php?option=com_lajvit&view=plot&layout=editplot&eid='.$this->eventId.'&pid='.$plotId.'&Itemid='.JRequest::getInt('Itemid', 0);
        }
        $redirect = 'index.php?option=com_lajvit&view=plot&layout=editplot&eid='.$this->eventId.'&pid='.$plotId.'&Itemid='.JRequest::getInt('Itemid', 0);
      } else {
        $redirect = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid='.$this->eventId.'&Itemid='.JRequest::getInt('Itemid', 0);
      }
    } else {
      $plotId = $this->createPlot($this->heading, $this->description, $this->statusId, $this->person->id, $this->eventId);
      if ($plotId <= 0) {
        $redirect = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid='.$this->eventId.'&Itemid='.JRequest::getInt('Itemid', 0);
      } else {
        $redirect = 'index.php?option=com_lajvit&view=plot&layout=editplot&eid='.$this->eventId.'&pid='.$plotId.'&Itemid='.JRequest::getInt('Itemid', 0);
      }
    }
    $this->setRedirect($redirect);
  }

  function savePlotObject() {
    echo " savePlotObject ";
    $errlink = 'index.php?option=com_lajvit&view=plot&Itemid='.JRequest::getInt('Itemid', 0);

    $this->model = &$this->getModel();
    $this->db = &JFactory::getDBO();

    $this->plotId = JRequest::getInt('pid', -1);
    $this->getPlotData($this->plotId);

    $this->plotObjectId = JRequest::getInt('poid', -1);
    if ($this->plotObjectId > 0 ) {
      $this->getPlotObjectData($this->plotObjectId);
    }

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
        $redirect = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$this->eventId.'&pid='. $this->plotId . '&poid='. $this->plotObjectId.'&Itemid='.JRequest::getInt('Itemid', 0);
      } else {
        echo "may not update ";
        $redirect = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid='.$this->eventId.'&Itemid='.JRequest::getInt('Itemid', 0);
      }
    } else {
      echo " creating plotobject ";
      $this->plotObjectId = $this->createPlotObject($this->heading, $this->description, $this->plotId);
      if ($this->plotObjectId <= 0) {
        echo "creation complete ";
        //return;
        $redirect = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid='.$this->eventId.'&Itemid='.JRequest::getInt('Itemid', 0);
      } else {
        $redirect = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$this->eventId.'&pid='. $this->plotId . '&poid='. $this->plotObjectId.'&Itemid='.JRequest::getInt('Itemid', 0);
      }
    }

    $this->setRedirect($redirect);
  }

  private function isCreatedByUserAndEditableOrAdmin($eventRole, $person) {
    echo "isCreatedByUserAndEditableOrAdmin";
    echo $person->id . "," . $this->plotCreator .",(".$this->statusId.")";
    if ($eventRole->character_setstatus || $eventRole->registration_setstatus || $eventRole->registration_setrole) {
      return TRUE;
    } elseif ($person->id == $this->plotCreator && ($this->statusId == 100 || $this->statusId == 101)) {
      return TRUE;
    }
    return FALSE;
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
      //        $this->setRedirect($errlink, $db->getErrorMsg());
      return FALSE;
    }
    return TRUE;
  }


  private function setPlotUpdatedTime($plotId) {
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
      //      $this->setRedirect($errlink, $db->getErrorMsg());
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
      //      $this->setRedirect($errlink, $db->getErrorMsg());
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
      //        $this->setRedirect($errlink, $db->getErrorMsg());
      return FALSE;
    }
    $this->setPlotUpdatedTime($this->plotId);
    return TRUE;
  }

  private function getPlotObjectData($plotObjectId) {
    echo " getPlotObjectData  ";
    $plotObject = $this->model->getPlotObject($plotObjectId);
    $this->plotId = $plotObject->plotid;
    $this->plotObjectHeading = $plotObject->heading;
    $this->plotObjectDescription = $plotObejct->description;
  }
}
