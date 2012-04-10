<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Database table object for events.
 */
class TableLIT_GroupMembers extends LITTable {
  static $tableName = '#__lit_group_members';
  var $id = 0;
  var $groupId = 0;
  var $personId = 0;

  function __construct(&$db) {
    parent::__construct($this->tableName, 'id', $db);
  }

  function check() {
    if ($this->groupId == 0 || $this->personId == 0) {
      return FALSE;
    }
    return TRUE;
  }
}
