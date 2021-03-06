<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * View for plots.
 */
class LajvITViewPlot extends JView {
  function getModel($name = "LajvIT") {
    return parent::getModel($name);
  }

  function setModel($name, $default = FALSE) {
    return parent::setModel($name, $default);
  }

  function display($tpl = NULL) {
    $layout = $this->getLayout();
    $model = &$this->getModel();
    $debug = JRequest::getInt('debug', 0);
    $this->assignRef('debug', $debug);

    $itemId = JRequest::getInt('Itemid', 0);
    $this->assignRef('itemId', $itemId);

    $person = &$model->getPerson();
    $this->assignRef('person', $person);

    $eventId = JRequest::getInt('eid', -1);
    $this->assignRef('eventId', $eventId);
    $role = $model->getRoleForEvent($eventId);
    $this->assignRef('role', $role);

    $mergedRole = $role;
    $this->assignRef('mergedrole', $mergedRole);
    $event = $model->getEvent($eventId);
    $this->assignRef('event', $event);
    $plotId = JRequest::getInt('pid', -1);
    $this->assignRef('plotId', $plotId);
    $app = &JFactory::getApplication();

    if ($this->isRestrictedAccessAndNotCreatedByUser($mergedRole, $layout, $person, $plotId, $model)) {
      $this->redirectToList($eventId, $app, $itemId);
    }
    if ($this->isRestrictedModificationsByCreatorUser($mergedRole, $plotId, $model) &&
        $layout != 'listplots' && $layout != 'editplot') {
      $this->redirectToList($eventId, $app, $itemId);
    }

    if ($layout == 'deletesubplotrelation') {
      $this->deleteSubPlotRelation($model);
      $redirectLink = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$eventId.'&pid='. $plotId . '&poid='. $this->plotObjectId . '&Itemid=' . $itemId;
      $app->redirect($redirectLink);
    } elseif ($layout == 'addsubplotrelation') {
      $redirectToEditSubPlot = $this->subPlotRelation($model, $event, $plotId);
      if ($redirectToEditSubPlot) {
        $redirectLink = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$eventId.'&pid='. $plotId . '&poid='. $this->plotObjectId . '&Itemid=' . $itemId;
        $app->redirect($redirectLink);
      }
    }

    if ($layout == 'listplots') {
      $this->displayListPlots($model, $eventId);
    } elseif ($layout == 'editplot') {
      $this->displayEditPlot($model, $plotId, $person);
    } elseif ($layout == 'editsubplot') {
      $this->displayEditSubPlot($model, $plotId);
    } elseif ($layout == 'listdistributedplots') {
      $characterId = JRequest::getInt('cid', -1);
      $this->displayListDistributedPlots($model, $eventId, $person, $characterId);
    }
    parent::display($tpl);
  }

  private function isRestrictedAccessAndNotCreatedByUser($mergedRole, $layout, $person, $plotId, $model) {
    if ($this->isAdminUser($mergedRole) || $plotId <= 0) {
      return FALSE;
    }
    $plotCreatorId = &$model->getPlotCreator($plotId);
    if ($layout != 'listplots' && $person->id != $plotCreatorId) {
      return TRUE;
    }
    return FALSE;
  }

