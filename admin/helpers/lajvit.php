<?php
// No direct access to this file
defined('_JEXEC') or die;

/**
 * LajvIT component helper.
 */
abstract class LajvitHelper
{
  /**
   * Configure the Linkbar.
   */
  public static function addSubmenu($submenu) {
    JSubMenuHelper::addEntry(JText::_('COM_LAJVIT_SUBMENU_EVENTS'),
        'index.php?option=com_lajvit&view=events', $submenu == 'events');
    // set some global property
    $document = JFactory::getDocument();
    $document->addStyleDeclaration('.icon-48-lajvit ' .
        '{background-image: url(../media/com_lajvit/images/tux-48x48.png);}');
  }

  /**
   * Get the actions
   */
  public static function getActions($itemType, $id = 0) {
    jimport('joomla.access.access');
    $user   = JFactory::getUser();
    $result = new JObject;

    if (empty($id)) {
      $assetName = 'com_lajvit';
    } else {
      $assetName = 'com_lajvit.' . $itemType . '.' .(int) $id;
    }

    $actions = JAccess::getActions('com_lajvit', 'component');

    foreach ($actions as $action) {
      $result->set($action->name, $user->authorise($action->name, $assetName));
    }

    return $result;
  }

  public static function getEventActions($id = 0) {
    return LajvitHelper::getActions('event', $id);
  }

}