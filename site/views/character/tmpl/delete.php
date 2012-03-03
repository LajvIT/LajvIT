<?php

// No direct access

defined('_JEXEC') or die('Restricted access'); ?>

<h1>
<?php echo $this->events[$this->eventid]->shortname; ?>
  - Bekräfta radera karaktär
</h1>
<p>Är du säker på att du vill radera nedanstående karaktär?</p>
<p><strong>
<?php echo $this->character->fullname; ?>
  </strong></p>

<form action="index.php" method="post" name="characterDeleteForm">
  <input type="submit" value="Ta bort karaktär" /> <input type="hidden" name="option"
    value="com_lajvit" /> <input type="hidden" name="task" value="delete" /> <input type="hidden"
    name="controller" value="character" /> <input type="hidden" name="eid"
    value="<?php echo $this->eventid; ?>" /> <input type="hidden" name="cid"
    value="<?php echo $this->characterid; ?>" /> <input type="hidden" name="Itemid"
    value="<?php echo $this->itemid; ?>" /> <input type="hidden" name="redirect"
    value="<?php echo $this->redirect; ?>" />
</form>
