<?php

defined('_JEXEC') or die();

require_once('littable.php');

/**
 * Class for plotobject table.
 */
class TableLIT_PlotObject extends LITTable {
  var $id = 0;
  var $heading = '';
  var $description = '';
  var $plotid = NULL;

  function __construct(&$db) {
    parent::__construct('#__lit_plotobject', 'id', $db);
  }

  function check() {
    if (!LITTable::check()) {
      return FALSE;
    }

    if (is_null($this->$plotid) || $this->$plotid <= 0) {
      return FALSE;
    }
    return TRUE;
  }
}
