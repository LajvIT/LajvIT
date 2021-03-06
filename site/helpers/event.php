<?php
defined('_JEXEC') or die;

/**
 * Group helper.
 */
abstract class EventHelper
{
  /**
   * Get the actions
   */
  public static function getActions($id = 0) {
    jimport('joomla.access.access');
    $user   = JFactory::getUser();
    $result = new JObject;

    if (empty($id)) {
      $assetName = 'com_lajvit';
    } else {
      $assetName = 'com_lajvit.event.' .(int) $id;
    }

    $actions = Array(
        'core.create', 'core.edit', 'core.edit.own', 'core.delete',
        'lajvit.view.visible', 'lajvit.view.hidden', 'lajvit.view.medical',
        'lajvit.plot.enabled', 'lajvit.char.groupmember');

    foreach ($actions as $action) {
      $result->set($action, $user->authorise($action, $assetName));
    }

    return $result;
  }

  public static function getEventBreadcrumb($eventId, $link = '') {
    $app = JFactory::getApplication();
    $pathway = $app->getPathway();
    $model = JModel::getInstance('lajvit', 'lajvitmodel');
    $events = $model->getEventsForPerson();
    if ($eventId > 0) {
      $currentEventName = $events[$eventId]->shortname;
      $pathway->addItem($currentEventName, $link);
    }
  }
}