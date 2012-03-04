<?php

// No direct access

defined('_JEXEC') or die('Restricted access'); ?>


<h1><?php echo $this->events[$this->eventid]->shortname; ?> - Din karaktär är sparad</h1>

<p>Klicka nedan för att uppdatera den med mer information.</p>
<p><strong>
  <?php echo $this->character->fullname; ?>
  <a href="index.php?option=com_lajvit&view=character&layout=edit&eid=<?php echo $this->eventid; ?>
    &cid=<?php echo $this->characterid; ?>&Itemid=<?php echo $this->itemid; ?>">
      <img src="components/com_lajvit/edit.gif"/>
    </a>
</strong></p>
<p>
  Eller så kan du återgå till
  <a href="index.php?option=com_lajvit&view=event&Itemid=<?php echo $this->itemid; ?>">
    arrangemangslistan</a>
  och fylla på med mer information senare.
</p>
