<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Database table object for events.
 */
class TableLIT_GroupLeaders extends LITTable {
  static $TABLE_NAME = '#__lit_group_leaders';
  var $id = 0;
  var $groupId = 0;
  var $personId = 0;

  function __construct(&$db) {
    parent::__construct(TableLIT_GroupLeaders::$TABLE_NAME, 'id', $db);
  }

  function check() {
    if ($this->groupId == 0 || $this->$personId == 0) {
      return FALSE;
    }
    return TRUE;
  }
}
