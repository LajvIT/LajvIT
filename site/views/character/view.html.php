<?php

defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.view');

/**
 * View class for all character related data.
 */
class LajvITViewCharacter extends JView {
  function getModel($name = "LajvIT") {
    return parent::getModel($name);
  }

  function setModel($name, $default = FALSE) {
    return parent::setModel($name, $default);
  }

  function display($tpl = NULL) {
    JHtml::stylesheet('com_lajvit/lajvit.css', array(), TRUE);
    $user = JFactory::getUser();
    $model = $this->getModel();
    $groupModel =& JModel::getInstance('Group', 'lajvitmodel');
    $this->assignRef('groupModel', $groupModel);

    $person = $model->getPerson();

    $events = $model->getEventsForPerson();
    $this->assignRef('events', $events);

    $eventid = JRequest::getInt('eid', -1);
    $this->assignRef('eventid', $eventid);

    $factions = $model->getCharacterFactions();
    $this->assignRef('factions', $factions);

    $cultures = $model->getCharacterCultures();
    $this->assignRef('cultures', $cultures);

    $concepts = $model->getCharacterConcepts();
    $this->assignRef('concepts', $concepts);

    $role = $model->getRoleForEvent($eventid);

    $charid = JRequest::getInt('cid', -1);
    $character = NULL;
    if ($charid >= 0) {
      $this->assignRef('characterid', $charid);

      $character = $model->getCharacterExtended($charid);
      //$groupLeaderForCharacter = $groupModel->isPersonGroupLeaderForCharacter($user->id, $charid);
      //$memberInSameGroup = $groupModel->isPersonGroupMemberInAGroupOfCharacter($user->id,$charid);
      $character->groupLeaderInfos = $groupModel->getAllGroupLeaderInfoForCharacter($charid);
      $character->groupMemberInfos = $groupModel->getAllGroupMemberInfoForCharacter($charid);
      $character->groupMemberships = $groupModel->getGroupsThatCharacterIsRegisteredIn($charid);

      //       $this->assignRef('groupLeaderForCharacter', $groupLeaderForCharacter);
      //       $this->assignRef('memberInSameGroup', $memberInSameGroup);

      if (!is_null($character->bornyear)) {
        $character->age = $events[$eventid]->ingameyear - $character->bornyear;
      } else {
        $character->age = 0;
      }

      $this->assignRef('character', $character);

      $crole = $model->getRoleForChara($eventid, $charid);
      $role = $model->mergeRoles($role, $crole);
    }

    $this->assignRef('role', $role);

    $err = JRequest::getInt('failed', 0);
    $this->assignRef('failed', $err);

    $fullname = JRequest::getString('fullname', '');
    $factionid = JRequest::getInt('factionid', 0);
    $cultureid = JRequest::getInt('cultureid', 0);
    $conceptid = JRequest::getInt('conceptid', 0);

    $this->assignRef('itemid', JRequest::getInt('Itemid', 0));

    $reg = $model->getRegistration($person->id, $eventid, $charid);
    $canDo = EventHelper::getActions($eventid);
    if ($this->getLayout() == 'edit') {
      if (!$canDo->get('core.edit') && !$reg) {
        $this->setLayout('default');
        /*
         $link = 'index.php?option=com_lajvit&view=character&eid='.$eventid.'&cid='.$charid;
         $link.= '&Itemid='.JRequest::getInt('Itemid', 0);
         $this->setRedirect($link);
         return;
         */
      }
    }
    if ($this->getLayout() == 'editconcept') {
      if (!$canDo->get('core.edit') && !$reg) {
        echo "LajvITViewCharacter.display changing to default <br>";
        $this->setLayout('default');
      }
      if ($err == 0) {
        $fullname = $character->fullname;
        $factionid = $character->factionid;
        $cultureid = $character->cultureid;
        $conceptid = $character->conceptid;
      }
    }

    $this->assignRef('fullname', $fullname);
    $this->assignRef('factionid', $factionid);
    $this->assignRef('cultureid', $cultureid);
    $this->assignRef('conceptid', $conceptid);

    $this->displayBreadcrumb($eventid);

    parent::display($tpl);
  }

  private function displayBreadcrumb($eventId) {
    $app = JFactory::getApplication();
    $pathway = $app->getPathway();
    $layout = $this->getLayout();
    $model = &$this->getModel();
    $events = $model->getEventsForPerson();
    if ($eventId > 0) {
      $currentEventName = $events[$eventId]->name;
      $pathway->addItem($currentEventName, '');
    }
    switch ($layout) {
      case 'create':
        $pathway->addItem('Skapa karaktär', '');
        break;
      case 'edit':
        $pathway->addItem('Uppdatera karaktär', '');
        break;
      case 'default':
        $pathway->addItem('Visa karaktär', '');
        break;
      case 'delete':
        $pathway->addItem('Ta bort karaktär', '');
        break;
      case 'updated':
        $pathway->addItem('Karaktär sparad', '');
        break;
      default:
        break;
    }
  }
}
