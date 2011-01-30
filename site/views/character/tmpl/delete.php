<?php
 
// No direct access
 
defined('_JEXEC') or die('Restricted access'); ?>

<h1><? echo $this->events[$this->eventid]->shortname; ?> - Bekräfta radera karaktär</h1>
<p>Är du säker på att du vill radera nedanstående karaktär?</p>
<strong><p><? echo $this->character->fullname; ?></p></strong>

<form action="index.php" method="post" name="characterDeleteForm">
	<input type="submit" value="Ta bort karaktär"/>
	<input type="hidden" name="option" value="com_lajvit"/>
	<input type="hidden" name="task" value="delete"/>
	<input type="hidden" name="controller" value="character"/>
	<input type="hidden" name="eid" value="<? echo $this->eventid; ?>"/>
	<input type="hidden" name="cid" value="<? echo $this->characterid; ?>"/>
	<input type="hidden" name="Itemid" value="<? echo $this->itemid; ?>"/>
</form>
