<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * HTML View class for the HelloWorld Component.
 */
class LajvITViewGroup extends JView {

  /**
   * @var LajvITModelGroup
   */
  protected $model;
  /**
   *
   * @var LajvITModelLajvIT
   */
  protected $lajvitModel;
  /**
   *
   * @var LajvITModelGroup
   */
  protected $groupModel;

  function getModel($name = NULL) {
    return parent::getModel($name);
  }

  function setModel($name, $default = FALSE) {
    return parent::setModel($name, $default);
  }

  function display($tpl = NULL) {
    JHtml::stylesheet('com_lajvit/lajvit.css', array(), TRUE);
    $this->model = $this->getModel();
    $this->lajvitModel = $this->getModel("LajvIT");
    $this->groupModel = $this->getModel("Group");
    $layout = $this->getLayout();
    $noGroupId = -1;
    $eventId = JRequest::getInt('eid', -1);
    $groupId = JRequest::getInt('groupId', -1);
    $this->message = JRequest::getString('message', '');
    $this->character = JRequest::getString('character', '');
    $this->errorMsg = JRequest::getString('errorMsg', '');
    $canDo = GroupHelper::getActions($groupId);
    $factions = $this->lajvitModel->getCharacterFactions();

    $this->assignRef('eventId', $eventId);
    $this->assignRef('groupId', $groupId);
    $this->assignRef('itemId', JRequest::getInt('Itemid', 0));
    $this->assignRef('factions', $factions);
    $this->assignRef('mymodel', $this->getModel("LajvIT"));
    if ($layout == 'edit' && !$this->canEditGroup($groupId)) {
      $this->setLayout('default');
    }
    if (($layout == 'edit' || $layout == 'default') && $groupId > 0) {
      $group = $this->model->getGroup($groupId);
      if (!$group) {
        $this->errorMsg = "COM_LAJVIT_GET_GROUP_FAILED";
        $this->assignRef('groupId', $noGroupId);
        $this->setLayout('error');
      } else {
        $this->charactersInGroup = $this->model->getCharactersInGroup($groupId);
        $this->getPersonDataForCharacters($this->charactersInGroup, $group['eventId']);
        $currentGroupStatus = '';
        $currentGroupStatus = $group['status'];
        $this->setGroupData($group);
      }
    } elseif ($layout == 'addchartogroup') {
      $this->charactersForEvent($groupId);
    }
    parent::display($tpl);
  }

  private function canEditGroup($groupId) {
    $canDo = GroupHelper::getActions($groupId);
    $user = JFactory::getUser();
    if ($canDo->get('core.edit')) {
      return TRUE;
    }
    if ($canDo->get('core.edit.own') &&
        $this->model->isPersonGroupLeaderForGroup($user->id, $groupId)) {
      return TRUE;
    }
    return FALSE;
  }

  private function setGroupData($group) {
    $this->assignRef('groupName', $group['name']);
    $this->assignRef('groupPublicDescription', $group['descriptionPublic']);
    $this->assignRef('groupPrivateDescription', $group['descriptionPrivate']);
    $this->assignRef('groupMaxParticipants', $group['maxParticipants']);
    $this->assignRef('groupExpectedParticipants', $group['expectedParticipants']);
    $this->assignRef('groupAdminInfo', $group['adminInformation']);
    $this->assignRef('groupUrl', $group['url']);
    $this->assignRef('groupVisible', $group['visible']);
    $this->assignRef('groupFaction', $group['factionId']);
    $this->assignRef('groupFactionName', $group['groupFactionName']);
    $this->assignRef('groupStatus', $group['status']);
    $this->assignRef('groupLeaderPersonId', $group['groupLeaderPersonId']);
    $this->assignRef('groupLeaderPersonName', $group['groupLeaderPersonName']);
    $this->assignRef('eventId', $group['eventId']);
    $this->assignRef('groupLeaders', $group['groupLeaders']);

  }

  private function charactersForEvent($groupId) {
    $user = &JFactory::getUser();
    $canDo = GroupHelper::getActions($groupId);
    $eventId = $this->model->getEventForGroup($groupId);
    $group = $this->model->getGroup($groupId);
    $charactersInGroup = $this->model->getCharacterIdsInGroup($groupId);
    $factionId = $group['factionId'];
    $this->assignRef('charactersInGroup', $charactersInGroup);
    $characters = Array();
    if ($canDo->get('core.edit')) {
      $characters = $this->lajvitModel->getCharactersForFaction(
          $eventId, $factionId, 'knownas', 'ASC', NULL, NULL);
    } elseif ($canDo->get('core.edit.own') &&
        $this->model->isPersonGroupLeaderForGroup($user->id, $groupId)) {
      $characters = $this->lajvitModel->getCharactersForFaction(
          $eventId, $factionId, 'knownas', 'ASC', NULL, NULL);
    } elseif ($this->model->isGroupVisible($groupId) &&
        $this->model->isGroupOpen($groupId)) {
      $characters = $this->lajvitModel->getCharactersForEvent($eventId);
    } else {
      $this->errorMsg = "COM_LAJVIT_NOT_AUTHORIZED_TO_ADD_CHAR_TO_GROUP";
      $this->assignRef('groupId', $minusOne);
      $this->setLayout('error');
    }
    $this->getPersonDataForCharacters($characters, $eventId);

    $this->assignRef('characters', $characters);
  }

  private function getPersonDataForCharacters(&$characters, $eventId) {
    foreach ($characters as $character) {
      $personId = $this->lajvitModel->getPersonIdOwningCharacterOnEvent($character->id, $eventId);
      $person = $this->lajvitModel->getPerson($personId);
      $character->personId = $personId;
      $character->personGivenName = $person->givenname;
      $character->personLastName = $person->surname;
    }
  }
}