  private function isAdminUser($mergedRole) {
    if (is_array($mergedRole) || is_object($mergedRole) && ((array_key_exists('character_setstatus', $mergedRole) &&
          $mergedRole->character_setstatus) ||
        (array_key_exists('registration_setstatus', $mergedRole) &&
          $mergedRole->registration_setstatus) ||
        (array_key_exists('registration_setrole', $mergedRole) &&
          $mergedRole->registration_setrole)) ) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  private function isRestrictedModificationsByCreatorUser($mergedRole, $plotId, $model) {
    if ($this->isAdminUser($mergedRole) || $plotId <= 0) {
      return FALSE;
    }
    $plotStatus = $model->getPlotStatus($plotId);
    if ($plotStatus->id == 100 || $plotStatus->id == 101) {
      return FALSE;
    } else {
      return TRUE;
    }
  }

  private function displayListPlots($model, $eventId) {
    $plots = $model->getPlotsForEvent($eventId);
    $orderBy = JRequest::getString('orderBy', "");
    $direction = JRequest::getString('sortOrder', "ASC");
    foreach ($plots as $plot) {
      $person = &$model->getPerson($plot->creatorpersonid);
      $plot->plotCreatorName = $person->givenname . "&nbsp;" . $person->surname;
    }
    if ($orderBy != "") {
      $this->orderArrayOfObjectsBy($plots, $orderBy, $direction);
      $this->assignRef('sortOrder', $direction);
    }
    $this->assignRef('orderBy', $orderBy);
    $this->assignRef('plots', $plots);
  }

  private function orderMultiDimensionArrayBy(&$data, $field) {
    $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
    uasort($data, create_function('$a,$b', $code));
  }
  private function orderArrayOfObjectsBy(&$data, $field, $direction) {
    if ($direction == "DESC") {
      $code = "return strnatcmp(\$b->".$field.", \$a->".$field.");";
    } else {
      $code = "return strnatcmp(\$a->".$field.", \$b->".$field.");";
    }
    usort($data, create_function('$a,$b', $code));
  }

  private function displayListDistributedPlots($model, $eventId, $person, $characterId) {
    $characterPlots = $culturePlots = $conceptPlots = $factionPlots = array();
    if ($model->isCharacterOwnedByPerson($characterId, $person->id) &&
        $model->hasCharacterPastFirstStatusCheck($characterId)) {
      $characterRegistration = $model->getCharacterRegistrationForEvent($eventId, $characterId, $person->id);
      $cultureId = $characterRegistration->cultureid;
      $conceptId = $characterRegistration->conceptid;
      $factionId = $characterRegistration->factionid;
      $characterPlots = $model->getPlotObjectsDistributedForEventOnCharacter($eventId, $characterId);
      $culturePlots = $model->getPlotObjectsDistributedForEventOnCulture($eventId, $cultureId);
      $conceptPlots = $model->getPlotObjectsDistributedForEventOnConcept($eventId, $conceptId);
      $factionPlots = $model->getPlotObjectsDistributedForEventOnFaction($eventId, $factionId);
    }
    $this->assignRef('plotObjectsCharacter', $characterPlots);
    $this->assignRef('plotObjectsCulture', $culturePlots);
    $this->assignRef('plotObjectsConcept', $conceptPlots);
    $this->assignRef('plotObjectsFaction', $factionPlots);
  }

  private function displayEditPlot($model, $plotId, $person) {
    if ($plotId > 0) {
      $heading = $model->getPlotHeading($plotId);
      $description = $model->getPlotDescription($plotId);
      $status = $model->getPlotStatus($plotId);
      $plotCreatorPersonId = &$model->getPlotCreator($plotId);
      $plotCreator = &$model->getPerson($plotCreatorPersonId);
      $plotCreatorPersonName = $plotCreator->givenname . " " . $plotCreator->surname;
    } else {
      $heading = "";
      $description = "";
      $status = $model->getPlotStatuses(100);
      $status = $status[0];
      $plotCreatorPersonId = $person->id;
      $plotCreatorPersonName = "";
    }
    $plotStatuses = $model->getPlotStatuses();
    $statusId = $status->id;
    $statusName = $status->name;

    $this->assignRef('heading', $heading);
    $this->assignRef('description', $description);
    $this->assignRef('statusId', $statusId);
    $this->assignRef('statusName', $statusName);
    $this->assignRef('status', $plotStatuses);
    $this->assignRef('plotCreatorPersonId', $plotCreatorPersonId);
    $this->assignRef('plotCreatorName', $plotCreatorPersonName);

    $plotObjects = $model->getPlotObjectsForPlot($plotId);
    foreach ($plotObjects as $plotObject) {
      $plotObject->characterRelations = $model->getPlotObjectCharacterRelations($plotObject->id);
      $plotObject->conceptRelations = $model->getPlotObjectConceptRelations($plotObject->id);
      $plotObject->cultureRelations = $model->getPlotObjectCultureRelations($plotObject->id);
      $plotObject->factionRelations = $model->getPlotObjectFactionRelations($plotObject->id);
    }
    $this->assignRef('plotObjects', $plotObjects);
  }

  private function displayEditSubPlot($model, $plotId) {
    $plotObjectId = JRequest::getInt('poid', -1);
    $plotObject = $model->getPlotObject($plotObjectId);
    $plotStatus = $model->getPlotStatus($plotId);
    if ($plotStatus->id == 100 || $plotStatus->id == 101) {
      $plotEditableByCreator = 1;
    } else {
      $plotEditableByCreator = 0;
    }
    if (is_object($plotObject)) {
      $heading = $plotObject->heading;
      $description = $plotObject->description;
    } else {
      $heading = '';
      $description = '';
    }
    $this->assignRef('heading', $heading);
    $this->assignRef('description', $description);
    $this->assignRef('plotObject', $plotObject);
    $this->assignRef('plotObjectId', $plotObjectId);
    $this->assignRef('statusId', $plotStatus->id);

    $this->assignRef('characterRelations', $model->getPlotObjectCharacterRelations($plotObjectId));
    $this->assignRef('conceptRelations', $model->getPlotObjectConceptRelations($plotObjectId));
    $this->assignRef('cultureRelations', $model->getPlotObjectCultureRelations($plotObjectId));
    $this->assignRef('factionRelations', $model->getPlotObjectFactionRelations($plotObjectId));
    $this->assignRef('plotEditableByCreator', $plotEditableByCreator);
  }

  private function deleteSubPlotRelation($model) {
    $relationType = JRequest::getString('rel', '');
    $relId = JRequest::getInt('relid', -1);
    $this->plotObjectId = JRequest::getInt('poid', -1);
    switch ($relationType) {
      case "char":
        $model->deleteSubPlotCharacterRelation($relId, $this->plotObjectId);
        break;
      case "concept":
        $model->deleteSubPlotConceptRelation($relId, $this->plotObjectId);
        break;
      case "culture":
        $model->deleteSubPlotCultureRelation($relId, $this->plotObjectId);
        break;
      case "faction":
        $model->deleteSubPlotFactionRelation($relId, $this->plotObjectId);
        break;
      default:
        break;
    }
  }

  private function subPlotRelation($model, $event) {
    $relationType = JRequest::getString('rel', '');
    $this->plotObjectId = JRequest::getInt('poid', -1);
    $relationObjectId = JRequest::getInt('oid', -1);
    switch ($relationType) {
      case "char":
        $relationObjects = $model->getAllCharactersForEvent($event->id);
        break;
      case "concept":
        $relationObjects = $model->getCharacterConcepts();
        $relationObjects = $this->addCultureNameToConcepts($relationObjects, $model);
        break;
      case "culture":
        $relationObjects = $model->getCharacterCultures();
        break;
      case "faction":
        $relationObjects = $model->getCharacterFactions();
        break;
      default:
        break;
    }
    $this->assignRef('relationType', $relationType);
    $this->assignRef('relationObjects', $relationObjects);
    $this->assignRef('plotObjectId', $this->plotObjectId);
    if ($relationObjectId > 0) {
      $this->addSubPlotRelation($model, $this->plotObjectId, $relationObjectId, $relationType);
      return TRUE;
    }

    return FALSE;
  }

  private function addCultureNameToConcepts($conceptList, $model) {
    $cultures = $model->getCharacterCultures();
    foreach ($conceptList as $concept) {
      $concept->culturename = $cultures[$concept->cultureid]->name;
    }
    return $conceptList;
  }

  private function addSubPlotRelation($model, $plotObjectId, $relationObjectId, $relationType) {
    $relationName = "";
    $errorMsg = FALSE;

    switch ($relationType) {
      case "char":
        if ($model->addSubPlotRelationToCharacter($plotObjectId, $relationObjectId)) {
          $errorMsg = FALSE;
        } else {
          $errorMsg = TRUE;
        }
        $character = &$model->getCharacter($relationObjectId);
        $relationName = $character->knownas;
        break;
      case "concept":
        if ($model->addSubPlotRelationToConcept($plotObjectId, $relationObjectId)) {
          $errorMsg = FALSE;
        } else {
          $errorMsg = TRUE;
        }
        $concept = $model->getCharacterConcept($relationObjectId);
        $relationName = $concept->name;
        break;
      case "culture":
        if ($model->addSubPlotRelationToCulture($plotObjectId, $relationObjectId)) {
          $errorMsg = FALSE;
        } else {
          $errorMsg = TRUE;
        }
        $culture = $model->getCharacterCulture($relationObjectId);
        $relationName = $culture->name;
        break;
      case "faction":
        if ($model->addSubPlotRelationToFaction($plotObjectId, $relationObjectId)) {
          $errorMsg = FALSE;
        } else {
          $errorMsg = TRUE;
        }
        $faction = $model->getCharacterFaction($relationObjectId);
        $relationName = $faction->name;
        break;
      default:
        break;
    }
    $this->assignRef('relationAddedName', $relationName);
    $this->assignRef('errorMsg', $errorMsg);
  }

  private function redirectToList($eventId, $app, $itemId) {
    $redirectLink = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid=' .
        $eventId . '&Itemid=' . $itemId;
    $app->redirect($redirectLink);
  }
}
