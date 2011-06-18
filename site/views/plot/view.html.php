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

		$eventId = JRequest::getInt('eid', -1);
		$this->assignRef('eventId', $eventId);
		$event = $model->getEvent($eventId);
		$this->assignRef('event', $event);
		$plotId = JRequest::getInt('pid', -1);
		$this->assignRef('plotId', $plotId);
		$app = &JFactory::getApplication();

		if ($layout == 'deletesubplotrelation') {
			$this->deleteSubPlotRelation($model);
			$redirectLink = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$eventId.'&pid='. $plotId . '&poid='. $this->plotObjectId;
			$app->redirect($redirectLink);
		} elseif ($layout == 'addsubplotrelation') {
			$redirectToEditSubPlot = $this->subPlotRelation($model, $event, $plotId);
			if ($redirectToEditSubPlot) {
				$redirectLink = 'index.php?option=com_lajvit&view=plot&layout=editsubplot&eid='.$eventId.'&pid='. $plotId . '&poid='. $this->plotObjectId;
				$app->redirect($redirectLink);
			}
		}

		if ($layout == 'editplot') {
			$this->displayEditPlot($model, $event, $plotId);
		} elseif ($layout == 'editsubplot') {
			$this->displayEditSubPlot($model, $event, $plotId);
		}

		$role = $model->getRoleForEvent($eventId);
		$this->assignRef('role', $role);

		$mergedrole = $role;
		$this->assignRef('mergedrole', $mergedrole);

		parent::display($tpl);
	}

	private function displayEditPlot($model, $event, $plotId) {

		$heading = $model->getPlotHeading($plotId);
		$description = $model->getPlotDescription($plotId);
		// TODO: get statusid from database
		$statusId = 100;
		$this->assignRef('heading', $heading);
		$this->assignRef('description', $description);
		$this->assignRef('statusId', $statusId);

		$plotObjects = $model->getPlotObjectsForPlot($plotId);
		$this->assignRef('plotObjects', $plotObjects);
	}

	private function displayEditSubPlot($model, $event, $plotId) {
		$plotObjectId = JRequest::getInt('poid', -1);
		$plotObject = $model->getPlotObject($plotObjectId);
		$heading = $plotObject->heading;
		$description = $plotObject->description;
		$this->assignRef('heading', $heading);
		$this->assignRef('description', $description);
		$this->assignRef('plotObject', $plotObject);
		$this->assignRef('plotObjectId', $plotObjectId);

		$this->assignRef('characterRelations', $model->getPlotObjectCharacterRelatations($plotObjectId));
		$this->assignRef('conceptRelations', $model->getPlotObjectConceptRelatations($plotObjectId));
		$this->assignRef('cultureRelations', $model->getPlotObjectCultureRelatations($plotObjectId));
		$this->assignRef('factionRelations', $model->getPlotObjectFactionRelatations($plotObjectId));
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
}
