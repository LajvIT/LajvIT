<?php

defined('_JEXEC') or die();

require_once('littable.php');

class TableLIT_Chara extends LITTable {
  var $id = 0;
  var $created = '';
  var $updated = null;
  var $main = false;
  var $knownas = '';
  var $fullname = '';
  var $bornyear = null;
  var $bornmonth = null;
  var $bornday = null;
  var $factionid = 0;
  var $cultureid = 0;
  var $conceptid = null;
  var $concepttext = null;
  var $privateinfo = null;
  var $image = null;
  var $description1 = null;
  var $description2 = null;
  var $description3 = null;

  function __construct(&$db) {
    parent::__construct('#__lit_chara', 'id', $db);

    $this->created = date('Y-m-d H:i:s');
  }
}
