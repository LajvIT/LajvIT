<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>


<h1><? echo $this->events[$this->eventid]->shortname; ?> - Din karaktär är sparad</h1>

<p>Klicka nedan för att uppdatera den med mer information.</p>
<strong><p>
	<? echo $this->character->fullname; ?>
	<a href="index.php?option=com_lajvit&view=character&layout=edit&eid=<? echo $this->eventid; ?>&cid=<? echo $this->characterid; ?>&Itemid=<? echo $this->itemid; ?>"><img src="components/com_lajvit/edit.gif"/></a>
</p></strong>
<p>
	Eller så kan du återgå till
	<a href="index.php?option=com_lajvit&view=event&Itemid=<? echo $this->itemid; ?>">arrangemangslistan</a>
	och fylla på med mer information senare.
</p>
