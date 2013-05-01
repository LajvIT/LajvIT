<?php
defined('_JEXEC') or die;

/**
 * Group helper.
 */
abstract class GroupHelper
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
      $assetName = 'com_lajvit.group.' .(int) $id;
    }

    $actions = Array(
        'core.create', 'core.edit', 'core.edit.own', 'core.delete',
        'lajvit.view.visible', 'lajvit.view.hidden');

    foreach ($actions as $action) {
      $result->set($action, $user->authorise($action, $assetName));
    }

    return $result;
  }

  public static function getGroupsBreadcrumb($eventId) {
    $app = JFactory::getApplication();
    $pathway = $app->getPathway();
    $model = JModel::getInstance('lajvit', 'lajvitmodel');
    $linkToGroupList = 'index.php?option=com_lajvit&view=groups';
    $linkToGroupList .= '&eid=' . $eventId . '&Itemid='.JRequest::getInt('Itemid', 0);
    EventHelper::getEventBreadcrumb($eventId);
    $pathway->addItem(JText::_('COM_LAJVIT_GROUPS'), $linkToGroupList);
  }
}