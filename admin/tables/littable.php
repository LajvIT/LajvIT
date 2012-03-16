<?php

defined('_JEXEC') or die();

/**
 * Class for extending JTable to LIT.
 */
class LITTable extends JTable {
  var $_forcenew = FALSE;

      /**
     * Inserts a new row if id is zero or updates an existing row in the database table
     *
     * Can be overloaded/supplemented by the child class
     *
     * @access public
     * @param boolean If FALSE, null object variables are not updated
     * @return null|stringnull if successful otherwise returns and error message
     */
  function store($updateNulls = FALSE) {
    $k = $this->_tbl_key;

    if (!$this->_forcenew && $this->$k) {
      $ret = $this->_db->updateObject($this->_tbl, $this, $this->_tbl_key, $updateNulls);
    } else {
      $ret = $this->_db->insertObject($this->_tbl, $this, $this->_tbl_key);
    }

    if (!$ret) {
      $this->setError(get_class( $this ).'::store failed - '.$this->_db->getErrorMsg());
      return FALSE;
    }

    return TRUE;
  }
}
