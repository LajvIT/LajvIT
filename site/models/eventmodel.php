<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.model');

JTable::addIncludePath(JPATH_ADMINISTRATOR.DS.'components'.DS.'com_lajvit'.DS.'tables');

/**
 * Event Model.
 */
class LajvITModelEventModel extends JModel {
  /**
   *
   * @var LajvITModelLajvIT
   */
  private $lajvitModel;

  function __construct() {
    $this->lajvitModel =& JModel::getInstance('lajvit', 'lajvitmodel');
  }

  /**
   * @param JUser $user
   * @param int $eventId
   * @return boolean
   */
  public function isUserAllowedToEditEvent($user, $eventId) {
    if ($user->usertype == 'Super Administrator') {
      return TRUE;
    }
    $userRolesForEvent = $this->lajvitModel->getAllRolesMerged($eventId, $user->id);
    if (is_object($userRolesForEvent) &&
        $userRolesForEvent->event_edit) {
      return TRUE;
    }
    return FALSE;
  }

}
