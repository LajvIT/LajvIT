<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Database table object for events.
 */
class TableLIT_GroupMembers extends LITTable {
  static $TABLE_NAME = '#__lit_group_members';
  var $id = 0;
  var $groupId = 0;
  var $characterId = 0;

  function __construct(&$db) {
    parent::__construct(TableLIT_GroupMembers::$TABLE_NAME, 'id', $db);
  }

  function check() {
    if ($this->groupId == 0 || $this->$characterId == 0) {
      return FALSE;
    }
    return TRUE;
  }
}
