<?php
defined('_JEXEC') or die();
require_once('littable.php');

/**
 * Class for character table.
 */
class TableLIT_Chara extends LITTable {
  var $id = 0;
  var $created = '';
  var $updated = NULL;
  var $main = FALSE;
  var $knownas = '';
  var $fullname = '';
  var $bornyear = NULL;
  var $bornmonth = NULL;
  var $bornday = NULL;
  var $factionid = 0;
  var $cultureid = 0;
  var $conceptid = NULL;
  var $concepttext = NULL;
  var $privateinfo = NULL;
  var $image = NULL;
  var $description1 = NULL;
  var $description2 = NULL;
  var $description3 = NULL;

  function __construct(&$db) {
    parent::__construct('#__lit_chara', 'id', $db);

    $this->created = date('Y-m-d H:i:s');
  }
}
