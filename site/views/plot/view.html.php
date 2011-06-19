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
		$layout = $this->getLayout();
		$model = &$this->getModel();

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
			$this->redirectToList($eventId, $app);
		}
		if ($this->isRestrictedModificationsByCreatorUser($mergedRole, $plotId, $model)) {
			if ($layout != 'listplots' && $layout != 'editplot') {
				$this->redirectToList($eventId, $app);
			}
		}

		if ($layout == 'deletesubplotrelation') {
			if ($this->isAdminUser($mergedRole)) {
			$this->deleteSubPlotRelation($model);
			$redirectLink = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$eventId.'&pid='. $plotId . '&poid='. $this->plotObjectId;
			$app->redirect($redirectLink);
			} else {
				$this->redirectToList($eventId, $app);
			}
		} elseif ($layout == 'addsubplotrelation') {
			if ($this->isAdminUser($mergedRole)) {
				$redirectToEditSubPlot = $this->subPlotRelation($model, $event, $plotId);
				if ($redirectToEditSubPlot) {
					$redirectLink = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$eventId.'&pid='. $plotId . '&poid='. $this->plotObjectId;
					$app->redirect($redirectLink);
				}
			} else {
				$this->redirectToList($eventId, $app);
			}
		}

		if ($layout == 'listplots') {
			$this->displayListPlots($model, $eventId, $person);
		} elseif ($layout == 'editplot') {
			$this->displayEditPlot($model, $event, $plotId);
		} elseif ($layout == 'editsubplot') {
			$this->displayEditSubPlot($model, $event, $plotId);
		}
		parent::display($tpl);
	}

	private function isRestrictedAccessAndNotCreatedByUser($mergedRole, $layout, $person, $plotId, $model) {
		if ($this->isAdminUser($mergedRole) || $plotId <= 0) {
			return false;
		}
		$plotCreatorId = &$model->getPlotCreator($plotId);
		if ($layout != 'listplots' && $person->id != $plotCreatorId) {
			return true;
		}
		return false;
	}

	private function isAdminUser($mergedRole) {
		if ($mergedRole->character_setstatus || $mergedRole->registration_setstatus || $mergedRole->registration_setrole) {
			return true;
		} else {
			return false;
		}
	}

	private function isRestrictedModificationsByCreatorUser($mergedRole, $plotId, $model) {
		if ($this->isAdminUser($mergedRole) || $plotId <= 0) {
			return false;
		}
		$plotStatus = $model->getPlotStatus($plotId);
		if ($plotStatus->id == 100 || $plotStatus->id == 101) {
			return false;
		} else {
			return true;
		}
	}

	private function displayListPlots($model, $eventId) {
		$plots = $model->getPlotsForEvent($eventId);
		$this->assignRef('plots', $plots);
	}

	private function displayEditPlot($model, $event, $plotId, $person) {
		if ($plotId > 0) {
			$heading = $model->getPlotHeading($plotId);
			$description = $model->getPlotDescription($plotId);
			$status = $model->getPlotStatus($plotId);
			$plotCreatorPersonId = &$model->getPlotCreator($plotId);
		} else {
			$heading = "";
			$description = "";
			$status = $model->getPlotStatuses(100);
			$status = $status[0];
			$plotCreatorPersonId = $person->id;
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

		$plotObjects = $model->getPlotObjectsForPlot($plotId);
		foreach ($plotObjects as $plotObject) {
			$plotObject->characterRelations = $model->getPlotObjectCharacterRelations($plotObject->id);
			$plotObject->conceptRelations = $model->getPlotObjectConceptRelations($plotObject->id);
			$plotObject->cultureRelations = $model->getPlotObjectCultureRelations($plotObject->id);
			$plotObject->factionRelations = $model->getPlotObjectFactionRelations($plotObject->id);
		}
		$this->assignRef('plotObjects', $plotObjects);
	}

	private function displayEditSubPlot($model, $event, $plotId) {
		$plotObjectId = JRequest::getInt('poid', -1);
		$plotObject = $model->getPlotObject($plotObjectId);
		$plotStatus = $model->getPlotStatus($plotId);
		if ($plotStatus->id == 100 || $plotStatus->id == 101) {
			$plotEditableByCreator = 1;
		} else {
			$plotEditableByCreator = 0;
		}
		$heading = $plotObject->heading;
		$description = $plotObject->description;
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

	private function subPlotRelation($model, $event, $plotId) {
		$relationType = JRequest::getString('rel', '');
		$this->plotObjectId = JRequest::getInt('poid', -1);
		$relationObjectId = JRequest::getInt('oid', -1);
		switch ($relationType) {
			case "char":
				$relationObjects = $model->getAllCharactersForEvent($event->id);
				break;
			case "concept":
				$relationObjects = $model->getCharacterConcepts();
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
			$this->addSubPlotRelation($model, $event, $plotId, $this->plotObjectId, $relationObjectId, $relationType);
			return TRUE;
		}

		return false;
	}

	private function addSubPlotRelation($model, $event, $plotId, $plotObjectId, $relationObjectId, $relationType) {
		$relationName = "";
		$errorMsg = false;

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

	private function redirectToList($eventId, $app) {
		$redirectLink = 'index.php?option=com_lajvit&view=plot&layout=listplots&eid='.$eventId;
		$app->redirect($redirectLink);
	}
}
