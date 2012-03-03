<?php

// No direct access

defined('_JEXEC') or die('Restricted access'); ?>

<h1><? echo $this->events[$this->eventid]->shortname; ?> - Du är registrerad på arrangemanget</h1>
<p>
  Nästa steg i anmälan är att
  <a href="index.php?option=com_lajvit&view=character&layout=create&eid=<?php echo $this->eventid; ?>&Itemid=<?php echo $this->itemid; ?>">
    skapa ett rollkoncept
  </a>
</p>
